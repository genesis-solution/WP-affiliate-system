<?php

namespace ShopEngine\Core\Page_Templates\Hooks;

use ShopEngine;
use ShopEngine\Core\Register\Module_List;
use ShopEngine\Widgets\Widget_Helper;

defined('ABSPATH') || exit;

class Checkout extends Base {

	protected $page_type = 'checkout';
	protected $template_part = 'content-checkout.php';

	public function init(): void {

		add_filter('wc_get_template', function ( $template ) {
			if ( strpos( $template, 'checkout/review-order.php' ) !== false ) {
				return ShopEngine::widget_dir() . 'checkout-review-order/screens/review-order-template.php';
			}
			return $template;
		});

		if (class_exists('ShopEngine_Pro\Modules\Multistep_Checkout\Multistep_Checkout')) {

			$module_list = Module_List::instance();

			if ($module_list->get_list()['multistep-checkout']['status'] === 'active') {
				\ShopEngine_Pro\Modules\Multistep_Checkout\Multistep_Checkout::instance()->load();
			}
		}

		Widget_Helper::instance()->wc_template_replace_multiple(
			[
				'checkout/review-order.php',
				'checkout/payment-method.php',
			]
		);

		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);

		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');


        /**
         * Remove checkout template extra markup;
         */
        remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

		do_action( 'woocommerce_check_cart_items' );
	} 
	
	protected function get_page_type_option_slug(): string {
		if(!empty($_REQUEST['nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['nonce'])), 'wp_rest')) {
			return !empty($_REQUEST['shopengine_quick_checkout']) && $_REQUEST['shopengine_quick_checkout'] === 'modal-content' ? 'quick_checkout' : $this->page_type;
		}
		return $this->page_type;
	}

	protected function template_include_pre_condition(): bool {
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- It's a fronted user part, not possible to verify nonce here
		return (is_checkout() && !is_wc_endpoint_url('order-received') && !is_checkout_pay_page()) || (isset($_REQUEST['wc-ajax']) &&  $_REQUEST['wc-ajax'] == 'update_order_review');
	}
}
