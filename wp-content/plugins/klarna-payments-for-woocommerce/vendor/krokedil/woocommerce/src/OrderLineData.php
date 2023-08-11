<?php
/**
 * Base class for order line data.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce;

use Krokedil\WooCommerce\Base;

/**
 * Base class for order line data.
 */
abstract class OrderLineData extends Base {
	/**
	 * The name of the product or service.
	 * @var string
	 */
	public $name;

	/**
	 * The product's unique SKU code.
	 * @var string
	 */
	public $sku;

	/**
	 * The number of items ordered.
	 * @var int
	 */
	public $quantity;

	/**
	 * The price of a single unit of the item, excluding tax.
	 * @var float|int
	 */
	public $unit_price;

    /**
     * The price of a single unit of the item, excluding tax, before any discounts are applied.
     * @var float|int
     */
    public $subtotal_unit_price;

	/**
	 * The tax rate applied to the item.
	 * @var float|int
	 */
	public $tax_rate;

	/**
	 * The total cost of the line, excluding tax.
	 * @var float|int
	 */
	public $total_amount;

    /**
     * The total cost of the line, excluding tax, before any discounts are applied.
     * @var float|int
     */
    public $subtotal_amount;

	/**
	 * The total amount of discounts applied to the line.
	 * @var float|int
	 */
	public $total_discount_amount;

    /**
     * The total amount of discounted tax to the line.
     *
     * @var float|int
     */
	public $total_discount_tax_amount;

	/**
	 * The total amount of tax applied to the line.
	 * @var float|int
	 */
	public $total_tax_amount;

    /**
     * The total tax of the line, excluding tax, before any discounts are applied.
     * @var float|int
     */
    public $subtotal_tax_amount;

	/**
	 * The type of item.
	 * @var string
	 */
	public $type;

	/**
	 * The URL of the product or service.
	 * @var string
	 */
	public $product_url;

	/**
	 * The URL of an image of the product or service.
	 * @var string
	 */
	public $image_url;

	/**
	 * The part number or other unique identifier for the item.
	 * @var array
	 */
	public $compatability;

    /**
     * Abstract function to set product name
     * @return void
     */
    public abstract function set_name();

    /**
     * Abstract function to set product sku
     * @return void
     */
    public abstract function set_sku();

    /**
     * Abstract function to set product quantity
     * @return void
     */
    public abstract function set_quantity();

    /**
     * Abstract function to set product unit price
     * @return void
     */
    public abstract function set_unit_price();

    /**
     * Abstract function to set product subtotal unit price. Unit price before any discounts are applied.
     *
     * @return void
     */
	public abstract function set_subtotal_unit_price();

    /**
     * Abstract function to set product tax rate
     * @return void
     */
    public abstract function set_tax_rate();

    /**
     * Abstract function to set product total amount
     * @return void
     */
    public abstract function set_total_amount();

    /**
     * Abstract function to set product subtotal amount, total amount before any discounts are applied.
     *
     * @return void
     */
    public abstract function set_subtotal_amount();

    /**
     * Abstract function to set product total discount amount
     * @return void
     */
    public abstract function set_total_discount_amount();

    /**
     * Abstract function to set product total discount tax amount
     * @return void
     */
    public abstract function set_total_discount_tax_amount();

    /**
     * Abstract function to set product total tax amount
     * @return void
     */
    public abstract function set_total_tax_amount();

    /**
     * Abstract function to set product subtotal tax amount, total tax amount before any discounts are applied.
     *
     * @return void
     */
    public abstract function set_subtotal_tax_amount();

    /**
     * Abstract function to set product type
     * @return void
     */
    public abstract function set_type();

    /**
     * Abstract function to set product url
     * @return void
     */
    public abstract function set_product_url();

    /**
     * Abstract function to set product image url
     * @return void
     */
    public abstract function set_image_url();

    /**
     * Abstract function to set product compatability
     * @return void
     */
    public abstract function set_compatability();

    /**
     * Function to get product name
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Function to get product sku
     * @return string
     */
    public function get_sku() {
        return $this->sku;
    }

    /**
     * Function to get product quantity
     * @return int
     */
    public function get_quantity() {
        return $this->quantity;
    }

    /**
     * Function to get product unit price
     * @return float|int
     */
    public function get_unit_price() {
        return $this->unit_price;
    }

    /**
     * Function to get product subtotal unit price
     * @return float|int
     */
    public function get_subtotal_unit_price() {
        return $this->subtotal_unit_price;
    }

	/**
	 * Function to get product unit tax amount
	 * @return float|int
	 */
	public function get_unit_tax_amount() {
		return $this->total_tax_amount / $this->quantity;
	}

    /**
	 * Function to get product unit tax amount
	 * @return float|int
	 */
	public function get_subtotal_unit_tax_amount() {
		return $this->subtotal_tax_amount / $this->quantity;
	}

    /**
     * Function to get product tax rate
     * @return float|int
     */
    public function get_tax_rate() {
        return $this->tax_rate;
    }

    /**
     * Function to get product total amount
     * @return float|int
     */
    public function get_total_amount() {
        return $this->total_amount;
    }

    /**
     * Function to get product subtotal amount
     * @return float|int
     */
    public function get_subtotal_amount() {
        return $this->subtotal_amount;
    }

    /**
     * Function to get product total discount amount
     * @return float|int
     */
    public function get_total_discount_amount() {
        return $this->total_discount_amount;
    }

    /**
     * Function to get product total discount tax amount
     * @return float|int
     */
    public function get_total_discount_tax_amount() {
        return $this->total_discount_tax_amount;
    }

    /**
     * Function to get product total tax amount
     * @return float|int
     */
    public function get_total_tax_amount() {
        return $this->total_tax_amount;
    }

    /**
     * Function to get product subtotal tax amount
     * @return float|int
     */
    public function get_subtotal_tax_amount() {
        return $this->subtotal_tax_amount;
    }

    /**
     * Function to get product type
     * @return string
     */
    public function get_type() {
        return $this->type;
    }

    /**
     * Function to get product url
     * @return string
     */
    public function get_product_url() {
        return $this->product_url;
    }

    /**
     * Function to get product image url
     * @return string
     */
    public function get_image_url() {
        return $this->image_url;
    }

    /**
     * Function to get product compatability
     * @return array
     */
    public function get_compatability() {
        return $this->compatability;
    }
}
