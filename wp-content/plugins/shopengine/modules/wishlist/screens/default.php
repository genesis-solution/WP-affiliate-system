<table class="table table-bordered shopengine-wishlist">
    <thead>
    <tr>
        <th><?php echo esc_html__('Products', 'shopengine') ?></th>
        <th><?php echo esc_html__('Unit Price', 'shopengine') ?></th>
        <th><?php echo esc_html__('Stock Status', 'shopengine') ?></th>
        <th><?php echo esc_html__('Action', 'shopengine') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php

    if(is_array($list)):
	foreach($list as $key => $product_id) {

		$product = wc_get_product($product_id);
		if(empty($product)) continue;

		?>
        <tr>
            <td>
                <span class="shopengine-wishlist-product-image">
                    <?php echo wp_get_attachment_image( $product->get_image_id(), ['100','100'], false, ["width" => "100"] ); ?>
                </span>
                <p class="wishlist-product-name">
                    <a title="<?php esc_html_e('View Product Full Details','shopengine')?>" target="_blank" href="<?php echo esc_url($product->get_permalink()) ?>">
                        <?php echo esc_html($product->get_name()) ?>
                    </a>
                </p>
            </td>

            <td>
				<?php
                shopengine_content_render(\ShopEngine\Utils\Helper::render($product->get_price_html()));
                ?>
            </td>

            <td>
	            <?php
                    switch($product->get_stock_status()) {
                        case 'instock':
                            echo esc_html__('In Stock', 'shopengine');
                            break;
                        default:
                        echo esc_html($product->get_stock_status());
                    }
                ?>
            </td>

            <td>
		        <span class="shopengine-remove-action remove-badge remove-from-wishlist" data-pid="<?php echo absint($product_id) ?>">X</span>
            </td>
        </tr>
		<?php
	}
    endif;
	?>

    </tbody>
</table>

<?php
