<?php

namespace WP_Social\App;

use WP_Social\Base\Api;

class Route extends Api {

	public function config() {

		$this->prefix = 'settings';
		$this->param = "";
	}


	public function post_clear_counter_cache() {

		$data = $this->request->get_params();

		if(!empty($data['provider'])) {

			$provider = sanitize_key($data['provider']);
			$username = isset($data['username']) ? sanitize_key($data['username']) : '';

			if(delete_transient('_xs_social_' . $provider . '_count_' . $username)) {

				return [
					'success' => true,
					'msg'     => esc_html__('Cache cleared successfully!', 'wp-social')
				];
			}

			return [
				'success' => true,
				'msg'     => esc_html__('No cache found.', 'wp-social')
			];
		}

		return [
			'success' => true,
			'msg'     => esc_html__('Invalid data.', 'wp-social')
		];
	}
}
