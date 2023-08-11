<?php
/**
 * Class to generate a order line item from the WooCommerce order item fee.
 */

namespace Krokedil\WooCommerce\Order;

/**
 * Class to generate a order line item from the WooCommerce order item fee.
 */
class OrderLineFee extends OrderLine {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'order_line_fee';

    /**
     * Constructor.
     *
     * @param \WC_Order_Item_Fee $order_line_item The order line item.
     * @param array $config Configuration array.
     */
	public function __construct( $order_line_item, $config = array() ) {
		parent::__construct( $order_line_item, $config );
	}

	/**
	 * Abstract function to set product sku
	 * @return void
	 */
	public function set_sku() {
		$this->sku = apply_filters( $this->get_filter_name( 'sku' ), $this->order_line_item->get_name(), $this->order_line_item );
	}

	/**
	 * Abstract function to set product total discount amount
	 * @return void
	 */
	public function set_total_discount_amount() {
        $this->total_discount_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), $this->format_price( 0 ), $this->order_line_item );
	}

	/**
     * Abstract function to set product total discount tax amount
     * @return void
     */
    public function set_total_discount_tax_amount() {
		$this->total_discount_tax_amount = apply_filters( $this->get_filter_name( 'total_discount_amount' ), $this->format_price( 0 ), $this->order_line_item );
	}

	/**
	 * Abstract function to set product type
	 * @return void
	 */
	public function set_type() {
		$this->type = apply_filters( $this->get_filter_name( 'type' ), 'fee', $this->order_line_item );
	}
}
