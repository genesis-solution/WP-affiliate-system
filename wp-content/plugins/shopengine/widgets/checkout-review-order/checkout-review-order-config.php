<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Checkout_Review_Order_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'checkout-review-order';
	}


	public function get_title() {
		return esc_html__('Checkout Order Review', 'shopengine');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-checkout_review_order';
	}


	public function get_categories() {
		return ['shopengine-checkout'];
	}


	public function get_keywords() {
		return ['checkout', 'shopengine', 'checkout review orders', 'review orders'];
	}


	public function get_template_territory() {
		return ['checkout', 'quick_checkout'];
	}

	public static function add_product_thumbnail( $cart_item ) {

		if(!empty($cart_item['product_id'])) {
			$product    = wc_get_product( intval($cart_item['product_id']) );
			$product_id = !empty( $cart_item['variation_id'] ) ? intval($cart_item['variation_id']) : $product->get_id();
			$attachment = wp_get_attachment_image( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

			if(empty($attachment)) {
				$attachment = wp_get_attachment_image( $product->get_image_id(), 'full' );
			} 
			shopengine_content_render($attachment);
		}
	}
}
