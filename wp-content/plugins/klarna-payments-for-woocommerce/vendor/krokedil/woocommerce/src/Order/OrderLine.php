<?php
/**
 * Class to generate a order line item from the WooCommerce order item.
 */

namespace Krokedil\WooCommerce\Order;

use Krokedil\WooCommerce\OrderLineData;

/**
 * Class to generate a order line item from the WooCommerce order item. The abstract class contains the methods that all different line item types have in common.
 */
abstract class OrderLine extends OrderLineData {
	/**
	 * Order line item.
	 *
	 * @var \WC_Order_Item $order_line_item
	 */
	public $order_line_item;

	/**
	 * Constructor.
	 *
	 * @param \WC_Order_Item $order_line_item The order line item.
	 * @param array $config Configuration array.
	 */
	public function __construct( $order_line_item, $config = array() ) {
		parent::__construct( $config );

		$this->order_line_item = $order_line_item;

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
	 * Abstract function to set product name
	 * @return void
	 */
	public function set_name() {
		$this->name = apply_filters( $this->get_filter_name( 'name' ), $this->order_line_item->get_name(), $this->order_line_item );
	}

	/**
	 * Abstract function to set product quantity
	 * @return void
	 */
	public function set_quantity() {
		$this->quantity = apply_filters( $this->get_filter_name( 'quantity' ), $this->order_line_item->get_quantity(), $this->order_line_item );
	}

	/**
	 * Abstract function to set product unit price
	 * @return void
	 */
	public function set_unit_price() {
		$this->unit_price = apply_filters( $this->get_filter_name( 'unit_price' ), $this->format_price( $this->order_line_item->get_total() / $this->order_line_item->get_quantity() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product subtotal unit price. Unit price before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_unit_price() {
		$this->subtotal_unit_price = apply_filters( $this->get_filter_name( 'subtotal_unit_price' ), $this->format_price( $this->order_line_item->get_total() / $this->order_line_item->get_quantity() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product tax rate
	 * @return void
	 */
	public function set_tax_rate() {
		$tax_rate = 0;
		$taxes    = $this->order_line_item->get_taxes();
		if ( ! empty( $taxes['total'] ) ) {
			foreach ( $taxes['total'] as $tax_id => $tax_amount ) {
				if ( ! empty( $tax_amount ) ) {
					$tax_rate = \WC_Tax::get_rate_percent_value( $tax_id ) * 100;
					break;
				}
			}
		}

		$this->tax_rate = apply_filters( $this->get_filter_name( 'tax_rate' ), $tax_rate, $this->order_line_item );
	}

	/**
	 * Abstract function to set product total amount
	 * @return void
	 */
	public function set_total_amount() {
		$this->total_amount = apply_filters( $this->get_filter_name( 'total_amount' ), $this->format_price( $this->order_line_item->get_total() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product subtotal amount. Total amount before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_amount() {
		$this->subtotal_amount = apply_filters( $this->get_filter_name( 'subtotal_amount' ), $this->format_price( $this->order_line_item->get_total() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product total tax amount
	 * @return void
	 */
	public function set_total_tax_amount() {
		$this->total_tax_amount = apply_filters( $this->get_filter_name( 'total_tax_amount' ), $this->format_price( $this->order_line_item->get_total_tax() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product subtotal tax amount. Total tax amount before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_tax_amount() {
		$this->subtotal_tax_amount = apply_filters( $this->get_filter_name( 'subtotal_tax_amount' ), $this->format_price( $this->order_line_item->get_total_tax() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product url
	 * @return void
	 */
	public function set_product_url() {
		$this->product_url = apply_filters( $this->get_filter_name( 'product_url' ), null, $this->order_line_item );
	}

	/**
	 * Abstract function to set product image url
	 * @return void
	 */
	public function set_image_url() {
		$this->image_url = apply_filters( $this->get_filter_name( 'image_url' ), null, $this->order_line_item );
	}

	/**
	 * Abstract function to set product compatability
	 * @return void
	 */
	public function set_compatability() {
		$this->compatability = apply_filters( $this->get_filter_name( 'compatability' ), array(), $this->order_line_item );
	}
}
