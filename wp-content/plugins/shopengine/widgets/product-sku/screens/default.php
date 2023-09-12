<?php defined('ABSPATH') || exit;

$post_type = get_post_type();

$product = \ShopEngine\Widgets\Products::instance()->get_product($post_type);

if(!$product->get_sku()) {

	if($post_type == \ShopEngine\Core\Template_Cpt::TYPE) {
		echo esc_html__('This product has no sku', 'shopengine');
	}

	return;
}

?>

<div class="shopengine-sku">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if(wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

        <span class="sku-wrapper">
                
                <?php if(isset($settings['shopengine_product_sku_label_show']) && $settings['shopengine_product_sku_label_show'] == 'yes') : ?>

                    <span class="sku-label"><?php esc_html_e('SKU:', 'shopengine'); ?></span>

                <?php endif; ?>

            <span class="sku-value">
				<?php
					if(empty( $product->get_sku())) {
						echo esc_html__('N/A', 'shopengine');
					} else {
						echo esc_html($product->get_sku());
					}
				?>
			</span>
                
        </span>

	<?php endif; ?>

</div>
