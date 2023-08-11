<?php
/**
 * Class to generate a cart line item from the WooCommerce cart shipping.
 */

namespace Krokedil\WooCommerce\StoreApi;

use Krokedil\WooCommerce\OrderLineData;

/**
 * Class to generate a cart line item from the WooCommerce cart shipping.
 *
 * Since shipping lines for carts are so different, we base it of the base OrderLineData class, instead of extending the CartLineItem class like the other cart line items.
 */
class StoreApiLineShipping extends OrderLineData {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'store_api_cart_line_shipping';

	/**
	 * The WooCommerce shipping rate from the store api.
	 *
	 * @var array $shipping_rate
	 */
	public $shipping_rate;

	/**
	 * Constructor.
	 *
	 * @param array $shipping_rate The WooCommerce shipping rate.
	 * @param array $config        Configuration array.
	 */
	public function __construct( $shipping_rate, $config = array() ) {
		parent::__construct( $config );

		$this->shipping_rate = $shipping_rate;

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
		$this->name = apply_filters( $this->get_filter_name( 'name' ), $this->shipping_rate['name'], $this->shipping_rate );
	}

	/**
	 * Abstract function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $this->shipping_rate['rate_id'], $this->shipping_rate );
	}

	/**
	 * Abstract function to set product quantity
	 * @return void
	 */
	public function set_quantity() {
		$this->quantity = apply_filters( $this->get_filter_name( 'quantity' ), 1, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product unit price
	 * @return void
	 */
	public function set_unit_price() {
		$this->unit_price = apply_filters( $this->get_filter_name( 'unit_price' ), $this->format_price_from_minor( $this->shipping_rate['price'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product subtotal unit price
	 * @return void
	 */
	public function set_subtotal_unit_price() {
		$this->subtotal_unit_price = apply_filters( $this->get_filter_name( 'subtotal_unit_price' ), $this->format_price_from_minor( $this->shipping_rate['price'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product tax rate
	 * @return void
	 */
	public function set_tax_rate() {
		$item_tax_rate = 0;

		$tax_total = $this->shipping_rate['taxes'];
		$total     = $this->shipping_rate['price'];

		// If the tax total or total is 0, we don't want to divide by 0.
		if ( ! empty( $tax_total ) ) {
			$item_tax_rate = ( $tax_total / $total ) * 10000;
		}

		$this->tax_rate = apply_filters( $this->get_filter_name( 'tax_rate' ), $item_tax_rate, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product total amount
	 * @return void
	 */
	public function set_total_amount() {
		$this->total_amount = apply_filters( $this->get_filter_name( 'total_amount' ), $this->format_price_from_minor( $this->shipping_rate['price'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product subtotal amount
	 * @return void
	 */
	public function set_subtotal_amount() {
		$this->subtotal_amount = apply_filters( $this->get_filter_name( 'subtotal_amount' ), $this->format_price_from_minor( $this->shipping_rate['price'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product total discount amount
	 * @return void
	 */
	public function set_total_discount_amount() {
		$this->total_discount_amount = apply_filters( $this->get_filter_name( 'discount_amount' ), 0, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product total discount tax amount
	 * @return void
	 */
	public function set_total_discount_tax_amount() {
		$this->total_discount_tax_amount = apply_filters( $this->get_filter_name( 'total_discount_tax_amount' ), 0, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product total tax amount
	 * @return void
	 */
	public function set_total_tax_amount() {
		$this->total_tax_amount = apply_filters( $this->get_filter_name( 'total_tax_amount' ), $this->format_price_from_minor( $this->shipping_rate['taxes'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product subtotal tax amount
	 * @return void
	 */
	public function set_subtotal_tax_amount() {
		$this->subtotal_tax_amount = apply_filters( $this->get_filter_name( 'subtotal_tax_amount' ), $this->format_price_from_minor( $this->shipping_rate['taxes'] ), $this->shipping_rate );
	}

	/**
	 * Abstract function to set product type
	 * @return void
	 */
	public function set_type() {
		$this->type = apply_filters( $this->get_filter_name( 'type' ), 'shipping', $this->shipping_rate );
	}

	/**
	 * Abstract function to set product url
	 * @return void
	 */
	public function set_product_url() {
		$this->product_url = apply_filters( $this->get_filter_name( 'product_url' ), null, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product image url
	 * @return void
	 */
	public function set_image_url() {
		$this->image_url = apply_filters( $this->get_filter_name( 'image_url' ), null, $this->shipping_rate );
	}

	/**
	 * Abstract function to set product compatability
	 * @return void
	 */
	public function set_compatability() {
		$this->compatability = apply_filters( $this->get_filter_name( 'compatability' ), array(), $this->shipping_rate );
	}
}
