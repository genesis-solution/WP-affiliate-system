<?php

namespace WP_Social\Inc;

/**
 * Login functionality for social logins
 *
 */

defined('ABSPATH') || exit;

class Login {

	/**
	 * ===================
	 *      Singleton
	 * ===================
	 */

	private static $instance;


	public static function instance() {

		if(!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * =========================
	 *      Execution point
	 * =========================
	 */

	public function init() {

		add_action('wp_login', [$this, 'after_login'], 10, 2);

		add_action('profile_update', [$this, 'after_password_rest']);

		add_action('init', [$this, 'rest_api']);

	}


	public function rest_api() {

		add_action('rest_api_init', function() {
			register_rest_route('wp-social', 'user/meta', [
				'methods'  => 'GET',
				'callback' => [$this, 'check_meta'],
				'permission_callback' => '__return_true',
			]);
		});
	}


	public function check_meta() {
		$user_meta = get_user_meta(5, 'xs_password_changed');
	}


	/**
	 * =====================
	 *      After login
	 * =====================
	 */

	public function after_login($user_login, $user) {


		$user_meta = get_user_meta($user->ID, 'xs_password_changed', true);

		/*
		-------------------------------------
		Check if user is created by WP Social
		-------------------------------------
		*/

		if($user_meta) {

			/**
			 * Check if user changed the password.
			 * If it says 'no' that means user did
			 * not change the password so we should
			 * loggout them
			 */

			if($user_meta == 'no') {

				wp_logout();
			}
		}
	}


	/**
	 * ======================================
	 *         After password reset
	 *=======================================
	 */

	public function after_password_rest() {

		$user_id = get_current_user_id();

		/** If password does not change */

		if(!isset($_POST['pass1']) || '' == $_POST['pass1']) {
			return;
		}

		$user_meta = get_user_meta($user_id, 'xs_password_changed', true);

		if($user_meta) {
			update_user_meta($user_id, 'xs_password_changed', 'yes');
		}
	}
}
