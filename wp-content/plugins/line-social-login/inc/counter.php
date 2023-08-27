<?php

namespace WP_Social\Inc;

defined('ABSPATH') || exit;

use WP_Social\App\Providers;
use WP_Social\Lib\Provider\Counter_Factory;

/**
 * Class Name : XS_Social_Counter;
 * Class Details : this class for showing login button in login and register page for wp, woocommerce, buddyPress and others
 *
 * @params : void
 *
 * @return : void
 *
 * @since : 1.0
 */
class Counter {

	const ORDER_LIST_PROVIDER_COUNTER = 'xs_counter_providers_order_frontend';

	public function __construct($load = true) {

		if($load) {
			$this->social_counter_action();
			add_action('init', [$this, 'counter_access_key_setup']);

			add_shortcode('xs_social_counter', [$this, 'social_counter_shortcode']);
		}
	}


	public function social_counter_action() {


		/**
		 * AR:20201110 - below caching is confusing and it is causing not showing datas for provider whose settings is set later
		 * Current flow:
		 * - loop through every provider
		 * -- call the dedicated 'xsc_' . $key . '_count'; function
		 * --- check the transient time there
		 * --- transient time should get from global settings
		 * --- call api and update the count
		 * ---- if count fail do not update transient
		 * ---- //this way next time for specific provider can update their count
		 *
		 * Count precedence : bigger of actual & defaults get precedence
		 *
		 */

		$return = [];
		$xsc_transient = [];

		$option_key = 'xs_counter_providers_data';
		$xsc_options = get_option($option_key) ? get_option($option_key) : []; //these are used as global so right now we can not remove

		$counter_provider = \WP_Social\App\Settings::get_counter_provider_settings();
		$cache_time = \WP_Social\App\Settings::get_counter_cache_time();
		$enabled_providers = \WP_Social\App\Settings::get_enabled_provider_conf_counter();

		/**
		 * Note - these need to be updated, very messier code
		 * for now just patching :( ARa
		 *
		 * Cleaning idea
		 * - each provider should have its transient and api call must not be performed in constructor call!
		 * - todo - etc etc
		 *
		 */
		if(!empty($counter_provider)) {

			$factory = new Counter_Factory();


			foreach($counter_provider as $key => $conf) {

				if(!empty($enabled_providers[$key]['enable'])) {

					$obj = $factory->make($key);

					if($obj->need_to_call_legacy_function()) {

						$function = 'xsc_' . $key . '_count';
						$return['data'][$key] = $function($cache_time);
						$xsc_transient[$key] = $return['data'][$key];

					} else {

						$count = $obj->set_config_data($conf)->get_count($cache_time);
						$return['data'][$key] = $count;
						$xsc_transient[$key] = $count;
					}
				}
			}
		}

		update_option(\WP_Social\App\Settings::$ok_counter_cached_data, $return);
	}


	public function social_counter_shortcode($atts, $content = null) {

		$atts = shortcode_atts(
			[
				'provider' => 'all',
				'class'    => '',
				'style'    => '',
				'hover'    => '',
			],
			$atts,
			'xs_social_counter'
		);

		if(isset($atts['provider']) && $atts['provider'] != 'all') {
			$provider = explode(',', $atts['provider']);
		} else {
			$provider = 'all';
		}

		$config = [];
		$config['class'] = trim($atts['class']);
		$config['style'] = trim($atts['style']);
		$config['hover'] = trim($atts['hover']);

		return $this->get_counter_data($provider, $config);
	}


	public function get_counter_data($provider = 'all', $config = []) {

		$core_provider = $this->xs_counter_providers();

		$className = isset($config['class']) ? $config['class'] : '';
		$provider = ($provider == 'all') ? array_keys($core_provider) : $provider;

		$styleArr = \WP_Social\Inc\Admin_Settings::counter_styles();

		$hoverStyles = [
			'none-none' => [
				'name'  => 'None',
				'class' => 'wslu-none',
			],
		];

		if(did_action('wslu_social_pro/plugin_loaded')) {

			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'counter_hover_effects' ) ){

				$hoverStyles = \WP_Social_Pro\Inc\Admin_Settings::counter_hover_effects();

			}else{

				$hoverStyles = \WP_Social_Pro\Inc\Admin_Settings::$counter_hover_effects;

			}

		}

		$globalShareSettings = get_option('xs_counter_global_setting_data', '');
		$themeFontClass = empty($globalShareSettings['show_font_from_theme']) ? 'wslu-theme-font-no' : 'wslu-theme-font-yes';

		$style = get_option('xs_style_setting_data_counter', '');

		$styleConfig = isset($style['login_button_style']['style']) ? $style['login_button_style']['style'] : 'style-1:none-none';

		$bArr = explode(':', $styleConfig);

		$cntStyleKey = empty($config['style']) ? $bArr[0] : $config['style'];
		$cntHoverKey = empty($config['hover']) ? $bArr[1] : $config['hover'];

		$mainStyleCls = isset($styleArr[$cntStyleKey]['class']) ? 'wslu-' . $cntStyleKey . ' ' . $styleArr[$cntStyleKey]['class'] : '';
		$hoverClass = empty($hoverStyles[$cntHoverKey]) ? $hoverStyles['none-none']['class'] : $hoverStyles[$cntHoverKey]['class'];
		$widget_style = $mainStyleCls . ' ' . $hoverClass . ' ' . $themeFontClass;

		$counter_data = \WP_Social\App\Settings::get_counter_cached_data();
		$counter_provider = \WP_Social\App\Settings::get_counter_provider_settings();

		ob_start();
		require(WSLU_LOGIN_PLUGIN . '/template/counter/counter-html.php');
		$counter = ob_get_contents();
		ob_end_clean();

		return $counter;
	}


	public function counter_access_key_setup() {

		if(isset($_POST['xs_provider_submit_form_access_counter'])) {

			$getpage = isset($_GET['page']) ? Admin_Settings::sanitize($_GET['page']) : '';
			$getType = isset($_GET['xs_access']) ? Admin_Settings::sanitize($_GET['xs_access']) : '';

			if($getpage != 'wslu_counter_setting') {
				return '';
			}

			$accesskey = isset($_POST['accesskey']) ? Admin_Settings::sanitize($_POST['accesskey']) : '';
			$app_id = isset($accesskey[$getType]['app_id']) ? $accesskey[$getType]['app_id'] : '';
			$app_secret = isset($accesskey[$getType]['app_secret']) ? $accesskey[$getType]['app_secret'] : '';

			if($getType == 'twitter') {
				// preparing credentials
				$credentials = $app_id . ':' . $app_secret;
				$toSend = base64_encode($credentials);

				// http post arguments
				$args = [
					'method'      => 'POST',
					'httpversion' => '1.1',
					'blocking'    => true,
					'headers'     => [
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
					],
					'body'        => ['grant_type' => 'client_credentials'],
				];

				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

				$keys = json_decode(wp_remote_retrieve_body($response));
				if(!isset($keys->access_token)) {
					return '';
				}
				if(!empty($keys->access_token)) {
					update_option('xs_counter_' . $getType . '_token', $keys->access_token);
					update_option('xs_counter_' . $getType . '_app_id', $app_id);
					update_option('xs_counter_' . $getType . '_app_secret', $app_secret);
					$redirect_url = admin_url() . "admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=$getType";
					?> 
					<script type='text/javascript'>window.location='<?php echo esc_url($redirect_url); ?>'</script>
					<?php
					exit;
				}
			} elseif($getType == 'instagram') {
				$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $getType . '';

				$params = [
					'client_id'     => $app_id,
					'response_type' => 'code',
					'scope'         => 'basic',
					'redirect_uri'  => $cur_page,
				];

				$url = "https://api.instagram.com/oauth/authorize/?" . http_build_query($params);

				set_transient('xs_counter_' . $getType . '_client_id', $app_id, 60 * 60);
				set_transient('xs_counter_' . $getType . '_client_secret', $app_secret, 60 * 60);
				header("Location: $url");

			} elseif($getType == 'linkedin') {
				$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $getType . '';
				$params = [
					'response_type' => 'code',
					'client_id'     => $app_id,
					//'scope'         => 'rw_company_admin r_basicprofile',
					'scope'         => 'r_liteprofile r_emailaddress w_member_social r_ad_campaigns rw_organization',
					'state'         => uniqid('', true), // unique long string
					'redirect_uri'  => $cur_page,
				];

				$url = 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query($params);

				set_transient('xs_counter_' . $getType . '_api_key', $app_id, 60 * 60);
				set_transient('xs_counter_' . $getType . '_secret_key', $app_secret, 60 * 60);

				header("Location: $url");
			} elseif($getType == 'facebook') {
				$url = 'https://www.facebook.com/login.php?skip_api_login=1&api_key=1203050406491591&signed_next=1&next=https://www.facebook.com/v2.12/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.ajuda.me%2Fwp-login.php%3FloginSocial%3Dfacebook
				&display=popup&state=d4a4c6d6df98117acfa25d4343483c69&scope=public_profile%2Cemail&response_type=code&client_id=1203050406491591&ret=login&logger_id=49a9a593-e908-a451-16d4-eb38a4ae7882&cancel_url=https://www.ajuda.me/wp-login.php?loginSocial=facebook&error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied&state=d4a4c6d6df98117acfa25d4343483c69#_=_&display=popup&locale=pt_PT&logger_id=49a9a593-e908-a451-16d4-eb38a4ae7882';

				$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $getType . '';

				$params = [
					'skip_api_login' => 1,
					'api_key'        => 1203050406491591,
					'signed_next'    => 1,
					'next'           => 'https://www.facebook.com/v2.12/dialog/oauth?redirect_uri=' . $cur_page,
					'display'        => 'popup',
					'response_type'  => 'code',
					'client_id'      => $app_id,
					'scope'          => 'public_profile email',
					'ret'            => 'login',
					'logger_id'      => '49a9a593-e908-a451-16d4-eb38a4ae7882',
					'cancel_url'     => 'https://www.ajuda.me/wp-login.php?loginSocial=facebook&error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied&state=d4a4c6d6df98117acfa25d4343483c69#_=_&display=popup&locale=pt_PT&logger_id=49a9a593-e908-a451-16d4-eb38a4ae7882',
					'state'          => uniqid('', true), // unique long string
					'redirect_uri'   => $cur_page,
				];
				$url = 'https://www.facebook.com/login.php?' . http_build_query($params);
				header("Location: $url");
			} elseif($getType == 'dribbble') {
				$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $getType . '';

				$params = [
					'client_id'     => $app_id,
					'response_type' => 'code',
					'scope'         => 'public',
					'redirect_uri'  => $cur_page,
					'state'         => substr(md5(microtime()), rand(0, 26), 10),
				];

				$url = "https://dribbble.com/oauth/authorize?" . http_build_query($params);

				/**
				 * Why saved in transient!!!!
				 *
				 */
				update_option('xs_counter_dribbble_app_id', $app_id);
				update_option('xs_counter_dribbble_app_secret', $app_secret);

				set_transient('xs_counter_' . $getType . '_client_id', $app_id, 60 * 60);
				set_transient('xs_counter_' . $getType . '_client_secret', $app_secret, 60 * 60);

				header("Location: $url");
			}
		}
	}


	public function xs_counter_providers() {
		$providers = [
			'facebook'  => [
				'label' => 'Facebook',
				'data'  => ['text' => __('Fans', 'wp-social'), 'url' => 'http://www.facebook.com/%s'],
			],
			'twitter'   => [
				'label' => 'Twitter',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://twitter.com/%s'],
			],
			//'linkedin'   => [ 'label' => 'LinkedIn', 'data' => ['text' => __( 'Followers', 'wp-social' ), 'url' => 'https://www.linkedin.com/%s/%s']  ],
			'pinterest' => [
				'label' => 'Pinterest',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://www.pinterest.com/%s'],
			],
			'dribbble'  => [
				'label' => 'Dribbble',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://dribbble.com/%s'],
			],
			'instagram' => [
				'label' => 'Instagram',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://instagram.com/%s'],
			],
			'youtube'   => [
				'label' => 'YouTube',
				'data'  => ['text' => __('Subscribers', 'wp-social'), 'url' => 'http://youtube.com/%s/%s'],
			],
			'mailchimp' => ['label' => 'Mailchimp', 'data' => ['text' => __('Subscribers', 'wp-social')]],
			'comments'  => ['label' => 'Comments', 'data' => ['text' => __('Count', 'wp-social')]],
			'posts'     => ['label' => 'Posts', 'data' => ['text' => __('Count', 'wp-social')]],
			//'vimeo'      => [ 'label' => 'Vimeo', 'data' => ['text' => __( 'Subscribers',	'wp-social' ), 'url' => 'https://vimeo.com/channels/%s']  ],
			//'vkontakte'  => [ 'label' => 'Vkontakte', 'data' => ['text' => __( 'Members', 'wp-social' ), 'url' => 'http://vk.com/%s']  ],
		];

		$providers_order = get_option(self::ORDER_LIST_PROVIDER_COUNTER);

		return Providers::providers_sort($providers_order, $providers);
	}


	public function xs_counter_providers_data() {

		// todo - alamin : make all label as translatable

		return [
			'facebook' => ['id' => ['type' => 'normal', 'label' => 'Page ID/Name', 'input' => 'text'],],
			'twitter'  => [
				'id'  => ['type' => 'normal', 'label' => 'Username', 'input' => 'text'],
				'api' => [
					'type'  => 'access',
					'label' => __('Access Token Key', 'wp-social'),
					'input' => 'text',
					'filed' => ['app_id' => 'Consumer key', 'app_secret' => 'Consumer secret'],
				],
			],

			'instagram' => [

				'user_name' => [
					'type'  => 'normal',
					'label' => 'Username',
					'input' => 'text',
				],

				'get_token' => [
					'type'  => 'link',
					'label' => esc_html__('Get access token ', 'wp-social'),
					'input' => 'link',
					'url' => 'https://token.wpmet.com/social_token.php?provider=instagram',
					'class' => 'wslu-btn wslu-target-link',
				],

				'access_token' => [
					'type'  => 'normal',
					'label' => 'Access token',
					'input' => 'text',
				],
				'user_id' => [
					'type'  => 'normal',
					'label' => 'User ID',
					'input' => 'text',
				],
			],

			'linkedin'  => [
				'type' => [
					'type'  => 'normal',
					'label' => 'Account Type',
					'input' => 'select',
					'data'  => ['Company' => 'Company', 'Profile' => 'Profile'],
				],
				'id'   => ['type' => 'normal', 'label' => 'Your ID', 'input' => 'text'],
				'api'  => [
					'type'  => 'access',
					'label' => __('Access Token Key', 'wp-social'),
					'input' => 'text',
					'filed' => ['app_id' => 'API Key', 'app_secret' => 'Secret Key'],
				],
			],
			'pinterest' => [
				'username' => [
					'type'  => 'normal',
					'label' => 'Username',
					'input' => 'text',
				],
			],

			'youtube'   => [
				'type' => [
					'type'  => 'normal',
					'label' => 'Account Type',
					'input' => 'select',
					'data'  => ['Channel' => 'Channel', 'User' => 'User'],
				],
				'id'   => ['type' => 'normal', 'label' => 'Username or Channel ID', 'input' => 'text'],
				'key'  => ['type' => 'normal', 'label' => 'YouTube API Key', 'input' => 'text'],
			],
			'dribbble'  => [
				'api' => [
					'type'  => 'access',
					'label' => __('Access Token Key', 'wp-social'),
					'input' => 'text',
					'filed' => ['app_id' => 'Client ID', 'app_secret' => 'Client Secret'],
				],
			],
			'mailchimp' => [
				'id'  => ['type' => 'normal', 'label' => 'List ID (Optional)', 'input' => 'text'],
				'api' => ['type' => 'normal', 'label' => 'API Key', 'input' => 'text'],
			],
		];
	}


	public function xs_counter_defalut_providers() {
		if(!get_option('xs_counter_active')) {
			$default_data = [
				'social' => $this->xs_counter_providers(),
				'cache'  => 5,
			];

			update_option('xs_counter_providers_data', $default_data);
			update_option('xs_counter_active', WSLU_VERSION);
		}
	}
}


