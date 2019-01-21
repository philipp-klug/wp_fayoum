<?php

require_once SDROST_CLASSES_SRC_DIR . '/helper/SdrostClassAddressRenderer.php';

/**
 * SdrostClassAddressPostType.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassAddressPostType extends SdrostClassBasePostType
{
    const ADDRESS_STREET_COLUMN_KEY = 'sdrost_class_address_street';
    const ADDRESS_ZIP_COLUMN_KEY = 'sdrost_class_address_zipcode';
    const ADDRESS_CITY_COLUMN_KEY = 'sdrost_class_address_city';
    const ADDRESS_DISTRICT_COLUMN_KEY = 'sdrost_class_address_district';
    const ADDRESS_ADDITIONAL_COLUMN_KEY = 'sdrost_class_address_additional';
    const ADDRESS_GOOGLE_MAP_COLUMN_KEY = 'sdrost_class_address_google_map';

    public function create()
    {
        $supports = array ( 'title' );
        register_post_type(
            self::SDROST_CLASS_ADDRESSES_POST_TYPE,
            array(
                'labels' => array(
                    'name' => 'Standorte',
                    'singular_name' => 'Standort',
                    'add_new' => 'Neuer Standort',
                    'add_new_item' => 'Standort hinzufügen',
                    'edit_item' => 'Standort bearbeiten',
                    'new_item' => 'Neuer Standort',
                    'all_items' => 'Alle Standorte',
                    'view_item' => 'Standorte ansehen',
                    'search_items' => 'Standorte suchen',
                    'not_found' =>  'Keine Standorte gefunden',
                    'not_found_in_trash' => 'Keine gelöschten Standorte',
                    'parent_item_colon' => '',
                    'menu_name' => 'Standorte',
                ),
                'supports' => $supports,
                'exclude_from_search' => true,
                'rewrite' => array( 'slug' => 'classes-addresses' ),
                'public' => true,
                'menu_position' => 30,
                'has_archive' => false,
                'menu_icon' => 'dashicons-admin-post',
                'register_meta_box_cb' => array(SdrostClassAddressPostType::class, 'addSdrostClassAddressesBox' ),
            )
        );
    }

    public function setGridColumnsForSdrostClassAddresses($columns) {
        $date = $columns['date'];
        unset($columns['date']);
        $columns[self::ADDRESS_STREET_COLUMN_KEY] = 'Straße';
        $columns[self::ADDRESS_ZIP_COLUMN_KEY] = 'PLZ';
        $columns[self::ADDRESS_CITY_COLUMN_KEY] = 'Stadt';
        $columns[self::ADDRESS_DISTRICT_COLUMN_KEY] = 'Bezirk';
        $columns['date'] = $date;

        return $columns;
    }


    public function addSdrostClassAddressesBox()
    {
        add_meta_box( 'sdrostClassAddresses_box','Kurs Adress Daten', array('SdrostClassAddressPostType', 'createSdrostClassAddressesDataBox' ),
            self::SDROST_CLASS_ADDRESSES_POST_TYPE, 'normal', 'high' );
        remove_meta_box( 'wp-editor', self::SDROST_CLASS_ADDRESSES_POST_TYPE, 'normal' );
    }


    public function createSdrostClassAddressesDataBox($post)
    {
        global $post;

        self::createWpOnceFields([
            self::ADDRESS_STREET_COLUMN_KEY,
            self::ADDRESS_ZIP_COLUMN_KEY,
            self::ADDRESS_CITY_COLUMN_KEY,
            self::ADDRESS_DISTRICT_COLUMN_KEY,
            self::ADDRESS_ADDITIONAL_COLUMN_KEY,
            self::ADDRESS_GOOGLE_MAP_COLUMN_KEY,
        ]);

        $classAddress = new SdrostClassAddress($post);
        echo SdrostClassAddressRenderer::getAddressForm($classAddress);
    }


    public function saveSdrostAddressesMeta( $post_id, $post )
    {
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        $valid = self::verifyPostData([
            self::ADDRESS_STREET_COLUMN_KEY,
            self::ADDRESS_ZIP_COLUMN_KEY,
            self::ADDRESS_CITY_COLUMN_KEY,
            self::ADDRESS_DISTRICT_COLUMN_KEY,
            self::ADDRESS_ADDITIONAL_COLUMN_KEY,
            self::ADDRESS_GOOGLE_MAP_COLUMN_KEY,
        ]);

        if (!$valid) {
            return $post_id;
        }

        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $events_meta.
        $classesMeta = $this->fillMetaDataByPostValues([
            self::ADDRESS_STREET_COLUMN_KEY. '_data',
            self::ADDRESS_ZIP_COLUMN_KEY . '_data',
            self::ADDRESS_CITY_COLUMN_KEY . '_data',
            self::ADDRESS_DISTRICT_COLUMN_KEY . '_data',
            self::ADDRESS_ADDITIONAL_COLUMN_KEY . '_data',
            self::ADDRESS_GOOGLE_MAP_COLUMN_KEY . '_data'
        ]);

        return self::savePostWithMeta($post_id, $post, $classesMeta);
    }


    public static function deletePosts()
    {
        $args = array (
            'post_type' => self::SDROST_CLASS_ADDRESSES_POST_TYPE,
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

}