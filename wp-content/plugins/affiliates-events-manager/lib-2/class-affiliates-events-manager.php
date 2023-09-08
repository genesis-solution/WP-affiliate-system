<?php
/**
 * affiliates-events-manager.php
 *
 * Copyright (c) 2012-2017 www.itthinx.com
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
 * @author itthinx
 * @package affiliates-events-manager
 * @since affiliates-events-manager 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiliates Events Manager class
 */
class Affiliates_Events_Manager {

	const PLUGIN_OPTIONS                = 'affiliates_events_manager';
	const REFERRAL_TYPE                 = 'booking';
	const JS_FILTER_PRIORITY            = 999;
	const REFERRAL_RATE                 = 'referral-rate';
	const DEFAULT_ZERO_VALUE            = '0';
	const NONCE                         = 'aff_em_admin_nonce';
	const SET_ADMIN_OPTIONS             = 'set_admin_options';
	const ENABLE_BOOKING_RATES          = 'enable_booking_rates';
	const DEFAULT_TOGGLE                = false;
	const ENABLE_RECURRING_REFERRALS    = 'enable_recurring_referrals';
	const RECURRING_REFERRALS_TIMEOUT   = 'recurring_referrals_timeout';

		// Booking status filter strings
	const BOOKING_STATUS_DEFAULT            = true;
	const BOOKING_UNAPPROVED                = 'auto_unapproved';
	const BOOKING_APPROVED                  = 'auto_approved';
	const BOOKING_REJECTED                  = 'auto_rejected';
	const BOOKING_CANCELLED                 = 'auto_cancelled';
	const BOOKING_AWAITING_ONLINE_PAYMENT   = 'auto_awaiting_online_payment';
	const BOOKING_AWAITING_PAYMENT          = 'auto_awaiting_payment';

		// Events Manager uses magic numbers
	const BOOKING_STATUS_UNAPPROVED              = 0;
	const BOOKING_STATUS_APPROVED                = 1;
	const BOOKING_STATUS_REJECTED                = 2;
	const BOOKING_STATUS_CANCELLED               = 3;
	const BOOKING_STATUS_AWAITING_ONLINE_PAYMENT = 4;
	const BOOKING_STATUS_AWAITING_PAYMENT        = 5;

	/**
	 * Admin messages.
	 *
	 * @static
	 * @access private
	 *
	 * @var array
	 */
	private static $admin_messages = array();

	/**
	 * Prints admin notices.
	 */
	public static function admin_notices() {
		if ( !empty( self::$admin_messages ) ) {
			foreach ( self::$admin_messages as $msg ) {
				echo wp_kses(
					$msg,
					array(
						'strong' => array(),
						'div' => array( 'class' ),
						'a' => array(
							'href'   => array(),
							'target' => array( '_blank' )
						),
						'div' => array(
							'class' => array()
						),
					)
				);
			}
		}
	}

	/**
	 * Checks dependencies and sets up actions and filters.
	 */
	public static function init() {

		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );

		$verified = true;
		$disable = false;
		$active_plugins = get_option( 'active_plugins', array() );
		$affiliates_is_active = in_array( 'affiliates/affiliates.php', $active_plugins ) || in_array( 'affiliates-pro/affiliates-pro.php', $active_plugins ) || in_array( 'affiliates-enterprise/affiliates-enterprise.php', $active_plugins );
		$events_manager_is_active = in_array( 'events-manager/events-manager.php', $active_plugins );
		$events_manager_pro_is_active = in_array( 'events-manager-pro/events-manager-pro.php', $active_plugins );
		$affiliates_events_manager_light_is_active = in_array( 'affiliates-events-manager-light/affiliates-events-manager-light.php', $active_plugins );
		if ( !$affiliates_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( '<strong>Affiliates Events Manager Integration</strong> plugin requires an appropriate Affiliates plugin to be activated: <a href="https://wordpress.org/plugins/affiliates/" target="_blank">Affiliates</a> or <a href="https://www.itthinx.com/plugins/affiliates-pro/" target="_blank">Affiliates Pro</a> or <a href="https://www.itthinx.com/plugins/affiliates-enterprise/" target="_blank">Affiliates Enterprise</a>.', 'affiliates-events-manager' ) . '</div>';
		}
		if ( !$events_manager_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( 'The <strong>Affiliates Events Manager Integration</strong> plugin requires the <a href="https://wordpress.org/plugins/events-manager/">Events Manager</a> plugin to be activated.', 'affiliates-events-manager' ) . '</div>';
		}
		if ( $affiliates_events_manager_light_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( 'You do not need to use the <strong>Affiliates Events Manager Integration Light</strong> plugin because you are already using the advanced Affiliates Events Manager Integration plugin. Please deactivate the <strong>Affiliates Events Manager Integration Light</strong> plugin now.', 'affiliates-events-manager' ) . '</div>';
		}
		if ( !$affiliates_is_active || !$events_manager_is_active || $affiliates_events_manager_light_is_active ) {
			if ( $disable ) {
				include_once  ABSPATH . 'wp-admin/includes/plugin.php' ;
				if ( function_exists( 'deactivate_plugins' ) ) {
					deactivate_plugins( array( __FILE__ ) );
				}
			}
			$verified = false;
		}

		if ( $verified ) {
			add_action( 'init', array( __CLASS__, 'wp_init' ) );
			add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) );
			add_action( 'em_bookings_added', array( __CLASS__, 'em_bookings_added' ) );
			add_filter( 'em_booking_set_status', array( __CLASS__, 'em_booking_set_status' ), 10, 2 );
			add_filter( 'em_booking_delete', array( __CLASS__, 'em_booking_delete' ), 10, 2 );
			// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ), self::JS_FILTER_PRIORITY );

			$options = get_option( self::PLUGIN_OPTIONS , array() );
			$toggle_booking_rates = isset( $options[self::ENABLE_BOOKING_RATES] ) ? $options[self::ENABLE_BOOKING_RATES] : self::DEFAULT_TOGGLE;
			if ( $toggle_booking_rates && class_exists( 'Affiliates_Referral_WordPress' ) ) {
				if ( is_admin() ) {
					require_once  'class-affiliates-em-booking.php' ;
				}
				require_once  'class-affiliates-em-method.php' ;
			}

		}
	}

	/**
	 * Adds a submenu item to the Affiliates menu for the Events Manager integration options.
	 *
	 * @param string $pages
	 */
	public static function affiliates_admin_menu( $pages ) {
		$page = add_submenu_page(
			'affiliates-admin',
			__( 'Affiliates Events Manager Integration', 'affiliates-events-manager' ),
			__( 'Events Manager Integration', 'affiliates-events-manager' ),
			AFFILIATES_ADMINISTER_OPTIONS,
			'affiliates-events-manager',
			array( __CLASS__, 'affiliates_admin_em' )
		);
		$pages[] = $page;
		add_action( 'admin_print_styles-' . $page, 'affiliates_admin_print_styles' );
		add_action( 'admin_print_scripts-' . $page, 'affiliates_admin_print_scripts' );
	}

	/**
	 * Affiliates Events Manager Integration : admin section.
	 */
	public static function affiliates_admin_em() {
		$output = '';
		if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
			wp_die( esc_html__( '拒絕訪問。', 'affiliates-events-manager' ) );
		}
		$options = get_option( self::PLUGIN_OPTIONS , array() );
		if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST[self::NONCE], self::SET_ADMIN_OPTIONS ) ) {
				$options[self::REFERRAL_RATE]               = floatval( $_POST[self::REFERRAL_RATE] );
				$options[self::BOOKING_CANCELLED]           = !empty( $_POST[self::BOOKING_CANCELLED] );
				$options[self::BOOKING_APPROVED]            = !empty( $_POST[self::BOOKING_APPROVED] );
				$options[self::BOOKING_REJECTED]            = !empty( $_POST[self::BOOKING_REJECTED] );
				$options[self::BOOKING_UNAPPROVED]          = !empty( $_POST[self::BOOKING_UNAPPROVED] );
				$options[self::BOOKING_AWAITING_PAYMENT]    = !empty( $_POST[self::BOOKING_AWAITING_PAYMENT] );
				$options[self::ENABLE_BOOKING_RATES]        = !empty( $_POST[self::ENABLE_BOOKING_RATES] );
				$options[self::ENABLE_RECURRING_REFERRALS]  = !empty( $_POST[self::ENABLE_RECURRING_REFERRALS] );
				$options[self::RECURRING_REFERRALS_TIMEOUT] = !empty( $_POST[self::RECURRING_REFERRALS_TIMEOUT] ) ? intval( $_POST[self::RECURRING_REFERRALS_TIMEOUT] ) : self::DEFAULT_ZERO_VALUE ;

				if ( $options[self::REFERRAL_RATE] > 1.0 ) {
					$options[self::REFERRAL_RATE] = 1.0;
				} else if ( $options[self::REFERRAL_RATE] < 0 ) {
					$options[self::REFERRAL_RATE] = 0.0;
				}

				if ( $options[self::RECURRING_REFERRALS_TIMEOUT] < 0 ) {
					$options[self::RECURRING_REFERRALS_TIMEOUT] = 0;
				}

			}
			update_option( self::PLUGIN_OPTIONS, $options );
		}

		$referral_rate                  = isset( $options[self::REFERRAL_RATE ] ) ? $options[self::REFERRAL_RATE] : self::DEFAULT_ZERO_VALUE;
		$auto_cancelled                 = isset( $options[self::BOOKING_CANCELLED ] ) ? $options[self::BOOKING_CANCELLED] : self::BOOKING_STATUS_DEFAULT;
		$auto_approved                  = isset( $options[self::BOOKING_APPROVED ] ) ? $options[self::BOOKING_APPROVED] : self::BOOKING_STATUS_DEFAULT;
		$auto_rejected                  = isset( $options[self::BOOKING_REJECTED ] ) ? $options[self::BOOKING_REJECTED] : self::BOOKING_STATUS_DEFAULT;
		$auto_unapproved                = isset( $options[self::BOOKING_UNAPPROVED ] ) ? $options[self::BOOKING_UNAPPROVED] : self::BOOKING_STATUS_DEFAULT;
		$auto_awaiting_payment          = isset( $options[self::BOOKING_AWAITING_PAYMENT ] ) ? $options[self::BOOKING_AWAITING_PAYMENT] : self::BOOKING_STATUS_DEFAULT;
		$enable_booking_rates           = isset( $options[self::ENABLE_BOOKING_RATES ] ) ? $options[self::ENABLE_BOOKING_RATES] : self::DEFAULT_TOGGLE;
		$enable_recurring_referrals     = isset( $options[self::ENABLE_RECURRING_REFERRALS ] ) ? $options[self::ENABLE_RECURRING_REFERRALS] : self::DEFAULT_TOGGLE;
		$recurring_referrals_timeout    = isset( $options[self::RECURRING_REFERRALS_TIMEOUT ] ) ? $options[self::RECURRING_REFERRALS_TIMEOUT ] : self::DEFAULT_ZERO_VALUE;

		$output = '<div><h2>' . esc_html__( 'Affiliates Events Manager Integration', 'affiliates-events-manager' ) . '</h2></div>';
		$output .= '<div>';
		$output .= '<form action="" name="options" method="post">';

		if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
			$output .= '<h3>' . esc_html__( 'Auto-adjustments of referrals', 'affiliates-events-manager' ) . '</h3>';
			$output .=
				'<p>' .
				wp_kses(
					__( 'The default referral status as determined in <em>Settings > Referrals</em> applies unless the following are enabled.', 'affiliates-events-manager' ),
					array(
						'em' => array()
					)
				) .
				'</p>';
			$output .= '<h4>' . esc_html__( 'Cancelled Bookings', 'affiliates-events-manager' ) . '</h4>';
			$output .= '<p>';
			$output .= '<input name="' . esc_attr( self::BOOKING_CANCELLED ) . '" type="checkbox" ' . ( $auto_cancelled ? ' checked="checked" ' : '' ) . ' />';
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::BOOKING_CANCELLED ) . '">' . esc_html__( 'Auto-adjust referral status when a booking is cancelled', 'affiliates-events-manager' ) . '</label>';
			$output .= '</p>';
			$output .= '<p class="description">' . esc_html__( 'The referrals related to the booking will be rejected automatically, unless they are closed.', 'affiliates-events-manager' ) . '</p>';
			$output .= '<h4>' . esc_html__( 'Approved Bookings', 'affiliates-events-manager' ) . '</h4>';
			$output .= '<p>';
			$output .= '<input name="' . esc_attr( self::BOOKING_APPROVED ) . '" type="checkbox" ' . ( $auto_approved ? ' checked="checked" ' : '' ) . ' />';
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::BOOKING_APPROVED ) . '">' . esc_html__( 'Auto-adjust referral status when a booking is approved', 'affiliates-events-manager' ) . '</label>';
			$output .= '</p>';
			$output .= '<p class="description">' . esc_html__( 'The referrals related to the booking will be accepted automatically, unless they are closed.', 'affiliates-events-manager' ) . '</p>';
			$output .= '<h4>' . esc_html__( 'Rejected Bookings', 'affiliates-events-manager' ) . '</h4>';
			$output .= '<p>';
			$output .= '<input name="' . esc_attr( self::BOOKING_REJECTED ) . '" type="checkbox" ' . ( $auto_rejected ? ' checked="checked" ' : '' ) . ' />';
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::BOOKING_REJECTED ) . '">' . esc_html__( 'Auto-adjust referral status when a booking is rejected', 'affiliates-events-manager' ) . '</label>';
			$output .= '</p>';
			$output .= '<p class="description">' . esc_html__( 'The referrals related to the booking will be rejected automatically, unless they are closed.', 'affiliates-events-manager' ) . '</p>';
			$output .= '<h4>' . esc_html__( 'Bookings Awaiting Approval', 'affiliates-events-manager' ) . '</h4>';
			$output .= '<p>';
			$output .= '<input name="' . esc_attr( self::BOOKING_UNAPPROVED ) . '" type="checkbox" ' . ( $auto_unapproved ? ' checked="checked" ' : '' ) . ' />';
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::BOOKING_UNAPPROVED ) . '">' . esc_html__( 'Auto-adjust referral status when a booking is unapproved', 'affiliates-events-manager' ) . '</label>';
			$output .= '</p>';
			$output .= '<p class="description">' . esc_html__( 'The referrals related to the booking will automatically be marked as pending, unless they are closed.', 'affiliates-events-manager' ) . '</p>';
			$output .= '<h4>' . esc_html__( 'Bookings Awaiting Payment', 'affiliates-events-manager' ) . '</h4>';
			$output .= '<p>';
			$output .= '<input name="' . esc_attr( self::BOOKING_AWAITING_PAYMENT ) . '" type="checkbox" ' . ( $auto_awaiting_payment ? ' checked="checked" ' : '' ) . ' />';
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::BOOKING_AWAITING_PAYMENT ) . '">' . esc_html__( 'Auto-adjust referral status when a booking is awaiting payment', 'affiliates-events-manager' ) . '</label>';
			$output .= '</p>';
			$output .= '<p class="description">' . esc_html__( 'The referrals related to the booking will automatically be marked as pending, unless they are closed.', 'affiliates-events-manager' ) . '</p>';
			$output .= '<div>';
			$output .= '<h3>' . esc_html__( 'Booking Rates', 'affiliates-events-manager' ) . '</h3>';
			$output .= '<p>';
			$output .= '<label>';
			$output .= sprintf( '<input name="%s" type="checkbox" %s />', esc_attr( self::ENABLE_BOOKING_RATES ), $enable_booking_rates ? ' checked="checked" ' : '' );
			$output .= '&nbsp;';
			$output .= esc_html__( 'Enable event booking referral rates', 'affiliates-events-manager' );
			$output .= '</label>';
			$output .= '<br/>';
			$output .= '<span class="description">';
			$output .= esc_html__( 'When this option is enabled, you can set referral rates for event bookings.', 'affiliates-events-manager' );
			$output .= ' ';
			$output .=
				wp_kses(
					__( 'The rate can be set when editing an event, under <strong>Event Content > Affiliates Booking Referral Rate</strong>.', 'affiliates-events-manager' ),
					array(
						'strong' => array()
					)
				);
			$output .= '<br/>';
			$output .=
				wp_kses(
					__( '<strong>Important</strong> : Note that you <strong>must</strong> choose the <code>Affiliates_EM_Method::event_booking_rates</code> method under <strong>Affiliates > Settings > Commissions</strong> for booking rates to be applied in general, or specify that method as an attribute for individual affiliates - otherwise the event booking rates will <strong>not</strong> apply.', 'affiliates-events-manager' ),
					array(
						'strong' => array()
					)
				);
		} else {
			$output .= '<h3>' . esc_html__( '推薦率', 'affiliates-events-manager' ) . '</h3>';
		}
		$output .= '</span>';
		$output .= '</p>';
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( self::REFERRAL_RATE ) . '">' . esc_html__( 'Default rate', 'affiliates-events-manager' ) . '</label>';
		$output .= '&nbsp;';
		$output .= '<input name="' . esc_attr( self::REFERRAL_RATE ) . '" type="text" value="' . esc_attr( $referral_rate ) . '"/>';
		$output .= '</p>';
		$output .= '<p>';
		$output .= esc_html__( 'The referral rate determines the referral amount based on the net sale made.', 'affiliates-events-manager' );
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

		if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
			$output .= '<h3>' . esc_html__( 'Recurring Referrals', 'affiliates-events-manager' ) . '</h3>';
			$output .= '<p>';
			$output .= '&nbsp;';
			$output .= sprintf( '<input name="%s" type="checkbox" %s />', esc_attr( self::ENABLE_RECURRING_REFERRALS ), $enable_recurring_referrals ? ' checked="checked" ' : '' );
			$output .= '&nbsp;';
			$output .= '<label for="' . esc_attr( self::ENABLE_RECURRING_REFERRALS ) . '">' . esc_html__( 'Enable recurring referrals', 'affiliates-events-manager' ) . '</label>';
			$output .= '<br/>';
			$output .= '<span class="description">';
			$output .= esc_html__( 'When this option is enabled, referrals on recurring events bookings by the same user, are credited to the affiliate who referred the initial recurring event.', 'affiliates-events-manager' );
			$output .= ' ';
			$output .=
				wp_kses(
					__( 'This option works for <strong>Recurring Events</strong> which can be created through the Dashboard under <strong>Events > Recurring Events</strong>.', 'affiliates-events-manager' ),
					array(
						'strong' => array()
					)
				);
			$output .= ' ';
			$output .= esc_html__( 'A referral for the original order must exist and must not have been rejected.', 'affiliates-events-manager' );
			$output .= '</p>';
			$output .= '<p>';
			$output .= '<label for="' . esc_attr( self::RECURRING_REFERRALS_TIMEOUT ) . '">' . esc_html__( 'Limit / Timeout', 'affiliates-events-manager' ) . '</label>';
			$output .= '&nbsp;';
			$output .= '<input name="' . esc_attr( self::RECURRING_REFERRALS_TIMEOUT ) . '" type="text" value="' . esc_attr( $recurring_referrals_timeout ) . '"/>';
			$output .= '</p>';
			$output .= '<p>';
			$output .= '<span class="description">';
			$output .= esc_html__( 'If set to 0, there is no time limit for referrals on recurring payments granted to the initial affiliate. Any other number will limit new referrals for a recurring event to so many days after the initial referral.', 'affiliates-events-manager' );
			$output .= '</span>';
			$output .= '</p>';
		}

		$output .= '<p>';
		$output .= wp_nonce_field( self::SET_ADMIN_OPTIONS, self::NONCE, true, false );
		$output .= '<input type="submit" name="submit" value="' . esc_attr__( 'Save', 'affiliates-events-manager' ) . '"/>';
		$output .= '</p>';
		$output .= '</form>';
		$output .= '</div>';

		// @codingStandardsIgnoreStart
		echo $output;
		// @codingStandardsIgnoreEnd

		affiliates_footer();
	}

	/**
	 * Load translations.
	 */
	public static function wp_init() {
		load_plugin_textdomain( AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN, false, 'affiliates-events-manager/languages' );
	}

	/**
	 * Registers script.
	 * Currently not used.
	 */
	public static function wp_enqueue_scripts() {
		wp_register_script( 'affiliates-events-manager', AFFILIATES_EVENTS_MANAGER_PLUGIN_URL . '/js/affiliates-events-manager.js', array( 'jquery' ), AFFILIATES_EVENTS_MANAGER_VERSION, true );
	}

	/**
	 * Retrieve the current URL.
	 *
	 * @return string
	 */
	public static function get_url() {
		return ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	/**
	 * Record a referral for a new booking.
	 *
	 * @param EM_Booking $em_booking
	 * @param array $affiliate_ids
	 */
	public static function em_bookings_added( $em_booking, $affiliate_ids = null ) {

		$options = get_option( self::PLUGIN_OPTIONS , array() );
		$em_event = $em_booking->get_event();

		$booking_price = null;
		$coupon_affiliate_ids = null;
		if ( isset( $em_booking->booking_meta['coupon']['coupon_code'] ) ) {
			$booking_coupon = $em_booking->booking_meta['coupon']['coupon_code'];
			if ( isset( $em_booking->taxes ) ) {
				$booking_price = bcsub( $em_booking->price, $em_booking->taxes, affiliates_get_referral_amount_decimals() );
			}
			if ( class_exists( 'Affiliates_Attributes_WordPress' ) ) {
				if ( null !== Affiliates_Attributes_WordPress::get_affiliate_for_coupon( $booking_coupon ) ) {
					$coupon_affiliate_ids[] = Affiliates_Attributes_WordPress::get_affiliate_for_coupon( $booking_coupon );
				}
			}
		}

		$post_id     = $em_event->post_id;
		$description = sprintf( __( 'Booking %d', 'affiliates-events-manager' ), $em_booking->booking_id );
		$currency    = get_option( 'dbem_bookings_currency' );
		$price       = isset( $booking_price ) ? $booking_price : $em_booking->get_price_pre_taxes();
		$status      = self::get_referral_status( $em_booking );

		$data = array(
			'booking_id' => array(
				'title' => 'Booking #',
				'domain' => AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN,
				'value' => esc_sql( $em_booking->booking_id )
			),
			'booking_total' => array(
				'title' => 'Total',
				'domain' => AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN,
				'value' => esc_sql( $price )
			),
			'booking_currency' => array(
				'title' => 'Currency',
				'domain' => AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN,
				'value' => esc_sql( $currency )
			),
			'booking_link' => array(
				'title' => 'Booking',
				'domain' => AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN,
				'value' => esc_sql(
					sprintf(
						'<a href="%s">%s</a>',
						$em_booking->get_admin_url(),
						__( 'View', 'affiliates-events-manager' )
					)
				)
			)
		);

		if ( !is_null( $em_event->recurrence_id ) ) {
			$recurring = self::affiliates_recurring_referrals( $em_booking );
			if ( !is_null( $recurring ) ) {
				$affiliate_ids[] = $recurring;
			}
		}

		if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
			$r = new Affiliates_Referral_WordPress();
			if ( $affiliate_ids !== null ) {
				if ( count( $affiliate_ids ) > 0 ) {
					bcscale( affiliates_get_referral_amount_decimals() );
					$split_amount = bcdiv( $price, count( $affiliate_ids ) );
					$r->add_referrals( $affiliate_ids, $post_id, $description, $data, $split_amount, null, $currency, $status, 'booking', $em_booking->booking_id );
				}
			} else if ( isset( $coupon_affiliate_ids ) && count( $coupon_affiliate_ids ) > 0 ) {
				bcscale( affiliates_get_referral_amount_decimals() );
				$split_amount = bcdiv( $price, count( $coupon_affiliate_ids ) );
				$r->add_referrals( $coupon_affiliate_ids, $post_id, $description, $data, $split_amount, null, $currency, $status, 'booking', $em_booking->booking_id );
			} else {
				$r->evaluate( $post_id, $description, $data, $price, null, $currency, $status, 'booking', $em_booking->booking_id );
			}
		} else {
			$referral_rate = isset( $options[self::REFERRAL_RATE] ) ? $options[self::REFERRAL_RATE] : self::DEFAULT_ZERO_VALUE;
			$type          = 'booking';
			$amount        = bcmul( $referral_rate, $price, affiliates_get_referral_amount_decimals() );
			$status        = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
			$reference     = $em_booking->booking_id;
			$aff_id        = affiliates_suggest_referral( $post_id, $description, $data, $amount, $currency, $status, $type, $reference );
		}
	}

	/**
	 * Hooked on the status filter to update the related referral(s) based on the
	 * booking status.
	 *
	 * @param int $result
	 * @param EM_Booking $em_booking
	 * @return int
	 */
	public static function em_booking_set_status( $result, $em_booking ) {
		global $wpdb;
		if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
			$status = self::get_referral_status( $em_booking );
		} else {
			$status = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
		}
		$referrals_table = _affiliates_get_tablename( 'referrals' );
		if ( $referrals = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT DISTINCT referral_id FROM $referrals_table WHERE reference = %s AND type = %s AND status != %s",
				$em_booking->booking_id,
				self::REFERRAL_TYPE,
				AFFILIATES_REFERRAL_STATUS_CLOSED
			)
		) ) {
			foreach ( $referrals as $referral ) {
				$result = affiliates_update_referral(
					$referral->referral_id,
					array( 'status' => $status )
				);
			}
		}
		return $result;
	}

	/**
	 * Reject referrals for deleted bookings.
	 *
	 * @param boolean $result true if the booking has been deleted
	 * @param EM_Booking $em_booking
	 * @return boolean
	 */
	public static function em_booking_delete( $result, $em_booking ) {
		global $wpdb;
		if ( $result !== false ) {
			$status = AFFILIATES_REFERRAL_STATUS_REJECTED;
			$referrals_table = _affiliates_get_tablename( 'referrals' );
			if ( $referrals = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT referral_id FROM $referrals_table WHERE reference = %s AND type = %s AND status NOT IN (%s,%s)",
					$em_booking->booking_id,
					self::REFERRAL_TYPE,
					$status,
					AFFILIATES_REFERRAL_STATUS_CLOSED
				)
			) ) {
				foreach ( $referrals as $referral ) {
					affiliates_update_referral(
						$referral->referral_id,
						array( 'status' => $status )
					);
				}
			}
		}
		return $result;
	}

	/**
	 * Returns the corresponding referral status for a booking, based
	 * on the booking's current status.
	 *
	 * @param EM_Booking $em_booking
	 * @return int
	 */
	private static function get_referral_status( $em_booking ) {
		$options = get_option( self::PLUGIN_OPTIONS , array() );
		$auto_cancelled         = isset( $options[self::BOOKING_CANCELLED ] ) ? $options[self::BOOKING_CANCELLED] : self::BOOKING_STATUS_DEFAULT;
		$auto_approved          = isset( $options[self::BOOKING_APPROVED ] ) ? $options[self::BOOKING_APPROVED] : self::BOOKING_STATUS_DEFAULT;
		$auto_rejected          = isset( $options[self::BOOKING_REJECTED ] ) ? $options[self::BOOKING_REJECTED] : self::BOOKING_STATUS_DEFAULT;
		$auto_unapproved        = isset( $options[self::BOOKING_UNAPPROVED ] ) ? $options[self::BOOKING_UNAPPROVED] : self::BOOKING_STATUS_DEFAULT;
		$auto_awaiting_payment  = isset( $options[self::BOOKING_AWAITING_PAYMENT ] ) ? $options[self::BOOKING_AWAITING_PAYMENT] : self::BOOKING_STATUS_DEFAULT;

		if ( isset( $em_booking->booking_status ) ) {
			switch ( $em_booking->booking_status ) {
				case self::BOOKING_STATUS_UNAPPROVED :
				case self::BOOKING_STATUS_AWAITING_PAYMENT :
				case self::BOOKING_STATUS_AWAITING_ONLINE_PAYMENT :
					if ( $auto_unapproved || $auto_awaiting_payment ) {
						$status = AFFILIATES_REFERRAL_STATUS_PENDING;
						break;
					}
				case self::BOOKING_STATUS_APPROVED :
					if ( $auto_approved ) {
						$status = AFFILIATES_REFERRAL_STATUS_ACCEPTED;
						break;
					}
				case self::BOOKING_STATUS_REJECTED :
				case self::BOOKING_STATUS_CANCELLED :
					if ( $auto_cancelled || $auto_rejected ) {
						$status = AFFILIATES_REFERRAL_STATUS_REJECTED;
						break;
					}
				default :
					$status = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
			}
		} else {
			$status = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
		}
		return $status;
	}

	/**
	 * Checks if the user booking an event has another
	 * booking that stored a referral
	 *
	 * @param EM_Booking $em_booking
	 * @return int affiliate_id or null
	 */
	public static function affiliates_recurring_referrals( $em_booking ) {
		global $affiliates_db;

		$recurring_affiliate_id = null;

		$options = get_option( self::PLUGIN_OPTIONS , array() );
		$enable_recurring_referrals = isset( $options[self::ENABLE_RECURRING_REFERRALS ] ) ? $options[self::ENABLE_RECURRING_REFERRALS] : self::DEFAULT_TOGGLE;
		$recurring_referrals_timeout = isset( $options[self::RECURRING_REFERRALS_TIMEOUT] ) ? $options[self::RECURRING_REFERRALS_TIMEOUT] : self::DEFAULT_ZERO_VALUE;

		if ( $enable_recurring_referrals ) {

			if ( $recurring_referrals_timeout >= 0 ) {
				$em_booking_user_id = $em_booking->person_id;
				$recurring_em_event = $em_booking->get_event();
				$bookings_amount = 0;

				if ( $recurring_em_event->is_recurring() ) {
					$main_event_id = $recurring_em_event->get_id();
				} else {
					$main_event_id = $recurring_em_event->recurrence_id;
				}

				// if $main_event_id doesn't exist then the event is not recurring
				if ( !is_null( $main_event_id ) ) {
					$search_attributes = array(
						'recurrence_id' => $main_event_id,
						'bookings'      => true, // events with bookings enabled
						'status'        => 1, // approved events only
					);

					$recurring_events = EM_Events::get( $search_attributes );
					if ( is_array( $recurring_events ) && count( $recurring_events ) > 0 ) {
						foreach ( $recurring_events as $recurring_event ) {
							$booked_events[] = $recurring_event->get_bookings( false );
						}

						foreach ( $booked_events as $b ) {
							if ( !empty( $b->bookings ) ) {
								$key = $b->bookings[0]->booking_id;
								$booked_recurring_events[$key] = $b->event_id;
							}
						}
						if ( is_array( $booked_recurring_events ) && count( $booked_recurring_events ) > 1 ) {

							$stored_em_booking_id = null;
							$stored_em_booking_user_id = null;
							$referrals_table = $affiliates_db->get_tablename( 'referrals' );
							$stored_referrals = $affiliates_db->get_objects( "SELECT affiliate_id, reference, data, datetime FROM $referrals_table WHERE type = 'booking' AND status = %s ORDER BY 'datetime' ", AFFILIATES_REFERRAL_STATUS_ACCEPTED );

							if ( count( $stored_referrals ) > 0 ) {

								foreach ( $stored_referrals as $stored_referral ) {
									$referral_dt = $stored_referral->datetime;
									$data = $stored_referral->data;
									if ( is_array( $data ) ) {
										foreach ( $data as $d => $info ) {
											if ( $d == 'booking' ) {
												$stored_em_booking_id = $info;
											}
											break;
										}
									} else {
										$data = maybe_unserialize( $data );
										foreach ( $data as $key => $value ) {
											if ( $key == 'booking' ) {
												$stored_em_booking_id = $value;
											}
											break;
										}
									}

									$stored_em_booking = em_get_booking( $stored_em_booking_id );
									$stored_em_booking_user_id = $stored_em_booking->person_id;
									$referral_datetime = '';
									$current_datetime = '';
									$recurring_affiliate_id = null;

									/**
									 * If the booking is recorded by a user who already has
									 * a stored booking, get the affiliate id from the stored
									 * booking
									 */
									if ( $em_booking_user_id == $stored_em_booking_user_id ) {

										$current_dt = date( 'Y-m-d H:i:s' );
										$referral_datetime = new DateTime( $referral_dt );
										$current_datetime = new DateTime( $current_datetime );
										$interval = $referral_datetime->diff( $current_datetime );
										$days_interval = $interval->format( '%a' );
										if ( intval( $days_interval ) <= $recurring_referrals_timeout ) {
											$recurring_affiliate_id = $stored_referral->affiliate_id;
											break;
										}
									}
								}
							}
						} // booked_recurring_events
					} // recurring_events
				}
			}
		}
		return $recurring_affiliate_id;
	}
}

Affiliates_Events_Manager::init();
