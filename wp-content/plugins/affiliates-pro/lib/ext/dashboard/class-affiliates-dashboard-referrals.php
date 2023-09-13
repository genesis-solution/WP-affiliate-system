<?php
/**
 * class-affiliates-dashboard-referrals.php
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Referrals
 */
class Affiliates_Dashboard_Referrals extends Affiliates_Dashboard_Section_Table {

	protected static $section_order = 300;

	private $search = null;

	protected static $defaults = array(

		'from_date'          => null,
		'thru_date'          => null,

		'per_page'           => self::PER_PAGE_DEFAULT,
		'status'             => array( AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED )
	);

	/**
	 * {@inheritDoc}
	 */
	public static function get_section_order() { return self::$section_order; }

	/**
	 * {@inheritDoc}
	 */
	public static function get_name() { return __( '推薦人', 'affiliates' ); }

	/**
	 * {@inheritDoc}
	 */
	public static function get_key() { return 'referrals'; }

	/**
	 * Filter by user's search query string ...
	 *
	 * @return string
	 */
	public function get_search() { return $this->search; }

	public function get_url( $params = array() ) { $IX31514 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $IX31514 = remove_query_arg( 'clear_filters', $IX31514 ); $IX31514 = remove_query_arg( 'apply_filters', $IX31514 ); foreach ( $this->url_parameters as $IX34149 ) { $IX31514 = remove_query_arg( $IX34149, $IX31514 ); $IX87242 = null; switch ( $IX34149 ) { case 'per_page' : $IX87242 = $this->get_per_page(); break; case 'from_date' : $IX87242 = $this->get_from_date(); break; case 'thru_date' : $IX87242 = $this->get_thru_date(); break; case 'orderby' : $IX87242 = $this->get_orderby(); break; case 'order' : $IX87242 = $this->get_sort_order(); break; case 'referral-search': case 'search' : $IX87242 = $this->get_search(); break; } if ( $IX87242 !== null ) { $IX31514 = add_query_arg( $IX34149, $IX87242, $IX31514 ); } } foreach ( $params as $IX20198 => $IX87242 ) { $IX31514 = remove_query_arg( $IX20198, $IX31514 ); if ( $IX87242 !== null ) { $IX31514 = add_query_arg( $IX20198, $IX87242, $IX31514 ); } } return $IX31514; }

	public static function init() { require_once( AFFILIATES_CORE_LIB . '/class-affiliates-date-helper.php' ); }

	public function __construct( $params = array() ) {
        $this->template = 'dashboard/earnings_profit.php'; //'dashboard/referrals.php';
        $this->require_user_id = true;
        parent::__construct( $params );
        $this->url_parameters = array( 'referrals-page', 'per_page', 'from_date', 'thru_date', 'orderby', 'order', 'referral-search', 'search' );
        $params = shortcode_atts( self::$defaults, $params );
        foreach ( $params as $IX15589 => $IX25184 ) {
            switch( $IX15589 ) {
                case 'per_page' : $IX25184 = intval( $IX25184 );
                if ( $IX25184 < 0 ) { $IX25184 = self::$defaults['per_page'];
                } break; case 'status' : if ( !is_array( $IX25184 ) ) { if ( is_string( $IX25184 ) ) { $IX25184 = array_map( 'trim', explode( ',', $IX25184 ) ); } else { $IX25184 = self::$defaults['status']; } } $IX87642 = array(); foreach ( $IX25184 as $IX14910 ) { switch ( $IX14910 ) { case AFFILIATES_REFERRAL_STATUS_ACCEPTED : case AFFILIATES_REFERRAL_STATUS_CLOSED : case AFFILIATES_REFERRAL_STATUS_PENDING : case AFFILIATES_REFERRAL_STATUS_REJECTED : $IX87642[] = $IX14910; break; } } $IX25184 = $IX87642; break; } $params[$IX15589] = $IX25184; } $this->per_page = $params['per_page']; $this->status = $params['status']; $this->column_display_names = array(); $IX27411 = DateHelper::getServerDateTimeZone();
        $this->columns['date'] = array( 'title' => __( '日期', 'affiliates' ),
            'description' => sprintf( __( "* 日期是針對服務器時區 : %s 給出的，相對於 GMT 有 %s 小時的偏移。", 'affiliates' ), $IX27411->getName(),
            $IX27411->getOffset( new DateTime() ) / 3600.0 ) );
        $this->columns['amount'] = array( 'title' => __( '數量', 'affiliates' ),
            'description' => __( '推薦金額或佣金總額。', 'affiliates' ) );
        $this->columns['status'] = array( 'title' => __( '地位', 'affiliates' ),
            'description' => __( '推薦的當前狀態。', 'affiliates' ) );
        $this->columns['items'] = array( 'title' => __( '項目', 'affiliates' ),
            'description' => __( '與轉介相關的項目。', 'affiliates' ) ); }

	public function render() { global $wpdb, $affiliates_db, $affiliates_version; wp_enqueue_script( 'datepicker', AFFILIATES_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_version ); wp_enqueue_script( 'datepickers', AFFILIATES_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_version ); wp_enqueue_style( 'smoothness', AFFILIATES_PLUGIN_URL . 'css/smoothness/jquery-ui.min.css', array(), $affiliates_version ); $IX76446 = !empty( $_REQUEST['per_page'] ) ? min( max( 1, intval( trim( $_REQUEST['per_page'] ) ) ), self::MAX_PER_PAGE ) : null; if ( $IX76446 !== null ) { $this->per_page = intval( $IX76446 ); } $this->current_page = isset( $_REQUEST['referrals-page'] ) ? max( 0, intval( $_REQUEST['referrals-page'] ) ) : 0; $IX29675 = isset( $_REQUEST['from_date'] ) ? trim( $_REQUEST['from_date'] ) : null; $IX38970 = isset( $_REQUEST['thru_date'] ) ? trim( $_REQUEST['thru_date'] ) : null; $IX92575 = null; if ( isset( $_REQUEST['clear_filters'] ) ) { unset( $_REQUEST['from_date'] ); unset( $_REQUEST['thru_date'] ); unset( $_REQUEST['search'] ); unset( $_REQUEST['referral-search'] ); $IX29675 = null; $IX38970 = null; $IX92575 = null; } else { if ( !empty( $_REQUEST['from_date'] ) ) { $IX29675 = date( 'Y-m-d', strtotime( $_REQUEST['from_date'] ) ); } else { $IX29675 = null; } if ( !empty( $_REQUEST['thru_date'] ) ) { $IX38970 = date( 'Y-m-d', strtotime( $_REQUEST['thru_date'] ) ); } else { $IX38970 = null; } if ( $IX29675 && $IX38970 ) { if ( strtotime( $IX29675 ) > strtotime( $IX38970 ) ) { $IX38970 = null; } } if ( !empty( $_REQUEST['search'] ) ) { $IX92575 = trim( $_REQUEST['search'] ); } if ( !empty( $_REQUEST['referral-search'] ) ) { $IX92575 = trim( $_REQUEST['referral-search'] ); } if ( $IX92575 !== null ) { $IX92575 = wp_check_invalid_utf8( $IX92575 ); $IX92575 = preg_replace( '/[\r\n\t ]+/', ' ', $IX92575 ); $IX92575 = trim( $IX92575 ); if ( strlen( $IX92575 ) === 0 ) { $IX92575 = null; } } } $this->from_date = $IX29675; $this->thru_date = $IX38970; $this->search = $IX92575; $this->orderby = isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : $this->orderby; switch ( $this->orderby ) { case 'referral_id' : case 'reference' : case 'datetime' : case 'post_title' : case 'amount' : case 'currency_id' : case 'status' : break; default : $this->orderby = 'datetime'; } $this->sort_order = isset( $_REQUEST['order'] ) ? $_REQUEST['order'] : $this->sort_order; switch ( $this->sort_order ) { case 'asc' : case 'ASC' : $this->switch_sort_order = 'DESC'; break; case 'desc' : case 'DESC' : $this->switch_sort_order = 'ASC'; break; default: $this->sort_order = 'DESC'; $this->switch_sort_order = 'ASC'; } $IX57878 = null; $IX19171 = null; $this->setup_query_filters( $IX57878, $IX19171 ); $IX86739 = $this->per_page * $this->current_page; $IX91426 = $wpdb->posts; $IX10416 = $affiliates_db->get_tablename( 'affiliates' ); $IX80720 = $affiliates_db->get_tablename( 'referrals' ); $IX64318 = $affiliates_db->get_tablename( 'referral_items' ); $IX62808 = "SELECT SQL_CALC_FOUND_ROWS " . "r.* " . "FROM $IX80720 r " . "LEFT JOIN $IX10416 a ON r.affiliate_id = a.affiliate_id " . "LEFT JOIN $IX91426 p ON r.post_id = p.ID " . "$IX57878"; $IX73558 = "ORDER BY %s %s LIMIT %d OFFSET %d"; $IX59170 = $IX62808 . sprintf( $IX73558, $this->orderby, $this->sort_order, intval( $this->per_page ), intval( $IX86739 ) ); $this->entries = $affiliates_db->get_objects( $IX59170, $IX19171 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); if ( count( $this->entries ) === 0 && $this->count > 0 ) { $this->current_page = 0; $IX59170 = $IX62808 . sprintf( $IX73558, $this->orderby, $this->sort_order, intval( $this->per_page ), 0 ); $this->entries = $affiliates_db->get_objects( $IX59170, $IX19171 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); } if ( count( $this->entries ) > 0 ) { foreach ( $this->entries as $IX21075 ) { $IX43826 = $affiliates_db->get_objects( "SELECT * FROM $IX64318 WHERE referral_id = %d", $IX21075->referral_id ); if ( count( $IX43826 ) > 0 ) { foreach ( $IX43826 as $IX89642 ) { if ( isset( $IX89642->object_id ) && $IX89642->object_id !== null && isset( $IX89642->type ) && $IX89642->type !== null ) { $IX22730 = get_posts( array( 'p' => $IX89642->object_id, 'post_type' => $IX89642->type, 'post_status' => 'publish' ) ); if ( count( $IX22730 ) > 0 ) { $IX45861 = array_shift( $IX22730 ); $IX21075->items[] = array( 'referral_item' => $IX89642, 'post' => $IX45861 ); } } } } } } parent::render(); }

	protected function setup_query_filters( &$filters, &$filter_params ) { global $wpdb, $affiliates_db; $IX92454 = $this->get_affiliate_id(); $filters = " WHERE 1=%d "; $filter_params = array( 1 ); if ( $this->from_date ) { $IX31829 = DateHelper::u2s( $this->from_date ); } if ( $this->thru_date ) { $IX82275 = DateHelper::u2s( $this->thru_date, 24*3600 ); } if ( $this->from_date && $this->thru_date ) { $filters .= " AND r.datetime >= %s AND r.datetime <= %s "; $filter_params[] = $IX31829; $filter_params[] = $IX82275; } else if ( $this->from_date ) { $filters .= " AND r.datetime >= %s "; $filter_params[] = $IX31829; } else if ( $this->thru_date ) { $filters .= " AND r.datetime < %s "; $filter_params[] = $IX82275; } $filters .= " AND r.affiliate_id = %d "; $filter_params[] = $IX92454; $IX57366 = ''; if ( is_array( $this->status ) && count( $this->status ) > 0 ) { $IX57366 = " AND ( r.status IS NULL OR r.status IN ('" . implode( "','", array_map( 'esc_sql', $this->status ) ) . "') ) "; $filters .= $IX57366; } $IX16460 = $wpdb->posts; $IX29658 = $affiliates_db->get_tablename( 'referral_items' ); if ( $this->search !== null ) { $filters .= " AND r.referral_id IN ( SELECT DISTINCT ri.referral_id FROM $IX29658 ri LEFT JOIN $IX16460 p ON p.ID = ri.object_id AND ri.type = p.post_type WHERE p.post_title LIKE %s ) "; $filter_params[] = '%' . $wpdb->esc_like( $this->search ) . '%'; } }
}
Affiliates_Dashboard_Referrals::init();
