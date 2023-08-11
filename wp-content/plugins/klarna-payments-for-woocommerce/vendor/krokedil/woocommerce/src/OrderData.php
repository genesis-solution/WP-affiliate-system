<?php
/**
 * Order data base class.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce;

use Krokedil\WooCommerce\Base;

/**
 * Order data base class.
 */
abstract class OrderData extends Base {
	/**
	 * Item lines
	 *
	 * @var array<OrderLineData>
	 */
	public $line_items = array();

	/**
	 * Shipping lines
	 *
	 * @var array<OrderLineData>
	 */
	public $line_shipping = array();

	/**
	 * Coupon lines
	 *
	 * @var array<OrderLineData>
	 */
	public $line_coupons = array();

	/**
	 * Fee lines
	 *
	 * @var array<OrderLineData>
	 */
	public $line_fees = array();

	/**
	 * Compatibility lines
	 *
	 * @var array<OrderLineData>
	 */
	public $line_compatibility = array();

	/**
	 * Customer data
	 *
	 * @var CustomerData
	 */
	public $customer;

	/**
	 * Cart total ex tax.
	 *
	 * @var int|float
	 */
	public $total;

	/**
	 * Cart total tax.
	 *
	 * @var int|float
	 */
	public $total_tax;

	/**
	 * Cart subtotal ex tax.
	 *
	 * @var int|float
	 */
	public $subtotal;

	/**
	 * Cart subtotal tax.
	 *
	 * @var int|float
	 */
	public $subtotal_tax;

	/**
	 * Returns the line items.
	 *
	 * @return array<OrderLineData>
	 */
	public function get_line_items() {
		return $this->line_items;
	}

	/**
	 * Sets the line items.
	 *
	 * @return void
	 */
	abstract public function set_line_items();

	/**
	 * Returns the shipping lines.
	 *
	 * @return array<OrderLineData>
	 */
	public function get_line_shipping() {
		return $this->line_shipping;
	}

	/**
	 * Sets the shipping lines.
	 *
	 * @return void
	 */
	abstract public function set_line_shipping();

	/**
	 * Returns the coupon lines.
	 *
	 * @return array<OrderLineData>
	 */
	public function get_line_coupons() {
		return $this->line_coupons;
	}

	/**
	 * Sets the coupon lines.
	 *
	 * @return void
	 */
	abstract public function set_line_coupons();

	/**
	 * Returns the fee lines.
	 *
	 * @return array<OrderLineData>
	 */
	public function get_line_fees() {
		return $this->line_fees;
	}

	/**
	 * Sets the fee lines.
	 *
	 * @return void
	 */
	abstract public function set_line_fees();

	/**
	 * Returns the compatibility lines.
	 *
	 * @return array<OrderLineData>
	 */
	public function get_line_compatibility() {
		return $this->line_compatibility;
	}

	/**
	 * Sets the compatibility lines.
	 *
	 * @return void
	 */
	abstract public function set_line_compatibility();

	/**
	 * Returns the customer data.
	 *
	 * @return CustomerData
	 */
	public function get_customer() {
		return $this->customer;
	}

	/**
	 * Sets the customer data.
	 *
	 * @return void
	 */
	abstract public function set_customer();

	/**
	 * Returns the total ex tax.
	 *
	 * @return int|float
	 */
	public function get_total() {
		return $this->total;
	}

	/**
	 * Sets the total ex tax.
	 *
	 * @return void
	 */
	abstract public function set_total();

	/**
	 * Returns the total tax.
	 *
	 * @return int|float
	 */
	public function get_total_tax() {
		return $this->total_tax;
	}

	/**
	 * Sets the total tax.
	 *
	 * @return void
	 */
	abstract public function set_total_tax();

	/**
	 * Returns the subtotal ex tax.
	 *
	 * @return int|float
	 */
	public function get_subtotal() {
		return $this->subtotal;
	}

	/**
	 * Sets the subtotal ex tax.
	 *
	 * @return void
	 */
	abstract public function set_subtotal();

	/**
	 * Returns the subtotal tax.
	 *
	 * @return int|float
	 */
	public function get_subtotal_tax() {
		return $this->subtotal_tax;
	}

	/**
	 * Sets the subtotal tax.
	 *
	 * @return void
	 */
	abstract public function set_subtotal_tax();
}
