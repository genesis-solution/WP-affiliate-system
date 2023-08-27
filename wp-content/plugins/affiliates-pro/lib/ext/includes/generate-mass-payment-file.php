<?php
/**
 * generate-mass-payment-file.php
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
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	$wp_load = 'wp-load.php';
	$max_depth = 100;

	while ( !file_exists( $wp_load ) && ( $max_depth > 0 ) ) {
		$wp_load = '../' . $wp_load;
		$max_depth--;
	}
	if ( file_exists( $wp_load ) ) {
		require_once $wp_load;
	}
}
if ( defined( 'ABSPATH' ) ) {
	if ( !current_user_can( AFFILIATES_ACCESS_AFFILIATES ) ) {
		wp_die( __( '拒絕訪問。', 'affiliates' ) );
	} else {
		if ( isset ( $_GET['action'] ) ) {
			global $wpdb, $affiliates_db;

			switch( $_GET['action'] ) {

				case 'generate_mass_payment_file' :
					if ( isset( $_GET['service'] ) ) {
						$params = array(
							'tables' => array(
								'referrals' => $affiliates_db->get_tablename( 'referrals' ),
								'affiliates' => $affiliates_db->get_tablename( 'affiliates' ),
								'affiliates_users' => $affiliates_db->get_tablename( 'affiliates_users' ),
								'users' => $wpdb->users,
							)
						);
						$params = array_merge( $_GET, $params );
						Affiliates_Totals::get_mass_payment_file( $_GET['service'], $params, get_option( 'blog_charset' ) );
						die;
					}
					break;
			}
		}
	}
}
