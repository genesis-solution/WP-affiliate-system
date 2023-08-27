<?php

namespace WP_Social\App;

use WP_Social\Lib\Provider\Share_Factory;

defined('ABSPATH') || exit;

class API_Routes {

	private static $instance;

	protected $version = 1;

	public function init() {

		add_action('rest_api_init', function() {

			register_rest_route('wp_social/v' . $this->version, '/counter/enable/(?P<key>\w+)', array(
					'methods'             => 'POST',
					'callback'            => [$this, 'enable_provider_counter'],
					'permission_callback' => function() {
						return true;
					},
				)
			);

			register_rest_route('wp_social/v' . $this->version, '/share/enable/(?P<key>\w+)', array(
					'methods'             => 'POST',
					'callback'            => [$this, 'enable_provider_share'],
					'permission_callback' => function() {
						return true;
					},
				)
			);

			register_rest_route('wp_social/v' . $this->version, '/login/enable/(?P<key>\w+)', array(
					'methods'             => 'POST',
					'callback'            => [$this, 'enable_provider_login'],
					'permission_callback' => function() {
						return true;
					},
				)
			);


			register_rest_route('wp_social/v' . $this->version, '/shared/url', array(
					'methods'             => 'POST',
					'callback'            => [$this, 'increase_url_share_count'],
					'permission_callback' => function() {
						return true;
					},
				)
			);

		});
	}


	public function enable_provider_counter(\WP_REST_Request $request) {

		$social_key = $request['key'];
		$providers = \WP_Social\App\Settings::get_enabled_provider_conf_counter();
		$parameters = $request->get_params();

		$providers[$social_key]['enable'] = empty($parameters['val']) ? '' : 1;

		$saved = \WP_Social\App\Settings::update_enabled_provider_conf_counter($providers);

		return array(
			'msg'     => 'successful',
			'success' => $saved,
		);
	}


	public function enable_provider_share(\WP_REST_Request $request) {

		$social_key = $request['social'];
		$providers = \WP_Social\App\Settings::get_enabled_provider_conf_share();
		$parameters = $request->get_params();

		$providers[$social_key]['enable'] = empty($parameters['val']) ? '' : 1;

		$saved = \WP_Social\App\Settings::update_enabled_provider_conf_share($providers);

		return array(
			'msg'     => 'successful',
			'success' => $saved,
		);
	}


	public function enable_provider_login(\WP_REST_Request $request) {

		$social_key = $request['key'];
		$providers = \WP_Social\App\Settings::get_enabled_provider_conf_login();
		$parameters = $request->get_params();

		$providers[$social_key]['enable'] = empty($parameters['val']) ? '' : 1;

		$saved = \WP_Social\App\Settings::update_enabled_provider_conf_login($providers);

		return array(
			'msg'     => 'successful',
			'success' => $saved,
		);
	}


	public function increase_url_share_count(\WP_REST_Request $request) {

		$key = $request['social'];
		$pid = $request['pid'];
		$hash = $request['hash'];

		$factory = new Share_Factory($pid);
		$obj = $factory->make($key);

		$saved = $obj->set_uri_hash($hash)->increase_share_count_by_one();

		return array(
			'msg'     => 'successful',
			'success' => $saved,
		);
	}

	public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
	}
}
