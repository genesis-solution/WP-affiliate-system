<?php
/**
 * class-affiliates-database-wordpress.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates-pro 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * System-specific database implementation which needs to comply with the independent base abstraction.
 */
class Affiliates_Database_WordPress extends Affiliates_Database {

	public function __construct( $implementation = 'WordPress', $host = null, $database = null, $user = null, $password = null ) { parent::__construct( 'WordPress', $host, $database, $user, $password ); }

	public function start_transaction() { }

	public function commit() { }

	public function rollback() { }

	public function get_tablename( $name ) { return _affiliates_get_tablename( $name ); }

	public function get_value( $query ) { global $wpdb; $IX35078 = func_get_args(); if ( count( $IX35078 ) < 2 ) { if ( isset( $IX35078[0] ) ) { $IX58389 = $IX35078[0]; } else { $IX58389 = false; } } else { $IX58389 = call_user_func_array( array( $wpdb, 'prepare' ), $IX35078 ); } if ( $IX58389 !== false ) { return $wpdb->get_var( $IX58389 ); } }

	public function get_objects( $query ) { global $wpdb; $IX27987 = func_get_args(); if ( count( $IX27987 ) < 2 ) { if ( isset( $IX27987[0] ) ) { $IX89307 = $IX27987[0]; } else { $IX89307 = false; } } else { $IX89307 = call_user_func_array( array( $wpdb, 'prepare' ), $IX27987 ); } if ( $IX89307 !== false ) { return $wpdb->get_results( $IX89307, OBJECT ); } }

	public function query( $query ) { global $wpdb; $IX25611 = func_get_args(); if ( count( $IX25611 ) < 2 ) { if ( isset( $IX25611[0] ) ) { $IX74170 = $IX25611[0]; } else { $IX74170 = false; } } else { $IX74170 = call_user_func_array( array( $wpdb, 'prepare' ), $IX25611 ); } if ( $IX74170 !== false ) { return $wpdb->query( $IX74170 ); } }
}
global $affiliates_db;
$affiliates_db = new Affiliates_Database_WordPress();
