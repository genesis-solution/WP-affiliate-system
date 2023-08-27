<?php
/**
 * class-affiliates-url-renderer.php
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
 * URL-renderer - implementation-independent abstraction to be used as the base for implementation-specific renderers.
 */
abstract class Affiliates_Url_Renderer implements I_Affiliates_Url_Renderer {
	protected static $pname   = 'affiliates';
	protected static $cname   = 'cmid';
	protected static $encoder = null;
	protected static $url_defaults = array(
		'type'   => self::TYPE_AUTO,
		'url'    => null
	);

	protected static $implementation = null;

	public static function set_implementation( $implementation ) { self::$implementation = $implementation; }

	static function render_affiliate_url( $options = array() ) { if ( self::$implementation === null ) { return ''; } $IX18341 = ''; if ( $IX80934 = call_user_func( array( self::$implementation['Affiliates_Affiliate'], 'get_user_affiliate_id' ) ) ) { $IX30966 = call_user_func( self::$encoder, $IX80934 ); } else { $IX30966 = 'affiliate-id'; } if ( !isset( $options['type'] ) ) { $options['type'] = self::TYPE_AUTO; } if ( isset( $options['url'] ) ) { $IX31244 = $options['url']; } else { $IX31244 = ''; } switch ( $options['type'] ) { case self::TYPE_APPEND : $IX18341 = self::get_affiliate_url( $IX31244, $IX80934 ); break; case self::TYPE_PARAMETER : $IX18341 = self::get_affiliate_url( $IX31244, $IX80934 ); break; case self::TYPE_PRETTY : $IX18341 = $IX31244 . '/' . self::$pname . '/' . $IX30966; break; case self::TYPE_AUTO : default : if ( isset( $options['use_parameter'] ) && $options['use_parameter'] ) { $IX18341 = $IX31244 . '/' . self::$pname . '/' . $IX30966; } else { $IX18341 = self::get_affiliate_url( $IX31244, $IX80934 ); } break; } return $IX18341; }

	public static function compose_url( $components ) { $IX40834 = isset( $components['scheme'] ) ? $components['scheme'] . '://' : ''; $IX50361 = isset( $components['host'] ) ? $components['host'] : ''; $IX67594 = isset( $components['port'] ) ? ':' . $components['port'] : ''; $IX40567 = isset( $components['user'] ) ? $components['user'] : ''; $IX92914 = isset( $components['pass'] ) ? ':' . $components['pass'] : ''; $IX92914 = ( !empty( $IX40567 ) || !empty( $IX92914 ) ) ? "$IX92914@" : ''; $IX70470 = isset( $components['path'] ) ? $components['path'] : ''; $IX32120 = isset( $components['query'] ) ? '?' . $components['query'] : ''; $IX98595 = isset( $components['fragment'] ) ? '#' . $components['fragment'] : ''; return "$IX40834$IX40567$IX92914$IX50361$IX67594$IX70470$IX32120$IX98595"; }

	public static function get_affiliate_url( $url, $affiliate_id, $campaign_id = null, $params = array() ) { $IX52203 = self::$pname; $IX83633 = self::$cname; $IX11758 = self::$encoder; $IX28104 = parse_url( $url, PHP_URL_SCHEME ); if ( empty( $IX28104 ) ) { $IX22233 = ''; if ( strpos( $url, 'http://' ) !== 0 && strpos( $url, 'https://' ) !== 0 ) { $IX22233 = !empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) != 'off' ? 'https:' : 'http:'; if ( strpos( $url, '//' ) !== 0 ) { $IX22233 .= '//'; } } $url = $IX22233 . $url; } $IX10733 = parse_url( $url ); if ( strpos( isset( $IX10733['query'] ) ? $IX10733['query'] : '', "$IX52203=" ) === false ) { $IX21684 = ''; if ( !empty( $IX10733['query'] ) ) { $IX21684 = $IX10733['query'] . '&'; } $IX21546 = $affiliate_id; if ( !empty( $IX11758 ) ) { $IX21546 = call_user_func( $IX11758, $affiliate_id ); } $IX21684 .= sprintf( '%s=%s', $IX52203, $IX21546 ); if ( empty( $IX10733['path'] ) ) { $IX10733['path'] = '/'; } if ( !empty( $campaign_id ) ) { $IX21684 .= '&'; $IX21684 .= sprintf( '%s=%s', $IX83633, $campaign_id ); } $IX10733['query'] = $IX21684; } return self::compose_url( $IX10733 ); }

}
