<?php
/**
 * Single Product  stock.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( str_replace( ' ', '', strtolower( $availability ) ) === 'preorder' ) {
	return;
}
?>
<p class="stock <?php echo esc_attr( $class ); ?>"><?php echo wp_kses_post( $availability ); ?></p>
