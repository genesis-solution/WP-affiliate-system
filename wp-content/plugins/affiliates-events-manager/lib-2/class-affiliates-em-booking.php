<?php
/**
 * class-affiliates-em-booking.php
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
 * Affliates EM Booking class
 */
class Affiliates_EM_Booking {

	const PLUGIN_OPTIONS        = 'affiliates_events_manager';
	const REFERRAL_TYPE         = 'booking';
	const REFERRAL_RATE         = 'referral-rate';
	const REFERRAL_RATE_DEFAULT = '0';
	const EVENT_NONCE           = 'aff_em_booking_nonce';
	const SET_EVENT_OPTIONS     = 'set_event_options';
	const EVENT_POST_TYPE       = 'event';

	/**
	 * Init
	 */
	public static function init() {
		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ), 10, 2 );
			add_action( 'save_post_event', array( __CLASS__, 'save_post_event' ), 10, 3 );
		}
	}

	/**
	 * Adds a meta box for referral rate per booking in event post
	 *
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public static function add_meta_boxes( $post_type, $post ) {
		// @codingStandardsIgnoreStart
		global $EM_Event;
		$em_event = $EM_Event;
		// @codingStandardsIgnoreStart
		global $post;

		if ( empty( $em_event ) && !empty( $post ) ) {
			$em_event = em_get_event( $post->ID, 'post_id' );

		}
		// add the meta box only if reservations are enabled
		if ( get_option( 'dbem_rsvp_enabled' ) && $em_event->can_manage( 'manage_bookings', 'manage_others_bookings' ) ) {
			add_meta_box( 'aem-event-referral-rate', __( 'Affiliates', 'affiliates-events-manager' ), array( __CLASS__, 'meta_box_affiliates' ), 'event', 'normal', 'high' );
			// We do not add it to recurring events (posts of type 'event-recurring') as these can't really be booked.
			// Recurring events just create normal events and that is where we would set a rate.
		}
	}

	/**
	 * Meta box output
	 *
	 * @param object $post
	 */
	public static function meta_box_affiliates( $post ) {
		$referral_rate = get_post_meta( $post->ID, self::REFERRAL_RATE, true );
		$referral_rate = isset( $referral_rate ) ? $referral_rate : self::REFERRAL_RATE_DEFAULT;

		$output = '<p>';
		$output .= esc_html__( 'Booking Referral Rate', 'affiliates-events-manager' );
		$output .= '</p>';

		$output = '<p class="description">';
		$output .= wp_nonce_field( self::SET_EVENT_OPTIONS, self::EVENT_NONCE, true, false );
		$output .= '<label for="' . esc_attr( self::REFERRAL_RATE ) . '">' . esc_html__( 'Here you can set the Affiliate Referral Rate per Booking:&nbsp;', 'affiliates-events-manager' ) . '</label>';
		$output .= '<input name="' . esc_attr( self::REFERRAL_RATE ) . '" type="text" value="' . esc_attr( $referral_rate ) . '"/>';
		$output .= '</p>';
		$output .= '<p class="description">';
		$output .=
			wp_kses(
				__( 'Example: Set the referral rate to <strong>0.1</strong> if you want your affiliates to get a <strong>10%</strong> commission on each booking.', 'affiliates-events-manager' ),
				array(
					'strong' => array()
				)
			);
		$output .= '</p>';

		// @codingStandardsIgnoreStart
		echo $output;
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Save referral rate as post_meta
	 *
	 * @param int $post_id
	 * @param object $post
	 * @param bool $update
	 */
	public static function save_post_event( $post_id, $post, $update ) {
		if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
			wp_die( esc_html__( '拒絕訪問。', 'affiliates-events-manager' ) );
		}
		if ( self::EVENT_POST_TYPE != $post->post_type ) {
			return;
		}
		if ( isset( $_POST[self::REFERRAL_RATE] ) ) {
			if ( wp_verify_nonce( $_POST[self::EVENT_NONCE], self::SET_EVENT_OPTIONS ) ) {
				$referral_rate = floatval( $_POST[self::REFERRAL_RATE] );
				if ( $referral_rate > 1.0 ) {
					$referral_rate = 1.0;
				} else if ( $referral_rate < 0 ) {
					$referral_rate = 0.0;
				}
			}
			update_post_meta( $post->ID, self::REFERRAL_RATE, sanitize_text_field( $referral_rate ) );
		}
	}

}

Affiliates_EM_Booking::init();
