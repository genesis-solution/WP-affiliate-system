<?php
/**
 * class-affiliates-database.php
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

/**
 * Implementation-independent database abstraction.
 */
abstract class Affiliates_Database implements I_Affiliates_Database {

	private $implementation;
	private $host;
	private $database;
	private $user;
	private $password;

	public function __construct( $implementation, $host = null, $database = null, $user = null, $password = null ) { $this->implementation = $implementation; $this->host = $host; $this->database = $database; $this->user = $user; $this->password = $password; }

	public function create_tables( $charset = null, $collate = null ) {
        $IX47939 = '';
        if ( ! empty( $charset ) ) {
            $IX47939 = "DEFAULT CHARACTER SET $charset";
        }
        if ( ! empty( $collate ) ) {
            $IX47939 .= " COLLATE $collate";
        }
        $IX70359 = $this->get_tablename( 'affiliates_attributes' );
        if ( $this->get_value( "SHOW TABLES LIKE '" . $IX70359 . "'" ) != $IX70359 ) {
            $IX22394 = "CREATE TABLE " . $IX70359 . " (
				affiliate_id BIGINT(20) UNSIGNED NOT NULL,
				attr_key     VARCHAR(100) NOT NULL,
				attr_value   LONGTEXT DEFAULT NULL,
				PRIMARY KEY  (affiliate_id, attr_key),
				INDEX        aff_attr_akv (affiliate_id, attr_key, attr_value(100)),
				INDEX        aff_attr_ka (attr_key, affiliate_id),
				INDEX        aff_attr_kva (attr_key, attr_value(100), affiliate_id)
			) $IX47939;";
            $this->query( $IX22394 );
        }
        $IX23694 = $this->get_tablename( 'rates' );
        if ( $this->get_value( "SHOW TABLES LIKE '" . $IX23694 . "'" ) != $IX23694 ) {
            $IX22394 = "CREATE TABLE " . $IX23694 . "(
			rate_id      BIGINT(20) UNSIGNED NOT NULL auto_increment,
			type         VARCHAR(10) DEFAULT NULL,
			value        decimal(24,6) DEFAULT NULL,
			currency_id  CHAR(3) DEFAULT NULL,
			affiliate_id BIGINT(20) UNSIGNED DEFAULT NULL,
			group_id     BIGINT(20) UNSIGNED DEFAULT NULL,
			object_id    BIGINT(20) UNSIGNED DEFAULT NULL,
			term_id      BIGINT(20) UNSIGNED DEFAULT NULL,
			level        INT UNSIGNED DEFAULT NULL,
			integration  VARCHAR(255) DEFAULT NULL,
			description  varchar(255) DEFAULT NULL,
			PRIMARY KEY  (rate_id),
			INDEX        type (type),
			INDEX        affiliate (affiliate_id),
			INDEX        object (object_id),
			INDEX        term (term_id),
			INDEX        level (level),
			INDEX        integration (integration(20))
			) $IX47939;";
            $this->query( $IX22394 );
        }
        $IX94384 = $this->get_tablename( 'rates_metas' );
        if ( $this->get_value( "SHOW TABLES LIKE '" . $IX94384 . "'" ) != $IX94384 ) {
            $IX22394 = "CREATE TABLE " . $IX94384 . "(
			rate_meta_id      BIGINT(20) UNSIGNED NOT NULL auto_increment,
			rate_id           BIGINT(20) UNSIGNED NOT NULL,
			meta_key          VARCHAR(255) DEFAULT NULL,
			meta_value        LONGTEXT DEFAULT NULL,
			PRIMARY KEY       (rate_meta_id),
			INDEX             rate_id (rate_id),
			INDEX             meta_key (meta_key(20))
			) $IX47939;";
            $this->query( $IX22394 );
        }
    }

	public function update_tables( $previous_version = null, $charset = null, $collate = null ) {
        $IX85671 = true;
        $IX25098 = '';
        if ( ! empty( $charset ) ) {
            $IX25098 = "DEFAULT CHARACTER SET $charset";
        }
        if ( ! empty( $collate ) ) {
            $IX25098 .= " COLLATE $collate";
        }
        if ( !empty( $previous_version ) && version_compare( $previous_version, '3.0.0' ) < 0 ) {
            $IX22370 = $this->get_tablename( 'rates' );
            if ( $this->get_value( "SHOW TABLES LIKE '" . $IX22370 . "'" ) != $IX22370 ) {
                $IX65871 = "CREATE TABLE " . $IX22370 . "(
				rate_id      BIGINT(20) UNSIGNED NOT NULL auto_increment,
				type         VARCHAR(10) DEFAULT NULL,
				value        decimal(24,6) DEFAULT NULL,
				currency_id  CHAR(3) DEFAULT NULL,
				affiliate_id BIGINT(20) UNSIGNED DEFAULT NULL,
				group_id     BIGINT(20) UNSIGNED DEFAULT NULL,
				object_id    BIGINT(20) UNSIGNED DEFAULT NULL,
				term_id      BIGINT(20) UNSIGNED DEFAULT NULL,
				level        INT UNSIGNED DEFAULT NULL,
				integration  VARCHAR(255) DEFAULT NULL,
				description  VARCHAR(255) DEFAULT NULL,
				PRIMARY KEY  (rate_id),
				INDEX        type (type),
				INDEX        affiliate (affiliate_id),
				INDEX        object (object_id),
				INDEX        term (term_id),
				INDEX        level (level),
				INDEX        integration (integration(20))
				) $IX25098;";
                if ( !$this->query( $IX65871 ) ) {
                    $IX85671 = false;
                }
            }
            $IX52499 = $this->get_tablename( 'rates_metas' );
            if ( $this->get_value( "SHOW TABLES LIKE '" . $IX52499 . "'" ) != $IX52499 ) {
                $IX65871 = "CREATE TABLE " . $IX52499 . "(
				rate_meta_id      BIGINT(20) UNSIGNED NOT NULL auto_increment,
				rate_id           BIGINT(20) UNSIGNED NOT NULL,
				meta_key          VARCHAR(255) DEFAULT NULL,
				meta_value        LONGTEXT DEFAULT NULL,
				PRIMARY KEY       (rate_meta_id),
				INDEX             rate_id (rate_id),
				INDEX             meta_key (meta_key(20))
				) $IX25098;";
                if ( !$this->query( $IX65871 ) ) {
                    $IX85671 = false;
                }
            }
        }
        $IX22370 = $this->get_tablename( 'rates' );
        if ( $this->get_value( "SHOW TABLES LIKE '" . $IX22370 . "'" ) == $IX22370 ) {
            $IX12165 = $this->get_objects( "SHOW COLUMNS FROM $IX22370 LIKE 'currency_id'" );
            if ( empty( $IX12165 ) ) {
                if ( !$this->query( "ALTER TABLE " . $IX22370 . " ADD COLUMN currency_id  CHAR(3) DEFAULT NULL;" ) ) {
                    $IX85671 = false;
                }
            }
        }
        return $IX85671;
    }

	public function drop_tables() {
        $IX58523 = $this->get_tablename( 'affiliates_attributes' );
        $IX94584 = "DROP TABLE IF EXISTS " . $IX58523 . ";";
        $this->query( $IX94584 );
        $IX35859 = $this->get_tablename( 'rates' );
        $IX94584 = "DROP TABLE IF EXISTS " . $IX35859 . ";";
        $this->query( $IX94584 );
        $IX69709 = $this->get_tablename( 'rates_metas' );
        $IX94584 = "DROP TABLE IF EXISTS " . $IX69709 . ";";
        $this->query( $IX94584 );
    }

	/**
	 * @since 4.16.0
	 * {@inheritDoc}
	 * @see I_Affiliates_Database::esc_like()
	 */
	public function esc_like( $s ) { return addcslashes( $s, '_%\\' ); }
}
