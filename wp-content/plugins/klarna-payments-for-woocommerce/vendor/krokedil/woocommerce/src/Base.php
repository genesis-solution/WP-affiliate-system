<?php
/**
 * Base file for the package. This file is used to define the base class for the package that will be extended by all other classes.
 *
 * @package Krokedil/WooCommerce
 */

namespace Krokedil\WooCommerce;

/**
 * Base class for the package.
 */
class Base {
	public $config = array();

	/**
	 * The slug for the plugin.
	 *
	 * @var string $slug
	 */
	public $slug;

	/**
	 * The price format for the plugin.
	 *
	 * @var string $price_format
	 */
	public $price_format;

	/**
	 * The prefix to use for the filter.
	 *
	 * @var string $filter_prefix
	 */
	public $filter_prefix;

	public $defaults = array(
		'slug'         => 'krokedil_woocommerce',
		'price_format' => 'minor',
	);

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration array.
	 */
	public function __construct( $config = array() ) {
		$this->config = wp_parse_args( $config, $this->defaults );

		$this->slug         = $this->config['slug'];
		$this->price_format = $this->config['price_format'];
	}

	/**
	 * Formats the price from major units according to either the config provided or the price_format passed .
	 *
	 * @param int|float|string $price The price to be formated .
	 * @param string|null      $price_format The price format to be used, either minor or major as a string .
	 *
	 * @return int|float
	 */
	public function format_price( $price, $price_format = null ) {
		$price_format   = $price_format ? $price_format : $this->price_format;
		$decimal_points = $price_format === 'minor' ? 0 : 2;

		if ( 'minor' === $price_format ) {
			$price = floatval( $price ) * 100;
		}

		$formated_price = wc_format_decimal( $price, $decimal_points );

		return $price_format === 'minor' ? intval( $formated_price ) : floatval( $formated_price );
	}

	/**
	 * Formats the price from minor units according to either the config provided or the price_format passed.
	 *
	 * @param int|float|string $price The price to be formated .
	 * @param string|null      $price_format The price format to be used, either minor or major as a string .
	 *
	 * @return int|float
	 */
	public function format_price_from_minor( $price, $price_format = null ) {
		$price_format   = $price_format ? $price_format : $this->price_format;
		$decimal_points = $price_format === 'minor' ? 0 : 2;

		if ( 'major' === $price_format ) {
			$price = floatval( $price ) / 100;
		}

		$formated_price = wc_format_decimal( $price, $decimal_points );

		return $price_format === 'minor' ? intval( $formated_price ) : floatval( $formated_price );
	}

	/**
	 * Gets the prefix to use for the filter name.
	 *
	 * @return string
	 */
	public function get_filter_prefix() {
		$slug   = $this->slug;
		$source = $this->filter_prefix;
		return "{$slug}_{$source}";
	}

	/**
	 * Gets the filter name for the property.
	 *
	 * @param string $prop_name
	 * @return string
	 */
	public function get_filter_name( $prop_name ) {
		$prefix = $this->get_filter_prefix();
		return "{$prefix}_{$prop_name}";
	}
}
