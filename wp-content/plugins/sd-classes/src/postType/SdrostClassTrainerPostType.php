<?php

require_once SDROST_CLASSES_SRC_DIR . '/helper/SdrostClassTrainerRenderer.php';

/**
 * SdrostClassTrainer.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassTrainerPostType extends SdrostClassBasePostType
{
    const TRAINER_FIRST_NAME_COLUMN_KEY = 'sdrost_class_trainer_firstname';
    const TRAINER_LAST_NAME_COLUMN_KEY = 'sdrost_class_trainer_lastname';

    public function create()
    {
        $supports = array ( 'title' );
        register_post_type(
            self::SDROST_CLASS_TRAINERS_POST_TYPE,
            array(
                'labels' => array(
                    'name' => 'Trainer',
                    'singular_name' => 'Trainer',
                    'add_new' => 'Neuer Trainer',
                    'add_new_item' => 'Trainer hinzufügen',
                    'edit_item' => 'Trainer bearbeiten',
                    'new_item' => 'Neuer Trainer',
                    'all_items' => 'Alle Trainer',
                    'view_item' => 'Trainer ansehen',
                    'search_items' => 'Trainer suchen',
                    'not_found' =>  'Keine Trainer gefunden',
                    'not_found_in_trash' => 'Keine gelöschten Trainer gefunden',
                    'parent_item_colon' => '',
                    'menu_name' => 'Trainer',
                ),
                'supports' => $supports,
                'exclude_from_search' => true,
                'rewrite' => array( 'slug' => 'classes-trainer' ),
                'public' => true,
                'menu_position' => 40,
                'has_archive' => false,
                'menu_icon' => 'dashicons-admin-users',
                'register_meta_box_cb' => array(SdrostClassTrainerPostType::class, 'addSdrostClassTrainersBox' ),
            )
        );
    }

    public function setGridColumnsForSdrostClassTrainer($columns) {
        $date = $columns['date'];
        unset($columns['date']);
        $columns[self::TRAINER_FIRST_NAME_COLUMN_KEY] = 'Vorname';
        $columns[self::TRAINER_LAST_NAME_COLUMN_KEY] = 'Nachname';
        $columns['date'] = $date;

        return $columns;
    }

    public function addSdrostClassTrainersBox()
    {
        add_meta_box( 'sdrostClassTrainers_box','Kurs Trainer Daten', array('SdrostClassTrainerPostType', 'createSdrostClassTrainersDataBox' ),
            self::SDROST_CLASS_TRAINERS_POST_TYPE, 'normal', 'high' );
        remove_meta_box( 'wp-editor', self::SDROST_CLASS_TRAINERS_POST_TYPE, 'normal' );
    }


    public function createSdrostClassTrainersDataBox($post)
    {
        global $post;

        self::createWpOnceFields([
            self::TRAINER_FIRST_NAME_COLUMN_KEY,
            self::TRAINER_LAST_NAME_COLUMN_KEY
        ]);

        $classTrainer = new SdrostClassTrainer($post);
        echo SdrostClassTrainerRenderer::getTrainerForm($classTrainer);
    }

    public function saveSdrostTrainerMeta( $post_id, $post )
    {
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        $valid = self::verifyPostData([
            self::TRAINER_FIRST_NAME_COLUMN_KEY,
            self::TRAINER_LAST_NAME_COLUMN_KEY
        ]);

        if (!$valid) {
            return $post_id;
        }

        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $events_meta.
        $classesMeta = $this->fillMetaDataByPostValues([
            self::TRAINER_FIRST_NAME_COLUMN_KEY. '_data',
            self::TRAINER_LAST_NAME_COLUMN_KEY . '_data'
        ]);

        return self::savePostWithMeta($post_id, $post, $classesMeta);
    }

    public static function deletePosts()
    {
        $args = array (
            'post_type' => self::SDROST_CLASS_TRAINERS_POST_TYPE,
            'nopaging' => true
        );
        $query = new WP_Query ($args);
        while ($query->have_posts ()) {
            $query->the_post ();
            $id = get_the_ID ();
            wp_delete_post ($id, true);
        }
        wp_reset_postdata ();
    }

    public function getTrainersAjax()
    {
        $args = array(
            'post_type' => self::SDROST_CLASS_TRAINERS_POST_TYPE
        );
        // The Query
        $trainers = new WP_Query( $args );

        if(!is_array($trainers->posts)){
            return false;
        }
        $trainerTitles = [];
        foreach ($trainers->posts as $postObject) {
            $firstName = get_post_meta($postObject->ID, 'sdrost_class_trainer_firstname_data', true);
            $lastName = get_post_meta($postObject->ID, 'sdrost_class_trainer_lastname_data', true);

            $trainerTitles[] = [
                'id' => $postObject->ID,
                'name' => $firstName . ' ' . $lastName
            ];
        }

        wp_send_json($trainerTitles);
    }

}