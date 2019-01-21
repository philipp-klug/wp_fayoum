<?php
/**
 * SdrostClassBasePostType.php
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassBasePostType
{
    const SDROST_CLASSES_POST_TYPE = 'Sdrost_Classes';
    const SDROST_CLASS_ADDRESSES_POST_TYPE = 'Sdrost_Addresses';
    const SDROST_CLASS_TRAINERS_POST_TYPE = 'Sdrost_Trainers';

    public static function getPageTitles()
    {
        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args);
        $pageTitles = [];
        foreach ($pages as $postObject) {
            $pageTitles[] = $postObject->post_title;
        }

        return $pageTitles;
    }


    public static function getAddresses()
    {
        $args = array(
            'post_type' => self::SDROST_CLASS_ADDRESSES_POST_TYPE
        );
        // The Query
        $addresses = new WP_Query( $args );

        if(!is_array($addresses->posts)){
            return false;
        }
        $addressTitles = [];
        foreach ($addresses->posts as $postObject) {
            $addressTitles[$postObject->ID] = $postObject->post_title;
        }

        return $addressTitles;
    }

    public static function getTrainers()
    {
        $args = array(
            'post_type' => self::SDROST_CLASS_TRAINERS_POST_TYPE,
            'posts_per_page' => 50
        );
        // The Query
        $trainers = new WP_Query( $args );

        if(!is_array($trainers->posts)){
            return false;
        }
        $trainerTitles = [];
        $trainerTitles[0] = '-';
        foreach ($trainers->posts as $postObject) {
            $firstName = get_post_meta($postObject->ID, 'sdrost_class_trainer_firstname_data', true);
            $lastName = get_post_meta($postObject->ID, 'sdrost_class_trainer_lastname_data', true);

            $trainerTitles[$postObject->ID] = $firstName . ' ' . $lastName;
        }

        return $trainerTitles;
    }

    public static function getTrainerById($id)
    {
        if (!$id) {
            return [
                'id' => $id,
                'name' => '-'
            ];
        }

        $firstName = get_post_meta($id, 'sdrost_class_trainer_firstname_data', true);
        $lastName = get_post_meta($id, 'sdrost_class_trainer_lastname_data', true);

        $data = [
            'id' => $id,
            'name' => $firstName . ' ' . $lastName
        ];

        return $data;
    }


    public static function getClassesByClassType($classType, $groupByLocation = false)
    {
        if (is_numeric($classType)) {
            return [];
        }

        $args = array(
            'post_type' => self::SDROST_CLASSES_POST_TYPE,
            'meta_key' => 'sdrost_class_class_data',
            'meta_value' => $classType,
            'meta_compare' => 'LIKE',
            'post_status' => 'publish',
            'pagination'  => false,
            'cache_results' => false,
        );
        // The Query
        $classes = new WP_Query( $args );

        if(!is_array($classes->posts)){
            return [];
        }

        // prepare data array
        $classesDataArray = self::formatMetaDataArray($classes->posts);
        // order multiple values by time
        $classesDataArray = self::sortClassesByTime($classesDataArray);
        //group by location
        if ($groupByLocation) {
            $classesDataArray = self::sortClassesByLocation($classesDataArray);
        }

        return $classesDataArray;
    }

    private static function sortClassesByLocation($data)
    {
        $sortedData = [];
        foreach ($data as $day => $classesData) {
            if (count($classesData) > 1) {
                usort($classesData, function($a, $b) {
                    return $a['place'] <=> $b['place'];
                });
            }
            $sortedData[$day] = $classesData;
        }

        return $sortedData;
    }

    public static function sortClassesByTime($data)
    {
        $sortedData = [];
        foreach ($data as $day => $classesData) {
            if (count($classesData) > 1) {
                usort($classesData, function($a, $b) {
                    return $a['begin'] <=> $b['begin'];
                });
            }
            $sortedData[$day] = $classesData;
        }

        return $sortedData;
    }


    public static function formatMetaDataArray($posts)
    {
        $dataArray = [];
        foreach ($posts as $classData) {
            $prio = get_post_meta($classData->ID, 'sdrost_class_weekday_priority_data', true);
            $addressObject = get_post(get_post_meta($classData->ID, 'sdrost_class_address_data', true));
            $address = get_post_meta($addressObject->ID, 'sdrost_class_address_street_data', true) . '<br/>' .
                get_post_meta($addressObject->ID, 'sdrost_class_address_zipcode_data', true) . ' ' .
                get_post_meta($addressObject->ID, 'sdrost_class_address_city_data', true) . '<br/>' .
                get_post_meta($addressObject->ID, 'sdrost_class_address_additional_data', true);

            $dataArray[(int)$prio][] = [
                'day' => get_post_meta($classData->ID, 'sdrost_class_day_data', true),
                'begin' => get_post_meta($classData->ID, 'sdrost_class_begin_data', true),
                'end' => get_post_meta($classData->ID, 'sdrost_class_end_data', true),
                'note' => get_post_meta($classData->ID, 'sdrost_class_note_data', true),
                'place' => get_post_meta($addressObject->ID, 'sdrost_class_address_district_data', true),
                'address' => $address,
                'trainer' => get_post_meta($classData->ID, 'sdrost_class_trainer_data', true),
                'googleMap' => get_post_meta($addressObject->ID, 'sdrost_class_address_google_map_data', true)
            ];
        }

        return $dataArray;
    }


    public static function createWpOnceFields($data)
    {
        foreach ( $data as $postValue) {
            wp_nonce_field( basename( __FILE__ ), $postValue);
        }
    }


    public static function verifyPostData($data)
    {
        // Verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times.
        foreach ( $data as $postValue) {
            if ( !isset( $_POST[$postValue . '_data'] ) || !wp_verify_nonce( $_POST[$postValue], basename(__FILE__) ) ) {
                return false;
            }
        }

        return true;
    }


    public function fillMetaDataByPostValues($keys): array
    {
        $data = [];

        foreach ($keys as $valueKey) {
            $data[$valueKey] = $_POST[$valueKey];
        }

        return $data;
    }


    public function savePostWithMeta($post_id, $post, $classesMeta): string
    {
        // Cycle through the $events_meta array.
        // Note, in this example we just have one item, but this is helpful if you have multiple.
        foreach ( $classesMeta as $key => $value ) :
            // Don't store custom data twice
            if ( 'revision' === $post->post_type ) {
                return $post_id;
            }
            if ( get_post_meta( $post_id, $key, false ) ) {
                // If the custom field already has a value, update it.
                update_post_meta( $post_id, $key, $value );
            } else {
                // If the custom field doesn't have a value, add it.
                add_post_meta( $post_id, $key, $value);
            }
            if ( ! $value ) {
                // Delete the meta key if there's no value
                delete_post_meta( $post_id, $key );
            }
        endforeach;

        return $post_id;
    }


    public function getSdrostClassesColumnValues($column, $post_id)
    {
        // gets always single value
        $value = get_post_meta( $post_id , $column . '_data' , true );
        $string = '';

        if ( !empty($value)) {
            if (is_array($value) && $column == 'sdrost_class_trainer') {
                foreach ($value as $key => $data) {
                    $string .= $data['name'] . '<br>';
                }
            }
            else {
                $string = $value;
            }
        }
        echo $string;
    }

}