<?php

namespace WP_Social\Inc;

defined('ABSPATH') || exit;

use WP_Social\App\Counter_Settings;
use WP_Social\App\Login_Settings;
use WP_Social\App\Providers;
use WP_Social\App\Settings;
use WP_Social\Helper\User_Helper;
use WP_Social\Lib\Onboard\Onboard;
use WP_Social\Xs_Migration\Migration;
use WP_User_Query;

/**
 * Class Name : XS_Social_Login_Settings;
 * Class Details : Added menu and sub menu in wordpress main admin menu
 *
 * @params : void
 * @return : added new page link
 *
 * @since : 1.0
 */
class Admin_Settings {

	public static $counter_style = ['wslu-counter-box-shaped wslu-counter-fill-colored' => 'Block', 'wslu-counter-line-shaped wslu-counter-fill-colored' => 'Line', 'wslu-counter-line-shaped wslu-counter-fill-colored wslu-counter-rounded' => 'Line with Round'];

	/**
	 * @var array
	 */
	public static $horizontal_style = [

		'horizontal' => [
			'class' => 'wslu-share-horizontal',
			'name'  => 'Horizontal',
		],

		'vertical' => [
			'class' => 'wslu-share-vertical',
			'name'  => 'Vertical',
		],
	];


	public function __construct($load = true) {

		add_action('wp_ajax_export_users_content_csv', [$this, 'export_users_content_csv']);

		add_action('wp_ajax_sort_providers_login', [$this, 'sort_providers_login']);

		add_action('wp_ajax_sort_providers_share', [$this, 'sort_providers_share']);

		add_action('wp_ajax_sort_providers_counter', [$this, 'sort_providers_counter']);

		if($load) {
			// added admin menu
			add_action('admin_menu', [$this, 'wp_social_admin_menu']);
		}

		if(!did_action('wslu_social_pro/plugin_loaded')) {
			add_filter('wslu/share/style_settins', [$this, 'share_style_settings']);
			add_filter('wslu/counter/style_settings', [$this, 'counter_style_settings']);
		}
	}


	public static function share_styles() {

		$share_style = [
			'style-1' => [
				'name'    => __('Icon with fill color', 'wp-social'),
				'class'   => 'wslu-share-box-shaped wslu-fill-colored',
				'design'  => 'img-1',
				'package' => 'free',
			],
			'style-2' => [
				'name'    => __('Icon with fill color and space', 'wp-social'),
				'class'   => 'wslu-share-box-shaped wslu-fill-colored wslu-share-m-5',
				'design'  => 'img-2',
				'package' => 'free',
			],
			'style-3' => [
				'name'    => __('Icon with hover fill color and space', 'wp-social'),
				'class'   => 'wslu-share-box-shaped wslu-fill-brand-hover-colored wslu-share-m-5',
				'design'  => 'img-3',
				'package' => 'free',
			],
		];

		return apply_filters('wslu/share/style_settins', $share_style);
	}

	public function share_style_settings($share) {

		$array = [
			'style-4'  => [
				'name'    => __('Icon with text', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-4',
				'package' => 'pro',
			],
			'style-5'  => [
				'name'    => __('Icon with text & slightly rounded', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-5',
				'package' => 'pro',
			],
			'style-6'  => [
				'name'    => __('Circled Icon with fill color', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-6',
				'package' => 'pro',
			],
			'style-7'  => [
				'name'    => __('Circled Icon with hover fill color', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-7',
				'package' => 'pro',
			],
			'style-8'  => [
				'name'    => __('Icon with colored border', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-8',
				'package' => 'pro',
			],
			'style-9'  => [
				'name'    => __('Icon with hover colored border', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-9',
				'package' => 'pro',
			],
			'style-10' => [
				'name'    => __('Icon with colored rounded border', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-10',
				'package' => 'pro',
			],
			'style-11' => [
				'name'    => __('Icon with hover colored rounded border', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-11',
				'package' => 'pro',
			],
			'style-12' => [
				'name'    => __('Icon with hover fill color border', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-12',
				'package' => 'pro',
			],
			'style-13' => [
				'name'    => __('Slightly rounded icon with fill color', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-13',
				'package' => 'pro',
			],
			'style-14' => [
				'name'    => __('Icon with follower count', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-14',
				'package' => 'pro',
			],
			'style-15' => [
				'name'    => __('Rounded filled icon with text', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-15',
				'package' => 'pro',
			],
			'style-16' => [
				'name'    => __('Semi-rounded icon with fill color', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-16',
				'package' => 'pro',
			],
			'style-17' => [
				'name'    => __('Semi-rounded icon and border color', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-17',
				'package' => 'pro',
			],
			'style-18' => [
				'name'    => __('Icon with text and follower count', 'wp-social'),
				'class'   => 'wslu-go-pro',
				'design'  => 'img-18',
				'package' => 'pro',
			],
		];

		return array_merge($share, $array);
	}


	/**
	 *
	 * @return mixed
	 */
	public static function counter_styles() {

		$counterStyles = [

			'style-1' => [
				'name'    => __('Flat style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-box-shaped wslu-counter-fill-colored wslu-counter-space',
				'design'  => 'img-1',
				'package' => 'free',
			],

			'style-2' => [
				'name'    => __('Line style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-line-shaped wslu-counter-fill-colored wslu-counter-space',
				'design'  => 'img-2',
				'package' => 'free',
			],

			'style-3' => [
				'name'    => __('Line slightly rounded style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-line-shaped wslu-counter-fill-colored wslu-counter-rounded wslu-counter-space',
				'design'  => 'img-3',
				'package' => 'free',
			],
		];


		return apply_filters('wslu/counter/style_settings', $counterStyles);
	}

	public function counter_style_settings($counter) {
		$array = [
			'style-4'  => [
				'name'    => __('Flat style with hover fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-4',
				'package' => 'pro',
			],
			'style-5'  => [
				'name'    => __('Metro style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-5',
				'package' => 'pro',
			],
			'style-6'  => [
				'name'    => __('Flat style with hover icon color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-6',
				'package' => 'pro',
			],
			'style-7'  => [
				'name'    => __('Flat style with icon color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-7',
				'package' => 'pro',
			],
			'style-8'  => [
				'name'    => __('Flat style with icon fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-8',
				'package' => 'pro',
			],
			'style-9'  => [
				'name'    => __('Flat style with fill color & rounded icon', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-9',
				'package' => 'pro',
			],
			'style-10' => [
				'name'    => __('Vertical line style with icon color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-10',
				'package' => 'pro',
			],
			'style-11' => [
				'name'    => __('Vertical line style with icon fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-11',
				'package' => 'pro',
			],
			'style-12' => [
				'name'    => __('Vertical line style with fill color & rounded icon', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-12',
				'package' => 'pro',
			],
			'style-13' => [
				'name'    => __('Rounded icon style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-13',
				'package' => 'pro',
			],
			'style-14' => [
				'name'    => __('Rounded icon style with hover fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-14',
				'package' => 'pro',
			],
			'style-15' => [
				'name'    => __('Slightly Rounded icon style with fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-15',
				'package' => 'pro',
			],
			'style-16' => [
				'name'    => __('Slightly Rounded icon style with hover fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-16',
				'package' => 'pro',
			],
			'style-17' => [
				'name'    => __('Metro style with hover fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-17',
				'package' => 'pro',
			],
			'style-18' => [
				'name'    => __('Line style with hover fill color', 'wp-social'),
				'class'   => 'wslu-counter-go-pro',
				'design'  => 'img-18',
				'package' => 'pro',
			],
		];

		return array_merge($counter, $array);
	}


	/**
	 * Method Name : wp_social_admin_menu
	 * Method Details : add menu for social login plugin
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function wp_social_admin_menu() {
		add_menu_page( __('WP Social Login Ultimate', 'wp-social'), __('WP Social', 'wp-social'), 'manage_options', 'wslu_global_setting', [$this, 'content_xs_global_setting'], WSLU_LOGIN_PLUGIN_URL . 'assets/images/icon-menu.png');
		add_submenu_page('wslu_global_setting', __('Social Login', 'wp-social'), __('Social Login', 'wp-social'), 'manage_options', 'wslu_global_setting', [$this, 'content_xs_global_setting']);
		add_submenu_page('wslu_global_setting', __('Social Share', 'wp-social'), __('Social Share', 'wp-social'), 'manage_options', 'wslu_share_setting', [$this, 'content_xs_share_setting']);
		add_submenu_page('wslu_global_setting', __('Social Counter', 'wp-social'), __('Social Counter', 'wp-social'), 'manage_options', 'wslu_counter_setting', [$this, 'content_xs_counter_setting']);
		add_submenu_page('wslu_global_setting', __('Settings', 'wp-social'), __('Settings', 'wp-social'), 'manage_options', 'wslu_settings', [$this, 'content_xs_settings']);
		//add_submenu_page('wslu_global_setting', 'Test123', 'Data conversion', 'manage_options', 'wslu_data_migration', [$this, 'content_xs_data_migration']);
	}

	/**
	 * Method Name : content_xs_global_setting
	 * Method Details : content for global setting page
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_global_setting() {

		if(isset($_GET['wp-social-met-onboard-steps']) && sanitize_text_field($_GET['wp-social-met-onboard-steps']) == 'loaded') {
            Onboard::instance()->views();
        } else {
			$global_optionKey = 'xs_global_setting_data';
			$message_global = 'hide';

			if(isset($_POST['global_setting_submit_form'])) {

				if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'global_setting_submit_form_nonce' ) ) {
					return;
				}

				$option_value_global = isset($_POST['xs_global']) ? Self::sanitize($_POST['xs_global']) : [];

				if(update_option($global_optionKey, $option_value_global, 'Yes')) {
					$message_global = 'show';
				}
			}

			// get returned global setting data from db
			$return_data = get_option($global_optionKey);

			$membership = get_option('users_can_register', 0);
			$wpUserRole = get_option('default_role', 'subscriber');


			// wordpress role options
			$active_tab = isset($_GET["tab"]) ? sanitize_text_field($_GET["tab"]) : 'wslu_global_setting';

			if($active_tab == 'wslu_providers') {

				$this->content_xs_providers();

			} elseif($active_tab == 'wslu_style_setting') {

				$this->content_xs_style_setting();

			} else {

				require_once(WSLU_LOGIN_PLUGIN . '/template/admin/global-setting.php');
			}
		}
	}


	/**
	 * Method Name : content_xs_providers
	 * Method Details : content for social provider page
	 *
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_providers() {
		$option_key = 'xs_provider_data';
		$message_provider = 'hide';

		$enabled_providers = \WP_Social\App\Settings::get_enabled_provider_conf_login();

		/**
		 * Legacy version support
		 * After 3/4 version we can hopefully  delete the below if block
		 */
		if(empty($enabled_providers)) {

			$old_settings = \WP_Social\App\Settings::get_login_settings_data();

			if(!empty($old_settings)) {

				$tmp = [];

				foreach($old_settings as $key => $info) {

					$tmp[$key]['enable'] = empty($info['enable']) ? '' : 1;
				}

				\WP_Social\App\Settings::update_enabled_provider_conf_login($tmp);

				$enabled_providers = $tmp;
			}
		}


		// save prodivers data in db
		if(isset($_POST['xs_provider_submit_form'])) {

			$option_value = isset($_POST['xs_social']) ? self::sanitize($_POST['xs_social']) : [];

			if(update_option($option_key, $option_value, 'Yes')) {
				$message_provider = 'show';
			}
		}

		$saved_settings = \WP_Social\App\Settings::get_login_settings_data();
		$core_provider = \WP_Social\App\Providers::get_core_providers_login();

		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/providers-setting.php');
	}


	/**
	 * Method Name : content_xs_style_setting
	 * Method Details : content for social provider style settings
	 *
	 */
	public function content_xs_style_setting() {

		$message_provider = 'hide';

		if(isset($_POST['style_setting_submit_form'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'style_setting_submit_form_nonce' ) ) {
				return;
			}

			$option_value = isset($_POST['xs_style']) ? self::sanitize($_POST['xs_style']) : [];

			if(update_option(Login_Settings::OK_STYLES, $option_value, 'yes')) {
				$message_provider = 'show';
			}
		}

		$saved_style = Login_Settings::instance()->get_style_settings();


		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/style-setting.php');
	}


	/**
	 * Method Name : content_xs_counter_setting
	 * Method Details : content for social provider style settings
	 *
	 *
	 */
	public function content_xs_counter_setting() {
		$global_optionKey = 'xs_counter_global_setting_data';
		$message_global = 'hide';

		if(isset($_POST['counter_settings_submit_form_global'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'counter_settings_submit_form_global_nonce' ) ) {
				return;
			}

			$option_value_global = isset($_POST['xs_counter']) ? self::sanitize($_POST['xs_counter']) : [];
			if(update_option($global_optionKey, $option_value_global, 'Yes')) {
				$message_global = 'show';
			}
		}

		// get returned global setting data from db
		$return_data = get_option($global_optionKey);

		// wordpress role options
		$active_tab = isset($_GET["tab"]) ? sanitize_text_field($_GET["tab"]) : 'wslu_global_setting';

		if($active_tab == 'wslu_providers') {
			$this->content_xs_providers_counter();
		} else {
			if($active_tab == 'wslu_style_setting') {
				$this->content_xs_style_setting_counter();
			} else {
				require_once(WSLU_LOGIN_PLUGIN . '/template/admin/counter/counter-setting.php');
			}
		}
	}


	public function export_users_content_csv() {
		if(current_user_can('manage_options') && isset($_POST['wslu_export_users_list_nonce']) && wp_verify_nonce($_POST['wslu_export_users_list_nonce'],'wslu_export_users_list_nonce') && isset($_POST['provider'])) {
			User_Helper::export_users_content_csv(sanitize_text_field($_POST['provider']));
		}
	}

	/**
	 * Method Name : content_xs_settings
	 * Method Details :
	 *
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_settings() {

		$message_global = '';

		if(!empty($_POST['sycn_setting'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'sycn_setting_nonce' ) ) {
				return;
			}

			if(isset($_POST['sync'])) {
				update_option('wp_social_login_sync', sanitize_key($_POST['sync']));
			} else {
				update_option('wp_social_login_sync', 'no');
			}

			if(isset($_POST['sync_image'])) {
				update_option('wp_social_login_sync_image_too', sanitize_key($_POST['sync_image']));
			} else {
				update_option('wp_social_login_sync_image_too', 'no');
			}
			$message_global = 'show';
		}
		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/settings.php');
	}

	/**
	 * Method Name : content_xs_providers_counter
	 * Method Details : content for social provider counter settings
	 *
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_providers_counter() {

		$counter = new Counter(false);
		$counter_social_items = $counter->xs_counter_providers();
		$counter_provider = \WP_Social\App\Settings::get_counter_provider_settings();

		$option_key = 'xs_counter_providers_data';
		$message_provider = 'hide';

		$enabled_providers = get_option(Settings::$ok_enabled_providers_counter, []);

		/**
		 * Legacy version support
		 * After 3/4 version we can hopefully  delete the below if block
		 */
		if(empty($enabled_providers)) {

			$old_settings = get_option($option_key, []);

			if(!empty($old_settings['social'])) {

				$tmp = [];

				foreach($old_settings['social'] as $key => $info) {

					$tmp[$key]['enable'] = empty($info['enable']) ? '' : 1;
				}

				update_option(Settings::$ok_enabled_providers_counter, $tmp);

				$enabled_providers = $tmp;
			}
		}


		/**
		 * Here saves all the counter providers updated settings
		 *
		 */
		if(isset($_POST['counter_settings_submit_form'])) {

			$option_value = isset($_POST['xs_counter']) ? self::sanitize($_POST['xs_counter']) : [];

			if(update_option($option_key, $option_value, 'yes')) {

				$message_provider = 'show';
			}
		}


		$xsc_options = get_option($option_key, []);

		$counter_provider = isset($xsc_options['social']) ? $xsc_options['social'] : $counter_social_items;

		$saved_settings = get_option($option_key, []);

		$core_provider = \WP_Social\App\Providers::get_core_providers_count();

		$getType = isset($_GET['xs_access']) ? self::sanitize($_GET['xs_access']) : '';

		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/counter/providers-counter.php');
	}


	/**
	 * Method Name : content_xs_style_setting
	 * Method Details : content for social provider style settings
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_style_setting_counter() {

		$option_key = 'xs_style_setting_data_counter';
		$message_provider = 'hide';

		//save providers data in db
		if(isset($_POST['style_setting_submit_form'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'style_setting_submit_form_counter_nonce' ) ) {
				return;
			}

			$option_value = isset($_POST['xs_style']) ? self::sanitize($_POST['xs_style']) : [];
			if(update_option($option_key, $option_value, 'Yes')) {
				$message_provider = 'show';
			}
		}


		$return_data = Counter_Settings::instance()->get_style_settings();

		// style type settings
		$styleArr = self::counter_styles();

		// prodiver settings data
		$return_data_prodivers = Settings::get_login_settings_data();

		if(empty($return_data['login_button_style']['style'])) {
			$return_data = [];
			$return_data['login_button_style']['style'] = 'style-1:top-tooltip';
		}

		$styleAndEffect = explode(':', $return_data['login_button_style']['style']);
		$selectedStyle = $styleAndEffect[0];
		$selectedEffect = empty($styleAndEffect[1]) ? 'top-tooltip' : $styleAndEffect[1];


		if(did_action('wslu_social_pro/plugin_loaded')) {
			
			// Counter Hover effect list
			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'counter_hover_effects' ) ){

				$share_hover_effects = \WP_Social_Pro\Inc\Admin_Settings::counter_hover_effects();

			}else{

				$share_hover_effects = \WP_Social_Pro\Inc\Admin_Settings::$counter_hover_effects;

			}
		}

		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/counter/style-setting.php');
	}


	/**
	 * Method Name : content_xs_share_setting
	 * Method Details : content for social provider style settings for share
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_share_setting() {

		$global_optionKey = 'xs_share_global_setting_data';
		$message_global = 'hide';

		if(isset($_POST['share_global_setting_submit_form'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'share_global_setting_submit_form_nonce' ) ) {
				return;
			}

			$option_value_global = isset($_POST['xs_share']) ? self::sanitize($_POST['xs_share']) : [];
			if(update_option($global_optionKey, $option_value_global, 'Yes')) {
				$message_global = 'show';
			}
		}

		// get returned global setting data from db
		$return_data = get_option($global_optionKey);

		// wordpress role options
		$active_tab = isset($_GET["tab"]) ? sanitize_text_field($_GET["tab"]) : 'wslu_global_setting';

		if($active_tab == 'wslu_providers') {
			$this->content_xs_share_provider();

		} elseif($active_tab == 'wslu_style_setting') {
			$this->content_xs_style_setting_share();

		} else {
			require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/share-setting.php');
		}
	}


	/**
	 * Social share providers
	 *
	 *
	 */
	public function content_xs_share_provider() {
		$share = new Share(false);
		$counter_social_items = $share->social_share_link();

		$option_key = 'xs_share_providers_data';
		$message_provider = 'hide';
		$saved_settings = get_option($option_key, []);
		$enabled_providers = get_option(Settings::$ok_enabled_providers_share, []);

		/**
		 * Legacy version support
		 * After 3/4 version we can hopefully  delete the below if block
		 */
		if(empty($enabled_providers)) {

			$old_settings = get_option($option_key, []);

			if(!empty($old_settings['social'])) {

				$tmp = [];

				foreach($old_settings['social'] as $key => $info) {

					$tmp[$key]['enable'] = empty($info['enable']) ? '' : 1;
				}

				update_option(Settings::$ok_enabled_providers_share, $tmp);

				$enabled_providers = $tmp;
			}
		}

		if(isset($_POST['share_settings_submit_form'])) {

			$option_value = isset($_POST['xs_share']) ? self::sanitize($_POST['xs_share']) : [];

			if(update_option($option_key, $option_value, true)) {
				$message_provider = 'show';
				$saved_settings = $option_value;
			}
		}

		// get returned data from db
		$xsc_options = get_option($option_key) ? get_option($option_key) : [];
		$share_provider = isset($xsc_options['social']) ? $xsc_options['social'] : $counter_social_items;
		$core_provider = \WP_Social\App\Providers::get_core_providers_share();

		$getType = isset($_GET['xs_access']) ? self::sanitize($_GET['xs_access']) : '';

		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/share-providers.php');
	}

	/**
	 * Method Name : content_xs_style_setting
	 * Method Details : content for social provider style settings
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public function content_xs_style_setting_share() {

		$option_key = 'xs_style_setting_data_share';
		$message_provider = 'hide';

		// save providers data in db
		if(isset($_POST['style_setting_submit_form'])) {

			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'style_setting_submit_form_share_nonce' ) ) {
				return;
			}

			$option_value = isset($_POST['xs_style']) ? self::sanitize($_POST['xs_style']) : [];
			if(update_option($option_key, $option_value, 'Yes')) {
				$message_provider = 'show';
			}
		}

		// get returned data from db
		$return_data = get_option($option_key);

		// style type settings
		$styleArr = self::share_styles();

		// prodiver settings data
		$return_data_prodivers = Settings::get_login_settings_data();

		if(did_action('wslu_social_pro/plugin_loaded')) {
			
			// Share Hover effect list
			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'share_hover_effects' ) ){
				
				$share_hover_effects = \WP_Social_Pro\Inc\Admin_Settings::share_hover_effects();

			}else{

				$share_hover_effects = \WP_Social_Pro\Inc\Admin_Settings::$share_hover_effects;
				
			}

		}

		if(empty($return_data['main_content']['style'])) {
			$return_data['main_content']['style'] = 'style-1:none-none:horizontal';
		}
		if(empty($return_data['fixed_display']['style'])) {
			$return_data['fixed_display']['style'] = 'style-1:none-none:vertical';
		}


		$styleAndEffect = explode(':', $return_data['main_content']['style']);
		$mainEffect = empty($styleAndEffect[1]) ? 'none-none' : $styleAndEffect[1];

		require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/style-setting.php');
	}


	public static function sanitize($value, $senitize_func = 'sanitize_text_field') {
		$senitize_func = (in_array($senitize_func, [
			'sanitize_email',
			'sanitize_file_name',
			'sanitize_hex_color',
			'sanitize_hex_color_no_hash',
			'sanitize_html_class',
			'sanitize_key',
			'sanitize_meta',
			'sanitize_mime_type',
			'sanitize_sql_orderby',
			'sanitize_option',
			'sanitize_text_field',
			'sanitize_title',
			'sanitize_title_for_query',
			'sanitize_title_with_dashes',
			'sanitize_user',
			'esc_url_raw',
			'wp_filter_nohtml_kses',
		])) ? $senitize_func : 'sanitize_text_field';

		if(!is_array($value)) {
			return $senitize_func($value);
		} else {
			return array_map(function ($inner_value) use ($senitize_func) {
				return self::sanitize($inner_value, $senitize_func);
			}, $value);
		}
	}


	public function content_xs_data_migration() {

		$migration = new Migration();

		$ret = $migration->input('wp-social', '1.3.3', '1.3.5');

		require_once(WSLU_LOGIN_PLUGIN . '/xs_migration/markup/data-conversion.php');

	}

	public function sort_providers_login() {

		if ( ! isset($_POST['wslu_provider_nonce'] ) || ( isset($_POST['wslu_provider_nonce']) && ! wp_verify_nonce( $_POST['wslu_provider_nonce'], 'wp_rest' )) || ! current_user_can( 'manage_options' ) ) {			
			return;
		}
		
		$providers = array_map('sanitize_key', $_POST['providers']);

		return update_option(Providers::ORDER_LIST_PROVIDER_LOGIN, $providers);
	}

	public function sort_providers_share() {

		if ( ! isset($_POST['wslu_provider_nonce'] ) || ( isset($_POST['wslu_provider_nonce']) && ! wp_verify_nonce( $_POST['wslu_provider_nonce'], 'wp_rest' )) || ! current_user_can( 'manage_options' )) {			
			return;
		}

		$providers = array_map('sanitize_key', $_POST['providers']);

		return update_option(Providers::ORDER_LIST_PROVIDER_SHARE, $providers);
	}

	public function sort_providers_counter() {

		if ( ! isset($_POST['wslu_provider_nonce'] ) || ( isset($_POST['wslu_provider_nonce']) && ! wp_verify_nonce( $_POST['wslu_provider_nonce'], 'wp_rest' )) || ! current_user_can( 'manage_options' ) ) {			
			return;
		}

		$providers = array_map('sanitize_key', $_POST['providers']);

		update_option(Counter::ORDER_LIST_PROVIDER_COUNTER, $providers); // frontend sort

		return update_option(Providers::ORDER_LIST_PROVIDER_COUNTER, $providers); // backend sort
	}

}

