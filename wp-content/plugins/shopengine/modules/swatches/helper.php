<?php

namespace ShopEngine\Modules\Swatches;

defined('ABSPATH') || exit;


class Helper
{

	public static function get_tax_attribute($taxonomy) {

		global $wpdb;

		$attr = substr($taxonomy, 3);
		$attr = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = %s", $attr));

		return $attr;
	}


	public static function get_dummy() {

		return WC()->plugin_url() . '/assets/images/placeholder.png';
	}

	/**
	 * Retrieve the image as product thumbnail size by image id
	 * @param $image_id 
	 * @return image_html
	 */ 
	public static function get_product_thumbnail_by_image_id($image_id, $product, $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true ) {

		if ( ! is_array( $attr ) ) {
			$attr = array();
		}
		if ( ! is_bool( $placeholder ) ) {
			$placeholder = true;
		}

		$size = apply_filters( 'single_product_archive_thumbnail_size', $size );
		$image = wp_get_attachment_image( $image_id, $size, false, $attr );
		if ( ! $image && $placeholder ) {
			$image = wc_placeholder_img( $size, $attr );
		}

		return apply_filters( 'woocommerce_product_get_image', $image, $product, $size, $attr, $placeholder, $image );
	}


}
