<?php
/**
 * class-affiliates-rate.php
 *
 * Copyright 2017 "kento" Karim Rahimpur - www.itthinx.com
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
 * @author itthinx
 * @package affiliates-pro
 * @since affiliates-pro 3.0.0
 */

/**
 * Rate object.
 */
class Affiliates_Rate {

	protected $rate_id      = null;
	protected $type         = null;
	protected $value        = null;
	protected $currency_id  = null;
	protected $affiliate_id = null;
	protected $group_id     = null;
	protected $object_id    = null;
	protected $term_id      = null;
	protected $level        = null;
	protected $integration  = null;
	protected $description  = null;
	protected $metas        = null;

	public function __construct( $o = null ) { self::initialize( $this, $o ); }

	private static function initialize( &$rate, $o ) { if ( isset( $o->rate_id ) ) { $rate->rate_id = $o->rate_id !== null ? intval( $o->rate_id ) : null; } if ( isset( $o->type ) ) { $rate->type = $o->type; } if ( isset( $o->value ) ) { $rate->value = $o->value; } if ( isset( $o->currency_id ) ) { $rate->currency_id = $o->currency_id; } if ( isset( $o->affiliate_id ) ) { $rate->affiliate_id = $o->affiliate_id !== null ? intval( $o->affiliate_id ) : null; } if ( isset( $o->group_id ) ) { $rate->group_id = $o->group_id !== null ? intval( $o->group_id ) : null; } if ( isset( $o->object_id ) ) { $rate->object_id = $o->object_id !== null ? intval( $o->object_id ) : null; } if ( isset( $o->term_id ) ) { $rate->term_id = $o->term_id !== null ? intval( $o->term_id ) : null; } if ( isset( $o->level ) ) { $rate->level = $o->level !== null ? intval( $o->level ) : null; } if ( isset( $o->integration ) ) { $rate->integration = $o->integration; } if ( isset( $o->description ) ) { $rate->description = $o->description; } if ( isset( $o->metas ) ) { $rate->metas = $o->metas; } }

	public function create() { global $affiliates_db; $IX83480 = null; if ( $this->rate_id === null ) { $IX89893 = $affiliates_db->get_tablename( 'rates' ); $IX12606 = array(); $IX89388 = array(); if ( $this->type !== null ) { $IX12606[] = 'type = %s'; $IX89388[] = $this->type; } if ( $this->value !== null ) { $IX12606[] = 'value = %s'; $IX89388[] = $this->value; } if ( $this->currency_id !== null ) { $IX12606[] = 'currency_id = %s'; $IX89388[] = $this->currency_id; } if ( $this->affiliate_id !== null ) { $IX12606[] = 'affiliate_id = %d'; $IX89388[] = intval( $this->affiliate_id ); } if ( $this->group_id !== null ) { $IX12606[] = 'group_id = %d'; $IX89388[] = intval( $this->group_id ); } if ( $this->object_id !== null ) { $IX12606[] = 'object_id = %d'; $IX89388[] = intval( $this->object_id ); } if ( $this->term_id !== null ) { $IX12606[] = 'term_id = %d'; $IX89388[] = intval( $this->term_id ); } if ( $this->level !== null ) { $IX12606[] = 'level = %d'; $IX89388[] = intval( $this->level ); } if ( $this->integration !== null ) { $IX12606[] = 'integration = %s'; $IX89388[] = $this->integration; } if ( $this->description !== null ) { $IX12606[] = 'description = %s'; $IX89388[] = $this->description; } if ( count( $IX12606 ) > 0 ) { $IX25563 = "INSERT INTO $IX89893 SET " . implode( ',', $IX12606 ); if ( $affiliates_db->query( $IX25563, $IX89388 ) ) { if ( $this->rate_id = $affiliates_db->get_value( 'SELECT LAST_INSERT_ID()' ) ) { $IX83480 = $this->rate_id; if ( !empty( $this->metas ) ) { $IX20255 = $affiliates_db->get_tablename( 'rates_metas' ); foreach( $this->metas as $IX99113 => $IX29997 ) { $IX25563 = "INSERT INTO $IX20255 SET rate_id = %d, meta_key = %s, meta_value = %s"; $IX29997 = serialize( $IX29997 ); $affiliates_db->query( $IX25563, intval( $this->rate_id ), $IX99113, $IX29997 ); } } } } } } return $IX83480; }

	public function read( $rate_id ) { global $affiliates_db; $IX48675 = null; $IX37111 = $affiliates_db->get_tablename( 'rates' ); if ( $IX51018 = $affiliates_db->get_objects( "SELECT * FROM $IX37111 WHERE rate_id = %d", intval( $rate_id ) ) ) { if ( $IX74083 = array_shift( $IX51018 ) ) { self::initialize( $this, $IX74083 ); $IX48675 = $this; $IX97904 = $affiliates_db->get_tablename( 'rates_metas' ); if ( $IX21681 = $affiliates_db->get_objects( "SELECT * FROM $IX97904 WHERE rate_id = %d", intval( $rate_id ) ) ) { $this->metas = array(); foreach( $IX21681 as $IX71456 ) { $this->metas[$IX71456->meta_key] = unserialize( $IX71456->meta_value ); } } } } return $IX48675; }

	public function update() { global $affiliates_db; $IX74958 = false; $IX68621 = $affiliates_db->get_tablename( 'rates' ); if ( $this->rate_id !== null ) { $IX75605 = array(); $IX40037 = array(); if ( $this->type !== null ) { $IX75605[] = 'type = %s'; $IX40037[] = $this->type; } else { $IX75605[] = 'type = NULL'; } if ( $this->value !== null ) { $IX75605[] = 'value = %s'; $IX40037[] = $this->value; } else { $IX75605[] = 'value = NULL'; } if ( $this->currency_id !== null ) { $IX75605[] = 'currency_id = %s'; $IX40037[] = $this->currency_id; } else { $IX75605[] = 'currency_id = NULL'; } if ( $this->affiliate_id !== null ) { $IX75605[] = 'affiliate_id = %d'; $IX40037[] = intval( $this->affiliate_id ); } else { $IX75605[] = 'affiliate_id = NULL'; } if ( $this->group_id !== null ) { $IX75605[] = 'group_id = %d'; $IX40037[] = intval( $this->group_id ); } else { $IX75605[] = 'group_id = NULL'; } if ( $this->object_id !== null ) { $IX75605[] = 'object_id = %d'; $IX40037[] = intval( $this->object_id ); } else { $IX75605[] = 'object_id = NULL'; } if ( $this->term_id !== null ) { $IX75605[] = 'term_id = %d'; $IX40037[] = intval( $this->term_id ); } else { $IX75605[] = 'term_id = NULL'; } if ( $this->level !== null ) { $IX75605[] = 'level = %d'; $IX40037[] = intval( $this->level ); } else { $IX75605[] = 'level = NULL'; } if ( $this->integration !== null ) { $IX75605[] = 'integration = %s'; $IX40037[] = $this->integration; } else { $IX75605[] = 'integration = NULL'; } if ( $this->description !== null ) { $IX75605[] = 'description = %s'; $IX40037[] = $this->description; } else { $IX75605[] = 'description = NULL'; } $IX40037[] = intval( $this->rate_id ); if ( count( $IX75605 ) > 0 ) { $IX60517 = "UPDATE $IX68621 SET " . implode( ',', $IX75605 ) . " WHERE rate_id = %d"; if ( $affiliates_db->query( $IX60517, $IX40037 ) ) { $IX74958 = true; } } $IX16988 = false; $IX24186 = Affiliates_Rate::get_rate_by_id( $this->rate_id ); if ( !empty( $this->metas ) ) { foreach( $this->metas as $IX38223 => $IX43760 ) { if ( !$IX24186->has_meta( $IX38223 ) || ( $IX24186->get_meta( $IX38223 ) != $IX43760 ) ) { $IX16988 = true; } } } if ( !empty( $IX24186->metas ) ) { foreach( $IX24186->metas as $IX38223 => $IX43760 ) { if ( !$this->has_meta( $IX38223 ) || ( $this->get_meta( $IX38223 ) != $IX43760 ) ) { $IX16988 = true; } } } if ( $IX16988 ) { $IX74958 = true; $IX97747 = $affiliates_db->get_tablename( 'rates_metas' ); $affiliates_db->query( "DELETE FROM $IX97747 WHERE rate_id = %d", intval( $this->rate_id ) ); if ( !empty( $this->metas ) ) { foreach( $this->metas as $IX38223 => $IX43760 ) { $IX60517 = "INSERT INTO $IX97747 SET rate_id = %d, meta_key = %s, meta_value = %s"; $IX43760 = serialize( $IX43760 ); $affiliates_db->query( $IX60517, intval( $this->rate_id ), $IX38223, $IX43760 ); } } } } return $IX74958; }

	public function delete() { global $affiliates_db; $IX97717 = false; if ( $this->rate_id !== null ) { $IX36146 = $affiliates_db->get_tablename( 'rates' ); if ( $affiliates_db->query( "DELETE FROM $IX36146 WHERE rate_id = %d", intval( $this->rate_id ) ) ) { $IX97717 = true; $IX23323 = $affiliates_db->get_tablename( 'rates_metas' ); $affiliates_db->query( "DELETE FROM $IX23323 WHERE rate_id = %d", intval( $this->rate_id ) ); } } return $IX97717; }

	public function __get( $name ) { $IX95923 = null; switch( $name ) { case 'rate_id' : case 'affiliate_id' : case 'group_id' : case 'object_id' : case 'term_id' : case 'level' : if ( $this->$name !== null ) { $IX95923 = intval( $this->$name ); } else { $IX95923 = null; } break; case 'type' : case 'value' : case 'currency_id' : case 'metas' : case 'integration' : case 'description' : $IX95923 = $this->$name; break; } return $IX95923; }

	public function __set( $name, $value ) { switch( $name ) { case 'rate_id' : case 'affiliate_id' : case 'group_id' : case 'object_id' : case 'term_id' : case 'level' : if ( $value !== null ) { $this->$name = intval( $value ); } else { $this->$name = null; } break; case 'type' : case 'value' : case 'currency_id' : case 'metas' : case 'integration' : case 'description' : $this->$name = $value; break; } }

	public function to_array() { $IX88851 = array( 'rate_id' => $this->rate_id, 'type' => $this->type, 'value' => $this->value, 'currency_id' => $this->currency_id, 'affiliate_id' => $this->affiliate_id, 'group_id' => $this->group_id, 'object_id' => $this->object_id, 'term_id' => $this->term_id, 'level' => $this->level, 'metas' => $this->metas, 'integration' => $this->integration, 'description' => $this->description ); return $IX88851; }

	/**
	 * Returns rates.
	 * $params will obtain all rates by default and accepts type, value, currency_id, affiliate_id, group_id, object_id, term_id, level, integration and description to obtain a matching subset of rates
	 * $params allows to indicate the order (asc,desc), orderby (rate_id, type, ...), limit and offset.
	 *
	 * @param array $params accepts key-value pairs to determine the subset of rates and the order
	 *
	 * @return array of Affiliates_Rate
	 */
	public static function get_rates( $params = array() ) { global $affiliates_db, $wpdb; $IX57394 = array( 'type' => null, 'value' => null, 'currency_id' => null, 'affiliate_id' => null, 'group_id' => null, 'object_id' => null, 'term_id' => null, 'level' => null, 'integration' => null, 'description' => null, 'order' => 'asc', 'orderby' => 'rate_id', 'limit' => null, 'offset' => null ); $params = array_merge( $IX57394, $params ); $IX44102 = ''; $IX17122 = array(); $IX37606 = array(); foreach ( $params as $IX56522 => $IX58998 ) { if ( $IX58998 !== null ) { switch( $IX56522 ) { case 'type' : switch ( $IX58998 ) { case AFFILIATES_PRO_RATES_TYPE_AMOUNT : case AFFILIATES_PRO_RATES_TYPE_RATE : case AFFILIATES_PRO_RATES_TYPE_FORMULA : $IX17122[] = 'type = %s'; $IX37606[] = $IX58998; break; } break; case 'value' : case 'currency_id' : case 'integration' : $IX17122[] = $IX56522 . ' = %s'; $IX37606[] = $IX58998; break; case 'description' : $IX17122[] = 'description LIKE %s'; $IX37606[] = '%' . $wpdb->esc_like( $IX58998 ) .'%'; break; case 'affiliate_id' : case 'group_id' : case 'object_id' : case 'term_id' : case 'level' : $IX17122[] = $IX56522 . ' = %d'; $IX37606[] = intval( $IX58998 ); break; } } } if ( count( $IX17122 ) > 0 ) { $IX44102 = ' WHERE ' . implode( ' AND ', $IX17122 ) . ' '; } $IX41388 = !empty( $params['order'] ) ? $params['order'] : 'asc'; $IX13296 = !empty( $params['orderby'] ) ? $params['orderby'] : 'rate_id'; $IX67295 = !empty( $params['limit'] ) ? intval( $params['limit'] ) : null; $IX37498 = !empty( $params['offset'] ) ? intval( $params['offset'] ) : null; switch( $IX41388 ) { case 'asc' : case 'desc' : break; default : $IX41388 = 'asc'; } switch( $IX13296 ) { case 'rate_id' : case 'type' : case 'value' : case 'currency_id' : case 'affiliate_id' : case 'group_id' : case 'object_id' : case 'term_id' : case 'level' : case 'integration' : case 'description' : break; default : $IX13296 = 'rate_id'; } $IX81245 = $affiliates_db->get_tablename( 'rates' ); $IX85136 = "SELECT * FROM $IX81245 $IX44102 ORDER BY $IX13296 $IX41388"; if ( $IX67295 !== null ) { $IX85136 .= " LIMIT $IX67295 "; } if ( $IX37498 !== null ) { $IX85136 .= " OFFSET $IX37498 "; } if ( count( $IX37606 ) > 0 ) { $IX95210 = $affiliates_db->get_objects( $IX85136, $IX37606 ); } else { $IX95210 = $affiliates_db->get_objects( $IX85136 ); } $IX79951 = array(); if ( !empty( $IX95210 ) && is_array( $IX95210 ) ) { foreach( $IX95210 as $IX61333 ) { $IX79951[] = new Affiliates_Rate( $IX61333 ); } } return $IX79951; }

	/**
	 * Check if there is an entry with the rate conditions of this object.
	 *
	 * @return boolean true|false
	 */
	public function exists() { return self::get_rate( $this->to_array() ) !== null; }

	/**
	 * Check if there is another entry with the rate conditions of this object.
	 *
	 * This object must have its rate_id set, otherwise the result from $this->exists()
	 * is returned.
	 *
	 * @return boolean
	 */
	public function exists_other() { $IX10978 = false; if ( $this->rate_id !== null ) { $IX22019 = $this->to_array(); $IX22019['limit'] = 2; $IX83805 = self::get_rate( $IX22019 ); if ( $IX83805 !== null && count( $IX83805 ) > 0 ) { unset( $IX83805[$this->rate_id] ); $IX10978 = count( $IX83805 ) > 0; } } else { $IX10978 = $this->exists(); } return $IX10978; }

	/**
	 * Returns the rate object for the given rate_id if it exists or null otherwise.
	 *
	 * @param int $rate_id ID of the desired rate
	 * @return Affiliates_Rate or null
	 */
	public static function get_rate_by_id( $rate_id ) { $IX26754 = new Affiliates_Rate(); return $IX26754->read( intval( $rate_id ) ); }

	/**
	 * Retrieve the first matching rate based on the parameters provided.
	 *
	 * This method does NOT support retrieval by rate_id.
	 * To retrieve a rate by if use Affiliates_Rate::get_rate_by_id( $rate_id ) instead.
	 *
	 * @param array $params acceptepted parameters include: type, affiliate_id, group_id, object_id, term_id, level, integration and limit
	 * @return null|Affiliates_Rate|array of Affiliates_Rate when limit is given and other than 1
	 */
	public static function get_rate( $params = null ) { global $affiliates_db; $IX99898 = null; $IX94324 = 1; $IX90287 = array( 'currency_id' => null, 'type' => null, 'affiliate_id' => null, 'group_id' => null, 'object_id' => null, 'term_id' => null, 'level' => null, 'integration' => null, 'limit' => $IX94324 ); $params = array_merge( $IX90287, $params !== null && is_array( $params ) ? $params : array() ); unset( $params['rate_id'] ); if ( ( $params !== null ) && is_array( $params ) ) { $IX74106 = array( '1=1' ); $IX72393 = array(); foreach( $params as $IX78955 => $IX56567 ) { switch( $IX78955 ) { case 'type' : switch( $IX56567 ) { case AFFILIATES_PRO_RATES_TYPE_RATE: case AFFILIATES_PRO_RATES_TYPE_AMOUNT: break; default : $IX56567 = null; } if ( $IX56567 !== null ) { $IX74106[] = 'type = %s'; $IX72393[] = $IX56567; } break; case 'affiliate_id' : case 'group_id' : case 'object_id' : case 'term_id' : case 'level' : if ( ( $IX56567 !== null ) && is_numeric( $IX56567 ) ) { $IX56567 = intval( $IX56567 ); } else { $IX56567 = null; } if ( $IX56567 === null ) { $IX74106[] = "$IX78955 IS NULL"; } else { $IX74106[] = "$IX78955 = %d"; $IX72393[] = $IX56567; } break; case 'integration' : if ( !empty( $IX56567 ) && is_string( $IX56567 ) ) { $IX56567 = trim( $IX56567 ); } else { $IX56567 = null; } if ( $IX56567 === null ) { $IX74106[] = "integration IS NULL"; } else { $IX74106[] = "integration = %s"; $IX72393[] = $IX56567; } break; case 'limit' : $IX94324 = intval( $IX56567 ); if ( $IX94324 < 0 ) { $IX94324 = 1; } break; case 'currency_id' : if ( !empty( $IX56567 ) && is_string( $IX56567 ) ) { $IX56567 = trim( $IX56567 ); if ( strlen( $IX56567 ) > 0 ) { $IX74106[] = 'currency_id = %s'; $IX72393[] = $IX56567; } } break; } } $IX74106 = implode( ' AND ', $IX74106 ); $IX84800 = $affiliates_db->get_tablename( 'rates' ); $IX37645 = "SELECT rate_id FROM $IX84800 WHERE $IX74106 ORDER BY rate_id ASC"; if ( $IX94324 > 0 ) { $IX37645 .= " LIMIT $IX94324"; } if ( count( $IX72393 ) > 0 ) { $IX80106 = $affiliates_db->get_objects( $IX37645, $IX72393 ); } else { $IX80106 = $affiliates_db->get_objects( $IX37645 ); } if ( $IX80106 !== null && count( $IX80106 ) > 0 ) { $IX32772 = array(); foreach( $IX80106 as $IX75645 ) { $IX99898 = new Affiliates_Rate(); $IX99898 = $IX99898->read( $IX75645->rate_id ); $IX32772[$IX99898->rate_id] = $IX99898; } if ( $IX94324 == 1 ) { $IX99898 = array_shift( $IX32772 ); } else { $IX99898 = $IX32772; } } } return $IX99898; }

	public function set_meta( $key, $value ) { if ( $this->metas === null ) { $this->metas = array(); } $this->metas[$key] = $value; }

	public function get_meta( $key ) { $IX65421 = null; if ( $this->has_meta( $key ) ) { $IX65421 = $this->metas[$key]; } return $IX65421; }

	public function has_meta( $key ) { $IX15696 = false; if ( $this->metas !== null ) { if ( isset( $this->metas[$key] ) ) { $IX15696 = true; } } return $IX15696; }

	public function delete_meta( $key ) { $IX12821 = false; if ( $this->has_meta( $key ) ) { unset( $this->metas[$key] ); $IX12821 = true; } return $IX12821; }

	/**
	 * Renders rate details.
	 *
	 * @return string
	 */
	public function view( $params = array() ) { $IX62212 = array( 'titles' => false, 'values' => true, 'style' => 'flat', 'separator' => null, 'exclude' => array(), 'prefix_class' => '' ); $params = array_merge( $IX62212, $params ); $IX45893 = new Affiliates_Rates_Table(); $IX69387 = $IX45893->get_columns(); unset( $IX69387['cb'] ); unset( $IX69387['actions'] ); if ( !is_array( $params['exclude'] ) ) { if ( is_string( $params['exclude'] ) ) { $params['exclude'] = array( $params['exclude'] ); } else { $params['exclude'] = array(); } } foreach ( $params['exclude'] as $IX85953 ) { unset( $IX69387[$IX85953] ); } $IX27437 = $this->to_array(); $IX83241 = ''; $IX31889 = ''; $IX92723 = ''; $IX45617 = ''; switch ( $params['style'] ) { case 'table' : $IX22361 = 'td'; $IX92723 = '<tr>'; $IX31889 = sprintf( '<tr class="%s">', esc_attr( $params['prefix_class'] ) ); $IX45617 = '</tr>'; break; case 'list' : $IX22361 = 'li'; break; case 'flat' : default : $IX22361 = 'span'; $IX83241 = ' '; break; } if ( $params['separator'] !== null ) { $IX83241 = $params['separator']; } $IX87388 = ''; if ( $params['titles'] && $params['style'] === 'table' ) { $IX87388 .= $IX92723; foreach( $IX69387 as $IX83209 => $IX21678 ) { $IX87388 .= sprintf( '<th class="%s">%s</th>', esc_attr( $IX83209 ), esc_html( $IX21678 ) ); } $IX87388 .= $IX45617; } if ( $params['values'] ) { $IX87388 .= $IX31889; foreach( $IX69387 as $IX83209 => $IX21678 ) { $IX87388 .= sprintf( '<%s class="%s">', esc_html( strip_tags( $IX22361 ) ), esc_attr( $IX83209 ) ); if ( $IX83209 === 'rate_id' && current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) { $IX24469 = wp_nonce_url( add_query_arg( array( 'rate_id' => $this->rate_id, 'action' => 'edit-rate' ), admin_url( 'admin.php?page=affiliates-admin-rates' ) ) ); $IX87388 .= sprintf( '<a href="%s">', esc_url( $IX24469 ) ); $IX87388 .= $IX45893->column_default( $IX27437, $IX83209 ); $IX87388 .= '</a>'; } else { $IX87388 .= $IX45893->column_default( $IX27437, $IX83209 ); } $IX87388 .= sprintf( '</%s>', esc_html( strip_tags( $IX22361 ) ) ); } $IX87388 .= $IX45617; $IX87388 .= esc_html( $IX83241 ); } return $IX87388; }
}
