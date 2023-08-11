<?php
/**
 * Class to generate a order line item from the WooCommerce order item product.
 */

namespace Krokedil\WooCommerce\Order;

/**
 * Class to generate a order line item from the WooCommerce order item product.
 */
class OrderLineItem extends OrderLine {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'order_line_item';

	/**
	 * Product.
	 *
	 * @var \WC_Product $product
	 */
	public $product;

	/**
	 * Constructor.
	 *
	 * @param \WC_Order_Item_Product $order_line_item The order line item.
	 * @param array $config Configuration array.
	 */
	public function __construct( $order_line_item, $config = array() ) {
		$this->product = $order_line_item->get_product();

		parent::__construct( $order_line_item, $config );
	}

	/**
	 * Abstract function to set product subtotal unit price. Unit price before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_unit_price() {
		$this->subtotal_unit_price = apply_filters( $this->get_filter_name( 'subtotal_unit_price' ), $this->format_price( $this->order_line_item->get_subtotal() / $this->order_line_item->get_quantity() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$product = $this->order_line_item->get_product();

		$item_reference = $this->order_line_item->get_id();
		if ( $product ) {
			if ( $product->get_sku() ) {
				$item_reference = $product->get_sku();
			} else {
				$item_reference = $product->get_id();
			}
		}


		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $item_reference, $this->order_line_item );
	}

	/**
	 * Abstract function to set product total discount amount
	 * @return void
	 */
	public function set_total_discount_amount() {
		$this->total_discount_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), $this->format_price( $this->order_line_item->get_subtotal() - $this->order_line_item->get_total() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product total discount tax amount
	 * @return void
	 */
	public function set_total_discount_tax_amount() {
		$this->total_discount_tax_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), $this->format_price( $this->order_line_item->get_subtotal_tax() - $this->order_line_item->get_total_tax() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product subtotal amount. Total amount before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_amount() {
		$this->subtotal_amount = apply_filters( $this->get_filter_name( 'subtotal_amount' ), $this->format_price( $this->order_line_item->get_subtotal() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product subtotal tax amount. Total tax amount before any discounts are applied.
	 *
	 * @return void
	 */
	public function set_subtotal_tax_amount() {
		$this->subtotal_tax_amount = apply_filters( $this->get_filter_name( 'subtotal_tax_amount' ), $this->format_price( $this->order_line_item->get_subtotal_tax() ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product type
	 * @return void
	 */
	public function set_type() {
		$this->type = apply_filters( $this->get_filter_name( 'type' ), $this->product->get_type(), $this->order_line_item );
	}

	/**
	 * Abstract function to set product url
	 * @return void
	 */
	public function set_product_url() {
		$this->product_url = apply_filters( $this->get_filter_name( 'product_url' ), $this->product->get_permalink(), $this->order_line_item );
	}

	/**
	 * Abstract function to set product image url
	 * @return void
	 */
	public function set_image_url() {
		$image_url = null;
		if ( $this->product ) {
			$image_url = wp_get_attachment_image_url( $this->product->get_image_id(), 'woocommerce_thumbnail' );
		}

		$this->image_url = apply_filters( $this->get_filter_name( 'image_url' ), $image_url ? $image_url : null, $this->order_line_item );
	}
}
