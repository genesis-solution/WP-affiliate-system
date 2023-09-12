<?php
namespace ShopEngine\Core\Settings;

use ShopEngine\Core\Onboard\Onboard;
use ShopEngine\Core\Register\Model;

defined('ABSPATH') || exit;

/**
 * Class Api
 *
 * @package ShopEngine\Core\Builders
 */
class Api extends \ShopEngine\Base\Api {

	public function config() {

		$this->prefix = 'settings';
		$this->param  = "";
		$this->only_admin = true;
	}


	public function post_save() {

		if( !wp_verify_nonce( $this->request->get_header('x_wp_nonce'), 'wp_rest') && !current_user_can( 'manage_options' ) ) {
			return false;
		}
		
		$data = json_decode($this->request->get_body(), true);

		if(!empty($data['widgets'])) {

			Model::source('settings')->set_option('widgets', $data['widgets']);
		}

		if(!empty($data['modules'])) {

			Model::source('settings')->set_option('modules', $data['modules']);
		}

		if(!empty($data['userdata'])) {

			Model::source('settings')->set_option('userdata', $data['userdata']);
		}

		do_action('shopengine/core/settings/on_save', $data);

		return [
			'status' => 'success',
			'message' => esc_html__('settings saved successfully.', 'shopengine'),
		];
	}


	public function get_fields() {
		$fields = array_merge(
			Action::instance()->get_fields(), 
			['sample_designs' => \ShopEngine\Core\Sample_Designs\Base::instance()->get_designs()]
		);

		return apply_filters('shopengine/core/settings/return_fields', $fields);
	}

	public function get_data() {
		$data = Action::instance()->get_data();

		return apply_filters('shopengine/core/settings/return_data', $data);
	}

	public function get_our_others_plugin_install_api() {
        $plugins = [
            'elementskit-lite'        => 'elementskit-lite.php',
            'metform'                 => 'metform.php',
            'wp-social'               => 'wp-social.php',
            'wp-ultimate-review'      => 'wp-ultimate-review.php',
            'wp-fundraising-donation' => 'wp-fundraising-donation.php',
            'getgenie' 				  => 'getgenie.php'
        ];

		$plugin_status = Plugin_Status::instance();
		$plugins_data  = [];

		foreach($plugins as $slug => $file) {
			$plugins_data[$slug] = $plugin_status->get_status($slug.'/'.$file);
		}
		return $plugins_data;
    }

	public function post_save_onboard() {
		$data    = $this->request->get_params();
		$onboard = new Onboard();
		return $onboard->submit($data);
	}
	
	public function get_categories() {

		$data = $this->request->get_params();

		$query_args = [
            'taxonomy'      => ['product_cat'], // taxonomy name
            'orderby'       => 'name', 
            'order'         => 'DESC',
            'hide_empty'    => false,
            'number'        => 10
        ];

		if(isset($data['only_parent'])){
			$query_args['parent'] = 0;
		}
		
		if(isset($data['ids'])){
            $ids = explode(',', $data['ids']);
            $query_args['include'] = $ids;
        }
        if(isset($data['s'])){
            $query_args['name__like'] = $data['s'];
        }

		$product_cat = get_terms($query_args);
		$product_categories = [];
		foreach($product_cat as $category) {
			$product_categories[$category->term_id] = $category->name;
		}
		return [
			'status' => 'success',
			'result' => $product_categories,
			'message' => esc_html__('categories fetched', 'shopengine')
		];
	}

	public function get_posts() {

		$data = $this->request->get_params();

		if(empty($data['post_type'])) {
			return [
				'status' => 'failed'
			];
		}

		$search = isset($data['s']) ? $data['s'] : false;
		$post_status = !empty($data['post_status']) ? $data['post_status'] : '';

		global $wpdb;

		$params = [
			sanitize_text_field($data['post_type'])
		];

		$post_status_array = ['publish'];
		if($post_status === 'draft'){
			$post_status_array[] = 'draft';
		}

		$escaped = array();
		foreach($post_status_array as $status_item){
			$escaped[] = $wpdb->prepare('%s', sanitize_text_field($status_item));
		}
		$post_status = implode(',',  $escaped);

		$post_search_statement = '';
		if(!empty($search)){
			$post_search_statement = 'AND post_title LIKE %s';
			array_push($params, '%'. $wpdb->esc_like( $search ) .'%');
		}
		
		//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Already applied prepare method in top
		$posts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type=%s AND post_status IN ($post_status) $post_search_statement LIMIT 10", $params) ); 
		
		$post_items = [];
		foreach($posts as $post) {
			array_push($post_items, ['id' => $post->ID, 'text' => $post->post_title]);
		}

		return [
			'status' => 'success',
			'results' => $post_items,
		];
	}
}


