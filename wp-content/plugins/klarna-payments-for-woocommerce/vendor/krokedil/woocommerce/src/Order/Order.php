<?php
/**
 * Class to generate a cart object from a WooCommerce order.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce\Order;

use Krokedil\WooCommerce\OrderData;

/**
 * Class to generate a cart object from a WooCommerce order.
 */
class Order extends OrderData {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'order';

	/**
	 * The WooCommerce order.
	 *
	 * @var \WC_Order|\WC_Order_Refund $order
	 */
	public $order;

	/**
	 * Constructor.
	 *
	 * @param \WC_Order|\WC_Order_Refund $order The WooCommerce order.
	 * @param array    $config Configuration array.
	 */
	public function __construct( $order, $config = array() ) {
		parent::__construct( $config );

		$this->order = $order;

		$this->set_line_items();
		$this->set_line_shipping();
		$this->set_line_fees();
		$this->set_line_coupons();
		$this->set_line_compatibility();
		$this->set_total();
		$this->set_total_tax();
		$this->set_subtotal();
		$this->set_subtotal_tax();

		if ( $order instanceof \WC_Order ) {
			$this->set_customer();
		}
	}
	/**
	 * Sets the line items.
	 * @return void
	 */
	public function set_line_items() {
		foreach ( $this->order->get_items() as $order_item ) {
			$order_item         = new OrderLineItem( $order_item, $this->config );
			$this->line_items[] = apply_filters( $this->get_filter_name( 'line_items' ), $order_item, $this->order );
		}

		$this->line_items = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_items, $this->order );
	}

	/**
	 * Sets the shipping lines.
	 * @return void
	 */
	public function set_line_shipping() {
		foreach ( $this->order->get_items( 'shipping' ) as $shipping_item ) {
			$shipping_method       = new OrderLineShipping( $shipping_item, $this->config );
			$this->line_shipping[] = apply_filters( $this->get_filter_name( 'line_shipping' ), $shipping_method, $this->order );
		}

		$this->line_shipping = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_shipping, $this->order );
	}

	/**
	 * Sets the coupon lines.
	 *
	 * @return void
	 */
	public function set_line_coupons() {
		// Smart coupons.
		foreach ( $this->order->get_items( 'coupon' ) as $coupon ) {
			$discount_type = $coupon->get_meta( 'coupon_data' )['discount_type'];

			if ( 'smart_coupon' === $discount_type || 'store_credit' === $discount_type ) {
				$coupon_line = new OrderLineCoupon( $this->config );
				$coupon_line->set_smart_coupon_data( $coupon );
				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $coupon );
				continue;
			}

			$coupon_line = new OrderLineCoupon( $this->config );
			$coupon_line->set_coupon_data( $coupon );
			$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $coupon );
		}

		// WC Giftcards.
		if ( class_exists( 'WC_GC_Gift_Cards' ) ) {
			foreach ( $this->order->get_items( 'gift_card' ) as $wc_gc_gift_card_data ) {
				$coupon_line = new OrderLineCoupon( $this->config );
				$coupon_line->set_wc_gc_data( $wc_gc_gift_card_data );

				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $wc_gc_gift_card_data );
			}
		}

		// YITY Giftcards.
		if ( class_exists( 'YITH_YWGC_Gift_Card' ) ) {
			$yith_meta = $this->order->get_meta( '_ywgc_applied_gift_cards', true );
			if ( ! empty( $yith_meta ) ) {
				foreach ( $yith_meta as $gift_card_code => $gift_card_amount ) {
					$coupon_line = new OrderLineCoupon( $this->config );
					$coupon_line->set_yith_wc_gc_data( $gift_card_code, $gift_card_amount );

					$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $gift_card_code );
				}
			}
		}

		// PW Giftcards
		if ( isset( WC()->session ) && ! empty( WC()->session->get( 'pw-gift-card-data' ) ) ) {
			$pw_gift_card_data = WC()->session->get( 'pw-gift-card-data' );
			foreach ( $pw_gift_card_data['gift_cards'] as $code => $value ) {
				$coupon_line = new OrderLineCoupon( $this->config );
				$coupon_line->set_pw_giftcards_data( $code, $value );

				$this->line_coupons[] = apply_filters( $this->get_filter_name( 'line_coupons' ), $coupon_line, $code, $value );
			}
		}

		$this->line_coupons = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_coupons, $this->order );
	}

	/**
	 * Sets the fee lines.
	 * @return void
	 */
	public function set_line_fees() {
		foreach ( $this->order->get_items( 'fee' ) as $fee_item ) {
			$fee_item          = new OrderLineFee( $fee_item, $this->config );
			$this->line_fees[] = apply_filters( $this->get_filter_name( 'line_fees' ), $fee_item, $this->order );
		}

		$this->line_fees = apply_filters( $this->get_filter_name( __FUNCTION__ ), $this->line_fees, $this->order );
	}

	/**
	 * Sets the compatibility lines.
	 * @return void
	 */
	public function set_line_compatibility() {
		// TODO - Compatibility
	}

	/**
	 * Sets the customer data.
	 * @return void
	 */
	public function set_customer() {
		$this->customer = apply_filters( $this->get_filter_name( 'customer' ), new OrderCustomer( $this->order, $this->config ), $this->order );
	}

	/**
	 * Sets the total ex tax.
	 * @return void
	 */
	public function set_total() {
		$this->total = apply_filters( $this->get_filter_name( 'total' ), $this->format_price( $this->order->get_total() ), $this->order );
	}

	/**
	 * Sets the total tax.
	 * @return void
	 */
	public function set_total_tax() {
		$this->total_tax = apply_filters( $this->get_filter_name( 'total_tax' ), $this->format_price( $this->order->get_total_tax() ), $this->order );
	}

	/**
	 * Sets the subtotal ex tax.
	 * @return void
	 */
	public function set_subtotal() {
		$this->subtotal = apply_filters( $this->get_filter_name( 'subtotal' ), $this->format_price( $this->order->get_subtotal() ), $this->order );
	}

	/**
	 * Sets the subtotal tax.
	 * @return void
	 */
	public function set_subtotal_tax() {
		// TODO - Subtotal tax
		//$this->subtotal_tax = $this->format_price( $this->order->get_subtotal_tax() );
	}
}
