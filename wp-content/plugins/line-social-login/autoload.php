<?php

namespace WP_Social;

defined('ABSPATH') || exit;

/**
 * autoloader.
 * Handles dynamically loading classes only when needed.
 *
 * @since 1.0.0
 */
class Autoloader {

	/**
	 * Run autoloader.
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function run() {
		spl_autoload_register([__CLASS__, 'autoload']);
	}


	/**
	 * Autoload.
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param string $class Class name.
	 */
	private static function autoload($class_name) {

		// If the class being requested does not start with our prefix
		// we know it's not one in our project.
		if(0 !== strpos($class_name, __NAMESPACE__)) {
			return;
		}


		$file_name = strtolower(
			preg_replace(
				['/\b' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'],
				['', '$1-$2', '-', DIRECTORY_SEPARATOR],
				$class_name
			)
		);

		// Compile our path from the corosponding location.
		$file = plugin_dir_path(__FILE__) . $file_name . '.php';

		// If a file is found.
		if(file_exists($file)) {
			// Then load it up!
			require_once($file);
		}
	}
}



require(WSLU_LOGIN_PLUGIN.'/lib/composer/vendor/autoload.php');

Autoloader::run();

// Include user custom function
require_once(WSLU_LOGIN_PLUGIN.'/inc/admin-custom-function.php');

require_once(WSLU_LOGIN_PLUGIN.'/inc/admin-social-button.php');

require_once(WSLU_LOGIN_PLUGIN.'/inc/admin-create-shortcode.php');

require_once(WSLU_LOGIN_PLUGIN.'/inc/admin-rest-api.php');

require_once(WSLU_LOGIN_PLUGIN.'lib/counter/counters-api.php');


// elementor plugin
require_once(WSLU_LOGIN_PLUGIN.'/inc/elementor/elements.php');   // namespace different but easy to change - just need to find the references

