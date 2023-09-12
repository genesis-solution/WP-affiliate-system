<?php defined('ABSPATH') || exit;

global $product;
if(!$product){
	return;
}

// return if review not available
$is_editor = ($post_type == \ShopEngine\Core\Template_Cpt::TYPE) ? true : false;
$rating_count = $product->get_rating_count();

if(!$is_editor && (!post_type_supports('product', 'comments') || !wc_review_ratings_enabled() || $rating_count <= 0 || !function_exists('woocommerce_template_single_rating'))) {

	return;
}

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter_by_match('woocommerce/single-product/rating.php', 'templates/single-product/rating.php');

$shopengine_rating_singular_label = !empty($settings['shopengine_rating_singular_label']) ? $settings['shopengine_rating_singular_label'] : __('Customer Review', 'shopengine');
$shopengine_rating_plural_label = !empty($settings['shopengine_rating_plural_label']) ? $settings['shopengine_rating_plural_label'] :  __('Customer Reviews', 'shopengine');

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>

<div class="shopengine-product-rating">

	<?php if($is_editor) : ?>

		<div class="woocommerce-product-rating">
			<?php shopengine_content_render( wc_get_rating_html( $average, $rating_count ) ); ?>
			<a title="<?php esc_html_e('Product Reviews','shopengine')?>" href="#reviews" class="woocommerce-review-link" rel="nofollow">
				(<?php shopengine_content_render(sprintf( _n( '%s '. $shopengine_rating_singular_label, '%s ' . $shopengine_rating_plural_label, $rating_count, 'shopengine' ), '<span class="count">' . esc_html( $review_count ) . '</span>' )); ?>)
			</a>
		</div>

	<?php else :

		
		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		if ( $rating_count > 0 ) : ?>

			<div class="woocommerce-product-rating">
				<?php shopengine_content_render( wc_get_rating_html( $average, $rating_count ) ); ?>
				<?php if ( comments_open() ) : ?>
					<?php //phpcs:disable ?>
					<a title="<?php esc_html_e('Product Reviews','shopengine')?>" href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s ' . $shopengine_rating_singular_label, '%s ' . $shopengine_rating_plural_label, $review_count, 'shopengine' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
					<?php // phpcs:enable ?>
				<?php endif ?>
			</div>
		<?php
		endif; 
	endif;
	?>
</div>