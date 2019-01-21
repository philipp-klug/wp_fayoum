<?php

/**
 * sdrost-classes.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'SDROST_CLASSES_ROOT_DIR', __DIR__);
define( 'SDROST_CLASSES_SRC_DIR', SDROST_CLASSES_ROOT_DIR . '/src' );
define( 'SDROST_CLASSES_ASSETS_DIR', SDROST_CLASSES_ROOT_DIR . '/assets' );

require_once SDROST_CLASSES_SRC_DIR . '/helper/SdrostClassRenderer.php';
require_once SDROST_CLASSES_SRC_DIR . '/postType/SdrostClassBasePostType.php';
require_once SDROST_CLASSES_SRC_DIR . '/postType/SdrostClassPostType.php';
require_once SDROST_CLASSES_SRC_DIR . '/postType/SdrostClassAddressPostType.php';
require_once SDROST_CLASSES_SRC_DIR . '/postType/SdrostClassTrainerPostType.php';
require_once SDROST_CLASSES_SRC_DIR . '/entity/SdrostClass.php';
require_once SDROST_CLASSES_SRC_DIR . '/entity/SdrostClassAddress.php';
require_once SDROST_CLASSES_SRC_DIR . '/entity/SdrostClassTrainer.php';
require_once SDROST_CLASSES_SRC_DIR . '/SdrostClassesOptionPage.php';
require_once SDROST_CLASSES_SRC_DIR . '/SdrostClassesShortCode.php';

const SDROST_CLASSES_PLUGIN_NAME = 'SDrost Classes';

/* also read https://codex.wordpress.org/Writing_a_Plugin */
/*
Plugin Name: SDrost Classes
Description: Ein Plugin um Kurse und deren Zeiten zu verwalten und anzuzeigen.
Version: 1.2.0
Author: Stefanie Drost
Author URI: stefaniedrost.com
License: GPLv2 or later
Text Domain: sdrostclasses
*/

/*
Copyright (C) 2018 SD - Web Development & Fitness (E-Mail: contact@stefaniedrost.com)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* OPTIONS PAGE */
add_action( 'admin_enqueue_scripts', 'addColorPickerToSdrostSettingsPage' );
function addColorPickerToSdrostSettingsPage($hook)
{
    if( is_admin() ) {
        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'sdrost-classes-js', plugins_url( '/assets/js/sdrost-classes.js', __FILE__), array( 'wp-color-picker' ), false, true );
    }
}
add_action( 'admin_init', array(SdrostClassesOptionPage::class, 'registerSdrostClassesSettings'));
add_action( 'admin_menu', array(SdrostClassesOptionPage::class, 'registerSdrostClassesOptionPage'));

/* AJAX Routes */
add_action( 'wp_ajax_sdrost_classes_get_trainers_ajax', array(SdrostClassTrainerPostType::class, 'getTrainersAjax'));

/* CUSTOM POST TYPES */
add_action( 'init', array(SdrostClassPostType::class, 'create'));
add_action( 'init', array(SdrostClassAddressPostType::class, 'create'));
add_action( 'init', array(SdrostClassTrainerPostType::class, 'create'));

/* CUSTOM COLUMNS IN GRIDS */
add_filter( 'manage_sdrost_classes_posts_columns', array(SdrostClassPostType::class, 'setGridColumnsForSdrostClass'));
add_action( 'manage_sdrost_classes_posts_custom_column' , array(SdrostClassPostType::class, 'getSdrostClassesColumnValues' ), 10, 2);

add_filter( 'manage_sdrost_addresses_posts_columns', array(SdrostClassAddressPostType::class, 'setGridColumnsForSdrostClassAddresses'));
add_action( 'manage_sdrost_addresses_posts_custom_column' , array(SdrostClassAddressPostType::class, 'getSdrostClassesColumnValues' ), 10, 2);

add_filter( 'manage_sdrost_trainer_posts_columns', array(SdrostClassTrainerPostType::class, 'setGridColumnsForSdrostClassTrainer'));
add_action( 'manage_sdrost_trainer_posts_custom_column' , array(SdrostClassTrainerPostType::class, 'getSdrostClassesColumnValues' ), 10, 2);

/* SAVE ACTIONS OF FORMS */
add_action( 'save_post', array(new SdrostClassPostType(), 'saveSdrostClassesMeta' ), 1, 2);
add_action( 'save_post', array(new SdrostClassAddressPostType(), 'saveSdrostAddressesMeta' ), 1, 2);
add_action( 'save_post', array(new SdrostClassTrainerPostType(), 'saveSdrostTrainerMeta' ), 1, 2);

/* SHORTCODE */
add_shortcode( 'sdrost_classes', array(new SdrostClassesShortCode(), 'getSdrostClassesShortCode'));

/* UNINSTALL */
register_uninstall_hook(__FILE__, 'uninstallSdrostClassesData' );

function uninstallSdrostClassesData() {
    SdrostClassesOptionPage::delete();
    SdrostClassPostType::deletePosts();
    SdrostClassAddressPostType::deletePosts();
    SdrostClassTrainerPostType::deletePosts();
}

/* Plugin-Code OBERhalb dieser Zeile */
 ?>