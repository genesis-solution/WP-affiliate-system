<?php
/**
 * Base class for customer data.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce;

use Krokedil\WooCommerce\Base;

/**
 * Base class for customer data.
 */
abstract class CustomerData extends Base {
	/**
	 * Billing first name
	 *
	 * @var string
	 */
	public $billing_first_name;

	/**
	 * Billing last name
	 *
	 * @var string
	 */
	public $billing_last_name;

	/**
	 * Billing company
	 *
	 * @var string
	 */
	public $billing_company;

	/**
	 * Billing address 1
	 *
	 * @var string
	 */
	public $billing_address_1;

	/**
	 * Billing address 2
	 *
	 * @var string
	 */
	public $billing_address_2;

	/**
	 * Billing city
	 *
	 * @var string
	 */
	public $billing_city;

	/**
	 * Billing state
	 *
	 * @var string
	 */
	public $billing_state;

	/**
	 * Billing postcode
	 *
	 * @var string
	 */
	public $billing_postcode;

	/**
	 * Billing country
	 *
	 * @var string
	 */
	public $billing_country;

	/**
	 * Billing email
	 *
	 * @var string
	 */
	public $billing_email;

	/**
	 * Billing phone
	 *
	 * @var string
	 */
	public $billing_phone;

	/**
	 * Shipping first name
	 *
	 * @var string
	 */
	public $shipping_first_name;

	/**
	 * Shipping last name
	 *
	 * @var string
	 */
	public $shipping_last_name;

	/**
	 * Shipping company
	 *
	 * @var string
	 */
	public $shipping_company;

	/**
	 * Shipping address 1
	 *
	 * @var string
	 */
	public $shipping_address_1;

	/**
	 * Shipping address 2
	 *
	 * @var string
	 */
	public $shipping_address_2;

	/**
	 * Shipping city
	 *
	 * @var string
	 */
	public $shipping_city;

	/**
	 * Shipping state
	 *
	 * @var string
	 */
	public $shipping_state;

	/**
	 * Shipping postcode
	 *
	 * @var string
	 */
	public $shipping_postcode;

	/**
	 * Shipping country
	 *
	 * @var string
	 */
	public $shipping_country;

	/**
	 * Shipping email
	 *
	 * @var string
	 */
	public $shipping_email;

	/**
	 * Shipping phone
	 *
	 * @var string
	 */
	public $shipping_phone;

	/**
	 * Get billing first name
	 *
	 * @return string
	 */
	public function get_billing_first_name() {
		return $this->billing_first_name;
	}

	/**
	 * Set billing first name
	 *
	 * @return void
	 */
	abstract public function set_billing_first_name();

	/**
	 * Get billing last name
	 *
	 * @return string
	 */
	public function get_billing_last_name() {
		return $this->billing_last_name;
	}

	/**
	 * Set billing last name
	 *
	 * @return void
	 */
	abstract public function set_billing_last_name();

	/**
	 * Get billing company
	 *
	 * @return string
	 */
	public function get_billing_company() {
		 return $this->billing_company;
	}

	/**
	 * Set billing company
	 *
	 * @return void
	 */
	abstract public function set_billing_company();

	/**
	 * Get billing address 1
	 *
	 * @return string
	 */
	public function get_billing_address_1() {
		return $this->billing_address_1;
	}

	/**
	 * Set billing address 1
	 *
	 * @return void
	 */
	abstract public function set_billing_address_1();

	/**
	 * Get billing address 2
	 *
	 * @return string
	 */
	public function get_billing_address_2() {
		return $this->billing_address_2;
	}

	/**
	 * Set billing address 2
	 *
	 * @return void
	 */
	abstract public function set_billing_address_2();

	/**
	 * Get billing city
	 *
	 * @return string
	 */
	public function get_billing_city() {
		return $this->billing_city;
	}

	/**
	 * Set billing city
	 *
	 * @return void
	 */
	abstract public function set_billing_city();

	/**
	 * Get billing state
	 *
	 * @return string
	 */
	public function get_billing_state() {
		return $this->billing_state;
	}

	/**
	 * Set billing state
	 *
	 * @return void
	 */
	abstract public function set_billing_state();

	/**
	 * Get billing postcode
	 *
	 * @return string
	 */
	public function get_billing_postcode() {
		return $this->billing_postcode;
	}

	/**
	 * Set billing postcode
	 *
	 * @return void
	 */
	abstract public function set_billing_postcode();

	/**
	 * Get billing country
	 *
	 * @return string
	 */
	public function get_billing_country() {
		 return $this->billing_country;
	}

	/**
	 * Set billing country
	 *
	 * @return void
	 */
	abstract public function set_billing_country();

	/**
	 * Get shipping email
	 *
	 * @return string
	 */
	public function get_shipping_email() {
		return $this->shipping_email;
	}

	/**
	 * Set shipping email
	 *
	 * @return void
	 */
	abstract public function set_shipping_email();

	/**
	 * Get shipping phone
	 *
	 * @return string
	 */
	public function get_billing_phone() {
		return $this->billing_phone;
	}

	/**
	 * Set shipping phone
	 *
	 * @return void
	 */
	abstract public function set_billing_phone();

	/**
	 * Get shipping first name
	 *
	 * @return string
	 */
	public function get_shipping_first_name() {
		 return $this->shipping_first_name;
	}

	/**
	 * Set shipping first name
	 *
	 * @return void
	 */
	abstract public function set_shipping_first_name();

	/**
	 * Get shipping last name
	 *
	 * @return string
	 */
	public function get_shipping_last_name() {
		return $this->shipping_last_name;
	}

	/**
	 * Set shipping last name
	 *
	 * @return void
	 */
	abstract public function set_shipping_last_name();

	/**
	 * Get shipping company
	 *
	 * @return string
	 */
	public function get_shipping_company() {
		return $this->shipping_company;
	}

	/**
	 * Set shipping company
	 *
	 * @return void
	 */
	abstract public function set_shipping_company();

	/**
	 * Get shipping address 1
	 *
	 * @return string
	 */
	public function get_shipping_address_1() {
		return $this->shipping_address_1;
	}

	/**
	 * Set shipping address 1
	 *
	 * @return void
	 */
	abstract public function set_shipping_address_1();

	/**
	 * Get shipping address 2
	 *
	 * @return string
	 */
	public function get_shipping_address_2() {
		return $this->shipping_address_2;
	}

	/**
	 * Set shipping address 2
	 *
	 * @return void
	 */
	abstract public function set_shipping_address_2();

	/**
	 * Get shipping city
	 *
	 * @return string
	 */
	public function get_shipping_city() {
		return $this->shipping_city;
	}

	/**
	 * Set shipping city
	 *
	 * @return void
	 */
	abstract public function set_shipping_city();

	/**
	 * Get shipping state
	 *
	 * @return string
	 */
	public function get_shipping_state() {
		return $this->shipping_state;
	}

	/**
	 * Set shipping state
	 *
	 * @return void
	 */
	abstract public function set_shipping_state();

	/**
	 * Get shipping postcode
	 *
	 * @return string
	 */
	public function get_shipping_postcode() {
		return $this->shipping_postcode;
	}

	/**
	 * Set shipping postcode
	 *
	 * @return void
	 */
	abstract public function set_shipping_postcode();

	/**
	 * Get shipping country
	 *
	 * @return string
	 */
	public function get_shipping_country() {
		return $this->shipping_country;
	}

	/**
	 * Set shipping country
	 *
	 * @return void
	 */
	abstract public function set_shipping_country();

	/**
	 * Get shipping phone
	 *
	 * @return string
	 */
	public function get_shipping_phone() {
		return $this->shipping_phone;
	}

	/**
	 * Set shipping phone
	 *
	 * @return void
	 */
	abstract public function set_shipping_phone();

	/**
	 * Get shipping email
	 *
	 * @return string
	 */
	public function get_billing_email() {
		return $this->billing_email;
	}

	/**
	 * Set shipping email
	 *
	 * @return void
	 */
	abstract public function set_billing_email();
}
