<?php
/*
Plugin Name: Easy Contact Form Lite
Plugin URI: https://www.ghozylab.com/plugins/
Description: Easy Contact Form (Lite) - Display your contact form anywhere you like. You can quickly customize your forms to look exactly the way you want them to look. <a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/pricing-compare-tables/" target="_blank"><strong> Upgrade to Pro Version Now</strong></a> and get a tons of awesome features.
Author: Form Plugin Team - GhozyLab
Text Domain: contact-form-lite
Domain Path: /languages
Version: 1.0.95
Author URI: https://www.ghozylab.com/plugins/
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}


/*-------------------------------------------------------------------------------*/
/*   All DEFINES
/*-------------------------------------------------------------------------------*/
define( 'ECF_ITEM_NAME', 'Easy Contact Form Lite' );
define( 'ECF_API_URLCURL', 'https://secure.ghozylab.com/' );
define( 'ECF_API_URL', 'http://secure.ghozylab.com/' );
if (!defined("ECF_PLUGIN_SLUG")) define("ECF_PLUGIN_SLUG","contact-form-lite/easy-contact-form.php");

// Plugin Version
if ( !defined( 'ECF_VERSION' ) ) {
	define( 'ECF_VERSION', '1.0.95' );
}

// Pro Price
if ( !defined( 'ECF_PRO' ) ) {
	define( 'ECF_PRO', '24' );
}

// Pro+
if ( !defined( 'ECF_PROPLUS' ) ) {
	define( 'ECF_PROPLUS', '29' );
}

// Pro++ Price
if ( !defined( 'ECF_PROPLUSPLUS' ) ) {
	define( 'ECF_PROPLUSPLUS', '35' );
}

// Dev Price
if ( !defined( 'ECF_DEV' ) ) {
	define( 'ECF_DEV', '99' );
}

// PHP Version
if ( version_compare( PHP_VERSION, '7.1', '>' ) ) {
	define( 'ECF_PHP7', true );
} else {
	define( 'ECF_PHP7', false );
}

// Plugin Folder Path
if ( ! defined( 'ECF_PLUGIN_DIR' ) ) {
	define( 'ECF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}
	
// plugin url
if ( ! defined( 'ECF_URL' ) ) {
	$ecf_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
	define( 'ECF_URL', $ecf_plugin_url );
	}
	
// All Filters
add_filter('widget_text', 'do_shortcode', 11);
add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');  


/*-------------------------------------------------------------------------------*/
/*  Requires Wordpress Version
/*-------------------------------------------------------------------------------*/

if( (float)substr(get_bloginfo('version'), 0, 3) >= 3.5) {
	define( 'ECF_WP_VER', "g35" );
	}
	else {
		define( 'ECF_WP_VER', "l35" );
	}
	

/*-------------------------------------------------------------------------------*/
/*   Check Wordpress Version & WP_DEBUG @since 1.0.23
/*-------------------------------------------------------------------------------*/
function ecf_admin_init_action() {
	
	$plugin = plugin_basename( __FILE__ );

	if ( ECF_WP_VER == 'l35' ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
			wp_die( "This plugin requires WordPress 3.5 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
		}
	}
	
	if ( defined('WP_DEBUG') ) {
		
		if ( WP_DEBUG == true ) {
			
			add_action( 'admin_notices', 'ecf_admin_wp_debug_notice' ); 
			
		}
		
	}
	
	
}
add_action( 'admin_init', 'ecf_admin_init_action' );


function ecf_admin_wp_debug_notice() {
	
	echo '<div class="error"> <p>NOTE: It is not recommended to use <strong>WP_DEBUG</strong> on live sites, they are meant for local testing and staging installs. You have to set <strong>WP_DEBUG</strong> to false in order to make '.ECF_ITEM_NAME.' works perfectly.</p></div>';
	
}


/*-------------------------------------------------------------------------------*/
/*   Load WP jQuery library
/*-------------------------------------------------------------------------------*/
function ecf_enqueue_scripts() {
	if( !is_admin() )
		{
			wp_enqueue_script( 'jquery' );
			}
}

if ( !is_admin() )
{
  add_action( 'init', 'ecf_enqueue_scripts' );
}


/*-------------------------------------------------------------------------------*/
/*   I18N - LOCALIZATION
/*-------------------------------------------------------------------------------*/
function ecf_lang_init() {
	load_plugin_textdomain( 'contact-form-lite', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
add_action( 'init', 'ecf_lang_init' );


/*-------------------------------------------------------------------------------*/
/*   Registers custom post type
/*-------------------------------------------------------------------------------*/
function ecf_post_type() {
	$labels = array(
		'name' 				=> _x( 'Easy Form', 'post type general name' ),
		'singular_name'		=> _x( 'Easy Form', 'post type singular name' ),
		'add_new' 			=> __( 'Add New Form', 'contact-form-lite' ),
		'add_new_item' 		=> __( 'Easy Contact Item', 'contact-form-lite' ),
		'edit_item' 		=> __( 'Edit Form', 'contact-form-lite' ),
		'new_item' 			=> __( 'New Form', 'contact-form-lite' ),
		'view_item' 		=> __( 'View Form', 'contact-form-lite' ),
		'search_items' 		=> __( 'Search Form', 'contact-form-lite' ),
		'not_found' 		=> __( 'No Form Found', 'contact-form-lite' ),
		'not_found_in_trash'=> __( 'No Form Found In Trash', 'contact-form-lite' ),
		'parent_item_colon' => __( 'Parent Form', 'contact-form-lite' ),
		'menu_name'			=> __( 'Easy Form', 'contact-form-lite' )
	);

	$taxonomies = array();
	$supports = array( 'title' );
	
	$post_type_args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __( 'Easy Contact', 'contact-form-lite' ),
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'hierarchical' 		=> false,
		'rewrite' 			=> array( 'slug' => 'easycontactform', 'with_front' => false ),
		'supports' 			=> $supports,
		'menu_position' 	=> 20,
		'menu_icon' =>  plugins_url( 'inc/images/ecf-cp-icon.png' , __FILE__ ),		
		'taxonomies'		=> $taxonomies
	);
	
	
// For Report - @since 1.0.3 > 5 ( BETA )
	$label = array(
		'name' 				=> _x( 'Submissions', 'post type general name' ),
		'singular_name'		=> _x( 'Submissions', 'post type singular name' ),
		'edit_item' 		=> __( 'Edit Submissions', 'contact-form-lite' ),
		'view_item' 		=> __( 'View Submissions', 'contact-form-lite' ),
		'search_items' 		=> __( 'Search Submissions', 'contact-form-lite' ),
		'not_found' 		=> __( 'No Submissions Found', 'contact-form-lite' ),
		'not_found_in_trash'=> __( 'No Submissions Found In Trash', 'contact-form-lite' )
	);

	$tax = array();
	$support = array( 'title' );
	
	$post_type_arg = array(
		'labels' 			=> $label,
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'hierarchical' 		=> false,
		'rewrite' 			=> array( 'slug' => 'ecfentrie', 'with_front' => false ),
		'supports' 			=> $support,
		'show_in_menu' 		=> false,
		'taxonomies'		=> $tax
	);
	

	 register_post_type( 'easycontactform', $post_type_args );
	 register_post_type( 'ecfentries', $post_type_arg );
	 
}
add_action( 'init', 'ecf_post_type' );


/*--------------------------------------------------------------------------------*/
/*  Add Custom Columns for Form Review Page 
/*--------------------------------------------------------------------------------*/
add_filter( 'manage_edit-easycontactform_columns', 'easycontactform_edit_columns' );
function easycontactform_edit_columns( $ecf_columns ){  
	$ecf_columns = array(  
		'cb' => '<input type="checkbox" />',  
		//'title' => _x( 'Title', 'column name', 'contact-form-lite' ),
		'ecf_ttl' => __( 'Form Name', 'contact-form-lite'),
		'ecf_sc' => __( 'Shortcode', 'contact-form-lite').' ( <span style="font-style:italic; font-size:12px;">click to copy</span> )',
		'ecf_id' => __( 'Form ID', 'contact-form-lite')	,
		'ecf_editor' => __( 'Actions', 'contact-form-lite'),
			
	);  
	unset( $ecf_columns['Date'] );
	return $ecf_columns;  
}

function easycontactform_columns_edit_columns_list( $ecf_columns, $post_id ){

	switch ( $ecf_columns ) {
		
		case 'ecf_ttl':
		
		echo '<span class="dashicons dashicons-feedback" style="margin: 0px 5px 0px 0px;"></span> <strong>'.strip_tags( get_the_title( $post_id ) ).'</strong>';

	        break;
		
	    case 'ecf_id':
		
		echo $post_id;

	        break;
		
	    case 'ecf_sc':
		
		echo '<input size="30" readonly="readonly" value="[easy-contactform id='.$post_id.']" class="ecf-scode-block" type="text">';

	        break;
			
	    case 'ecf_editor':

		echo '<a class="ecf_tooltips" alt="Edit Form" href="'.get_edit_post_link( $post_id ).'"><span class="dashicons dashicons-edit ecf_form_actions"></span></a>'.( current_user_can('edit_posts') ? '<a class="ecf_tooltips" alt="Duplicate Form" href="'.admin_url( 'admin.php?action=ecf_duplicate_form&amp;post=' . $post_id . '"><span class="dashicons dashicons-admin-page ecf_form_actions"></span></a>' ) : '').'<a style="cursor:pointer;" class="ecf_tooltips" alt="Preview" onClick="alert(\'This feature only available in Pro Version.\')"><span class="dashicons dashicons-desktop ecf_form_actions"></span></a><a class="ecf_tooltips delforms" alt="Delete Form" href="'.( isset( $_GET['post_status'] ) && $_GET['post_status'] == 'trash' ? get_delete_post_link( $post_id, '', true ) : get_delete_post_link( $post_id ) ).'"><span class="dashicons dashicons-trash ecf_form_actions"></span></a>';
		
	        break;

		default:
			break;
	}  
}  

add_filter( 'manage_posts_custom_column',  'easycontactform_columns_edit_columns_list', 10, 2 );  


/*-------------------------------------------------------------------------------*/
/*  Put Style & Script
/*-------------------------------------------------------------------------------*/
function ecf_admin_head_overview() {
	
	global $post;
	
    if( isset( $post ) && $post->post_type == 'easycontactform' ) {
	
    	echo '<style type="text/css">
		.ecf-scode-block {
		padding: 4px;
		background: none repeat scroll 0% 0% rgba(0, 0, 0, 0.07);
		font-family: "courier new",courier;
		cursor: pointer;
		text-align: center;
		font-size:1em !important;
		border:1px dashed #ccc !important;
		}
		.ecf-shortcode-message {
    	font-style: italic;
    	color: #2EA2CC !important;
		}
		.column-ecf_sc {width: 275px;}
		.ecf_form_actions {margin-right: 15px !important;margin-top: 5px !important;}
		.ecf_tooltips[alt] { position: relative;}
		.ecf_tooltips[alt]:hover:after{
content: attr(alt);
padding: 3px 12px;
color: #85003a;
position: absolute;
white-space: nowrap;
z-index: 20;
left:0px;
top:33px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
-moz-box-shadow: 0px 0px 2px #c0c1c2;
-webkit-box-shadow: 0px 0px 2px #c0c1c2;
box-shadow: 0px 0px 2px #c0c1c2;
background-image: -moz-linear-gradient(top, #ffffff, #eeeeee);
background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #ffffff),color-stop(1, #eeeeee));
background-image: -webkit-linear-gradient(top, #ffffff, #eeeeee);
background-image: -moz-linear-gradient(top, #ffffff, #eeeeee);
background-image: -ms-linear-gradient(top, #ffffff, #eeeeee);
background-image: -o-linear-gradient(top, #ffffff, #eeeeee);}
.delforms:hover {color:rgb(171, 27, 27);}</style>';
		
		?>
		<script>
				
					jQuery(function($) {
						$('.ecf-scode-block').click( function () {
							try {
								//select the contents
								this.select();
								//copy the selection
								document.execCommand('copy');
								//show the copied message
								$('.ecf-shortcode-message').remove();
								$(this).after('<p class="ecf-shortcode-message"><?php _e( 'Shortcode copied to clipboard','easycform' ); ?></p>');
							} catch(err) {
								console.log('Oops, unable to copy!');
							}
						});
					});
				</script>
                
                <?php
				
	}

	
}
add_action( 'admin_head', 'ecf_admin_head_overview' );
/*-------------------------------------------------------------------------------*/
/*  Rename Sub Menu
/*-------------------------------------------------------------------------------*/
function ecf_rename_submenu() {  
    global $submenu;     
	$submenu['edit.php?post_type=easycontactform'][5][0] = __( 'Forms', 'contact-form-lite' );  
}  
add_action( 'admin_menu', 'ecf_rename_submenu' ); 


/*-------------------------------------------------------------------------------*/
/*   Hide & Disabled View, Quick Edit and Preview Button
/*-------------------------------------------------------------------------------*/
function ecf_remove_row_actions( $actions ) {
	global $post;
    if( $post->post_type == 'easycontactform' ) {
		unset( $actions['view'] );
		unset( $actions['inline hide-if-no-js'] );
	
	}
    return $actions;
}

if ( is_admin() ) {
	add_filter( 'post_row_actions','ecf_remove_row_actions', 10, 2 );
}


/*-------------------------------------------------------------------------------*/
/*   Create Session for Captcha
/*-------------------------------------------------------------------------------*/
function ecf_start_session() {
	
	@ini_set('session.use_trans_sid', '0');
	$char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));
	$str = rand(1, 7) . rand(1, 7) . $char;
	
    if( !session_id() ) {
        session_start();
		$_SESSION['ecf-captcha'] = $str;
    	}
}

if ( get_transient( 'ecf_captcha_transient' ) ) {
	add_action('init', 'ecf_start_session', 1);
	}
	

/*-------------------------------------------------------------------------------*/
/*   Load Plugin Functions
/*-------------------------------------------------------------------------------*/
include_once( ECF_PLUGIN_DIR . 'inc/functions/ecf-functions.php' );
include_once( ECF_PLUGIN_DIR . 'inc/ecf-tinymce.php' );
include_once( ECF_PLUGIN_DIR . 'inc/ecf-metaboxes.php' );
include_once( ECF_PLUGIN_DIR . 'inc/ecf-shortcode.php' );
include_once( ECF_PLUGIN_DIR . 'inc/ecf-opt-loader.php' );
include_once( ECF_PLUGIN_DIR . 'inc/functions/ecf-mail.php' );
include_once( ECF_PLUGIN_DIR . 'inc/ecf-entries.php' ); // @since 1.0.3 > 5 ( BETA )
include_once( ECF_PLUGIN_DIR . 'inc/ecf-widget.php' );

/*-------------------------------------------------------------------------------*/
/*   Featured Plugins Page
/*-------------------------------------------------------------------------------*/
if ( is_admin() ){
	
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-freeplugins.php' );
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-featured.php' );
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-pricing.php' ); 
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-settings.php' );
	include_once( ECF_PLUGIN_DIR . 'inc/ecf-notice.php' );
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-analytics.php' ); // @since 1.0.11
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-addons.php' ); // @since 1.0.11
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-freethemes.php' ); // @since 1.0.93
	include_once( ECF_PLUGIN_DIR . 'inc/pages/ecf-welcome.php' ); // @since 1.0.11

	}
	
	
/*-------------------------------------------------------------------------------*/
/*   Redirect to Pricing Table on Activate
/*-------------------------------------------------------------------------------*/	

function ecf_plugin_activate() {

  add_option( 'activatedecf', 'ecf-activate' );

}
register_activation_hook( __FILE__, 'ecf_plugin_activate' );


/*-------------------------------------------------------------------------------*/
/*   Auto Update
/*-------------------------------------------------------------------------------*/	
$ecf_auto_updt = get_option( "ecf-settings-automatic_update" );

switch ( $ecf_auto_updt ) {
	
	case 'active':
		if ( !wp_next_scheduled( "ecf_auto_update" ) ) {
			wp_schedule_event( time(), "daily", "ecf_auto_update" );
			}
		add_action( "ecf_auto_update", "plugin_ecf_auto_update" );
	break;
	
	case 'inactive':
		wp_clear_scheduled_hook( "ecf_auto_update" );
	break;	
	
	case '':
		wp_clear_scheduled_hook( "ecf_auto_update" );
		update_option( "ecf-settings-automatic_update", 'active' );
	break;
					
}

function plugin_ecf_auto_update() {
	try
	{
		require_once( ABSPATH . "wp-admin/includes/class-wp-upgrader.php" );
		require_once( ABSPATH . "wp-admin/includes/misc.php" );
		if ( !defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
			}
		require_once( ABSPATH . "wp-includes/update.php" );
		require_once( ABSPATH . "wp-admin/includes/file.php" );
		wp_update_plugins();
		ob_start();
		$plugin_upg = new Plugin_Upgrader();
		$plugin_upg->upgrade( "contact-form-lite/easy-contact-form.php" );
		$output = @ob_get_contents();
		@ob_end_clean();
	}
	catch(Exception $e)
	{
	}
}