<?php
/**
 * affiliates-woocommerce-light.php
 *
 * Copyright (c) 2012-2023 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates-woocommerce-light
 * @since affiliates-woocommerce-light 1.0.0
 *
 * Plugin Name: Affiliates WooCommerce Light
 * Plugin URI: https://www.itthinx.com/plugins/affiliates-woocommerce-light/
 * Description: Grow your Business with your own Affiliate Network and let your partners earn commissions on referred sales. Integrates Affiliates and WooCommerce.
 * Version: 2.1.0
 * WC requires at least: 7.4
 * WC tested up to: 7.9
 * Author: itthinx
 * Author URI: https://www.itthinx.com/
 * Donate-Link: https://www.itthinx.com/shop/
 * Text Domain: affiliates-woocommerce-light
 * Domain Path: /languages
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Light integration for WooCommerce.
 */
class Affiliates_WooCommerce_Light_Integration {

	/**
	 * Shop order post type
	 *
	 * @var string
	 */
	const SHOP_ORDER_POST_TYPE  = 'shop_order';

	/**
	 * Plugin options key
	 *
	 * @var string
	 */
	const PLUGIN_OPTIONS        = 'affiliates_woocommerce_light';

	/**
	 * @var boolean
	 */
	const AUTO_ADJUST_DEFAULT   = true;

	/**
	 * @var string
	 */
	const NONCE                 = 'aff_woo_light_admin_nonce';

	/**
	 * @var string
	 */
	const SET_ADMIN_OPTIONS     = 'set_admin_options';

	/**
	 * @var string
	 */
	const REFERRAL_RATE         = 'referral-rate';

	/**
	 * @var string
	 */
	const REFERRAL_RATE_DEFAULT = '0';

	/**
	 * @var string
	 */
	const USAGE_STATS           = 'usage_stats';

	/**
	 * @var boolean
	 */
	const USAGE_STATS_DEFAULT   = true;

	/**
	 * Links to posts of type shop_order will be modified only on these admin pages.
	 *
	 * @var array
	 */
	private static $shop_order_link_modify_pages = array(
		'affiliates-admin-referrals',
		'affiliates-admin-hits',
		'affiliates-admin-hits-affiliate'
	);

	/**
	 * Holds messages to render on the back end.
	 *
	 * @var array
	 */
	private static $admin_messages = array();

	/**
	 * Plugin status
	 *
	 * @var array
	 */
	private static $plugins = array();

	/**
	 * Prints admin notices.
	 */
	public static function admin_notices() {
		if ( !empty( self::$admin_messages ) ) {
			foreach ( self::$admin_messages as $msg ) {
				echo $msg;
			}
		}
	}

	/**
	 * Checks dependencies and adds appropriate actions and filters.
	 */
	public static function init() {

		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );

		$verified = true;
		$disable = false;
		$affiliates_is_active = self::is_active( 'affiliates/affiliates.php' ) || self::is_active( 'affiliates-pro/affiliates-pro.php' ) || self::is_active( 'affiliates-enterprise/affiliates-enterprise.php' );
		$woocommerce_is_active = self::is_active( 'woocommerce/woocommerce.php' );
		$affiliates_woocommerce_is_active = self::is_active( 'affiliates-woocommerce/affiliates-woocommerce.php' );
		if ( !$affiliates_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( 'The <strong>Affiliates WooCommerce Integration Light</strong> plugin requires the <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a> plugin.', 'affiliates-woocommerce-light' ) . "</div>";
		}
		if ( !$woocommerce_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( 'The <strong>Affiliates WooCommerce Integration Light</strong> plugin requires the <a href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a> plugin to be activated.', 'affiliates-woocommerce-light' ) . "</div>";
		}
		if ( $affiliates_woocommerce_is_active ) {
			self::$admin_messages[] = "<div class='error'>" . __( 'You do not need to use the <srtrong>Affiliates WooCommerce Integration Light</strong> plugin because you are already using the advanced Affiliates WooCommerce Integration plugin. Please deactivate the <strong>Affiliates WooCommerce Integration Light</strong> plugin now.', 'affiliates-woocommerce-light' ) . "</div>";
		}
		if ( !$affiliates_is_active || !$woocommerce_is_active || $affiliates_woocommerce_is_active ) {
			if ( $disable ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				deactivate_plugins( array( __FILE__ ) );
			}
			$verified = false;
		}

		if ( $verified ) {
			load_plugin_textdomain( 'affiliates-woocommerce-light', null, 'affiliates-woocommerce-light' . '/languages' );
			add_action ( 'woocommerce_checkout_order_processed', array( __CLASS__, 'woocommerce_checkout_order_processed' ), 10, 3 );
			if ( function_exists( 'affiliates_get_referral_post_permalink' ) ) {
				add_filter( 'affiliates_referral_post_permalink', array( __CLASS__, 'affiliates_referral_post_permalink' ), 10, 2 );
			} else {
				add_filter( 'post_type_link', array( __CLASS__, 'post_type_link' ), 10, 4 );
			}
			if ( function_exists( 'affiliates_get_referral_post_title' ) ) {
				add_filter( 'affiliates_referral_post_title', array( __CLASS__, 'affiliates_referral_post_title' ), 10, 2 );
			}
			add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) );
			add_filter( 'affiliates_footer', array( __CLASS__, 'affiliates_footer' ) );
			add_filter( 'affiliates_setup_buttons', array( __CLASS__, 'affiliates_setup_buttons' ) );
		}
	}

	/**
	 * Check whether the plugin is active.
	 *
	 * @return boolean
	 */
	public static function is_active( $plugin ) {
		if ( !isset( self::$plugins[$plugin] ) ) {
			self::$plugins[$plugin] = false;
			if ( function_exists( 'wp_get_active_and_valid_plugins' ) ) {
				$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . $plugin;
				$active_plugin_paths = wp_get_active_and_valid_plugins();
				self::$plugins[$plugin] = in_array( $plugin_path, $active_plugin_paths );
				if ( !self::$plugins[$plugin] && is_multisite() && function_exists( 'wp_get_active_network_plugins' ) ) {
					$active_network_plugin_paths = wp_get_active_network_plugins();
					self::$plugins[$plugin] = in_array( $plugin_path, $active_network_plugin_paths );
				}
			} else {
				$active_plugins = get_option( 'active_plugins', array() );
				if ( is_multisite() ) {
					$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
					$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
					$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
				}
				self::$plugins[$plugin] = in_array( $plugin, $active_plugins );
			}
		}
		return self::$plugins[$plugin];
	}

	/**
	 * Add a setup hint button.
	 *
	 * @param array $buttons
	 *
	 * @return array
	 */
	public static function affiliates_setup_buttons( $buttons ) {
		$buttons['affiliates-woocommerce-light'] = sprintf (
			'<a href="%s" class="button-primary">%s</a>',
			add_query_arg( 'section', 'affiliates-woocommerce-light', admin_url( 'admin.php?page=affiliates-admin-woocommerce-light' ) ),
			esc_html__( 'Set the Commission Rate', 'affiliates-woocommerce-light' )
		);
		return $buttons;
	}

	/**
	 * Adds a submenu item to the Affiliates menu for the WooCommerce integration options.
	 */
	public static function affiliates_admin_menu() {
		$page = add_submenu_page(
			'affiliates-admin',
			esc_html__( 'Affiliates WooCommerce Integration Light', 'affiliates-woocommerce-light' ),
			esc_html__( 'WooCommerce Integration Light', 'affiliates-woocommerce-light' ),
			AFFILIATES_ADMINISTER_OPTIONS,
			'affiliates-admin-woocommerce-light',
			array( __CLASS__, 'affiliates_admin_woocommerce_light' )
		);
		// $pages[] = $page;
		add_action( 'admin_print_styles-' . $page, 'affiliates_admin_print_styles' );
		add_action( 'admin_print_scripts-' . $page, 'affiliates_admin_print_scripts' );
	}

	/**
	 * Affiliates WooCommerce Integration Light : admin section.
	 */
	public static function affiliates_admin_woocommerce_light() {
		$output = '';
		if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
			wp_die( esc_html__( '拒絕訪問。', 'affiliates-woocommerce-light' ) );
		}
		$options = get_option( self::PLUGIN_OPTIONS , array() );
		if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST[self::NONCE], self::SET_ADMIN_OPTIONS ) ) {
				$options[self::REFERRAL_RATE]  = floatval( $_POST[self::REFERRAL_RATE] );
				if ( $options[self::REFERRAL_RATE] > 1.0 ) {
					$options[self::REFERRAL_RATE] = 1.0;
				} else if ( $options[self::REFERRAL_RATE] < 0 ) {
					$options[self::REFERRAL_RATE] = 0.0;
				}
				$options[self::USAGE_STATS] = !empty( $_POST[self::USAGE_STATS] );
			}
			update_option( self::PLUGIN_OPTIONS, $options );
		}

		$referral_rate = isset( $options[self::REFERRAL_RATE] ) ? $options[self::REFERRAL_RATE] : self::REFERRAL_RATE_DEFAULT;
		$usage_stats   = isset( $options[self::USAGE_STATS] ) ? $options[self::USAGE_STATS] : self::USAGE_STATS_DEFAULT;

		$output .= '<h2>';
		$output .= esc_html__( 'Affiliates WooCommerce Integration Light', 'affiliates-woocommerce-light' );
		$output .= '</h2>';

//		$output .= '<p class="manage" style="border:2px solid #00a651;padding:1em;margin-right:1em;font-weight:bold;font-size:1em;line-height:1.62em">';
//		$output .= wp_kses(
//			sprintf(
//				__( 'Get additional features with <a href="%s" target="_blank">%s</a> and <a href="%s" target="_blank">%s</a>!', 'affiliates-woocommerce-light' ),
//				'https://www.itthinx.com/shop/affiliates-pro/',
//				'Affiliates Pro',
//				'https://www.itthinx.com/shop/affiliates-enterprise/',
//				'Affiliates Enterprise'
//			),
//			array( 'a' => array( 'href' => array(), 'target' => array() ) )
//		);
//		$output .= '</p>';

		$output .= '<div class="manage" style="padding:2em;margin-right:1em;">';
		$output .= '<form action="" name="options" method="post">';
		$output .= '<div>';
		$output .= '<h3>' . esc_html__( '推薦率', 'affiliates-woocommerce-light' ) . '</h3>';
		$output .= '<p>';
		$output .= '<label for="' . self::REFERRAL_RATE . '">' . esc_html__( 'Referral rate', 'affiliates-woocommerce-light') . '</label>';
		$output .= '&nbsp;';
		$output .= '<input name="' . self::REFERRAL_RATE . '" type="text" value="' . esc_attr( $referral_rate ) . '"/>';
		$output .= '</p>';
		$output .= '<p>';
		$output .= esc_html__( 'The referral rate determines the referral amount based on the net sale made.', 'affiliates-woocommerce-light' );
		$output .= '</p>';
		$output .= '<p class="description">';
		$output .= wp_kses(
			__( 'Example: Set the referral rate to <strong>0.1</strong> if you want your affiliates to get a <strong>10%</strong> commission on each sale.', 'affiliates-woocommerce-light' ),
			array( 'strong' => array() )
		);
		$output .= '</p>';

		$output .= '<h3>' . esc_html__( 'Usage stats', 'affiliates-woocommerce-light' ) . '</h3>';
		$output .= '<p>';
		$output .= '<input name="' . self::USAGE_STATS . '" type="checkbox" ' . ( $usage_stats ? ' checked="checked" ' : '' ) . '/>';
		$output .= ' ';
		$output .= '<label for="' . self::USAGE_STATS . '">' . esc_html__( 'Allow the plugin to provide usage stats.', 'affiliates-woocommerce-light' ) . '</label>';
		$output .= '<br/>';
		$output .= '<span class="description">' . esc_html__( 'This will allow the plugin to help in computing how many installations are actually using it. No personal or site data is transmitted, this simply embeds an icon on the bottom of the Affiliates admin pages, so that the number of visits to these can be counted. This is useful to help prioritize development.', 'affiliates-woocommerce-light' ) . '</span>';
		$output .= '</p>';

		$output .= '<p>';
		$output .= wp_nonce_field( self::SET_ADMIN_OPTIONS, self::NONCE, true, false );
		$output .= '<input class="button-primary" type="submit" name="submit" value="' . esc_html__( 'Save', 'affiliates-woocommerce-light' ) . '"/>';
		$output .= '</p>';

		$output .= '</div>';
		$output .= '</form>';
		$output .= '</div>';

		echo $output;

	//	affiliates_footer();
	}

	/**
	 * Add a notice to the footer that the integration is active.
	 *
	 * @param string $footer
	 *
	 * @return string footer
	 */
	public static function affiliates_footer( $footer ) {
//		$options     = get_option( self::PLUGIN_OPTIONS , array() );
//		$usage_stats = isset( $options[self::USAGE_STATS] ) ? $options[self::USAGE_STATS] : self::USAGE_STATS_DEFAULT;
//		$protocol    = is_ssl() ? 'https://' : 'http://';
//		return
//			'<div style="font-size:0.9em">' .
//			'<p>' .
//			( $usage_stats ? sprintf( "<img src='%swww.itthinx.com/img/affiliates-woocommerce/affiliates-woocommerce-light.png' alt='Logo'/>", $protocol ) : '' ) .
//			wp_kses(
//				sprintf(
//					__( "Powered by <a href='%s' target='_blank'>itthinx.com</a>", 'affiliates-woocommerce-light' ),
//					'https://www.itthinx.com/shop/',
//					'itthinx'
//				),
//				array( 'a' => array( 'href' => array(), 'target' => array() ) )
//			) .
//			'</p>' .
//			'</div>' .
//			$footer;
        return "";
	}

	/**
	 * Filter to use the URL to edit the order.
	 *
	 * @since 2.0.0
	 *
	 * @param string $url
	 * @param array|object $referral
	 *
	 * @return string
	 */
	public static function affiliates_referral_post_permalink( $url, $referral ) {
		$data = null;
		if ( is_array( $referral ) && array_key_exists( 'data', $referral ) ) {
			$data = $referral['data'];
		} else if ( is_object( $referral ) && property_exists( $referral, 'data' ) ) {
			$data = $referral->data;
		}
		if ( $data !== null ) {
			if ( !empty( $data ) ) {
				$data = unserialize( $data );
				if ( is_array( $data ) ) {
					if ( array_key_exists( 'order_id', $data ) ) {
						$order_id_data = $data['order_id'];
						if (
							is_array( $order_id_data ) &&
							array_key_exists( 'domain', $order_id_data ) &&
							$order_id_data['domain'] === 'affiliates-woocommerce-light' &&
							array_key_exists( 'value', $order_id_data )
						) {
							$order = wc_get_order( $order_id_data['value'] );
							if ( $order instanceof WC_Order ) {
								if ( current_user_can( 'manage_woocommerce' ) ) {
									$url = $order->get_edit_order_url();
								}
							}
						}
					}
				}
			}
		}
		// A simpler way would be like this, but we could mistakenly modify links related to referrals from other integrations
		// if ( is_array( $referral ) && array_key_exists( 'post_id', $referral ) ) {
		// 	$order = wc_get_order( $referral['post_id'] );
		// 	if ( $order instanceof WC_Order ) {
		// 		$url = $order->get_edit_order_url();
		// 	}
		// }
		return $url;
	}

	/**
	 * Filter to display the order title.
	 *
	 * @param string $title
	 * @param array|object $referral
	 *
	 * @return string
	 */
	public static function affiliates_referral_post_title( $title, $referral ) {
		$data = null;
		if ( is_array( $referral ) && array_key_exists( 'data', $referral ) ) {
			$data = $referral['data'];
		} else if ( is_object( $referral ) && property_exists( $referral, 'data' ) ) {
			$data = $referral->data;
		}
		if ( $data !== null ) {
			if ( !empty( $data ) ) {
				$data = unserialize( $data );
				if ( is_array( $data ) ) {
					if ( array_key_exists( 'order_id', $data ) ) {
						$order_id_data = $data['order_id'];
						if (
							is_array( $order_id_data ) &&

							array_key_exists( 'domain', $order_id_data ) &&
							$order_id_data['domain'] === 'affiliates-woocommerce-light' &&
							array_key_exists( 'value', $order_id_data )
						) {
							$order = wc_get_order( $order_id_data['value'] );
							if ( $order instanceof WC_Order ) {
								if ( current_user_can( 'manage_woocommerce' ) ) {
									$title = sprintf( '%s #%s', esc_html( $order->get_title() ), esc_html( $order->get_order_number() ) );
								}
							}
						}
					}
				}
			}
		}
		return $title;
	}

	/**
	 * Returns an edit link for shop_order post types.
	 *
	 * @deprecated since 2.0.0
	 *
	 * @param string $post_link
	 * @param array $post
	 * @param boolean $leavename
	 * @param boolean $sample
	 *
	 * @return string link URL
	 */
	public static function post_type_link( $post_link, $post, $leavename, $sample ) {
		$url = $post_link;
		if (
			// right post type
			isset( $post->post_type) && ( $post->post_type == self::SHOP_ORDER_POST_TYPE ) &&
			// admin page
			is_admin() &&
			// right admin page
			isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], self::$shop_order_link_modify_pages ) &&
			// check link
			(
				( preg_match( "/" . self::SHOP_ORDER_POST_TYPE . "=([^&]*)/", $post_link, $matches ) === 1 ) && isset( $matches[1] ) && ( $matches[1] === $post->post_name )
				||
				( strpos( $post_link, 'post_type=' . self::SHOP_ORDER_POST_TYPE ) !== false ) && ( preg_match( '/p=([0-9]+)/', $post_link, $matches ) === 1 ) && isset( $matches[1] ) && ( $matches[1] == $post->ID )
			)
		) {
			$order = wc_get_order( $post->ID );
			if ( $order instanceof WC_Order ) {
				$url = $order->get_edit_order_url();
			}
		}
		return $url;
	}

	/**
	 * Make sure the shop_order type is in the $order_types array.
	 *
	 * @param array $order_types
	 * @param string $for
	 *
	 * @return array
	 */
	public static function wc_order_types( $order_types, $for ) {
		if ( !in_array( 'shop_order', $order_types ) ) {
			$order_types[] = 'shop_order';
		}
		return $order_types;
	}

	/**
	 * Record a referral when a new order has been processed.
	 *
	 * Note that we can't hook into the order process before(*), because
	 * the meta data would not have been added.
	 *
	 * (*) We could hook into woocommerce_checkout_update_order_meta but the
	 * 'coupons' meta data would not be there, so if we want to use it here at
	 * some point, woocommerce_checkout_order_processed is a better choice.
	 *
	 * @param int $order_id the post id of the order
	 * @param array $posted_data an array of data
	 * @param WC_Order $order the order object
	 */
	public static function woocommerce_checkout_order_processed( $order_id, $posted_data, $order ) {

		if ( !( $order instanceof WC_Order ) ) {
			return;
		}

		$currency = $order->get_currency();
		$order_subtotal = $order->get_subtotal();
		$discount = $order->get_total_discount();
		$order_subtotal -= $discount;
		if ( $order_subtotal < 0 ) {
			$order_subtotal = 0;
		}

		// Workaround to an issue observed as of WooCommerce 7.8.0: Invalid order type: shop_order during checkout with the $order->get_edit_order_url() call:
		add_filter( 'wc_order_types', array( __CLASS__, 'wc_order_types' ), 10, 2 );
		$edit_url = $order->get_edit_order_url();
		remove_filter( 'wc_order_types', array( __CLASS__, 'wc_order_types' ) );
		$order_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( $edit_url ),
			sprintf( esc_html__( 'Order #%s', 'affiliates-woocommerce-light' ), $order_id )
		);

		$data = array(
			'order_id' => array(
				'title' => 'Order #',
				'domain' => 'affiliates-woocommerce-light',
				'value' => esc_sql( $order_id )
			),
			'order_total' => array(
				'title' => 'Total',
				'domain' =>  'affiliates-woocommerce-light',
				'value' => esc_sql( $order_subtotal )
			),
			'order_currency' => array(
				'title' => 'Currency',
				'domain' =>  'affiliates-woocommerce-light',
				'value' => esc_sql( $currency )
			),
			'order_link' => array(
				'title' => 'Order',
				'domain' =>  'affiliates-woocommerce-light',
				'value' => esc_sql( $order_link )
			)
		);

		$options = get_option( self::PLUGIN_OPTIONS , array() );
		$referral_rate  = isset( $options[self::REFERRAL_RATE] ) ? $options[self::REFERRAL_RATE] : self::REFERRAL_RATE_DEFAULT;
		$amount = round( floatval( $referral_rate ) * floatval( $order_subtotal ), AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
		$description = sprintf( 'Order #%s', $order_id );
		affiliates_suggest_referral( $order_id, $description, $data, $amount, $currency );
	}
}

/**
 * Hooked on the plugins_loaded action to boot the plugin.
 */
function affiliates_woocommerce_light_plugins_loaded() {
	Affiliates_WooCommerce_Light_Integration::init();
}
add_action( 'plugins_loaded', 'affiliates_woocommerce_light_plugins_loaded' );

// @since 2.0.0 HPOS compatibility
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
