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
			// add_action( 'save_post_event', array( __CLASS__, 'save_post_event' ), 10, 3 );
		}
	}

	/**
	 * Adds a meta box for referral rate per booking in event post
	 *
	 * @param string $post_type
	 * @param WP_POST $post
	 */
	public static function add_meta_boxes( $post_type, $post ) {

		// Variable "EM_Event" is not in valid snake_case format
		// @codingStandardsIgnoreStart
		global $EM_Event, $post;
		$em_event = $EM_Event;
		// @codingStandardsIgnoreEnd
		if ( empty( $em_event ) && !empty( $post ) ) {
			$em_event = em_get_event( $post->ID, 'post_id' );
		}

		// add the meta box only if reservations are enabled
		if ( get_option( 'dbem_rsvp_enabled' ) && $em_event->can_manage( 'manage_bookings', 'manage_others_bookings' ) ) {
			add_meta_box(
				'aem-event-referral-rate',
				__( 'Affiliates', 'affiliates-events-manager' ),
				array( __CLASS__, 'meta_box_affiliates' ),
				'event',
				'normal',
				'high'
			);
			// We do not add it to recurring events (posts of type 'event-recurring') as these can't really be booked.
			// Recurring events just create normal events and that is where we would set a rate.
		}
	}

	/**
	 * Meta box output
	 *
	 * @param WP_Post $post
	 */
	public static function meta_box_affiliates( $post ) {
		echo '<div style="padding: 1em;">';
		$rates = Affiliates_Rate::get_rates(
			array(
				'integration' => 'affiliates-events-manager',
				'object_id'   => $post->ID
			)
		);

		if ( function_exists( 'em_get_event' ) ) {
			$em_event = em_get_event( $post->ID, 'post_id' );
			$categories = $em_event->get_categories();
			foreach ( $categories as $category ) {
				$term_rates = Affiliates_Rate::get_rates(
					array(
						'integration' => 'affiliates-events-manager',
						'term_id'     => $category->id
					)
				);
			}
		}
		echo '<h3>';
		echo esc_html( __( '價格', 'affiliates-events-manager' ) );
		echo '</h3>';
		if ( count( $rates ) > 0 ) {
			echo '<p>';
			echo esc_html( _n( 'This specific rate applies to this event', 'These specific rates apply to this event.', count( $rates ), 'affiliates-events-manager' ) );
			echo '</p>';
			$odd      = true;
			$is_first = true;
			echo '<table style="width:100%">';
			foreach ( $rates as $rate ) {
				if ( $is_first ) {
					// @codingStandardsIgnoreStart
					echo $rate->view(
						array(
							'style'        => 'table',
							'titles'       => true,
							'exclude'      => 'integration',
							'prefix_class' => 'odd'
						)
					);
					// @codingStandardsIgnoreStart
				} else {
					// @codingStandardsIgnoreStart
					echo $rate->view(
						array(
							'style'        => 'table',
							'exclude'      => 'integration',
							'prefix_class' => $odd ? 'odd' : 'even'
						)
					);
					// @codingStandardsIgnoreEnd
				}
				$is_first = false;
				$odd      = !$odd;
			}
			echo '</table>';
		} else {
			echo '<p>';
			echo esc_html( __( 'This event has no specific applicable rates.', 'affiliates-events-manager' ) );
			echo '</p>';
		}
		if (
			current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) &&
			!empty( $post ) &&
			!empty( $post->post_status ) &&
			$post->post_status !== 'auto-draft'
		) {
			echo '<p>';
			$url = wp_nonce_url( add_query_arg(
				array(
					'object_id'   => $post->ID,
					'integration' => 'affiliates-events-manager',
					'action'      => 'create-rate'
				),
				admin_url( 'admin.php?page=affiliates-admin-rates' )
			) );
			echo sprintf(
				'<a href="%s">',
				esc_url( $url )
			);
			echo esc_html__( 'Create a rate', 'affiliates-events-manager' );
			echo '</a>';
			echo '</p>';
		} else {
			echo '<p>';
			echo esc_html__( 'Once you save this event, you can create a rate from here.', 'affiliates-woocommerce' );
			echo '</p>';
		}
		echo '</div>';
	}
}

Affiliates_EM_Booking::init();
