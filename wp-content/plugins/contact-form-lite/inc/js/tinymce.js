jQuery(document).ready(function($) {
	
			FormList = jQuery('#ecftinymce_select_form');
			var ecf_H = 390;
			var ecf_W = 550;
			

// END LOAD MEDIA

	jQuery("body").delegate("#ecf_shortcode_button","click",function(){	

			FormList.find('option').remove();
			jQuery("<option/>").val(0).text('Loading...').appendTo(FormList);
			
		setTimeout(function() {
			tb_show( '<img class="ecf_sc_ttl_ico" src="'+ecf_tinymce_vars.sc_icon+'" alt="Easy Contact Form">Shortcode Generator<span class="ecf_cp_version">v'+ecf_tinymce_vars.sc_version+'</span>', '#TB_inline?height='+ecf_H+'&width='+ecf_W+'&inlineId=ecfmodal' );
			jQuery("#TB_window").addClass("TB_ecf_window").css('z-index','999999');
			jQuery("#TB_ajaxContent").addClass("TB_ecf_ajaxContent");
			jQuery(".TB_ecf_ajaxContent").css('height','auto');
			jQuery("select#ecftinymce_select_form").val("select");
			ecf_H = 390;
			
			$("#TB_closeWindowButton").replaceWith($("<div class='closetb' id='TB_closeWindowButton'><span class='screen-reader-text'>Close</span><span class='tb-close-icon'></span></div>"));
			
			grabform();
			ecftbReposition();
			

		}, 300);	
		
	});
	
	// Close Thickbox
	$("body").delegate(".closetb","click",function(){
		tb_remove();
	});
	
	// add the shortcode to the post editor
	jQuery('#ecf_insert_scrt').on("click", function () {

		if ( jQuery( "#ecftinymce_select_form" ).val() != 'select' ) {
		
			var sccode;
			sccode = "[easy-contactform id="+jQuery( "#ecftinymce_select_form option:selected" ).val()+"]";
		
			if( jQuery('#wp-content-editor-container > textarea').is(':visible') ) {
				var val = jQuery('#wp-content-editor-container > textarea').val() + sccode;
				jQuery('#wp-content-editor-container > textarea').val(val);	
				}
				else {
				tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sccode);
					}

			tb_remove();
			}
			else {
				alert('Please select form first!');
				//tb_remove();
				}
		});	
		
		
		function grabform() {
			
					jQuery.ajax({
					url: ajaxurl,
					data:{
						'action': 'ecf_grab_form_list_ajax',
						'grabform': 'yes'
					},
					dataType: 'JSON',
					type: 'POST',
					success:function(response){
						FormList.find('option').remove();
						jQuery("<option/>").val('select').text('- Select Form -').appendTo(FormList);
						jQuery.each(response, function(i, option)
						{
							jQuery("<option/>").val(option.val).text(option.title).appendTo(FormList);
						});
					},
					error: function(errorThrown){
					   jQuery("<option/>").val('select').text('- Select Form -').appendTo(FormList);
					}
					
				}); // End Grab	
				
		}
	
		// Reposition Thickbox
		function ecftbReposition() {
			
			$('.TB_ecf_window').css({
				'top' : ((jQuery(window).height() - ecf_H) / 6) + 'px',
				'left' : ((jQuery(window).width() - ecf_W) / 4) + 'px',
				'margin-top' : ((jQuery(window).height() - ecf_H) / 6) + 'px',
				'margin-left' : ((jQuery(window).width() - ecf_W) / 4) + 'px',
				'max-height' : parseInt(ecf_H) + 'px',
				'min-height' : parseInt(ecf_H) + 'px',
			});
				
		}
		
		$(window).resize(function() {
			
			ecftbReposition();
			
		});	
		
		
});