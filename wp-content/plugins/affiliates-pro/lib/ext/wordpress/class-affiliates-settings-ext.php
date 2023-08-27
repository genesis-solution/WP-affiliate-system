<?php
/**
 * class-affiliates-settings-ext.php
 *
 * Copyright (c) 2015 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates-pro
 * @since affiliates-pro 2.8.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extended settings.
 */
class Affiliates_Settings_Ext {

	public static function init() { add_filter( 'affiliates_setup_buttons', array( __CLASS__, 'affiliates_setup_buttons' ) ); }

	public static function affiliates_setup_buttons( $buttons ) { $buttons['commissions'] = sprintf ( '<a href="%s" class="button-primary">%s</a>', add_query_arg( 'section', 'commissions', admin_url( 'admin.php?page=affiliates-admin-settings' ) ), __( 'Set up Commissions', AFFILIATES_PLUGIN_DOMAIN ) ); $buttons['banners'] = sprintf ( '<a href="%s" class="button-primary">%s</a>', add_query_arg( 'section', 'banners', admin_url( 'edit.php??post_type=affiliates_banner' ) ), __( 'Upload Banners', AFFILIATES_PLUGIN_DOMAIN ) ); $buttons['notifications'] = sprintf ( '<a href="%s" class="button-primary">%s</a>', add_query_arg( 'section', 'notifications', admin_url( 'admin.php?page=affiliates-admin-notifications' ) ), __( 'Enable Notifications', AFFILIATES_PLUGIN_DOMAIN ) ); return $buttons; }

}
Affiliates_Settings_Ext::init();
