<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/cart/cart-empty.php.
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );
