<?php

namespace ShopEngine\Utils;

defined('ABSPATH') || exit;

use WC_Validation;
use Exception;

/**
 * Global helper class.
 *
 * @since 1.0.0
 */
class Shipping_Calculation {

	/**
	 * Output the cart shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public static function output() {

		if(!empty($_REQUEST['woocommerce-shipping-calculator-nonce'])) {
			$nonce_key =  'woocommerce-shipping-calculator-nonce';
		} else {
			$nonce_key = '_wpnonce';
		}

		// Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
		if ( ! empty( $_POST['calc_shipping'] ) && !empty($_REQUEST[$nonce_key]) && 
		( wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[$nonce_key] ) ), 'woocommerce-shipping-calculator' ) || 
		wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[$nonce_key] ) ), 'woocommerce-cart' ) ) ) {
			try {
				WC()->shipping()->reset_shipping();
	
				$address = array();
	
				$address['country']  = isset( $_POST['calc_shipping_country'] ) ? map_deep( wp_unslash( $_POST['calc_shipping_country'] ), 'sanitize_text_field' ) : '';
				$address['state']    = isset( $_POST['calc_shipping_state'] ) ? map_deep( wp_unslash( $_POST['calc_shipping_state'] ), 'sanitize_text_field' ) : '';
				$address['postcode'] = isset( $_POST['calc_shipping_postcode'] ) ? map_deep( wp_unslash( $_POST['calc_shipping_postcode'] ), 'sanitize_text_field' ) : '';
				$address['city']     = isset( $_POST['calc_shipping_city'] ) ? map_deep( wp_unslash( $_POST['calc_shipping_city'] ), 'sanitize_text_field' ) : '';
	
				$address = apply_filters( 'woocommerce_cart_calculate_shipping_address', $address );
	
				if ( $address['postcode'] && ! WC_Validation::is_postcode( $address['postcode'], $address['country'] ) ) {
					throw new Exception( __( 'Please enter a valid postcode / ZIP.', 'shopengine' ) );
				} elseif ( $address['postcode'] ) {
					$address['postcode'] = wc_format_postcode( $address['postcode'], $address['country'] );
				}
	
				if ( $address['country'] ) {
					if ( ! WC()->customer->get_billing_first_name() ) {
						WC()->customer->set_billing_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
					}
					WC()->customer->set_shipping_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
				} else {
					WC()->customer->set_billing_address_to_base();
					WC()->customer->set_shipping_address_to_base();
				}
	
				WC()->customer->set_calculated_shipping( true );
				WC()->customer->save();
	
				wc_add_notice( __( 'Shipping costs updated.', 'shopengine' ), 'notice' );
	
				do_action( 'woocommerce_calculated_shipping' );
	
			} catch ( Exception $e ) {
				if ( ! empty( $e ) ) {
					wc_add_notice( $e->getMessage(), 'error' );
				}
			}

			// Also calc totals before we check items so subtotals etc are up to date.
			WC()->cart->calculate_totals();
		}
	}
}