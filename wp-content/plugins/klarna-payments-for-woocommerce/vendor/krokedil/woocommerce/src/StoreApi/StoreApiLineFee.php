<?php
/**
 * Class to generate a cart line item from the WooCommerce StoreApi cart fee.
 */

namespace Krokedil\WooCommerce\StoreApi;

use Krokedil\WooCommerce\OrderLineData;

/**
 * Class to generate a cart line item from the WooCommerce StoreApi cart fee.
 */
class StoreApiLineFee extends OrderLineData {

	/**
	 * The WooCommerce cart item from the store api.
	 *
	 * @var array $cart_fee
	 */
	public $cart_fee;

	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'store_api_cart_line_fee';

	/**
	 * Constructor.
	 *
	 * @param array $cart_fee The WooCommerce cart fee from the store api.
	 * @param array $config Configuration array.
	 */
	public function __construct( $cart_fee, $config = array() ) {
		parent::__construct( $config );

		$this->cart_fee = $cart_fee;

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
		$this->name = apply_filters( $this->get_filter_name( 'name' ), $this->cart_fee['name'], $this->cart_fee );
	}

	/**
	 * Function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$item_reference = $this->cart_fee['key'];

		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $item_reference, $this->cart_fee );
	}

	/**
	 * Function to set product quantity
	 * @return void
	 */
	public function set_quantity() {
		$this->quantity = apply_filters( $this->get_filter_name( 'quantity' ), 1, $this->cart_fee );
	}

	/**
	 * Function to set product unit price
	 * @return void
	 */
	public function set_unit_price() {
		$unit_price = $this->cart_fee['totals']['total'];

		$this->unit_price = apply_filters( $this->get_filter_name( 'unit_price' ), $this->format_price_from_minor( $unit_price ), $this->cart_fee );
	}

	/**
	 * Function to set product subtotal unit price
	 * @return void
	 */
	public function set_subtotal_unit_price() {
		$subtotal_unit_price = $this->cart_fee['totals']['total'];

		$this->subtotal_unit_price = apply_filters( $this->get_filter_name( 'subtotal_unit_price' ), $this->format_price_from_minor( $subtotal_unit_price ), $this->cart_fee );
	}

	/**
	 * Function to set product tax rate
	 * @return void
	 */
	public function set_tax_rate() {
		$tax_rate = 0;

		$total     = $this->cart_fee['totals']['total'];
		$tax_total = $this->cart_fee['totals']['total_tax'];

		// Calculate the tax rate if the tax total is not 0.
		if ( 0 !== $tax_total ) {
			$tax_rate = round( ( $tax_total / $total ) * 10000 );
		}

		$this->tax_rate = apply_filters( $this->get_filter_name( 'tax_rate' ), $tax_rate, $this->cart_fee );
	}

	/**
	 * Function to set product total amount
	 * @return void
	 */
	public function set_total_amount() {
		$total_amount = $this->cart_fee['totals']['total'];

		$this->total_amount = apply_filters( $this->get_filter_name( 'total_amount' ), $this->format_price_from_minor( $total_amount ), $this->cart_fee );
	}

	/**
	 * Function to set product subtotal amount
	 * @return void
	 */
	public function set_subtotal_amount() {
		$subtotal_amount = $this->cart_fee['totals']['total'];

		$this->subtotal_amount = apply_filters( $this->get_filter_name( 'subtotal_amount' ), $this->format_price_from_minor( $subtotal_amount ), $this->cart_fee );
	}

	/**
	 * Function to set product total discount amount
	 * @return void
	 */
	public function set_total_discount_amount() {
		$total_discount_amount = 0;

		$this->total_discount_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), $this->format_price_from_minor( $total_discount_amount ), $this->cart_fee );
	}

	/**
	 * Abstract function to set product total discount tax amount
	 * @return void
	 */
	public function set_total_discount_tax_amount() {
		$total_discount_tax_amount = 0;

		$this->total_discount_tax_amount = apply_filters( $this->get_filter_name( 'total_discount_tax_amount' ), $this->format_price_from_minor( $total_discount_tax_amount ), $this->cart_fee );
	}

	/**
	 * Function to set product total tax amount
	 * @return void
	 */
	public function set_total_tax_amount() {
		$total_tax_amount       = $this->cart_fee['totals']['total_tax'];
		$this->total_tax_amount = apply_filters( $this->get_filter_name( 'total_tax_amount' ), $this->format_price_from_minor( $total_tax_amount ), $this->cart_fee );
	}

	/**
	 * Function to set product subtotal tax amount
	 * @return void
	 */
	public function set_subtotal_tax_amount() {
		$subtotal_tax_amount       = $this->cart_fee['totals']['total_tax'];
		$this->subtotal_tax_amount = apply_filters( $this->get_filter_name( 'subtotal_tax_amount' ), $this->format_price_from_minor( $subtotal_tax_amount ), $this->cart_fee );
	}

	/**
	 * Function to set product type
	 * @return void
	 */
	public function set_type() {
		$this->type = apply_filters( $this->get_filter_name( 'type' ), 'fee', $this->cart_fee );
	}

	/**
	 * Function to set product url
	 * @return void
	 */
	public function set_product_url() {
		$product_url = null;

		$this->product_url = apply_filters( $this->get_filter_name( 'product_url' ), $product_url ? $product_url : null, $this->cart_fee );
	}

	/**
	 * Function to set product image url
	 * @return void
	 */
	public function set_image_url() {
		$image_url = null;

		$this->image_url = apply_filters( $this->get_filter_name( 'image_url' ), $image_url ? $image_url : null, $this->cart_fee );
	}

	/**
	 * Function to set product compatability
	 * @return void
	 */
	public function set_compatability() {
		$this->compatability = apply_filters( $this->get_filter_name( 'compatability' ), array(), $this->cart_fee );
	}
}
