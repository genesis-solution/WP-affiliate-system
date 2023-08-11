<?php
/**
 * Gets the customer data from the StoreApi object.
 *
 * @package Krokedil/WooCommerce/
 */

namespace Krokedil\WooCommerce\StoreApi;

use Krokedil\WooCommerce\CustomerData;

/**
 * Gets the customer data from the StoreApi object.
 */
class StoreApiCustomer extends CustomerData {
	/**
	 * The WooCommerce cart response from the StoreApi.
	 *
	 * @var array $cart
	 */
	public $cart;

	/**
	 * The WooCommerce billing address from the StoreApi.
	 *
	 * @var array $billing_address
	 */
	public $billing_address;

	/**
	 * The WooCommerce shipping address from the StoreApi.
	 *
	 * @var array $shipping_address
	 */
	public $shipping_address;

	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'store_api_cart_customer';

	/**
	 * Constructor.
	 *
	 * @param array|string $cart The WooCommerce store api cart.
	 * @param array $config Configuration array.
	 */
	public function __construct( $cart, $config = array() ) {
		parent::__construct( $config );

		$this->cart = $cart;

		$this->billing_address  = $cart['billing_address'];
		$this->shipping_address = $cart['shipping_address'];

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
	 *
	 * @return void
	 */
	public function set_billing_first_name() {
		$this->billing_first_name = apply_filters( $this->get_filter_name( 'billing_first_name' ), stripslashes( $this->billing_address['first_name'] ), WC()->checkout );
	}

	/**
	 * Set billing last name
	 *
	 * @return void
	 */
	public function set_billing_last_name() {
		$this->billing_last_name = apply_filters( $this->get_filter_name( 'billing_last_name' ), stripslashes( $this->billing_address['last_name'] ), WC()->checkout );
	}

	/**
	 * Set billing company
	 *
	 * @return void
	 */
	public function set_billing_company() {
		$this->billing_company = apply_filters( $this->get_filter_name( 'billing_company' ), stripslashes( $this->billing_address['company'] ), WC()->checkout );
	}

	/**
	 * Set billing address 1
	 *
	 * @return void
	 */
	public function set_billing_address_1() {
		$this->billing_address_1 = apply_filters( $this->get_filter_name( 'billing_address_1' ), stripslashes( $this->billing_address['address_1'] ), WC()->checkout );
	}

	/**
	 * Set billing address 2
	 *
	 * @return void
	 */
	public function set_billing_address_2() {
		$this->billing_address_2 = apply_filters( $this->get_filter_name( 'billing_address_2' ), stripslashes( $this->billing_address['address_2'] ), WC()->checkout );
	}

	/**
	 * Set billing city
	 *
	 * @return void
	 */
	public function set_billing_city() {
		$this->billing_city = apply_filters( $this->get_filter_name( 'billing_city' ), stripslashes( $this->billing_address['city'] ), WC()->checkout );
	}

	/**
	 * Set billing state
	 *
	 * @return void
	 */
	public function set_billing_state() {
		$this->billing_state = apply_filters( $this->get_filter_name( 'billing_state' ), stripslashes( $this->billing_address['state'] ), WC()->checkout );
	}

	/**
	 * Set billing postcode
	 *
	 * @return void
	 */
	public function set_billing_postcode() {
		$this->billing_postcode = apply_filters( $this->get_filter_name( 'billing_postcode' ), stripslashes( $this->billing_address['postcode'] ), WC()->checkout );
	}

	/**
	 * Set billing country
	 *
	 * @return void
	 */
	public function set_billing_country() {
		$this->billing_country = apply_filters( $this->get_filter_name( 'billing_country' ), stripslashes( $this->billing_address['country'] ), WC()->checkout );
	}

	/**
	 * Set billing email
	 *
	 * @return void
	 */
	public function set_billing_email() {
		$this->billing_email = apply_filters( $this->get_filter_name( 'billing_email' ), stripslashes( $this->billing_address['email'] ), WC()->checkout );
	}

	/**
	 * Set billing phone
	 *
	 * @return void
	 */
	public function set_billing_phone() {
		$this->billing_phone = apply_filters( $this->get_filter_name( 'billing_phone' ), stripslashes( $this->billing_address['phone'] ), WC()->checkout );
	}

	/**
	 * Set shipping email
	 *
	 * @return void
	 */
	public function set_shipping_email() {
		$this->shipping_email = apply_filters( $this->get_filter_name( 'shipping_email' ), stripslashes( $this->shipping_address['email'] ?? $this->billing_address['email'] ), WC()->checkout );
	}

	/**
	 * Set shipping first name
	 *
	 * @return void
	 */
	public function set_shipping_first_name() {
		$this->shipping_first_name = apply_filters( $this->get_filter_name( 'shipping_first_name' ), stripslashes( $this->shipping_address['first_name'] ), WC()->checkout );
	}

	/**
	 * Set shipping last name
	 *
	 * @return void
	 */
	public function set_shipping_last_name() {
		$this->shipping_last_name = apply_filters( $this->get_filter_name( 'shipping_last_name' ), stripslashes( $this->shipping_address['last_name'] ), WC()->checkout );
	}

	/**
	 * Set shipping company
	 *
	 * @return void
	 */
	public function set_shipping_company() {
		$this->shipping_company = apply_filters( $this->get_filter_name( 'shipping_company' ), stripslashes( $this->shipping_address['company'] ), WC()->checkout );
	}

	/**
	 * Set shipping address 1
	 *
	 * @return void
	 */
	public function set_shipping_address_1() {
		$this->shipping_address_1 = apply_filters( $this->get_filter_name( 'shipping_address_1' ), stripslashes( $this->shipping_address['address_1'] ), WC()->checkout );
	}

	/**
	 * Set shipping address 2
	 *
	 * @return void
	 */
	public function set_shipping_address_2() {
		$this->shipping_address_2 = apply_filters( $this->get_filter_name( 'shipping_address_2' ), stripslashes( $this->shipping_address['address_2'] ), WC()->checkout );
	}

	/**
	 * Set shipping city
	 *
	 * @return void
	 */
	public function set_shipping_city() {
		$this->shipping_city = apply_filters( $this->get_filter_name( 'shipping_city' ), stripslashes( $this->shipping_address['city'] ), WC()->checkout );
	}

	/**
	 * Set shipping state
	 *
	 * @return void
	 */
	public function set_shipping_state() {
		$this->shipping_state = apply_filters( $this->get_filter_name( 'shipping_state' ), stripslashes( $this->shipping_address['state'] ), WC()->checkout );
	}

	/**
	 * Set shipping postcode
	 *
	 * @return void
	 */
	public function set_shipping_postcode() {
		$this->shipping_postcode = apply_filters( $this->get_filter_name( 'shipping_postcode' ), stripslashes( $this->shipping_address['postcode'] ), WC()->checkout );
	}

	/**
	 * Set shipping country
	 *
	 * @return void
	 */
	public function set_shipping_country() {
		$this->shipping_country = apply_filters( $this->get_filter_name( 'shipping_country' ), stripslashes( $this->shipping_address['country'] ), WC()->checkout );
	}

	/**
	 * Set shipping phone
	 *
	 * @return void
	 */
	public function set_shipping_phone() {
		$this->shipping_phone = apply_filters( $this->get_filter_name( 'shipping_phone' ), stripslashes( $this->shipping_address['phone'] ), WC()->checkout );
	}
}
