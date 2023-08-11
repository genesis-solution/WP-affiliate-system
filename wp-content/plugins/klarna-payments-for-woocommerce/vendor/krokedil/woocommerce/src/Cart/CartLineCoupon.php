<?php
/**
 * Cart line coupon.
 *
 * @package Krokedil/WooCommerce/Classes/Cart
 */

namespace Krokedil\WooCommerce\Cart;

use Krokedil\WooCommerce\OrderLineData;
use _PHPStan_503e82092\Nette\NotImplementedException;

defined( 'ABSPATH' ) || exit;

/**
 * Cart line coupon class.
 */
class CartLineCoupon extends OrderLineData {

	/**
	 * WooCommerce Coupon data.
	 *
	 * @var WC_Coupon
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
	public $filter_prefix = 'cart_line_coupon';

	/**
	 * Set the data for a normal WooCommerce coupon.
	 *
	 * @param string    $coupon_key Coupon key.
	 * @param WC_Coupon $coupon Coupon data.
	 *
	 * @return void
	 */
	public function set_coupon_data( $coupon_key, $coupon ) {
		$this->coupon              = $coupon;
		$this->discount_amount     = $this->format_price( WC()->cart->get_coupon_discount_amount( $coupon_key, true ) );
		$this->discount_tax_amount = $this->format_price( WC()->cart->get_coupon_discount_tax_amount( $coupon_key, true ) );

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
	 * @param string $coupon_key Coupon key.
	 *
	 * @return void
	 */
	public function set_smart_coupon_data( $coupon_key ) {
		$coupon_amount     = WC()->cart->get_coupon_discount_amount( $coupon_key ) * -1;
		$coupon_tax_amount = 0;
		$coupon_name       = 'Discount';

		$this->name                = "$coupon_name $coupon_key";
		$this->sku                 = substr( strval( $coupon_key ), 0, 64 );
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
	 * @param WC_GC_Gift_Card_Data $wc_gift_card_data WC Giftcard data.
	 *
	 * @return void
	 */
	public function set_wc_gc_data( $wc_gift_card_data ) {
		$code              = $wc_gift_card_data['giftcard']->get_data()['code'];
		$coupon_amount     = $wc_gift_card_data['amount'] * -1;
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
	 *
	 * @return void
	 */
	public function set_yith_wc_gc_data( $code ) {
		$coupon_amount     = isset( WC()->cart->applied_gift_cards_amounts[ $code ] ) ?
			WC()->cart->applied_gift_cards_amounts[ $code ] : 0 * -1;
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
		$this->reference           = 'gift_card';
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
		$this->type = apply_filters( $this->get_filter_name( 'type' ), $this->coupon->get_discount_type(), $this->coupon );
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
