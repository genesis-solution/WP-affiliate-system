<?php
/**
 * class-affiliates-em-method.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-events-manager
 * @since affiliates-events-manager 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affliates EM Method class
 */
class Affiliates_EM_Method {

	/**
	 * Init
	 */
	public static function init() {
		if ( method_exists( 'Affiliates_Referral', 'register_referral_amount_method' ) ) {
			Affiliates_Referral::register_referral_amount_method( array( __CLASS__, 'event_booking_rates' ) );
		}
	}

	/**
	 * Calculate referral amount
	 *
	 * @param int $affiliate_id
	 * @param array $parameters
	 * @return string
	 */
	public static function event_booking_rates( $affiliate_id = null, $parameters = null ) {
		$result = '0';

		if ( isset( $parameters['post_id'] ) ) {
			$result = self::calculate( $parameters['post_id'] );
		} else if ( isset( $parameters['reference'] ) ) {
			$reference_id = $parameters['reference'];
			$result = self::calculate( $reference_id );

		} else if ( isset( $parameters['data'] ) ) {
			$transaction_id = $parameters['data']['booking']['value'];
			$result = self::calculate( $transaction_id );
		} else {
			return;
		}

		return $result;
	}

	/**
	 * Calculate Helper function
	 *
	 * @param int $post_id
	 * @return string
	 */
	public static function calculate( $post_id ) {
		// @codingStandardsIgnoreStart
		global $EM_Event, $EM_Booking;
		$em_event = $EM_Event;
		$em_booking = $EM_Booking;
		// @codingStandardsIgnoreStart

		$amount = '0';
		$referral_rate = Affiliates_Events_Manager::DEFAULT_ZERO_VALUE;
		$options = get_option( Affiliates_Events_Manager::PLUGIN_OPTIONS , array() );

		if ( !empty( $post_id ) ) {
			if ( empty( $em_event ) ) {
				$event = em_get_event( $post_id, 'post_id' );
				$event_id = $event->post_id;
			} else {
				// post id of the event
				$event_id = $em_event->post_id;
			}
			if ( empty( $em_booking ) ) {
				$booking = em_get_booking( $post_id );
				$booking_price_post_tax = $booking->price;
			} else {
				$booking_price_post_tax = $em_booking->price;
			}
			if ( isset( $em_booking->taxes ) ) {
				$booking_price = bcsub( $booking_price_post_tax, $em_booking->taxes, affiliates_get_referral_amount_decimals() );
			} else {
				$booking_price = $booking_price_post_tax;
			}
		}
		if ( get_post_meta( $event_id, Affiliates_EM_Booking::REFERRAL_RATE, true ) != '' ) {
			$referral_rate = get_post_meta( $event_id, Affiliates_EM_Booking::REFERRAL_RATE, true );
		} else {
			$referral_rate = $options['referral-rate'];
		}
		$amount = bcmul( $booking_price, $referral_rate, affiliates_get_referral_amount_decimals() );

		return $amount;
	}

}

add_action( 'init', array( 'Affiliates_EM_Method', 'init' ) );
