<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/single-product/tabs/additional-information.php.
 */

defined('ABSPATH') || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', esc_html__( 'Additional information', 'shopengine' ) );
?>

<div class="shopengine">
    <div class="shopengine-additional-information">

		<?php

		if($heading) : ?>

            <h2><?php echo esc_html($heading); ?></h2> <?php

		endif;

		do_action('woocommerce_product_additional_information', $product);

		?>

    </div>
</div>

