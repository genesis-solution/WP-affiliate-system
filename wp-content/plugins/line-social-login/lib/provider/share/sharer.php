<?php

namespace WP_Social\Lib\Provider\Share;

defined('ABSPATH') || exit;

abstract class Sharer implements Share_Interface {

	protected $global_options;
	protected $key;
	protected $post_id;
	protected $tracking_url;
	protected $option_key;
	protected $url_hash;

	public function __construct($post_id = 0, $key = '') {

		$this->key = $key;

		$this->post_id = $post_id;

		$this->tracking_url = get_permalink($this->post_id);
	}


	protected function get_transient_key() {

		$md5 = md5($this->tracking_url . $this->post_id);

		return 'xs_sharer_' . $this->post_id . '_' . $this->key . '_' . $md5;
	}


	public function need_to_call_legacy_function() {

		return false;
	}


	public function set_config_data($conf_array = []) {

		$this->global_options = $conf_array;

		return $this;
	}


	public function set_uri_hash($hash) {

		$this->url_hash = $hash;

		return $this;
	}


	protected function get_option_key() {

		return 'xs_shared_count__' . $this->key . '_' . $this->url_hash;
	}


	protected function get_meta_key() {

		return 'xs_shared_count_' . intval($this->post_id) . '_' . $this->key;
	}


	public function increase_share_count_by_one() {

		$opt_key = $this->get_meta_key();

		$old = get_post_meta($this->post_id, $opt_key, true);

		$count = intval($old) + 1;

		return update_post_meta($this->post_id, $opt_key, $count);
	}


	public function get_url_share_count() {

		$opt_key = $this->get_meta_key();

		$old = get_post_meta($this->post_id, $opt_key, true);

		return intval($old);
	}
}
