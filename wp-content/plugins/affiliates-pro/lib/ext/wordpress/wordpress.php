<?php
/**
 * wordpress.php
 *
 * Copyright 2011 "kento" Karim Rahimpur - www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

include_once dirname( __FILE__ ) . '/class-affiliates-database-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate-profile-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-attributes-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-referral-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliates-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-totals-wordpress.php';

include_once dirname( __FILE__ ) . '/class-affiliates-admin-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-admin-menu-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-settings-ext.php';
include_once dirname( __FILE__ ) . '/class-affiliates-settings-integrations-ext.php';

include_once dirname( __FILE__ ) . '/class-affiliates-graph-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-link-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-stats-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-traffic-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-url-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate-stats-renderer-wordpress.php';
include_once dirname( __FILE__ ) . '/class-affiliates-banner.php';

include_once dirname( __FILE__ ) . '/class-affiliates-rates-table-renderer.php';
include_once dirname( __FILE__ ) . '/class-affiliates-rates-wordpress.php';

include_once dirname( __FILE__ ) . '/class-affiliates-admin-referral-ext.php';
