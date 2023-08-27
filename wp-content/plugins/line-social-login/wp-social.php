<?php
/*
 * Plugin Name: Wp Social
 * Plugin URI: https://wpmet.com/
 * Description: Wp Social Login / Social Sharing / Social Counter System for Facebook, Google, Twitter, Linkedin, Dribble, Pinterest, Wordpress, Instagram, GitHub, Vkontakte, Reddit and more providers.
 * Author: Wpmet
 * Version: 2.2.2
 * Author URI: https://wpmet.com/
 * Text Domain: wp-social
 * License: GPL2+
 * Domain Path: /languages/
**/


defined('ABSPATH') || exit;

define('WSLU_VERSION', '2.2.2');
define('WSLU_VERSION_PREVIOUS_STABLE_VERSION', '2.2.1');

define("WSLU_LOGIN_PLUGIN", plugin_dir_path(__FILE__));
define("WSLU_LOGIN_PLUGIN_URL", plugin_dir_url(__FILE__));


require(WSLU_LOGIN_PLUGIN . 'autoload.php');

require_once plugin_dir_path(__FILE__) . '/lib/notice/notice.php';
require_once plugin_dir_path(__FILE__) . '/lib/banner/banner.php';
require_once plugin_dir_path(__FILE__) . '/lib/pro-awareness/pro-awareness.php';
require_once plugin_dir_path(__FILE__) . '/lib/rating/rating.php';
require_once plugin_dir_path(__FILE__) . '/lib/stories/stories.php';

// init notice class
\Oxaim\Libs\Notice::init();

if(!function_exists('xs_social_plugin_activate')) :
	function xs_social_plugin_activate() {
		$counter = new \WP_Social\Inc\Counter(false);
		$counter->xs_counter_defalut_providers();
	}

	// custom function added
	if(file_exists(WSLU_LOGIN_PLUGIN . 'inc/custom-function.php')) {
		include(WSLU_LOGIN_PLUGIN . 'inc/custom-function.php');
	}
endif;


function xs_social_plugin_deactivate() {
}

register_activation_hook(__FILE__, 'xs_social_plugin_activate');
register_deactivation_hook(__FILE__, 'xs_social_plugin_deactivate');


if(!function_exists('wslu_social_init')) :

	function wslu_social_init() {

		new \WP_Social\App\Legacy();

		\WP_Social\Inc\Elementor\Elements::instance()->_init();

		\WP_Social\App\API_Routes::instance()->init();

		new \WP_Social\App\Route();

		new \WP_Social\Inc\Admin_Settings();
		new \WP_Social\Inc\Counter();
		new \WP_Social\Inc\Share();

		\WP_Social\Helper\Share_Style_Settings::instance()->init();
		\WP_Social\Inc\Login::instance()->init();
		\WP_Social\App\Avatar::instance()->init();

		/**
		 * ----------------------------------------
		 *  Ask for rating ⭐⭐⭐⭐⭐
		 *  A rating notice will appear depends on
		 *
		 * @set_first_appear_day methods
		 * ----------------------------------------
		 */
		\Wpmet\Libs\Rating::instance('wp-social')
			->set_plugin_logo('https://ps.w.org/wp-social/assets/icon-128x128.png')
			->set_plugin('Wpsocial', 'https://wordpress.org/plugins/wp-social')
			->set_allowed_screens('toplevel_page_wslu_global_setting')
			->set_allowed_screens('wp-social_page_wslu_share_setting')
			->set_allowed_screens('wp-social_page_wslu_counter_setting')
			->set_allowed_screens('wp-social_page_wp-social_get_help')
			->set_priority(50)
			->set_first_appear_day(7)
			->set_condition(true)
			->call();


		\Wpmet\Libs\Pro_Awareness::init();


		$is_pro_active = in_array('wp-social-pro/wp-social-pro.php', apply_filters('active_plugins', get_option('active_plugins')));

		$pro_awareness = \Wpmet\Libs\Pro_Awareness::instance('wp-social');
		if(version_compare($pro_awareness->get_version(), '1.2.0') >= 0) {
			$pro_awareness
				->set_parent_menu_slug('wslu_global_setting')
				->set_plugin_file('wp-social/wp-social.php')
				->set_pro_link(
					($is_pro_active ? '' : 'https://wpmet.com/plugin/wp-social/')
				)
				->set_default_grid_link('https://wpmet.com/support-ticket')
				->set_default_grid_thumbnail(WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/support.png')
				->set_page_grid([
					'url'       => 'https://www.facebook.com/groups/1319571704894531',
					'title'     => __('Join the Community', 'wp-social'),
					'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/community.png',
					'description' => __('Join our Facebook group to get 20% discount coupon on premium products. Follow us to get more exciting offers.', 'wp-social')
				])
				->set_page_grid([
					'url'       => 'https://www.youtube.com/playlist?list=PL3t2OjZ6gY8PnEdvPuCiz1goxm8wBTn-f',
					'title'     => __('Video Tutorials', 'wp-social'),
					'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/videos.png',
					'description' => __('Learn the step by step process for developing your site easily from video tutorials.', 'wp-social')
				])
				->set_page_grid(
					array(
						'url'       => 'https://wpmet.com/plugin/wp-social/roadmaps#ideas',
						'title'     => __('Request a feature', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/request.png',
						'description' => __('Have any special feature in mind? Let us know through the feature request.', 'wp-social')
					)
				)
				->set_page_grid([
					'url'       => 'https://wpmet.com/doc/wp-social/',
					'title'     => __('Documentation', 'wp-social'),
					'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/community.png',
					'description' => __('Detailed documentation to help you understand the functionality of each feature.', 'wp-social')
				])
				->set_page_grid(
					array(
						'url'       => 'https://wpmet.com/plugin/wp-social/roadmaps/',
						'title'     => __('Public Roadmap', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/pro-awareness/assets/roadmaps.png',
						'description' => __('Check our upcoming new features, detailed development stories and tasks', 'wp-social')
					)
				)
				->set_products(
					array(
						'url'       => 'https://getgenie.ai/',
						'title'     => __('GetGenie', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/getgenie-logo.svg',
						'description' => __('Your AI-Powered Content & SEO Assistant for WordPress', 'wp-social'),
					)
				)
				->set_products(
					array(
						'url'       => 'https://wpmet.com/plugin/elementskit/',
						'title'     => __('WP Social', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/elementskit-logo.svg',
						'description' => __('All-in-One drag and drop Addons for Elementor', 'wp-social')
					)
				)
				->set_products(
					array(
						'url'       => 'https://wpmet.com/plugin/shopengine/',
						'title'     => __('ShopEngine', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/shopengine-logo.svg',
						'description' => __('Complete WooCommerce Solution for Elementor', 'wp-social'),
					)
				)
				->set_products(
					array(
						'url'       => 'https://wpmet.com/plugin/metform/',
						'title'     => __('MetForm', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/metform-logo.svg',
						'description' => __('Most flexible drag-and-drop form builder', 'wp-social')
					)
				)
				->set_products(
					array(
						'url'       => 'https://wpmet.com/plugin/wp-ultimate-review/?ref=wpmet',
						'title'     => __('Ultimate Review', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/ultimate-review-logo.svg',
						'description' => __('Integrate various styled review system in your website', 'wp-social')
					)
				)
				->set_products(
					array(
						'url'       => 'https://products.wpmet.com/crowdfunding/?ref=wpmet',
						'title'     => __('Fundraising & Donation Platform', 'wp-social'),
						'thumbnail' => WSLU_LOGIN_PLUGIN_URL . 'lib/onboard/assets/images/onboard/wp-fundraising-logo.svg',
						'description' => __('Enable donation system in your website', 'wp-social')
					)
				)
				->set_plugin_row_meta('Documentation', 'https://help.wpmet.com/docs-cat/wp-social/', ['target' => '_blank'])
				->set_plugin_row_meta('Facebook Community', 'https://wpmet.com/fb-group', ['target' => '_blank'])
				->set_plugin_row_meta('Rate the plugin ★★★★★', 'https://wordpress.org/support/plugin/wp-social/reviews/#new-post', ['target' => '_blank'])
				->set_plugin_action_link('Settings', admin_url() . 'admin.php?page=wslu_global_setting')
				->set_plugin_action_link(($is_pro_active ? '' : 'Go Premium'), 'https://wpmet.com/plugin/wp-social', ['target' => '_blank', 'style' => 'color: #FCB214; font-weight: bold;'])
				->call();		
		}		


		$filter_string = ''; // elementskit,metform-pro
		$filter_string .= ((!in_array('elementskit/elementskit.php', apply_filters('active_plugins', get_option('active_plugins')))) ? '' : ',elementskit');
		$filter_string .= ((!in_array('wp-social/wp-social.php', apply_filters('active_plugins', get_option('active_plugins')))) ? '' : ',wp-social');
		$filter_string .= (!class_exists('\MetForm\Plugin') ? '' : ',metform');
		$filter_string .= (!class_exists('\MetForm_Pro\Plugin') ? '' : ',metform-pro');

		/**
		 * Show WPMET stories widget in dashboard
		 */
		\Wpmet\Libs\Stories::instance('wp-social')
			->set_filter($filter_string)
			->set_plugin('Wpsocial', 'https://wpmet.com/plugin/wp-social/')
			->set_api_url('https://api.wpmet.com/public/stories/')
			->call();


		add_action('widgets_init', '\WP_Social\Inc\Counter_Widget::register');
		add_action('widgets_init', '\WP_Social\Inc\Share_Widget::register');
		add_action('widgets_init', '\WP_Social\Inc\Login_widget::register');


		do_action('wslu_social/plugin_loaded');


		\Wpmet\Libs\Banner::instance('wp-social')
			->set_filter($filter_string)
			->set_api_url('https://api.wpmet.com/public/jhanda/index.php')
			->set_plugin_screens('toplevel_page_wslu_global_setting')
			->set_plugin_screens('wp-social_page_wslu_share_setting')
			->set_plugin_screens('wp-social_page_wslu_counter_setting')
			->call();


		\WP_Social\Plugin::instance()->enqueue();

		// onboard style
		if(isset($_GET['wp-social-met-onboard-steps']) && sanitize_text_field($_GET['wp-social-met-onboard-steps']) == 'loaded') {
			\WP_Social\Lib\Onboard\Attr::instance();
		}
	}

	add_action('plugins_loaded', 'wslu_social_init', 118);

endif;


/**
 * Below code has no effect right now, but I am going to organize the code step by step
 * So this will be the root access point
 *
 * - for now loading the language by this class
 * -
 *
 */
if(!class_exists('\WP_Social')) {

	class WP_Social {


		/**
		 * Plugin plugins's root file
		 *
		 * @return string
		 */
		static function plugin_file() {
			return __FILE__;
		}
		/**
		 * Plugin plugins's root url.
		 *
		 * todo - WSLU_LOGIN_PLUGIN_URL will be replaced by this method
		 *
		 * @return mixed
		 */
		static function plugin_url() {
			return trailingslashit(plugin_dir_url(__FILE__));
		}


		/**
		 * Plugin plugins's root directory.
		 *
		 * todo - WSLU_LOGIN_PLUGIN will be replaced by this method
		 *
		 * @return mixed
		 */
		static function plugin_dir() {
			return trailingslashit(plugin_dir_path(__FILE__));
		}


		/**
		 * Lets start the plugin
		 *
		 *
		 */
		public function __construct() {

			add_action('init', [$this, 'i18n']);

			//add_action('plugins_loaded', array($this, 'init'), 100);
		}


		/**
		 * Load text-domain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function i18n() {
			// onboard
			\WP_Social\Lib\Onboard\Onboard::instance()->init();
			load_plugin_textdomain('wp-social', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}


		public static function is_pro_active() {

			$is_pro_active = in_array('wp-social-pro/wp-social-pro.php', apply_filters('active_plugins', get_option('active_plugins')));

			return $is_pro_active;
		}
	}
}

new \WP_Social();
