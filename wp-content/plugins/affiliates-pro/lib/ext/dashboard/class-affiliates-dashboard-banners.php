<?php
/**
 * class-affiliates-dashboard-banners.php
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
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Banners
 */
class Affiliates_Dashboard_Banners extends Affiliates_Dashboard_Section_Table {

	protected static $section_order = 500;

	private $search = null;

	protected $banner_url = null;

	public static function get_section_order() { return self::$section_order; }

	public static function init() { }

	/**
	 * Get name
	 *
	 * @return string
	 */
	public static function get_name() { return __( '橫幅', 'affiliates' ); }

	/**
	 * Get key
	 *
	 * @return string
	 */
	public static function get_key() { return 'banners'; }

	/**
	 * Get the banner image by the post id
	 *
	 * @param int $post_id
	 * @return string post thumbnail image tag
	 */
	public static function get_banner_image( $post_id ) { $IX31428 = get_the_post_thumbnail( $post_id, 'full', array( 'class' => '' ) ); if ( empty( $IX31428 ) ) { $IX76216 = get_the_title( $post_id ); $IX31428 = Affiliates_Banner::get_url_image( $post_id, $IX76216 ); } $IX31428 = wp_kses( $IX31428, array( 'img' => array( 'src' => array(), 'width' => array(), 'height' => array(), 'srcset' => array(), 'alt' => array(), 'sizes' => array(), 'title' => array() ) ) ); return $IX31428; }

	public function __construct( $params = array() ) { $this->template = 'dashboard/banners.php'; $this->require_user_id = true; if ( isset( $params['per_page'] ) ) { $this->per_page = intval( $params['per_page'] ); } parent::__construct( $params ); $this->url_parameters = array( 'banners-page', 'banner-url', 'per_page', 'banner-search', 'search', 'from_date', 'thru_date', 'orderby', 'order' ); }

	/**
	 * Filter by user's search query string ...
	 *
	 * @return string
	 */
	public function get_search() { return $this->search; }

	/**
	 * Generate banner codes for this URL.
	 *
	 * @return string
	 */
	public function get_banner_url() { return $this->banner_url; }

	public function get_url( $params = array() ) { $IX34459 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $IX34459 = remove_query_arg( 'clear_filters', $IX34459 ); $IX34459 = remove_query_arg( 'apply_filters', $IX34459 ); foreach ( $this->url_parameters as $IX58094 ) { $IX34459 = remove_query_arg( $IX58094, $IX34459 ); $IX37684 = null; switch ( $IX58094 ) { case 'per_page' : $IX37684 = $this->get_per_page(); break; case 'from_date' : $IX37684 = $this->get_from_date(); break; case 'thru_date' : $IX37684 = $this->get_thru_date(); break; case 'orderby' : $IX37684 = $this->get_orderby(); break; case 'order' : $IX37684 = $this->get_sort_order(); break; case 'banner-search': case 'search' : $IX37684 = $this->get_search(); break; case 'banner_url' : $IX37684 = $this->get_banner_url(); break; } if ( $IX37684 !== null ) { $IX34459 = add_query_arg( $IX58094, $IX37684, $IX34459 ); } } foreach ( $params as $IX34095 => $IX37684 ) { $IX34459 = remove_query_arg( $IX34095, $IX34459 ); if ( $IX37684 !== null ) { $IX34459 = add_query_arg( $IX34095, $IX37684, $IX34459 ); } } return $IX34459; }

	public function render() { global $affiliates_version; if ( $this->get_affiliate_id() === null ) { return; } $IX53418 = !empty( $_REQUEST['per_page'] ) ? min( max( 1, intval( trim( $_REQUEST['per_page'] ) ) ), self::MAX_PER_PAGE ) : null; if ( $IX53418 !== null ) { $this->per_page = intval( $IX53418 ); } $this->current_page = isset( $_REQUEST['banners-page'] ) ? max( 0, intval( $_REQUEST['banners-page'] ) ) : 0; wp_enqueue_script( 'affiliates-dashboard-banners-controls', AFFILIATES_PLUGIN_URL . 'js/dashboard-banners-controls.js', array( 'jquery' ), $affiliates_version ); $IX60039 = null; $IX33299 = null; if ( isset( $_REQUEST['clear_filters'] ) ) { unset( $_REQUEST['banner-search'] ); unset( $_REQUEST['search'] ); unset( $_REQUEST['banner-url'] ); $this->search = null; $this->banner_url = null; } else { if ( !empty( $_REQUEST['search'] ) ) { $IX60039 = trim( $_REQUEST['search'] ); } if ( !empty( $_REQUEST['banner-search'] ) ) { $IX60039 = trim( $_REQUEST['banner-search'] ); } if ( $IX60039 !== null ) { $IX60039 = wp_check_invalid_utf8( $IX60039 ); $IX60039 = preg_replace( '/[\r\n\t ]+/', ' ', $IX60039 ); $IX60039 = trim( $IX60039 ); if ( strlen( $IX60039 ) === 0 ) { $IX60039 = null; } } if ( !empty( $_REQUEST['banner-url'] ) ) { $IX33299 = trim( $_REQUEST['banner-url'] ); if ( !empty( $IX33299 ) ) { if ( ( stripos( $IX33299, 'http://' ) !== 0 ) && ( stripos( $IX33299, 'https://' ) !== 0 ) ) { $IX33299 = ( is_ssl() ? 'https://' : 'http://' ) . $IX33299; } $IX39159 = parse_url( $IX33299 ); if ( $IX39159 === false ) { $IX33299 = null; } } else { $IX33299 = null; } } } $this->search = $IX60039; $this->banner_url = $IX33299; $IX85658 = array( 'numberposts' => -1, 'post_type' => 'affiliates_banner', 'post_status' => 'publish', 'fields' => 'ids', 'suppress_filters' => false ); if ( $this->search !== null ) { $IX85658['s'] = $this->search; } $IX80864 = get_posts( apply_filters( 'affiliates_dashboard_banners_get_posts', $IX85658 ) ); foreach ( $IX80864 as $IX20450 ) { if ( get_post_thumbnail_id( $IX20450 ) || get_post_meta( $IX20450, 'url', true ) ) { $this->entries[] = (object) array( 'banner_id' => $IX20450, 'url' => $this->get_affiliate_url( $this->banner_url ), 'image' => self::get_banner_image( $IX20450 ) ); } } $this->count = $this->entries !== null ? count( $this->entries ) : 0; $IX70549 = $this->per_page * $this->current_page; if ( $this->entries !== null ) { $this->entries = array_splice( $this->entries, $IX70549, $this->per_page ); } parent::render(); }

	protected function get_affiliate_url( $url ) { if ( $url === null ) { $url = home_url(); } return Affiliates_Url_Renderer_WordPress::render_affiliate_url( array( 'url' => $url, 'type' => 'append' ) ); }
}
Affiliates_Dashboard_Banners::init();
