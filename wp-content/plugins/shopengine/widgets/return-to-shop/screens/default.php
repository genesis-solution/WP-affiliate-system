<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/cart/cart-empty.php.
 */

defined('ABSPATH') || exit;

?>
<div class="shopengine-return-to-shop">
    <p class="return-to-shop">
        <a title="<?php esc_html_e('Return To Shop','shopengine')?>" class="button wc-backward"
           href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
			<?php esc_html_e('Return to shop', 'shopengine'); ?>
        </a>
    </p>
</div>
