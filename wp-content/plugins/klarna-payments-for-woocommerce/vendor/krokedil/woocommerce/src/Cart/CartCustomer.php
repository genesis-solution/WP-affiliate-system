<?php
/**
 * Gets the customer data from the checkout object.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce\Cart;

use Krokedil\WooCommerce\CustomerData;

/**
 * Gets the customer data from the checkout object.
 */
class CartCustomer extends CustomerData {
	/**
	 * Filter prefix.
	 *
	 * @var mixed
	 */
	public $filter_prefix = 'cart';

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration array.
	 */
	public function __construct( $config = array() ) {
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
	 *
	 * @return void
	 */
	public function set_billing_first_name() {
		$this->billing_first_name = apply_filters( $this->get_filter_name( 'first_name' ), stripslashes( WC()->checkout->get_value( 'billing_first_name' ) ), WC()->checkout ) ;
	}

	/**
	 * Set billing last name
	 *
	 * @return void
	 */
	public function set_billing_last_name() {
		$this->billing_last_name = apply_filters( $this->get_filter_name( 'last_name' ), stripslashes( WC()->checkout->get_value( 'billing_last_name' ) ), WC()->checkout );
	}

	/**
	 * Set billing company
	 *
	 * @return void
	 */
	public function set_billing_company() {
		$this->billing_company = apply_filters( $this->get_filter_name( 'company' ), stripslashes( WC()->checkout->get_value( 'billing_company' ) ), WC()->checkout );
	}

	/**
	 * Set billing address 1
	 *
	 * @return void
	 */
	public function set_billing_address_1() {
		$this->billing_address_1 = apply_filters( $this->get_filter_name( 'address_1' ), stripslashes( WC()->checkout->get_value( 'billing_address_1' ) ), WC()->checkout );
	}

	/**
	 * Set billing address 2
	 *
	 * @return void
	 */
	public function set_billing_address_2() {
		$this->billing_address_2 = apply_filters( $this->get_filter_name( 'address_2' ), stripslashes( WC()->checkout->get_value( 'billing_address_2' ) ), WC()->checkout );
	}

	/**
	 * Set billing city
	 *
	 * @return void
	 */
	public function set_billing_city() {
		$this->billing_city = apply_filters( $this->get_filter_name( 'city' ), stripslashes( WC()->checkout->get_value( 'billing_city' ) ), WC()->checkout );
	}

	/**
	 * Set billing state
	 *
	 * @return void
	 */
	public function set_billing_state() {
		$this->billing_state = apply_filters( $this->get_filter_name( 'state' ), stripslashes( WC()->checkout->get_value( 'billing_state' ) ), WC()->checkout );
	}

	/**
	 * Set billing postcode
	 *
	 * @return void
	 */
	public function set_billing_postcode() {
		$this->billing_postcode = apply_filters( $this->get_filter_name( 'postcode' ), stripslashes( WC()->checkout->get_value( 'billing_postcode' ) ), WC()->checkout );
	}

	/**
	 * Set billing country
	 *
	 * @return void
	 */
	public function set_billing_country() {
		$this->billing_country = apply_filters( $this->get_filter_name( 'country' ), stripslashes( WC()->checkout->get_value( 'billing_country' ) ), WC()->checkout );
	}

	/**
	 * Set billing email
	 *
	 * @return void
	 */
	public function set_billing_email() {
		$this->billing_email = apply_filters( $this->get_filter_name( 'email' ), stripslashes( WC()->checkout->get_value( 'billing_email' ) ), WC()->checkout );
	}

	/**
	 * Set billing phone
	 *
	 * @return void
	 */
	public function set_billing_phone() {
		$this->billing_phone = apply_filters( $this->get_filter_name( 'phone' ), stripslashes( WC()->checkout->get_value( 'billing_phone' ) ), WC()->checkout );
	}

	/**
	 * Set shipping email
	 *
	 * @return void
	 */
	public function set_shipping_email() {
		$this->shipping_email = apply_filters( $this->get_filter_name( 'email' ), stripslashes( WC()->checkout->get_value( 'shipping_email' ) ), WC()->checkout );
	}

	/**
	 * Set shipping first name
	 *
	 * @return void
	 */
	public function set_shipping_first_name() {
		$this->shipping_first_name = apply_filters( $this->get_filter_name( 'first_name' ), stripslashes( WC()->checkout->get_value( 'shipping_first_name' ) ), WC()->checkout );
	}

	/**
	 * Set shipping last name
	 *
	 * @return void
	 */
	public function set_shipping_last_name() {
		$this->shipping_last_name = apply_filters( $this->get_filter_name( 'last_name' ), stripslashes( WC()->checkout->get_value( 'shipping_last_name' ) ), WC()->checkout );
	}

	/**
	 * Set shipping company
	 *
	 * @return void
	 */
	public function set_shipping_company() {
		$this->shipping_company = apply_filters( $this->get_filter_name( 'company' ), stripslashes( WC()->checkout->get_value( 'shipping_company' ) ), WC()->checkout );
	}

	/**
	 * Set shipping address 1
	 *
	 * @return void
	 */
	public function set_shipping_address_1() {
		$this->shipping_address_1 = apply_filters( $this->get_filter_name( 'address_1' ), stripslashes( WC()->checkout->get_value( 'shipping_address_1' ) ), WC()->checkout );
	}

	/**
	 * Set shipping address 2
	 *
	 * @return void
	 */
	public function set_shipping_address_2() {
		$this->shipping_address_2 = apply_filters( $this->get_filter_name( 'address_2' ), stripslashes( WC()->checkout->get_value( 'shipping_address_2' ) ), WC()->checkout );
	}

	/**
	 * Set shipping city
	 *
	 * @return void
	 */
	public function set_shipping_city() {
		$this->shipping_city = apply_filters( $this->get_filter_name( 'city' ), stripslashes( WC()->checkout->get_value( 'shipping_city' ) ), WC()->checkout );
	}

	/**
	 * Set shipping state
	 *
	 * @return void
	 */
	public function set_shipping_state() {
		$this->shipping_state = apply_filters( $this->get_filter_name( 'state' ), stripslashes( WC()->checkout->get_value( 'shipping_state' ) ), WC()->checkout );
	}

	/**
	 * Set shipping postcode
	 *
	 * @return void
	 */
	public function set_shipping_postcode() {
		$this->shipping_postcode = apply_filters( $this->get_filter_name( 'postcode' ), stripslashes( WC()->checkout->get_value( 'shipping_postcode' ) ), WC()->checkout );
	}

	/**
	 * Set shipping country
	 *
	 * @return void
	 */
	public function set_shipping_country() {
		$this->shipping_country = apply_filters( $this->get_filter_name( 'country' ), stripslashes( WC()->checkout->get_value( 'shipping_country' ) ), WC()->checkout );
	}

	/**
	 * Set shipping phone
	 *
	 * @return void
	 */
	public function set_shipping_phone() {
		$this->shipping_phone = apply_filters( $this->get_filter_name( 'phone' ), stripslashes( WC()->checkout->get_value( 'shipping_phone' ) ), WC()->checkout );
	}
}
