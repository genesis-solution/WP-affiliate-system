<?php

defined('ABSPATH') || exit;
?>
<div class="shopengine-cart-table">
	<form class="shopengine-cart-form woocommerce-cart-form" action="javascript:void(0)" method="post">

		<?php do_action('woocommerce_before_cart_table'); ?>

		<!-- shopengine cart table start -->
		<div class="shopengine-table">

			<!-- -------------------------------
				shopengine cart table  head start 
				------------------------------------->
			<div class="shopengine-table__head">
				<div class="shopengine-table__head--th product-name"><?php echo esc_html($settings['shopengine_cart_table_title']) ?></div>
				<div class="shopengine-table__head--th product-price"><?php echo esc_html($settings['shopengine_cart_table_price']) ?></div>
				<div class="shopengine-table__head--th product-quantity"><?php echo esc_html($settings['shopengine_cart_table_quantity']) ?></div>
				<div class="shopengine-table__head--th product-subtotal"><?php echo esc_html($settings['shopengine_cart_table_subtotal']) ?></div>
			</div> <!-- shopengine cart table  head end -->

			<!---------------------------------------
				shopengine cart table  body start
				------------------------------------- -->
			<div class="shopengine-table__body">
				<?php do_action('woocommerce_before_cart_contents'); ?>


				<div class="shopengine-table__body-item" cart_item="=">
					<div class="shopengine-table__body-item--td table-first-body-column">
						<!-- Product Thumbnail and remove button together -->
						<div class="product-thumbnail" data-title="Image">
							<a title="<?php esc_html_e('Product Thumbnail', 'shopengine') ?>" href="https://en.gravatar.com/userimage/215260729/3cb6b9fe31d9ee9112faba4c056a9d0e.jpg?size=300">
								<img width="300" height="300" src="https://en.gravatar.com/userimage/215260729/3cb6b9fe31d9ee9112faba4c056a9d0e.jpg?size=300" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?php esc_attr_e('Beanie with logo','shopengine'); ?>" loading="lazy" sizes="(max-width: 300px) 100vw, 300px">
							</a>
							<!-- remove button -->
							<div class="product-remove">
								<a title="<?php esc_html_e('Remove Item','shopengine')?>" href="javascript:void(0)" class="remove" aria-label="Remove this item" data-product_id="34" data-product_sku="Woo-beanie-logo">
										<span class="ahfb-svg-iconset ast-inline-flex">
											<svg class="ast-mobile-svg ast-close-svg" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
												<path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path>
											</svg>
										</span>
									</a>
							</div>
						</div>
					</div>

					<!-- product name -->
					<div class="shopengine-table__body-item--td product-name" data-title="Product">
						<a title="<?php esc_html_e('Product Name','shopengine')?>"href="https://en.gravatar.com/userimage/215260729/3cb6b9fe31d9ee9112faba4c056a9d0e.jpg?size=300">Beanie with Logo</a>
					</div>
					<!-- product price -->
					<div class="shopengine-table__body-item--td product-price" data-title="Price">
						<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>100.00</bdi></span>
					</div>

					<!-- product quantity -->
					<div class="shopengine-table__body-item--td product-quantity" data-title="Quantity">
						<div class="shopengine-cart-quantity">
							<span class="minus-button">−</span><span class="plus-button">+</span>
							<div class="quantity buttons_added"><a title="<?php esc_html_e('Minus','shopengine')?>" href="javascript:void(0)" class="minus">-</a>
								<label class="screen-reader-text" for="quantity_62e659e085d4e">Beanie with Logo quantity</label>
								<input type="number" id="quantity_62e659e085d4e" class="input-text qty text" step="1" min="0" max="" name="cart[e369853df766fa44e1ed0ff613f563bd][qty]" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
								<a title="<?php esc_html_e('Plus','shopengine')?>" href="javascript:void(0)" class="plus">+</a>
							</div>
						</div>

					</div>

					<!-- product subtotal -->
					<div class="shopengine-table__body-item--td product-subtotal" data-title="Subtotal">
						<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>100.00</bdi></span>
					</div>

				</div>


				<?php do_action('woocommerce_cart_contents'); ?>
				<?php do_action('woocommerce_after_cart_contents'); ?>

			</div> <!-- shopengine cart table  body end -->

			<!--------------------------------
				shopengine cart table footer start
				------------------------------- -->
			<div class="shopengine-table__footer">

				<div class="button-group-left">
					<button class="return-to-shop shopengine-footer-button">
						<i class="eicon-arrow-left"></i>
						<a title="<?php esc_html_e('Return To Shop','shopengine')?>" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
							<?php echo esc_html(apply_filters('woocommerce_return_to_shop_text', esc_html($settings['shopengine_cart_continue_shopping_btn'])));  ?>
						</a>
					</button>
				</div>

				<div class="button-group-right">
					<button type="submit" class="button update-cart-btn shopengine-footer-button" name="">
						<i class="eicon-redo"></i>
						<?php echo esc_html($settings['shopengine_cart_table_update']); ?>
					</button>

					<button class="shopengine-footer-button clear-btn" type="submit" name="empty_cart">
						<i class="eicon-trash-o"></i>
						<?php echo esc_html($settings['shopengine_cart_table_clear_all']); ?>
					</button>
				</div>
				<?php do_action('woocommerce_cart_actions'); ?>

			</div> <!-- shopengine cart table footer end -->

		</div> <!-- shopengine cart table  end -->
		<?php do_action('woocommerce_after_cart_table'); ?>
	</form>

	<?php do_action('woocommerce_after_cart'); ?>
</div>