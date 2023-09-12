<?php

namespace ShopEngine\Base;

defined('ABSPATH') || exit;

abstract class Api {

	public $prefix = '';
	public $param = '';
	public $request = null;
	public $only_admin = false;

	abstract public function config();

	public function __construct() {
		$this->config();
		$this->init();
	}


	public function init() {
		add_action('rest_api_init', function() {
			register_rest_route(untrailingslashit(\ShopEngine::SHOPENGINE_PREFIX.'/v1/' . $this->prefix), '/(?P<action>\w+)/' . ltrim($this->param, '/'), array(
				'methods'  => \WP_REST_Server::ALLMETHODS,
				'callback' => [$this, 'action'],
				'permission_callback' => function() {
					if($this->only_admin) {
						return current_user_can('edit_others_posts');
					}
					return true;
				},
			));
		});
	}


	public function action($request) {
		$this->request = $request;
		$action_class  = strtolower($this->request->get_method()) . '_' . sanitize_key($this->request['action']);

		if(method_exists($this, $action_class)) {
			return $this->{$action_class}();
		}
	}

}