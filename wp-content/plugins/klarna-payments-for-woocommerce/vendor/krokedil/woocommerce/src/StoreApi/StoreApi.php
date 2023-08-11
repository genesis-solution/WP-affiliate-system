<?php
/**
 * Class to generate a cart object from the WooCommerce store api cart.
 *
 * @package Krokedil/WooCommerce/
 */

namespace Krokedil\WooCommerce\StoreApi;

use Krokedil\WooCommerce\OrderData;

/**
 * Class to generate a cart object from the WooCommerce cart.
 */
class StoreApi extends OrderData {
	/**
	 * The WooCommerce cart response from the StoreApi.
	 *
	 * @var array $cart
	 */
	public $cart;

	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'store_api_cart';

	/**
	 * Constructor.
	 *
	 * @param array|string $cart The WooCommerce store api cart.
	 * @param array        $config Configuration array.
	 */
	public function __construct( $cart, $config = array() ) {
		parent::__construct( $config );

		// If the cart is a string, decode it as an array.
		if ( is_string( $cart ) ) {
			$cart = json_decode( $cart, true );
		}

		$this->cart = $cart;

		$this->set_line_items();
		$this->set_line_shipping();
		$this->set_line_fees();
		$this->set_line_coupons();
		$this->set_line_compatibility();
		$this->set_customer();
		$this->set_total();
		$this->set_total_tax();
		$this->set_subtotal();
		$this->set_subtotal_tax();
	}

	/**
	 * Gets the cart items.
	 *
	 * @return void
	 */
	public function set_line_items() {
		foreach ( $this->cart['items'] ?? array() as $cart_item ) {
			$cart_item          = new StoreApiLineItem( $cart_item, $this->config );
			$this->line_items[] = apply_filters( $this->get_filter_name( 'line_items' ), $cart_item, $this->cart );
		}

		$this->line_items = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_items, $this->cart );
	}

	/**
	 * Sets the shipping lines.
	 *
	 * @return void
	 */
	public function set_line_shipping() {
		// Loop each shipping package, the key is called shipping rates but it's actually the shipping packages.
		foreach ( $this->cart['shipping_rates'] ?? array() as $shipping_package ) {
			// Loop the shipping packages shipping rates. WooCommerce has this as a nested array with the same key.
			foreach ( $shipping_package['shipping_rates'] ?? array() as $shipping_rate ) {
				// Skip if the shipping rate is not selected.
				if ( ! $shipping_rate['selected'] ) {
					continue;
				}

				$shipping_line         = new StoreApiLineShipping( $shipping_rate, $this->config );
				$this->line_shipping[] = apply_filters( $this->get_filter_name( 'shipping_lines' ), $shipping_line, $shipping_rate, $shipping_package, $this->cart );
			}
		}

		$this->line_shipping = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_shipping, $this->cart );
	}

	/**
	 * Sets the coupon lines.
	 *
	 * @return void
	 */
	public function set_line_coupons() {
		// Loop any coupons.
		foreach ( $this->cart['coupons'] ?? array() as $coupon ) {
			$coupon_line = new StoreApiLineCoupon( $this->config );
			$coupon_line->set_coupon_data( $coupon );
			$this->line_coupons[] = apply_filters( $this->get_filter_name( 'coupon_lines' ), $coupon_line, $coupon, $this->cart );
		}

		$this->line_coupons = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_coupons, $this->cart );
	}

	/**
	 * Sets the fee lines.
	 *
	 * @return void
	 */
	public function set_line_fees() {
		foreach ( $this->cart['fees'] ?? array() as $fee ) {
			$fee_line          = new StoreApiLineFee( $fee, $this->config );
			$this->line_fees[] = apply_filters( $this->get_filter_name( 'fee_lines' ), $fee_line, $fee, $this->cart );
		}

		$this->line_fees = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_fees, $this->cart );
	}

	/**
	 * Sets the compatibility lines.
	 *
	 * @return void
	 */
	public function set_line_compatibility() {
		// TODO - Add support for compatibility.
	}

	/**
	 * Sets the customer data.
	 *
	 * @return void
	 */
	public function set_customer() {
		$this->customer = apply_filters( $this->get_filter_name( 'customer' ), new StoreApiCustomer( $this->cart, $this->config ), $this->cart );

	}

	/**
	 * Sets the total ex tax.
	 *
	 * @return void
	 */
	public function set_total() {
		$total       = $this->cart['totals']['total_price'] ?? 0;
		$this->total = apply_filters( $this->get_filter_name( 'total' ), $this->format_price_from_minor( $total ), $this->cart );
	}

	/**
	 * Sets the total tax.
	 *
	 * @return void
	 */
	public function set_total_tax() {
		$total_tax       = $this->cart['totals']['total_tax'] ?? 0;
		$this->total_tax = apply_filters( $this->get_filter_name( 'total_tax' ), $this->format_price_from_minor( $total_tax ), $this->cart );
	}

	/**
	 * Sets the subtotal ex tax.
	 *
	 * @return void
	 */
	public function set_subtotal() {
		$total_items    = $this->cart['totals']['total_items'] ?? 0;
		$total_shipping = $this->cart['totals']['total_shipping'] ?? 0;
		$subtotal       = $total_items + $total_shipping;
		$this->subtotal = apply_filters( $this->get_filter_name( 'subtotal' ), $this->format_price_from_minor( $subtotal ), $this->cart );
	}

	/**
	 * Sets the subtotal tax.
	 *
	 * @return void
	 */
	public function set_subtotal_tax() {
		$total_items_tax    = $this->cart['totals']['total_items_tax'] ?? 0;
		$total_shipping_tax = $this->cart['totals']['total_shipping_tax'] ?? 0;
		$subtotal_tax       = $total_items_tax + $total_shipping_tax;
		$this->subtotal_tax = apply_filters( $this->get_filter_name( 'subtotal_tax' ), $this->format_price_from_minor( $subtotal_tax ), $this->cart );
	}
}
