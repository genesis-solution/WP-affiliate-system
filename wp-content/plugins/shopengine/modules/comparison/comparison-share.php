<?php


namespace ShopEngine\Modules\Comparison;


class Comparison_Share {

	public static function init() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- It's a fronted user part, not possible to verify nonce here
		$product_ids = !empty( $_GET['product_ids'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_GET['product_ids'] ) ) ?? '' ) : [];

		if ( empty( $product_ids ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- It's a fronted user part, not possible to verify nonce here
			$existing_comparison_products = empty( $_COOKIE[ Comparison::COOKIE_KEY ] ) ? '' : sanitize_text_field( wp_unslash( $_COOKIE[ Comparison::COOKIE_KEY ] ) );
			$product_ids                  = $existing_comparison_products? explode( ',', $existing_comparison_products ) : [];

		} else {
			setcookie(
				Comparison::COOKIE_KEY,
				implode( ',', $product_ids ),
				strtotime( '+' . Comparison::COOKIE_TIME_IN_DAYS . ' days' ), '/'
			);
		}

		get_header();
		?>
		<div class="shopengine-comparison-page">
			<div class="comparison-page-inner">
				<?php
				if ( empty( $product_ids ) ) {
					echo '<h1 class="shopengine-no-comparison-product">' . esc_html__( 'No product is added for comparison, please add some product to compare', 'shopengine' ) . '</h1>';
				} else {
					Comparison_Helper::get_html( $product_ids, true );
				}
				?>
			</div>
		</div>
		<?php get_footer();
	}

}