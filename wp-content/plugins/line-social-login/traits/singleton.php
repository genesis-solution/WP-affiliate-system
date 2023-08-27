<?php

namespace WP_Social\Traits;

/**
 * Trait for making singleton instance
 *
 * @package WP_Social\Traits
 */
trait Singleton {

	private static $instance;

	public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
	}
}
