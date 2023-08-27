<?php

use WP_Social\Lib\Login\Line_App;

defined('ABSPATH') || exit;

// $buttonStyle is the styles selected by user example: style-1 || style-2 || style-3
$currentStyle = empty($force_style) ? (isset($style_data['login_button_style']) ? $style_data['login_button_style'] : 'style-1') : $force_style;

// parent class of login button container
$className = 'xs-login xs-login--' . $currentStyle;
?>
<div id="xs-social-login-container">
    <div class="<?php echo esc_attr($className); ?>">
		<?php

		if(!is_user_logged_in()) {

			$url_params = '';

			if(empty($_GET['redirect_to'])) {

				$custom_url = xs_current_url_custom();

				if(strlen($custom_url) > 2) {
					if($typeCurrent == 'show') {
						$url_params = '?XScurrentPage=' . $custom_url;
					}
				}

			} else {

				$url_params = '?redirect_to=' . urlencode(urldecode($_GET['redirect_to']));
			}

			$core_provider = \WP_Social\App\Providers::get_core_providers_login();
			$enabled_providers = \WP_Social\App\Settings::get_enabled_provider_conf_login();

			/**
			 * todo - below there are some bujruki code need to change it, style icon set info also should come from array
			 *
			 */

			// loop through all the provides
			foreach($core_provider AS $keyType => $valueType):
				// check if the provider enable
				if(!empty($enabled_providers[$keyType]['enable'])):

					if(in_array('all', $attr_provider) || in_array($keyType, $attr_provider)) {

						/*
							------------------------------------------
							arrange necessary info for all buttons
							----------------------------------------
						*/
						$args = [
							'label'    => isset($provider_data[$keyType]['login_label']) ? $provider_data[$keyType]['login_label'] : 'Login with <b>' . $valueType . '</b>',
							'icon'     => '<i class="met-social met-social-' . $keyType . '"></i>',
							'clrClass' => 'wslu-color-scheme--' . $keyType,
						];


						if($valueType == 'LineApp') {
							$line = new Line_App();
							$args['url'] = $line->get_auth_url(get_site_url() . '/wp-json/wslu-social-login/type/' . $keyType);

						} else {
							$args['url'] = get_site_url() . '/wp-json/wslu-social-login/type/' . $keyType . '' . $url_params;
						}

						/*
							-------------------------------------------------------
							-require a specific markup file that contain the style
							-markup file name and style key must be same
							------------------------------------------------------
						*/
						$style_file_path = WSLU_LOGIN_PLUGIN . '/template/login/screens/default.php';

						require($style_file_path);
					}
				endif;
			endforeach;
		} else {
			$correntUrlLogout = esc_url(xs_current_url_custom());
			?>
            <div><a class="wslu-logout-button"
                    rel="nofollow"
                    href="<?php echo esc_url(wp_logout_url($correntUrlLogout)); ?>"><?php echo esc_html__('Logout', 'wp-social'); ?></a>
            </div> <?php
		} ?>
    </div>
</div>
