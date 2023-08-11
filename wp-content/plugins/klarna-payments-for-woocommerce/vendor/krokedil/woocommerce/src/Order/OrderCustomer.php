<?php
/**
 * Gets the customer data from a WooCommerce order.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce\Order;

use Krokedil\WooCommerce\CustomerData;

/**
 * Gets the customer data from a WooCommerce order.
 */
class OrderCustomer extends CustomerData {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'order';

    /**
     * The WooCommerce order.
     *
     * @var \WC_Order $order
     */
    public $order;

	/**
	 * Constructor.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 * @param array $config Configuration array.
	 */
	public function __construct( $order, $config = array() ) {
        $this->order = $order;

		parent::__construct( $config );

		$this->set_billing_first_name();
		$this->set_billing_last_name();
		$this->set_billing_company();
		$this->set_billing_address_1();
		$this->set_billing_address_2();
		$this->set_billing_city();
		$this->set_billing_state();
		$this->set_billing_postcode();
		$this->set_billing_country();
		$this->set_billing_email();
		$this->set_billing_phone();

		$this->set_shipping_first_name();
		$this->set_shipping_last_name();
		$this->set_shipping_company();
		$this->set_shipping_address_1();
		$this->set_shipping_address_2();
		$this->set_shipping_city();
		$this->set_shipping_state();
		$this->set_shipping_postcode();
		$this->set_shipping_country();
		$this->set_shipping_email();
		$this->set_shipping_phone();
	}

	/**
	 * Set billing first name
	 * @return void
	 */
	public function set_billing_first_name() {
        $this->billing_first_name = apply_filters( $this->get_filter_name( 'billing_first_name' ), $this->order->get_billing_first_name(), $this->order );
	}

	/**
	 * Set billing last name
	 * @return void
	 */
	public function set_billing_last_name() {
        $this->billing_last_name = apply_filters( $this->get_filter_name( 'billing_last_name' ),  $this->order->get_billing_last_name(),  $this->order );
	}

	/**
	 * Set billing company
	 * @return void
	 */
	public function set_billing_company() {
        $this->billing_company = apply_filters( $this->get_filter_name( 'billing_company' ),  $this->order->get_billing_company(),  $this->order );
	}

	/**
	 * Set billing address 1
	 * @return void
	 */
	public function set_billing_address_1() {
        $this->billing_address_1 = apply_filters( $this->get_filter_name( 'billing_address_1' ),  $this->order->get_billing_address_1(),  $this->order );
	}

	/**
	 * Set billing address 2
	 * @return void
	 */
	public function set_billing_address_2() {
        $this->billing_address_2 = apply_filters( $this->get_filter_name( 'billing_address_2' ),  $this->order->get_billing_address_2(),  $this->order );
	}

	/**
	 * Set billing city
	 * @return void
	 */
	public function set_billing_city() {
        $this->billing_city = apply_filters( $this->get_filter_name( 'billing_city' ),  $this->order->get_billing_city(),  $this->order );
	}

	/**
	 * Set billing state
	 * @return void
	 */
	public function set_billing_state() {
        $this->billing_state = apply_filters( $this->get_filter_name( 'billing_state' ),  $this->order->get_billing_state(),  $this->order );
	}

	/**
	 * Set billing postcode
	 * @return void
	 */
	public function set_billing_postcode() {
        $this->billing_postcode = apply_filters( $this->get_filter_name( 'billing_postcode' ),  $this->order->get_billing_postcode(),  $this->order );
	}

	/**
	 * Set billing country
	 * @return void
	 */
	public function set_billing_country() {
        $this->billing_country = apply_filters( $this->get_filter_name( 'billing_country' ),  $this->order->get_billing_country(),  $this->order );
	}

    /**
	 * Set shipping phone
	 * @return void
	 */
	public function set_billing_phone() {
        $this->billing_phone = apply_filters( $this->get_filter_name( 'billing_phone' ),  $this->order->get_billing_phone(),  $this->order );
	}

	/**
	 * Set shipping email
	 * @return void
	 */
	public function set_billing_email() {
        $this->billing_email = apply_filters( $this->get_filter_name( 'billing_email' ),  $this->order->get_billing_email(),  $this->order );
	}

	/**
	 * Set shipping first name
	 * @return void
	 */
	public function set_shipping_first_name() {
        $this->shipping_first_name = apply_filters( $this->get_filter_name( 'shipping_first_name' ),  $this->order->get_shipping_first_name(),  $this->order );
	}

	/**
	 * Set shipping last name
	 * @return void
	 */
	public function set_shipping_last_name() {
        $this->shipping_last_name = apply_filters( $this->get_filter_name( 'shipping_last_name' ),  $this->order->get_shipping_last_name(),  $this->order );
	}

	/**
	 * Set shipping company
	 * @return void
	 */
	public function set_shipping_company() {
        $this->shipping_company = apply_filters( $this->get_filter_name( 'shipping_company' ),  $this->order->get_shipping_company(),  $this->order );
	}

	/**
	 * Set shipping address 1
	 * @return void
	 */
	public function set_shipping_address_1() {
        $this->shipping_address_1 = apply_filters( $this->get_filter_name( 'shipping_address_1' ),  $this->order->get_shipping_address_1(),  $this->order );
	}

	/**
	 * Set shipping address 2
	 * @return void
	 */
	public function set_shipping_address_2() {
        $this->shipping_address_2 = apply_filters( $this->get_filter_name( 'shipping_address_2' ),  $this->order->get_shipping_address_2(),  $this->order );
	}

	/**
	 * Set shipping city
	 * @return void
	 */
	public function set_shipping_city() {
        $this->shipping_city = apply_filters( $this->get_filter_name( 'shipping_city' ),  $this->order->get_shipping_city(),  $this->order );
	}

	/**
	 * Set shipping state
	 * @return void
	 */
	public function set_shipping_state() {
        $this->shipping_state = apply_filters( $this->get_filter_name( 'shipping_state' ),  $this->order->get_shipping_state(),  $this->order );
	}

	/**
	 * Set shipping postcode
	 * @return void
	 */
	public function set_shipping_postcode() {
        $this->shipping_postcode = apply_filters( $this->get_filter_name( 'shipping_postcode' ),  $this->order->get_shipping_postcode(),  $this->order );
	}

	/**
	 * Set shipping country
	 * @return void
	 */
	public function set_shipping_country() {
        $this->shipping_country = apply_filters( $this->get_filter_name( 'shipping_country' ),  $this->order->get_shipping_country(),  $this->order );
	}

	/**
	 * Set shipping phone
	 * @return void
	 */
	public function set_shipping_phone() {
        $this->shipping_phone = apply_filters( $this->get_filter_name( 'shipping_phone' ),  $this->order->get_shipping_phone(),  $this->order );
	}

	/**
	 * Set shipping email
	 * @return void
	 */
	public function set_shipping_email() {
        // TODO - Get shipping email if it exists.
        //$this->shipping_email = apply_filters( $this->get_filter_name( '' ),  $this->order->get_shipping_email(),  $this->order );
		$this->shipping_email = apply_filters( $this->get_filter_name( 'shipping_email' ), get_post_meta( $this->order->get_id(), '_shipping_email', true ), $this->order );
	}
}
