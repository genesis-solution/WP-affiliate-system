<?php
defined( 'ABSPATH') || exit;
?>
<div class="wslu-social-login-main-wrapper">
	<?php 
	require_once( WSLU_LOGIN_PLUGIN . '/template/admin/counter/tab-menu.php');
	if($message_global == 'show'){?>
	<div class="admin-page-framework-admin-notice-animation-container">
		<div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
			<p><?php echo esc_html__('Global setting data have been updated.', 'wp-social');?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social');?></span></button>
		</div>
	</div>
	<?php } ?>

	<form action="<?php echo esc_url(admin_url().'admin.php?page=wslu_counter_setting');?>" name="global_setting_submit_form" method="post" id="xs_global_form">
		<div class="social-block-wraper">
			<div class="global-section">

				<div class="wslu-single-item wslu-align-center">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Cache (hours)', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">

						<input class="global-input-text wslu-global-input"  type="text" id="cache_setup" name="xs_counter[global][cache]" value="<?php echo esc_html(isset($return_data['global']['cache']) ? $return_data['global']['cache'] : 12);?>" >
						
					</div>
				</div> <!-- ./ end item -->


               <div class="wslu-single-item">

                    <div class="wslu-left-label">
                        <label class="wslu-sec-title" for=""><?php echo esc_html__('Use theme default font family', 'wp-social'); ?></label>
                    </div>

                    <div class="wslu-right-content wslu-inline">

                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_counter[show_font_from_theme]" value="1" <?php echo esc_attr((!empty($return_data['show_font_from_theme'])) ? 'checked' : ''); ?>>

							<?php echo esc_html__('Yes', 'wp-social'); ?>
                        </label>

                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_counter[show_font_from_theme]" value="0" <?php echo esc_attr((empty($return_data['show_font_from_theme'])) ? 'checked' : ''); ?>>

							<?php echo esc_html__('No', 'wp-social'); ?>
						</label>
						
						<div class="wslu-help-text">
							<p><?php esc_html_e('Choose "Yes" if you want to use the default font family of the theme installed on your website.', 'wp-social'); ?></p>
						</div>
                    </div>
               </div>

				<!-- Submit Button -->
				<div class="wslu-single-item wslu-align-center">
					
					<div class="wslu-left-label">&nbsp;</div>

					<div class="wslu-right-content">
					<?php wp_nonce_field( 'counter_settings_submit_form_global_nonce', 'nonce' ); ?>
						<button type="submit" name="counter_settings_submit_form_global" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social');?></button>
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- Shortcode section -->
				<div class="wslu-single-item wslu-align-center">
					
					<div class="wslu-left-label"><label class="wslu-sec-title" for=""><?php echo esc_html__('Shortcode ', 'wp-social');?></label></div>

					<div class="wslu-right-content">
						<ol class="wslu-social-shortcodes">
							<li>[xs_social_counter] </li>
							<li>[xs_social_counter provider="facebook,twitter,instagram" class="custom-class"] </li>
							<li>[xs_social_counter provider="facebook" class="custom-class" style="" hover="top-tooltip"]</li>
							<li>[xs_social_counter provider="all" class="" style="style-2" hover="top-tooltip"]</li>
						</ol>
					</div>
				</div> <!-- ./ End Single Item -->

			</div>
		</div>
	</form>
</div>