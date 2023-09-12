<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/templates/checkout/form-checkout.php.
 */

defined('ABSPATH') || exit;
$editor_mode = ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) ;
if(get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE) {
	wc()->frontend_includes();

	if(empty(WC()->cart->cart_contents)) {

		WC()->session = new WC_Session_Handler();
		WC()->session->init();
		WC()->customer = new WC_Customer(get_current_user_id(), true);
		WC()->cart     = new WC_Cart();

		$demo_products = get_posts(
			[
				'post_type'   => 'product',
				'numberposts' => 1,
				'post_status' => 'publish',
				'fields'      => 'ids',
				'orderby'     => 'ID',
				'order'       => 'DESC',
			]
		);

		if(!empty($demo_products)) {
			foreach($demo_products as $id) {
				WC()->cart->add_to_cart($id);
			}
		}
	}
}
?>

    <div class="shopengine-checkout-review-order">

        <h3 id="order_review_heading"><?php esc_html_e('Your order', 'shopengine'); ?></h3>

        <div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action('woocommerce_checkout_before_order_review'); ?>
			<?php 
				if($editor_mode){
					include_once ShopEngine::widget_dir() . 'checkout-review-order/screens/review-order-template.php';
				}else{
					woocommerce_order_review();
				}
			?>
        </div>
		<?php do_action('woocommerce_checkout_after_order_review'); ?>
    </div>
<?php
