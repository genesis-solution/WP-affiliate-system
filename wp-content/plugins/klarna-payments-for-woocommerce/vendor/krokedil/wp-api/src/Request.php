<?php
/**
 * Base request class file for the package. This file is used to define the base class for the package that will be extended by all other classes.
 *
 * @package Krokedil/WpApi
 */

namespace Krokedil\WpApi;

use Krokedil\WpApi\Logger;

/**
 * Base request class for the package.
 */
abstract class Request {
	/**
	 * Config values.
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Default values for the config.
	 *
	 * @var array
	 */
	public $defaults = array(
		'slug'                   => 'krokedil_api',
		'plugin_version'         => '1.0.0',
		'plugin_user_agent_name' => 'KAPI',
		'logging_enabled'        => true,
		'extended_debugging'     => false,
		'base_url'               => null,
	);

	/**
	 * Settings for plugin.
	 *
	 * @var array
	 */
	public $settings = array();

	/**
	 * Any arguments that the request needs to be made.
	 *
	 * @var array
	 */
	public $arguments = array();

	/**
	 * Endpoint path to be added to the base URL for the request. Has to be added by the the child class.
	 *
	 * @var string
	 */
	public $endpoint = '';

	/**
	 * The title to use for the log message. Has to be added by the the child class.
	 *
	 * @var string
	 */
	public $log_title = '';

	/**
	 * The method to use for the request.
	 *
	 * @var string
	 */
	public $method = 'GET';

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration array.
	 */
	public function __construct( $config = array(), $settings = array(), $arguments = array() ) {
		$this->config    = wp_parse_args( $config, $this->defaults );
		$this->settings  = $settings;
		$this->arguments = $arguments;
	}

	/**
	 * Get the request headers.
	 *
	 * @return array
	 */
	protected function get_request_headers() {
		return array(
			'Authorization' => $this->calculate_auth(),
			'Content-Type'  => 'application/json',
		);
	}

	/**
	 * Get the request URL for the request.
	 *
	 * @return string
	 */
	protected function get_request_url() {
		$base_url = rtrim( $this->config['base_url'], '/' );
		$endpoint = ltrim( $this->endpoint, '/' );
		return "$base_url/$endpoint";
	}

	/**
	 * Get the user agent.
	 *
	 * @return string
	 */
	protected function get_user_agent() {
		$wp_version             = get_bloginfo( 'version' );
		$wp_url                 = get_bloginfo( 'url' );
		$wc_version             = WC()->version;
		$plugin_user_agent_name = $this->config['plugin_user_agent_name'];
		$plugin_version         = $this->config['plugin_version'];
		$php_version            = phpversion();

		return apply_filters( 'http_headers_useragent', "WordPress/$wp_version; $wp_url - WooCommerce: $wc_version - $plugin_user_agent_name: $plugin_version - PHP Version: $php_version - Krokedil" );
	}

	/**
	 * Make the request.
	 *
	 * @return array|\WP_Error
	 */
	public function request() {
		$url      = $this->get_request_url();
		$args     = $this->get_request_args();
		$response = wp_remote_request( $url, $args );
		return $this->process_response( $response, $args, $url );
	}

	/**
	 * Processes the response checking for errors.
	 *
	 * @param array|\WP_Error $response The response from the request.
	 * @param array           $request_args The request args.
	 * @param string          $request_url The request url.
	 * @return array|\WP_Error
	 */
	protected function process_response( $response, $request_args, $request_url ) {
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code < 200 || $response_code > 299 ) {
			$return = $this->get_error_message( $response );
		} else {
			$return = json_decode( wp_remote_retrieve_body( $response ), true );
		}

		$this->log_response( $response, $request_args, $request_url );
		return $return;
	}

	/**
	 * Logs the response from the request.
	 *
	 * @param array|\WP_Error $response The response from the request.
	 * @param array           $request_args The request args.
	 * @param string          $request_url The request URL.
	 * @return void
	 */
	protected function log_response( $response, $request_args, $request_url ) {
		if ( ! $this->config['logging_enabled'] ) {
			return;
		}

		// Get the response body if its not a WP_Error.
		$response_body = ! is_wp_error( $response ) ? json_decode( wp_remote_retrieve_body( $response ), true ) : array();
		$code = wp_remote_retrieve_response_code( $response );

		// Parse the Request body into an array if its json format.
		$request_body  = $request_args['body'];
		$decoded_body  = json_decode( $request_body );
		$request_args['body'] = $decoded_body ?? $request_args['body'];

		// Log the response.
		Logger::log(
			$this->config['slug'],
			array(
				'type'           => $this->method,
				'title'          => $this->log_title,
				'arguments'      => $this->arguments,
				'request'        => $request_args,
				'request_url'    => $request_url,
				'response'       => array(
					'body' => $response_body,
					'code' => $code,
				),
				'timestamp'      => date( 'Y-m-d H:i:s' ), // phpcs:ignore WordPress.DateTime.RestrictedFunctions -- Date is not used for display.
				'stack'          => Logger::get_stack( $this->config['extended_debugging'] ),
				'plugin_version' => $this->config['plugin_version'],
			)
		);
	}

	/**
	 * Calculate the auth headers. Has to be implemented by the child class.
	 *
	 * @return string
	 */
	abstract protected function calculate_auth();

	/**
	 * Get the request args.
	 *
	 * @return array
	 */
	abstract protected function get_request_args();

	/**
	 * Gets the error message from the response. Has to be implemented by the child class.
	 *
	 * @param array $response The response from the request.
	 * @return \WP_Error
	 */
	abstract protected function get_error_message( $response );
}
