<?php
defined( 'ABSPATH') || exit;
?>
<div class="wslu-social-login-main-wrapper">
	<?php
	require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/tab-menu.php');
	if ($message_global == 'show') { ?>
		<div class="admin-page-framework-admin-notice-animation-container">
			<div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
				<p><?php echo esc_html__('Global setting data have been updated.', 'wp-social'); ?></p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span></button>
			</div>
		</div>
	<?php } ?>


    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting'); ?>" name="share_global_setting_form" method="post" id="share_global_setting_form">

        <div class="xs-social-block-wraper">
            <div class="xs-global-section">

                <div class="wslu-single-item">

                    <div class="wslu-left-label">
                        <label class="wslu-sec-title" for=""><?php echo esc_html__('Use theme default font family', 'wp-social'); ?></label>
                    </div>

                    <div class="wslu-right-content wslu-inline">

                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_share[show_font_from_theme]" value="1" <?php echo esc_attr((!empty($return_data['show_font_from_theme'])) ? 'checked' : ''); ?>>

				            <?php echo esc_html__('Yes', 'wp-social'); ?>
                        </label>

                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_share[show_font_from_theme]" value="0" <?php echo esc_attr((empty($return_data['show_font_from_theme'])) ? 'checked' : ''); ?>>

				            <?php echo esc_html__('No', 'wp-social'); ?>
						</label>
						
						<div class="wslu-help-text">
							<p><?php esc_html_e('Choose "Yes" if you want to use the default font family of the theme installed on your website.', 'wp-social'); ?></p>
						</div>
                    </div>
                </div>

				<div class="wslu-single-item">
					<div class="wslu-left-label">&nbsp;</div>
					<div class="wslu-right-content">
					<?php wp_nonce_field( 'share_global_setting_submit_form_nonce', 'nonce' ); ?>
						<button type="submit" name="share_global_setting_submit_form" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
					</div>
				</div>
				

            </div>
        </div>

    </form>

	<!-- <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting'); ?>" name="global_setting_submit_form" method="post" id="xs_global_form">
		<div class="social-block-wraper">
			<div class="global-section">

				<div class="wslu-single-item">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Hide Icon', 'wp-social'); ?></label>
					</div>

					<div class="wslu-right-content">

						<input class="social_switch_button" type="checkbox" id="enable_shoe_icon_enable" name="xs_share[global][show_icon][enable]" value="1" <?php echo (isset($return_data['global']['show_icon']['enable']) && $return_data['global']['show_icon']['enable'] == 1) ? 'checked' : ''; ?>>
						<label for="enable_shoe_icon_enable" class="social_switch_button_label"></label>

					</div>
				</div>

				<div class="wslu-single-item">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Hide Text', 'wp-social'); ?></label>
					</div>

					<div class="wslu-right-content">

						<input class="social_switch_button" type="checkbox" id="enable_shoe_text_enable" name="xs_share[global][show_text][enable]" value="1" <?php echo esc_attr((isset($return_data['global']['show_text']['enable']) && $return_data['global']['show_text']['enable'] == 1) ? 'checked' : ''); ?>>
						<label for="enable_shoe_text_enable" class="social_switch_button_label"></label>

					</div>
				</div>

				<div class="wslu-single-item">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Hide Label', 'wp-social'); ?></label>
					</div>

					<div class="wslu-right-content">

						<input class="social_switch_button" type="checkbox" id="enable_shoe_label_enable" name="xs_share[global][show_label][enable]" value="1" <?php echo esc_attr((isset($return_data['global']['show_label']['enable']) && $return_data['global']['show_label']['enable'] == 1) ? 'checked' : ''); ?>>
						<label for="enable_shoe_label_enable" class="social_switch_button_label"></label>

					</div>
				</div>

				<div class="wslu-single-item">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Hide Share Count', 'wp-social'); ?></label>
					</div>

					<div class="wslu-right-content">

						<input class="social_switch_button" type="checkbox" id="enable_shoe_counter_enable" name="xs_share[global][show_counter][enable]" value="1" <?php echo esc_attr((isset($return_data['global']['show_counter']['enable']) && $return_data['global']['show_counter']['enable'] == 1) ? 'checked' : ''); ?>>
						<label for="enable_shoe_counter_enable" class="social_switch_button_label"></label>

					</div>
				</div>

				<div class="wslu-single-item">

					<div class="wslu-left-label">&nbsp;</div>

					<div class="wslu-right-content">
						<button type="submit" name="share_settings_submit_form_global" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
					</div>
				</div>

				<div class="wslu-single-item">

					<div class="wslu-left-label"><label class="wslu-sec-title" for=""><?php echo esc_html__('Shortcode ', 'wp-social'); ?></label></div>

					<div class="wslu-right-content">
						<ol class="wslu-social-shortcodes">
							<li>[xs_social_share] </li>
							<li>[xs_social_share provider="facebook,twitter,instagram" class="custom-class"] </li>
							<li>[xs_social_share provider="facebook" class="custom-class" style=""]</li>
						</ol>
					</div>
				</div>

			</div>
		</div>
	</form> -->

    <br>
    <br>
    <br>

	<div class="wslu-single-item">

		<div class="wslu-left-label"><label class="wslu-sec-title" for=""><?php echo esc_html__('Shortcode ', 'wp-social'); ?></label></div>

		<div class="wslu-right-content">
			<ol class="wslu-social-shortcodes">
				<li>[xs_social_share] </li>
				<li>[xs_social_share provider="facebook,twitter,instagram" class="custom-class"] </li>
				<li>[xs_social_share provider="facebook" class="custom-class" style="" hover=""]</li>
				<li>[xs_social_share provider="all" class="" style="style-3" hover="top-tooltip" layout="horizontal/vertical" count="Yes/No"]</li>
			</ol>
		</div>
	</div>

</div>