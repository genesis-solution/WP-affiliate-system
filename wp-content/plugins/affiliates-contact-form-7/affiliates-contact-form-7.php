<?php
/**
 * affiliates-contact-form-7.php
 *
 * Copyright (c) 2013-2022 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates-contact-form-7
 * @since affiliates-contact-form-7 3.0.0
 *
 * Plugin Name: Affiliates Contact Form 7 Integration
 * Plugin URI: https://www.itthinx.com/plugins/affiliates-contact-form-7/
 * Description: Integrates Affiliates, Affiliates Pro and Affiliates Enterprise with Contact Form 7
 * Author: itthinx
 * Author URI: https://www.itthinx.com/
 * License: GPLv3
 * Version: 5.3.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !defined( 'AFF_CF7_PLUGIN_DOMAIN' ) ) {
	define( 'AFF_CF7_PLUGIN_DOMAIN', 'affiliates-contact-form-7' );
}
if ( !defined( 'AFF_CF7_CURRENT_USER_FIELD' ) ) {
	define( 'AFF_CF7_CURRENT_USER_FIELD', 'affiliates_current_user_id' );
}

define( 'AFF_CF7_FILE', __FILE__ );

require_once 'includes/class-affiliates-cf7.php';
