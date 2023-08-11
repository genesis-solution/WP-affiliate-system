<?php
/**
 * Order line coupon.
 *
 * @package Krokedil/WooCommerce/Classes/Order
 */

namespace Krokedil\WooCommerce\Order;

use Krokedil\WooCommerce\OrderLineData;

defined( 'ABSPATH' ) || exit;

/**
 * Order line coupon class.
 */
class OrderLineCoupon extends OrderLineData {

	/**
	 * WooCommerce order item coupon.
	 *
	 * @var WC_Order_Item_Coupon
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
	 * Sets the data for the order line coupon.
	 *
	 * @param WC_Order_Item_Coupon $coupon
	 * @return void
	 */
	public function set_coupon_data( $coupon ) {
		$this->coupon = $coupon;

		$this->discount_amount     = $this->format_price( $coupon->get_discount() );
		$this->discount_tax_amount = $this->format_price( $coupon->get_discount_tax() );

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
	 * Set coupon data from Smart coupons.
	 *
	 * @param WC_Order_Item_Coupon $coupon The WooCommerce coupon
	 *
	 * @return void
	 */
	public function set_smart_coupon_data( $coupon ) {
		$code              = $coupon->get_code();
		$coupon_amount     = $coupon->get_discount() * -1;
		$coupon_tax_amount = 0;
		$coupon_name       = 'Discount';

		$this->name                = "$coupon_name $code";
		$this->sku                 = substr( strval( $code ), 0, 64 );
		$this->quantity            = 1;
		$this->unit_price          = $this->format_price( $coupon_amount );
		$this->subtotal_unit_price = $this->format_price( $coupon_amount );
		$this->total_amount        = $this->format_price( $coupon_amount );
		$this->total_tax_amount    = $this->format_price( $coupon_tax_amount );
		$this->tax_rate            = 0;
		$this->type                = 'discount';
	}

	/**
	 * Set the data from WC_Gift_Card plugin.
	 *
	 * @param WC_GC_Order_Item_Gift_Card $wc_gift_card WC Giftcard.
	 *
	 * @return void
	 */
	public function set_wc_gc_data( $wc_gift_card ) {
		$coupon_amount     = $wc_gift_card->get_amount() * -1;
		$code              = $wc_gift_card->get_code();
		$coupon_tax_amount = 0;
		$coupon_name       = 'Gift card';

		$this->name                = "$coupon_name $code";
		$this->sku                 = 'gift_card';
		$this->quantity            = 1;
		$this->unit_price          = $this->format_price( $coupon_amount );
		$this->subtotal_unit_price = $this->format_price( $coupon_amount );
		$this->total_amount        = $this->format_price( $coupon_amount );
		$this->total_tax_amount    = $this->format_price( $coupon_tax_amount );
		$this->tax_rate            = 0;
		$this->type                = 'gift_card';
	}

	/**
	 * Set the data from the YITH WooCommerce Gift Cards plugin.
	 *
	 * @param string $code YITH Giftcard code.
	 * @param string|int|float $amount YITH Giftcard amount.
	 *
	 * @return void
	 */
	public function set_yith_wc_gc_data( $code, $amount ) {
		$coupon_amount     = $amount * -1;
		$coupon_tax_amount = 0;
		$coupon_name       = 'Gift card';

		$this->name                = "$coupon_name $code";
		$this->sku                 = 'gift_card';
		$this->quantity            = 1;
		$this->unit_price          = $this->format_price( $coupon_amount );
		$this->subtotal_unit_price = $this->format_price( $coupon_amount );
		$this->total_amount        = $this->format_price( $coupon_amount );
		$this->total_tax_amount    = $this->format_price( $coupon_tax_amount );
		$this->tax_rate            = 0;
		$this->type                = 'gift_card';
	}

	/**
	 * Set the data from the PW Giftcard plugin.
	 *
	 * @param string $code PW Giftcard code.
	 * @param string $amount PW Giftcard amount.
	 *
	 * @return void
	 */
	public function set_pw_giftcards_data( $code, $amount ) {
		$coupon_amount     = $amount * -1;
		$coupon_tax_amount = 0;
		$coupon_name       = 'Gift card';

		$this->name                = "$coupon_name $code";
		$this->sku                 = 'gift_card';
		$this->quantity            = 1;
		$this->unit_price          = $this->format_price( $coupon_amount );
		$this->subtotal_unit_price = $this->format_price( $coupon_amount );
		$this->total_amount        = $this->format_price( $coupon_amount );
		$this->total_tax_amount    = $this->format_price( $coupon_tax_amount );
		$this->tax_rate            = 0;
		$this->type                = 'gift_card';
	}

	/**
	 * Function to set product name
	 * @return void
	 */
	public function set_name() {
		$this->name = apply_filters( $this->get_filter_name( 'name' ), $this->coupon->get_code(), $this->coupon );
	}

	/**
	 * Function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $this->coupon->get_code(), $this->coupon );
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
		$meta_data  = $this->coupon->get_meta( 'coupon_data', true );
		$type       = isset( $meta_data['discount_type'] ) ? $meta_data['discount_type'] : 'fixed_cart';
		$this->type = apply_filters( $this->get_filter_name( 'type' ), $type, $this->coupon );
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
