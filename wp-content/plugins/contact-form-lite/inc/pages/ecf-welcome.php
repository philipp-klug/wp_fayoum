<?php
/**
 * Weclome Page Class
 *
 * @package     ECF
 * @since       1.0.11
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ECF_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.0.11
 */
class ECF_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @since 1.0.11
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ecf_admin_menus') );
		add_action( 'admin_head', array( $this, 'ecf_admin_head' ) );
		add_action( 'admin_init', array( $this, 'ecf_welcome_page' ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function ecf_admin_menus() {

			// What's New / Overview
    		add_submenu_page('edit.php?post_type=easycontactform', 'What\'s New', 'What\'s New<span class="ecf-menu-blink">NEW</span>', $this->minimum_capability, 'ecf-whats-new', array( $this, 'ecf_about_screen') );
			
			// Changelog Page
    		add_submenu_page('edit.php?post_type=easycontactform', ECF_ITEM_NAME.' Changelog', ECF_ITEM_NAME.' Changelog', $this->minimum_capability, 'ecf-changelog', array( $this, 'ecf_changelog_screen') );
			
			// Getting Started Page
    		add_submenu_page('edit.php?post_type=easycontactform', 'Getting started with '.ECF_ITEM_NAME.'', 'Getting started with '.ECF_ITEM_NAME.'', $this->minimum_capability, 'ecf-getting-started', array( $this, 'ecf_getting_started_screen') );
			
			// Free Plugins Page
    		add_submenu_page('edit.php?post_type=easycontactform', 'Free Install Plugins', 'Free Install Plugins', $this->minimum_capability, 'ecf-free-plugins', array( $this, 'free_plugins_screen') );
			
			// Premium Plugins Page
    		add_submenu_page('edit.php?post_type=easycontactform', 'Premium Plugins', 'Premium Plugins', $this->minimum_capability, 'ecf-premium-plugins', array( $this, 'premium_plugins_screen') );
			
			// Free Themes Page
			add_submenu_page('edit.php?post_type=easycontactform', 'Free Themes', 'Free Themes', $this->minimum_capability, 'ecf-free-themes', array( $this, 'free_themes_screen') );
			
			// Addons Page
    		add_submenu_page('edit.php?post_type=easycontactform', 'Addons', 'Addons', $this->minimum_capability, 'ecf-addons', array( $this, 'addons_plugins_screen') );
			
			// Earn EXTRA MONEY Page
    		add_submenu_page('edit.php?post_type=easycontactform', 'Earn EXTRA MONEY', 'Earn EXTRA MONEY', $this->minimum_capability, 'ecf-earn-xtra-money', array( $this, 'earn_plugins_screen') );
		
			// Analytics Page
			add_submenu_page('edit.php?post_type=easycontactform', 'Form Analytics', __('Form Analytics', 'contact-form-lite'), $this->minimum_capability, 'easycform-form-analytics', 'easycform_analytics');	
			
			// Pricing Page
			add_submenu_page('edit.php?post_type=easycontactform', 'Pricing & compare tables', __('UPGRADE to PRO', 'contact-form-lite'), $this->minimum_capability, 'easycform_comparison', 'easycform_pricing_table');
			
			// Settings Page
			add_submenu_page('edit.php?post_type=easycontactform', 'Global Settings', __('Global Settings', 'contact-form-lite'), $this->minimum_capability, 'ecf_settings_page', 'ecf_stt_page');
			
				
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function ecf_admin_head() {
		
		remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-changelog' );
		remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-getting-started' );
		//remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-free-plugins' );
		//remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-premium-plugins' );
		remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-addons' );
		remove_submenu_page( 'edit.php?post_type=easycontactform', 'ecf-earn-xtra-money' );
		remove_submenu_page( 'edit.php?post_type=easycontactform', 'easycform-form-analytics' );

		// Badge for welcome page
		$badge_url = ECF_URL . '/css/images/assets/mailman-logo.png';
		
		?>
        
        <script type="text/javascript">
        /*<![CDATA[*/
				jQuery(document).ready(function($) {
					
				<?php global $pagenow;
				
				if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'ecf-premium-plugins' ) || ( isset( $_GET['page'] ) && $_GET['page'] == 'ecf-addons' ) ){
					
					wp_enqueue_script( 'ecf-lazyload' );
					
					echo '$("img.lazy").each(function() {$(this).attr("data-src",$(this).attr("src"));$(this).removeAttr("src alt");}); 
					
					$(function() {$(".lazy").lazy({effect : "fadeIn",afterLoad: function(element) {element.removeClass("ghozypreloader");},});});';
					
					}
				?>
					
					
					if ( $( '.ecftabs' ).length ) {	
					
						var prevecfPosition = $('.ecftabs').offset();
					
						$(window).scroll(function(){
							
							if($(window).scrollTop() > prevecfPosition.top) {
								
								if(! $('.ecf-theme-list').length) {
									$('.ecftabs').addClass('ecftabfixed');
								}
								
								}
								
								else {
									
									$('.ecftabs').removeClass('ecftabfixed');
									
									}
									
							});	
							
						}
						
					function shorten_text(el, maxLength) {
						var ret = el.text();
						if (ret.length > maxLength) {
							ret = ret.substr(0,maxLength-3) + "...";
							}
							el.text(ret).show();
					}
					
					$('.ecf-free-theme-page').find('.theme-desc').each(function(){
						shorten_text($(this), 300);
					});
					
					$('.ecf-free-theme-page').find('.theme-details-ratings').each(function(){	
						var $col = $(this).find(".rating-color");
						for(var i = 0; i < 4; i++){
							$col.clone().appendTo($(this));
							}
					});
					
				});
          /*]]>*/      
         </script>
        
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		
		/* Theme list */
		#ghozy-free-themes .feature-section {
			margin-top:0;
			padding-top:20px;	
		}
		.theme-list-container {
			position: relative;
			width: 100%;
			display:block;
		}
		
		ul.free-themes-list {
			list-style-type: none;
		}
		
		li.free-themes-item {
			position:relative;
			display:inline-block;
			border:solid 1px #ccc;
			float: left;
			width: 48.8%;
			margin: 0 2% 3% 0;
			background-color: #fff;
		}
		
		li.no-left-margin {
		margin-right:0 !important;	
		}
		
		.theme-details-cont {
			position:relative;
			padding: 15px;
			border-top: 3px solid #e5e5e5;
		}
		
		.theme-sc {
			position:relative;
			display: block;
			vertical-align:top;
			max-width: 100%;
			max-height: 300px;
			overflow-y: scroll;
			overflow-x: hidden;
		}
		
		.theme-sc img {
			width: 100%;
			height: auto;	
			margin: 0;
			padding: 0;
			display: block;
			vertical-align:top;
			margin-bottom:0 !important;
		}
		
		.theme-desc-cont {
			width: 100%;	
			position:relative;
			display: block;
			vertical-align:bottom;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		
		.theme-desc {
			display: none;
			margin-top: 10px;
			color: #726f6f;
			border-top: 1px solid #f1f1f1;
			padding-top: 10px;
			line-height: 1.5;
		}
		
		.theme-desc-cont h3 {
			margin: 0;
			line-height: 1.9;
			display: inline-block;
		}
		
		.theme-by {
			display: inline-block;
			margin: 0 0 0 10px;
			font-style:italic;
			font-size: 14px;
			position: relative;
			top: -1px;
		}
		
		.theme-details-footer {
			position:relative;
			display:block;
			border-top: 1px solid #c2c2c2;
			background-color: #efefef;
			padding: 15px;
			line-height: 1.6;
		}
		
		.theme-details-ratings {
			display: inline-block;
			position: relative;
			top: 5px;
			margin-right: 5px;
			width: auto;
		}
		
		.rating-color {
			color: #F90;
			font-size: 16px;
		}
		
		.rating-content {
			display: inline-block;
			position: relative;
			font-size: 13px;
		}
		
		.theme-details-actions {
			display: inline-block;
			position: relative;
			text-align:right;
			width:55%;
		}
		
		.install-theme-now,
		.switch-theme-now,
		.upgrade-theme-now {
			margin-left: 10px !important;
		}
		.button-secondary.upgrade-theme-now {
			color: #fff;
			border-color: #b77b2b;
			background: #f0711e;
			-webkit-box-shadow: 0 1px 0 #ccc;
			box-shadow: 0 1px 0 #ccc;
			vertical-align: top;
		}
		
		.button-secondary.upgrade-theme-now:hover,
		.button-secondary.upgrade-theme-now:active,
		.button-secondary.upgrade-theme-now:focus {
			color: #fff;
			background: #e36820;
			border-color: #c75100;
		}
		
		.active-theme-cont {
			display: inline-block;
			position: relative;
			text-align:right;
			width:55%;
		}
		
		.dashicons.active-theme {
			color: #0C3;
			margin-top: 4px;
		}
		
		.current-active-theme {
			
		}
		
		/* Effect */
		.drop-shadow:before,
		.drop-shadow:after {
			content:"";
			position:absolute; 
			z-index:-2;
		}

		/* Lifted corners */
		
		.lifted {
			-moz-border-radius:4px; 
				 border-radius:4px;
		}
		
		.lifted:before,
		.lifted:after { 
			bottom:15px;
			left:10px;
			width:50%;
			height:20%;
			max-width:300px;
			-webkit-box-shadow:0 15px 10px rgba(0, 0, 0, 0.7);   
			   -moz-box-shadow:0 15px 10px rgba(0, 0, 0, 0.7);
					box-shadow:0 15px 10px rgba(0, 0, 0, 0.7);
			-webkit-transform:rotate(-3deg);    
			   -moz-transform:rotate(-3deg);   
				-ms-transform:rotate(-3deg);   
				 -o-transform:rotate(-3deg);
					transform:rotate(-3deg);
		}
		
		.lifted:after {
			right:10px; 
			left:auto;
			-webkit-transform:rotate(3deg);   
			   -moz-transform:rotate(3deg);  
				-ms-transform:rotate(3deg);  
				 -o-transform:rotate(3deg);
					transform:rotate(3deg);
		}
		
		/* End Theme List */
		
		.ecf-container-cnt .feature-section p {
			max-width: 100% !important;	
		}
		
		.ghozypreloader {width:100% !important; height:auto !important; background:url(<?php echo ECF_URL . '/inc/images/ajax-loader.gif'; ?>) center center no-repeat !important; text-align:center;}
		
		.ecftabs{
			width:auto;
			height:50px;
			padding:10px;
			margin-top: 50px;
			}
		
		.ecftabfixed {
			position: fixed;
			-webkit-box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			background:#EAEAEA;
			z-index: 999;
			margin: 0px auto;
			width: 100%;
			/* max-width: 1050px; */
			left: 0px;
			top: 0px;
			padding-left: 210px;
			padding-top: 32px;
			
			-webkit-animation: fadein 1s; /* Safari, Chrome and Opera > 12.1 */
			-moz-animation: fadein 1s; /* Firefox < 16 */
        	-ms-animation: fadein 1s; /* Internet Explorer */
         	-o-animation: fadein 1s; /* Opera < 12.1 */
            animation: fadein 1s;
			
			}
			
			@keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Firefox < 16 */
			@-moz-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Safari, Chrome and Opera > 12.1 */
			@-webkit-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Internet Explorer */
			@-ms-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Opera < 12.1 */
			@-o-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}
			
		.ecftabfixed h2 {
			border-bottom : 1px dashed #DADADA !important;
		}

		.ecf-menu-blink {
			padding:0px 6px 0px 6px;
			background-color: #E74C3C;
			border-radius:9px;
			-moz-border-radius:9px;
			-webkit-border-radius:9px;
			margin-left:5px;
			color:#fff;
			font-size:10px !important;
    		outline:none;
    		text-decoration: none;
		}

		.ecf-menu-blink:hover {
    		-webkit-animation:none;
    		-moz-animation: none;
    		animation: none;
		}
		
		
		.ecf-badge {
			padding-top: 150px;
			height: 128px;
			width: 128px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .ecf-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.ecf-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}

		.about-wrap .feature-section {
			margin-top: 20px;
		}
		
		
		.about-wrap .feature-section .plugin-card h4 {
    		margin: 0px 0px 12px;
    		font-size: 18px;
    		line-height: 1.3;
		}
		
		.about-wrap .feature-section .plugin-card-top p {
    		font-size: 13px;
    		line-height: 1.5;
    		margin: 1em 0px;
		}	
				
		.about-wrap .feature-section .plugin-card-bottom {
    		font-size: 13px;
		}	
		
		.customh3 {

		}
		
		
		.customh4 {
			display:inline-block;
			border-bottom: 1px dashed #CCC;
		}
		
		
		.ecf-dollar {
		
		background: url('<?php echo ECF_URL . '/css/images/assets/dollar.png'; ?>') no-repeat;
		color: #2984E0;
			
		}
		
		.ecf-affiliate-screenshots {
			-webkit-box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			-moz-box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			float: right;
			margin: 20px 0 30px 30px !important;
		}
		
		
		.button_loading {
    		background: url('<?php echo ECF_URL . '/css/images/assets/gen-loader.gif'; ?>') no-repeat 50% 50%;
    		/* apply other styles to "loading" buttons */
			display:inline-block;
			position:relative;
			width: 16px;
			height: 16px;
			top: 17px;
			margin-left: 10px;
			}
			
		.ecf-aff-note {
			color:#F00;
			font-size:12px;
			font-style:italic;
		}
		
		

		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation tabs
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function ecf_tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'ecf-whats-new';
		?>
       <div class="ecftabs">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'ecf-whats-new' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-whats-new' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( "What's New", 'contact-form-lite' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'ecf-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-getting-started' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( 'Getting Started', 'contact-form-lite' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'ecf-addons' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-addons' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( 'Addons', 'contact-form-lite' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'ecf-free-themes' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-free-themes' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( 'Free Themes', 'contact-form-lite' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'ecf-free-plugins' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-free-plugins' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( 'Free Plugins', 'contact-form-lite' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'ecf-premium-plugins' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-premium-plugins' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( 'Premium Plugins', 'contact-form-lite' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'ecf-earn-xtra-money' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-earn-xtra-money' ), 'edit.php?post_type=easycontactform' ) ) ); ?>">
				<?php _e( '<span class="ecf-dollar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extra</span>', 'contact-form-lite' ); ?>
			</a>
		</h2>
       </div> 
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function ecf_about_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>
            
            <?php ecf_lite_get_news();  ?>

			<div class="ecf-container-cnt">
				<h3 class="customh3"><?php _e( 'New Welcome Page', 'contact-form-lite' );?></h3>

				<div class="feature-section">

					<p><?php _e( 'Version 1.0.13 introduces a comprehensive welcome page interface. The easy way to get important informations about this product and other related plugins.', 'contact-form-lite' );?></p>
                    
					<p><?php _e( 'In this page, you will find four important Tabs named Getting Started, Addons, Free Themes, Free Plugins and Premium Plugins.', 'contact-form-lite' );?></p>

				</div>
			</div>

			<div class="ecf-container-cnt">
				<h3 class="customh3"><?php _e( 'ADDONS', 'contact-form-lite' );?></h3>

				<div class="feature-section">

					<p><?php _e( 'Need some Pro version features to be applied in your Free version? What you have to do just go to <strong>Addons</strong> page and choose any Addons that you want to install. All listed addons are Premium version.', 'contact-form-lite' );?></p>

				</div>
			</div>

			<div class="ecf-container-cnt">
				<h3><?php _e( 'Additional Updates', 'contact-form-lite' );?></h3>

				<div class="feature-section col three-col">
					<div>

						<h4><?php _e( 'CSS Clean and Optimization', 'contact-form-lite' );?></h4>
						<p><?php _e( 'We have improved some css class to make your form for look fancy and better.', 'contact-form-lite' );?></p>

					</div>

					<div>

						<h4><?php _e( 'Disable Notifications', 'contact-form-lite' );?></h4>
						<p><?php _e( 'In this version you will no longer see some annoying notifications in top of form editor page. Thanks for who suggested it.' ,'contact-form-lite' );?></p>
                        
					</div>

					<div class="last-feature">

						<h4><?php _e( 'Improved WP Mail Function', 'contact-form-lite' );?></h4>
						<p><?php _e( ' WP Mail function has been improved to be more robust and fast so you can send an email only in seconds.', 'contact-form-lite' );?></p>

					</div>

				</div>
			</div>

			<div class="return-to-dashboard">&middot;<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ecf-changelog' ), 'edit.php?post_type=easycontactform' ) ) ); ?>"><?php _e( 'View the Full Changelog', 'contact-form-lite' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Changelog Screen
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function ecf_changelog_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php _e( ECF_ITEM_NAME. ' Changelog', 'contact-form-lite' ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">
				<h3><?php _e( 'Full Changelog', 'contact-form-lite' );?></h3>
				<div>
					<?php echo $this->parse_readme(); ?>
				</div>
			</div>

		</div>
		<?php
	}

	/**
	 * Render Getting Started Screen
	 *
	 * @access public
	 * @since 1.9
	 * @return void
	 */
	public function ecf_getting_started_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<p class="about-description"><?php _e( 'There are no complicated instructions for using Contact Form plugin because this plugin designed to make all easy. Please watch the following video and we believe that you will easily to understand it just in minutes :', 'contact-form-lite' ); ?></p>

			<div class="ecf-container-cnt">
				<div class="feature-section">
                <iframe width="853" height="480" src="https://www.youtube.com/embed/_3lsRi9C77k?rel=0" frameborder="0" allowfullscreen></iframe>
			</div>
            </div>

			<div class="ecf-container-cnt">
				<h3><?php _e( 'Need Help?', 'contact-form-lite' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Phenomenal Support','contact-form-lite' );?></h4>
					<p><?php _e( 'We do our best to provide the best support we can. If you encounter a problem or have a question, post a question in the <a href="https://wordpress.org/support/plugin/contact-form-lite" target="_blank">support forums</a>.', 'contact-form-lite' );?></p>

					<h4><?php _e( 'Need Even Faster Support?', 'contact-form-lite' );?></h4>
					<p><?php _e( 'Just upgrade to <a target="_blank" href="http://demo.ghozylab.com/plugins/easy-contact-form-plugin/pricing-compare-tables/">Pro version</a> and you will get Priority Support are there for customers that need faster and/or more in-depth assistance.', 'contact-form-lite' );?></p>

				</div>
			</div>

			<div class="ecf-container-cnt">
				<h3><?php _e( 'Stay Up to Date', 'contact-form-lite' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Get Notified of Addons Releases','contact-form-lite' );?></h4>
					<p><?php _e( 'New Addons that make '.ECF_ITEM_NAME.' even more powerful are released nearly every single week. Subscribe to the newsletter to stay up to date with our latest releases. <a target="_blank" href="http://eepurl.com/bq3RcP" target="_blank">Signup now</a> to ensure you do not miss a release!', 'contact-form-lite' );?></p>

				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render Free Plugins
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function free_plugins_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">

				<div class="feature-section">
					<?php echo easycform_free_plugin_page(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	/**
	 * Render Premium Plugins
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function premium_plugins_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap" id="ghozy-featured">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">
			<p style="margin-bottom:50px;"class="about-description"></p>

				<div class="feature-section">
					<?php echo easycform_get_feed(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	/**
	 * Render Free Themes Page
	 *
	 * @access public
	 * @since 1.1.15
	 * @return void
	 */
	public function free_themes_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap ecf-free-theme-page" id="ghozy-free-themes">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your slider more fancy and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">
				<div class="feature-section">
					<?php if ( current_user_can( 'install_themes' ) ) echo ecf_lite_free_themes(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render Addons Page
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function addons_plugins_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap" id="ghozy-addons">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">
			<p style="margin-bottom:50px;"class="about-description"></p>

				<div class="feature-section">
					<?php echo ecf_lite_get_addons_feed(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render Addons Page
	 *
	 * @access public
	 * @since 1.0.11
	 * @return void
	 */
	public function earn_plugins_screen() {
		list( $display_version ) = explode( '-', ECF_VERSION );
		?>
		<div class="wrap about-wrap" id="ghozy-addons">
			<h1><?php printf( __( 'Welcome to '.ECF_ITEM_NAME.'', 'contact-form-lite' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.ECF_ITEM_NAME.'. This plugin is ready to make your form more fancy, safer, and better!', 'contact-form-lite' ), $display_version ); ?></div>
			<div class="ecf-badge"><?php printf( __( 'Version %s', 'contact-form-lite' ), $display_version ); ?></div>

			<?php $this->ecf_tabs(); ?>

			<div class="ecf-container-cnt">
				<div class="feature-section">
					<?php ecf_earn_xtra_money(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	

	/**
	 * Parse the Easy Form readme.txt file
	 *
	 * @since 2.0.3
	 * @return string $readme HTML formatted readme file
	 */
	public function parse_readme() {
		$file = file_exists( ECF_PLUGIN_DIR . 'readme.txt' ) ? ECF_PLUGIN_DIR . 'readme.txt' : null;

		if ( ! $file ) {
			$readme = '<p>' . __( 'No valid changlog was found.', 'contact-form-lite' ) . '</p>';
		} else {
			$readme = file_get_contents( $file );
			$readme = nl2br( esc_html( $readme ) );
			$readme = explode( '== Changelog ==', $readme );
			$readme = end( $readme );

			$readme = preg_replace( '/`(.*?)`/', '<code>\\1</code>', $readme );
			$readme = preg_replace( '/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme );
			$readme = preg_replace( '/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme );
			$readme = preg_replace( '/= (.*?) =/', '<h4>\\1</h4>', $readme );
			$readme = preg_replace( '/\[(.*?)\]\((.*?)\)/', '<a href="\\2">\\1</a>', $readme );
			$readme = str_replace("*","<span class='dashicons dashicons-arrow-right'></span>", $readme );
		}

		return $readme;
	}

	/**
	 * Sends user to the Welcome page on first activation of Easy Form as well as each
	 * time Easy Form is upgraded to a new version
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function ecf_welcome_page() {	
		
    if ( is_admin() && get_option( 'activatedecf' ) == 'ecf-activate' && !is_network_admin() ) {
		delete_option( 'activatedecf' );
		wp_safe_redirect( admin_url( 'edit.php?post_type=easycontactform&page=ecf-whats-new' ) ); exit;
		
    	}

	}
}
new ECF_Welcome();
