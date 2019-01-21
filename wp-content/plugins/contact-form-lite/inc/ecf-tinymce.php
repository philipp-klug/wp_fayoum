<?php


if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
	
// ADD STYLE & SCRIPT
	add_action( 'admin_head', 'ecf_editor_add_init' );
		function ecf_editor_add_init() {
			
			if ( get_post_type( get_the_ID() ) != 'easycontactform' ) {
				
				wp_enqueue_style( 'ecf-tinymcecss' );
				wp_enqueue_script( 'ecf-tinymcejs' );
				
				$tinymcedata = array(
						'sc_icon' => plugins_url( 'images/ecf-cp-icon.png' , __FILE__ ),
						'sc_version' => ECF_VERSION
						);
				
				wp_localize_script( 'ecf-tinymcejs', 'ecf_tinymce_vars', $tinymcedata );

		?>
        <?php
			}
			
		}
	
// ADD MEDIA BUTOON	
	add_action( 'media_buttons_context', 'ecf_shortcode_button', 1 );
		function ecf_shortcode_button($context) {
			$img = plugins_url( 'images/ecf_sc_manager.png' , __FILE__ );
			$container_id = 'ecfmodal';
			$title = 'Shortcode Generator';
			$context .= '
			<a class="thickbox button" id="ecf_shortcode_button" title="'.$title.'" style="outline: medium none !important; cursor: pointer;" >
			<img src="'.$img.'" alt="Easy Contact Form Pro" width="20" height="20" style="position:relative; top:-1px"/>Easy Contact Form</a>';
			return $context;
		}	
}


// GENERATE POPUP CONTENT
add_action('admin_footer', 'ecf_popup_content');	
function ecf_popup_content() {

if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {

if ( get_post_type( get_the_ID() ) != 'easycontactform' ) {
// START GENERATE POPUP CONTENT

?>
<div id="ecfmodal" style="display:none;">
<div id="tinyform">
<form method="post">

<div class="ecf_input" id="ecftinymce_select_form_div">
<label class="ecf_label_option" for="ecftinymce_select_form">Select Form</label>
	<select class="ecf_select" name="ecftinymce_select_form" id="ecftinymce_select_form">
    <option id="selectform" type="text" value="select">- Select form -</option>
</select>
<div class="clearfix"></div>
</div>

<div class="ecf_button">
<input type="button" value="Insert Shortcode" name="ecf_insert_scrt" id="ecf_insert_scrt" class="button-secondary" />	
<div class="clearfix"></div>
</div>

<div style="border-top: 1px solid #DDD; margin-top:10px; padding: 7px;display:block; width:505px;"></div>
<div style="display:inline-block;">
<h4 class="ecf_pro_here">Pro Version DEMO :</h4>
<ul class="ecf_pro_demo_list">
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-form-registration/" target="_blank">Form Registration</a></li>
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-form-job-application/" target="_blank">Form Job Application</a></li>
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-form-with-image-in-header/" target="_blank">Form with Image in Header</a></li>
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-fields/" target="_blank">Form with All Fields</a></li>
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-newsletter-signup/" target="_blank">Form Newsletter Signup</a></li>
<li><a href="https://demo.ghozylab.com/plugins/easy-contact-form-plugin/contact-form-recaptcha/" target="_blank">Form with reCAPTCHA</a></li>
</ul>
<div class="clearfix"></div>
</div>
<div style="display:inline-block; float: right; position: absolute; right:50px; bottom: 0;">
<img src="<?php echo plugins_url( 'images/goto_pro_version.png' , __FILE__ ); ?>" alt="Pro Version" width="130" height="182" style="margin-left:100px;"/>
</div>

</form>
</div>
</div>
<?php 
	}
  } //END
}

?>