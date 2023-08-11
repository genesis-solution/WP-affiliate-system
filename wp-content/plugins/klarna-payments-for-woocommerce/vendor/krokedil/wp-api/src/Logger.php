<?php
/**
 * Logger class for the api requests.
 *
 * @package Krokedil/WpApi
 */

namespace Krokedil\WpApi;

/**
 * Logger class for the api requests. Used the WooCommerce logger.
 */
class Logger {
	/**
	 * WC Logger instance.
	 *
	 * @var \WC_Logger $log
	 */
	public static $log;

	/**
	 * Log the request with all the passed data.
	 *
	 * @param string $slug The plugin slug to create the log for.
	 * @param array  $log_data The data to log.
	 * @return void
	 */
	public static function log( $slug, $log_data = array() ) {
		// Log the data.
		if ( empty( self::$log ) ) {
			self::$log = new \WC_Logger();
		}

		self::$log->add( $slug, wp_json_encode( $log_data ) );
	}

	/**
	 * Gets the stack for the request.
	 *
	 * @param bool $extended_debugging Whether to include the arguments in the stack trace. This should never be turned on by default, but rather only used when extra information is needed.
	 * @return array
	 */
	public static function get_stack( $extended_debugging = false ) {
		$debug_data = debug_backtrace(); // phpcs:ignore WordPress.PHP.DevelopmentFunctions -- Data is not used for display.
		$stack      = array();

		// Skip the first 4 items in the stack trace to skip to the actual caller.
		$count      = count( $debug_data );
		for ( $i = 5; $i < $count; $i++ ) {
			self::process_debug_line( $stack, $debug_data[ $i ], $extended_debugging );
		}

		return $stack;
	}

	/**
	 * Processes a debug line, and adds it to the stack trace.
	 *
	 * @param array $stack The stack trace passed by reference.
	 * @param array $debug_line The debug info from the raw stack trace.
	 * @param bool  $extended_debugging Whether to include the arguments in the stack trace.
	 * @return void
	 */
	private static function process_debug_line( &$stack, $debug_line, $extended_debugging ) {
		$class    = $debug_line['class'] ?? '';
		$type     = $debug_line['type'] ?? '';
		$function = $debug_line['function'] ?? '';
		$args     = $debug_line['args'] ?? array();

		self::handle_wp_hook( $class, $function, $args, $debug_line );

		// Construct a caller string.
		$caller  = self::get_caller_string( $class, $type, $function, $args, $extended_debugging );

		$row     = array(
			'file'     => $debug_line['file'] ?? '',
			'line'     => $debug_line['line'] ?? '',
			'function' => $caller,
		);

		$stack[] = $row;
	}

	/**
	 * Get the caller string from the stack trace line.
	 *
	 * @param string $class The class name.
	 * @param string $type The type, :: or -> depending on if its a static or non static class.
	 * @param string $function The function name.
	 * @param array  $args The arguments passed to the caller.
	 * @param bool   $extended_debugging Whether to include the arguments in the stack trace.
	 * @return string
	 */
	private static function get_caller_string( $class, $type, $function, $args, $extended_debugging ) {
		// Construct a caller string.
		$caller = $class . $type . $function;
		$caller .= '(';
		// Only add data if we are doing extended debugging.
		$caller .= $extended_debugging ? implode(
			', ',
			array_map(
				function ($value) {
					// Json encode all values so that we can see what objects and arrays are passed. Dont escape anything, partial output on errors, and ignore slashes and line terminators.
					return wp_json_encode( $value, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES );
				},
				$args
			)
		) : '';
		$caller .= ')';

		return $caller;
	}

	/**
	 * Handles any WP hooks that are called.
	 *
	 * @param string $class The class name.
	 * @param string $function The function name.
	 * @param array  $args The arguments. Passed by reference to allow modifications.
	 * @param array  $debug_line The debug line.
	 * @return void
	 */
	private static function handle_wp_hook( $class, $function, &$args, $debug_line ) {
		if ( 'WP_Hook' === $class && in_array( $function, array( 'apply_filters', 'do_action' ), true ) ) {
			$wp_hook = $debug_line['object'] ?? null;
			if ( $wp_hook instanceof \WP_Hook ) {
				$priority = $wp_hook->current_priority();
				$current  = $wp_hook->current() ? current( $wp_hook->current() ) : false;
				$name     = '';

				if ( ! $current ) {
					return;
				}

				$function = $current['function'] ?? array();

				// If function is not a string, loop the functions to get the name.
				if ( ! is_string( $function ) ) {
					foreach ( $current['function'] ?? array() as $function ) {
						$name .= self::get_name_of_hook_function( $function );
					}
				} else {
					$name = self::get_name_of_hook_function( $function );
				}

				array_unshift( $args, $name . ' (' . $priority . ')' );
			}
		}
	}

	/**
	 * Gets a string back from the object passed to match the name of any class that it is an instance off.
	 *
	 * @param mixed $object The potential class object.
	 * @return string
	 */
	private static function get_name_of_hook_function( $object ) {
		// If the object is null, reutrn an empty string.
		if ( null === $object ) {
			return '';
		}

		// If its not an object, check if class exists, else return as function name.
		if ( ! is_object( $object ) ) {
			return $object . ( class_exists( $object ) ? '::' : '()' );
		}

		// Get the class name and return it with appended static divider.
		return get_class( $object ) . '::';
	}
}
