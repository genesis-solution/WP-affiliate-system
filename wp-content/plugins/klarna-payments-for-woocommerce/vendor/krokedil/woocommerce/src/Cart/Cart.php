<?php
/**
 * Class to generate a cart object from the WooCommerce cart.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce\Cart;

use Krokedil\WooCommerce\OrderData;

/**
 * Class to generate a cart object from the WooCommerce cart.
 */
class Cart extends OrderData {
	/**
	 * The WooCommerce cart.
	 *
	 * @var \WC_Cart $cart
	 */
	public $cart;

	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'cart';

	/**
	 * Constructor.
	 *
	 * @param \WC_Cart $cart The WooCommerce cart.
	 * @param array    $config Configuration array.
	 */
	public function __construct( $cart, $config = array() ) {
		parent::__construct( $config );

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
		foreach ( $this->cart->get_cart() as $cart_item ) {
			$cart_item          = new CartLineItem( $cart_item, $this->config );
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
		if ( $this->cart->needs_shipping() && $this->cart->show_shipping() ) {
			$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

			if ( empty( $chosen_shipping_methods ) ) {
				return;
			}

			$shipping_ids   = array_unique( $chosen_shipping_methods );
			// Only use the first package in the cart.
			$packages = WC()->shipping->get_packages() ?? array();
			$package  = reset( $packages );

			// Get the shipping rates for the package.
			$shipping_rates = $package['rates'] ?? array();
			foreach ( $shipping_ids as $shipping_id ) {
				if ( $shipping_rates[ $shipping_id ] ?? false ) {
					$shipping_rate         = $shipping_rates[ $shipping_id ];
					$shipping_line         = new CartLineShipping( $shipping_rate, $this->config );
					$this->line_shipping[] = apply_filters( $this->get_filter_name( 'line_shipping' ), $shipping_line, $this->cart );
				}
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
		// Smart coupons.
		foreach ( WC()->cart->get_coupons() as $coupon_key => $coupon ) {
			if ( 'smart_coupon' === $coupon->get_discount_type() || 'store_credit' === $coupon->get_discount_type() ) {
				$coupon_line = new CartLineCoupon( $this->config );
				$coupon_line->set_smart_coupon_data( $coupon_key );

				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $coupon_key );
				continue;
			}

			// Handle normal WooCommerce coupons.
			$coupon_line = new CartLineCoupon( $this->config );
			$coupon_line->set_coupon_data( $coupon_key, $coupon );
			$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $coupon_key );
		}

		// WC Giftcards.
		if ( class_exists( 'WC_GC_Gift_Cards' ) ) {
			foreach ( WC_GC()->cart->get_applied_gift_cards()['giftcards'] as $wc_gc_gift_card_data ) {
				$coupon_line = new CartLineCoupon( $this->config );
				$coupon_line->set_wc_gc_data( $wc_gc_gift_card_data );

				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $wc_gc_gift_card_data );
			}
		}

		// YITY Giftcards.
		if ( class_exists( 'YITH_YWGC_Gift_Card' ) ) {
			if ( isset( WC()->cart->applied_gift_cards ) ) {
				foreach ( WC()->cart->applied_gift_cards as $gift_card_code ) {
					$coupon_line = new CartLineCoupon( $this->config );
					$coupon_line->set_yith_wc_gc_data( $gift_card_code );

					$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $gift_card_code );
				}
			}
		}

		// PW Giftcards
		if ( isset( WC()->session ) && ! empty( WC()->session->get( 'pw-gift-card-data' ) ) ) {
			$pw_gift_card_data = WC()->session->get( 'pw-gift-card-data' );
			foreach ( $pw_gift_card_data['gift_cards'] as $code => $value ) {
				$coupon_line = new CartLineCoupon( $this->config );
				$coupon_line->set_pw_giftcards_data( $code, $value );

				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $code, $value );
			}
		}

		$this->line_coupons = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_coupons, $this->cart );
	}

	/**
	 * Sets the fee lines.
	 *
	 * @return void
	 */
	public function set_line_fees() {
		foreach ( $this->cart->get_fees() as $cart_fee ) {
			$fee_line          = new CartLineFee( $cart_fee, $this->config );
			$this->line_fees[] = apply_filters( $this->get_filter_name( 'line_fees' ), $fee_line, $this->cart );
		}

		$this->line_fees = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_fees, $this->cart );
	}

	/**
	 * Sets the compatibility lines.
	 *
	 * @return void
	 */
	public function set_line_compatibility() {
		// TODO - Add compatibility lines handling.
	}

	/**
	 * Sets the customer data.
	 *
	 * @return void
	 */
	public function set_customer() {
		$this->customer = apply_filters( $this->get_filter_name( 'customer' ), new CartCustomer( $this->config ), $this->cart );
	}

	/**
	 * Sets the total ex tax.
	 *
	 * @return void
	 */
	public function set_total() {
		$this->total = apply_filters( $this->get_filter_name( 'total' ), $this->format_price( $this->cart->get_total( 'calc' ) ), $this->cart );
	}

	/**
	 * Sets the total tax.
	 *
	 * @return void
	 */
	public function set_total_tax() {
		$this->total_tax = apply_filters( $this->get_filter_name( 'tax' ), $this->format_price( $this->cart->get_total_tax() ), $this->cart );
	}

	/**
	 * Sets the subtotal ex tax.
	 *
	 * @return void
	 */
	public function set_subtotal() {
		$this->subtotal = apply_filters( $this->get_filter_name( 'subtotal' ), $this->format_price( $this->cart->get_subtotal() ), $this->cart );
	}

	/**
	 * Sets the subtotal tax.
	 *
	 * @return void
	 */
	public function set_subtotal_tax() {
		$this->subtotal_tax = apply_filters( $this->get_filter_name( 'tax' ), $this->format_price( $this->cart->get_subtotal_tax() ), $this->cart );
	}
}
