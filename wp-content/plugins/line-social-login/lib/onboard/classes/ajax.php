<?php

namespace WP_Social\Lib\Onboard\Classes;

defined( 'ABSPATH' ) || exit;

class Ajax {

	private $utils;

	public function __construct() {

		$this->utils = Utils::instance();
		add_action( 'wp_ajax_wp_social_admin_action', [ $this, 'metform_admin_action' ] );
	}

	public function metform_admin_action() {

		// Check for nonce security
		if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_POST['user_data'] ) ) {
			$this->utils->save_option( 'user_data', empty( $_POST['user_data'] ) ? [] : map_deep( wp_unslash( $_POST['user_data'] ) , 'sanitize_text_field' ) );
		}

		if ( isset( $_POST['settings'] ) ) {
			$this->utils->save_settings( empty( $_POST['settings'] ) ? [] : map_deep( wp_unslash( $_POST['settings'] ) , 'sanitize_text_field' ) );
		}

		do_action( 'wpsocial/admin/after_save' );

		return true;
	}

	public function return_json( $data ) {
		if ( is_array( $data ) || is_object( $data ) ) {
			return json_encode( $data );
		} else {
			return $data;
		}
	}

}