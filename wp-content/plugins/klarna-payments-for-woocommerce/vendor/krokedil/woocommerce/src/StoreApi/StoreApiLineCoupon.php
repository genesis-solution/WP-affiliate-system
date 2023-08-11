<?php
/**
 * Cart line coupon.
 *
 * @package Krokedil/WooCommerce/
 */

namespace Krokedil\WooCommerce\StoreApi;

use Krokedil\WooCommerce\OrderLineData;

defined( 'ABSPATH' ) || exit;

/**
 * StoreApi line coupon class.
 */
class StoreApiLineCoupon extends OrderLineData {

	/**
	 * WooCommerce Coupon data.
	 *
	 * @var array
	 */
	public $coupon;

	/**
	 * Coupon amount.
	 *
	 * @var float|int
	 */
	public $discount_amount;

	/**
	 * Coupon amount.
	 *
	 * @var float|int
	 */
	public $discount_tax_amount;

	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'store_api_cart_line_coupon';

	/**
	 * Set the data for a normal WooCommerce coupon from the store api.
	 *
	 * @param array $coupon Coupon data.
	 *
	 * @return void
	 */
	public function set_coupon_data( $coupon ) {
		$this->coupon              = $coupon;
		$this->discount_amount     = $this->format_price_from_minor( $coupon['totals']['total_discount'] );
		$this->discount_tax_amount = $this->format_price_from_minor( $coupon['totals']['total_discount_tax'] );

		$this->set_name();
		$this->set_sku();
		$this->set_quantity();
		$this->set_unit_price();
		$this->set_subtotal_unit_price();
		$this->set_tax_rate();
		$this->set_total_amount();
		$this->set_subtotal_amount();
		$this->set_total_discount_amount();
		$this->set_total_discount_tax_amount();
		$this->set_total_tax_amount();
		$this->set_subtotal_tax_amount();
		$this->set_type();
		$this->set_product_url();
		$this->set_image_url();
		$this->set_compatability();
	}

	/**
	 * Function to set product name
	 * @return void
	 */
	public function set_name() {
		$this->name = apply_filters( $this->get_filter_name( 'name' ), $this->coupon['code'], $this->coupon );
	}

	/**
	 * Function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $this->coupon['code'], $this->coupon );
	}

	/**
	 * Function to set product quantity
	 * @return void
	 */
	public function set_quantity() {
		$this->quantity = apply_filters( $this->get_filter_name( 'quantity' ), 1, $this->coupon );
	}

	/**
	 * Function to set product unit price
	 * @return void
	 */
	public function set_unit_price() {
		$this->unit_price = apply_filters( $this->get_filter_name( 'unit_price' ), $this->discount_amount, $this->coupon );
	}

	/**
	 * Function to set product subtotal unit price
	 * @return void
	 */
	public function set_subtotal_unit_price() {
		$this->subtotal_unit_price = apply_filters( $this->get_filter_name( 'subtotal_unit_price' ), $this->discount_amount, $this->coupon );
	}

	/**
	 * Function to set product tax rate
	 * @return void
	 */
	public function set_tax_rate() {
		$this->tax_rate = apply_filters( $this->get_filter_name( 'tax_rate' ), 0, $this->coupon );
	}

	/**
	 * Function to set product total amount
	 * @return void
	 */
	public function set_total_amount() {
		$this->total_amount = apply_filters( $this->get_filter_name( 'total_amount' ), $this->discount_amount, $this->coupon );
	}

	/**
	 * Function to set product subtotal amount
	 * @return void
	 */
	public function set_subtotal_amount() {
		$this->subtotal_amount = apply_filters( $this->get_filter_name( 'subtotal_amount' ), $this->discount_amount, $this->coupon );
	}

	/**
	 * Function to set product total discount amount
	 * @return void
	 */
	public function set_total_discount_amount() {
		$this->total_discount_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), 0, $this->coupon );
	}

	/**
	 * Abstract function to set product total discount tax amount
	 * @return void
	 */
	public function set_total_discount_tax_amount() {
		$this->total_discount_tax_amount = apply_filters( $this->get_filter_name( 'tota_discount_tax_amount' ), 0, $this->coupon );
	}

	/**
	 * Function to set product total tax amount
	 * @return void
	 */
	public function set_total_tax_amount() {
		$this->total_tax_amount = apply_filters( $this->get_filter_name( 'total_tax_amount' ), $this->discount_tax_amount, $this->coupon );
	}

	/**
	 * Function to set product subtotal tax amount
	 * @return void
	 */
	public function set_subtotal_tax_amount() {
		$this->subtotal_tax_amount = apply_filters( $this->get_filter_name( 'subtotal_tax_amount' ), $this->discount_tax_amount, $this->coupon );
	}

	/**
	 * Function to set product type
	 * @return void
	 */
	public function set_type() {
		// The store api does not return a type for the coupon. So get the coupon by code and set the type.
		$wc_coupon  = new \WC_Coupon( $this->coupon['code'] );
		$this->type = apply_filters( $this->get_filter_name( 'type' ), $wc_coupon->get_discount_type(), $this->coupon );
	}

	/**
	 * Function to set product url
	 * @return void
	 */
	public function set_product_url() {
		$this->product_url = apply_filters( $this->get_filter_name( 'product_url' ), null, $this->coupon );
	}

	/**
	 * Function to set product image url
	 * @return void
	 */
	public function set_image_url() {
		$this->image_url = apply_filters( $this->get_filter_name( 'image_url' ), null, $this->coupon );
	}

	/**
	 * Function to set product compatability
	 * @return void
	 */
	public function set_compatability() {
		$this->compatability = apply_filters( $this->get_filter_name( 'compatability' ), array(), $this->coupon );
	}
}
