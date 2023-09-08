<?php
/**
 * affiliates-events-manager.php
 *
 * Copyright (c) 2015 - 2022 www.itthinx.com
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
 * @since 1.0.0
 *
 * Plugin Name: Affiliates Events Manager
 * Plugin URI: https://www.itthinx.com/plugins/affiliates-events-manager/
 * Description: Integrates <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with <a href="https://wordpress.org/plugins/events-manager/">Events Manager</a>.
 * Author: itthinx, proaktion, gtsiokos
 * Author URI: https://www.itthinx.com/
 * Donate-Link: https://www.itthinx.com/shop/
 * License: GPLv3
 * Version: 3.2.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AFFILIATES_EVENTS_MANAGER_VERSION', '3.2.0' );

define( 'AFFILIATES_EVENTS_MANAGER_FILE', __FILE__ );
define( 'AFFILIATES_EVENTS_MANAGER_PLUGIN_DOMAIN', 'affiliates-events-manager' );

/**
 * Get loaded plugins
 */
function affiliates_events_manager_plugins_loaded() {
	if (
		defined( 'AFFILIATES_EXT_VERSION' ) &&
		version_compare( AFFILIATES_EXT_VERSION, '3.0.0' ) >= 0 &&
		class_exists( 'Affiliates_Referral' ) &&
		(
			!defined( 'Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY' ) ||
			!get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, null )
		)
	) {
		$lib = '/lib';
	} else {
		$lib = '/lib-2';
	}
	define( 'AFFILIATES_EVENTS_MANAGER_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
	define( 'AFFILIATES_EVENTS_MANAGER_LIB', AFFILIATES_EVENTS_MANAGER_DIR . $lib );
	define( 'AFFILIATES_EVENTS_MANAGER_PLUGIN_URL', plugins_url( 'affiliates-events-manager' ) );
	require_once AFFILIATES_EVENTS_MANAGER_LIB . '/class-affiliates-events-manager.php';
}
add_action( 'plugins_loaded', 'affiliates_events_manager_plugins_loaded' );
