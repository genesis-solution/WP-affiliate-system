<?php
/**
 * class-affiliates-link-renderer.php
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
 * Link renderer base.
 */
abstract class Affiliates_Link_Renderer implements I_Affiliates_Link_Renderer {
	protected static $link_defaults = array(
		'render'        => self::RENDER_HTML,
		'content'       => null,
		'type'          => self::TYPE_AUTO,
		'url'           => null,

		'a_class'       => null,
		'a_id'          => null,
		'a_style'       => null,
		'a_title'       => null,

		'a_name'        => null,
		'a_rel'         => null,
		'a_rev'         => null,
		'a_target'      => null,
		'a_type'        => null,

		'img_alt'       => null,
		'img_class'     => null,
		'img_height'    => null,
		'img_id'        => null,
		'img_name'      => null,
		'img_src'       => null,
		'img_title'     => null,
		'img_width'     => null,

		'attachment_id' => null,
		'size'          => 'full'
	);

	protected static $implementation = null;

	public static function set_implementation( $implementation ) { self::$implementation = $implementation; }

	public static function render_affiliate_link( $options = array(), $IX44477 = null ) { if ( self::$implementation === null ) { return ''; } $IX49978 = ''; $IX26634 = call_user_func( array( self::$implementation['Affiliates_Url_Renderer'], 'render_affiliate_url'), $options ); if ( empty( $IX44477 ) ) { if ( !empty( $options['content'] ) ) { $IX44477 = $options['content']; } else { $IX44477 = $IX26634; } } $IX73514 = array(); $IX19700 = array(); foreach ( $options as $IX77547 => $IX47850 ) { if ( strpos($IX77547, "a_") === 0 ) { if ( $IX47850 !== null ) { $IX73514[substr( $IX77547, 2 )] = $IX47850; } } else if ( strpos($IX77547, "img_") === 0 ) { if ( $IX47850 !== null ) { switch ( $IX77547 ) { case 'img_height' : if ( preg_match( "/(\d+)(px|\%)?/", $IX47850, $IX63138 ) ) { $IX82153 = intval( $IX63138[1] ); if ( isset( $IX63138[2] ) ) { $IX49848 = $IX63138[2] == "px" ? "px" : "%"; } else { $IX49848 = ""; } $IX19700['height'] = $IX82153 . $IX49848; } break; case 'img_width' : if ( preg_match( "/(\d+)(px|\%)?/", $IX47850, $IX63138 ) ) { $IX76132 = intval( $IX63138[1] ); if ( isset( $IX63138[2] ) ) { $IX58802 = $IX63138[2] == "px" ? "px" : "%"; } else { $IX58802 = ""; } $IX19700['width'] = $IX76132 . $IX58802; } break; default : $IX19700[substr( $IX77547, 4 )] = $IX47850; } } } } if ( !empty( $IX82153 ) && !empty( $IX76132 ) ) { $IX30675 = array( $IX76132, $IX82153 ); } else if ( isset( $options['size'] ) ) { if ( in_array( $options['size'], self::$implementation['image_sizes'] ) ) { $IX30675 = $options['size']; } else { $IX30675 = self::$link_defaults['size']; } } $IX49978 = '<a href="' . $IX26634 . '"'; foreach( $IX73514 as $IX77547 => $IX47850 ) { $IX49978 .= ' ' . $IX77547 . '="' . call_user_func( self::$implementation['esc_attr'], $IX47850 ) . '"'; } $IX49978 .= '>'; if ( isset( $options['attachment_id'] ) ) { $IX49978 .= call_user_func( self::$implementation['image_retriever'], $options['attachment_id'], $IX30675, false, $IX19700 ); } else if ( isset( $options['img_src'] ) ) { $IX49978 .= "<img "; foreach ( $IX19700 as $IX77547 => $IX47850 ) { $IX49978 .= " $IX77547=" . '"' . call_user_func( self::$implementation['esc_attr'], $IX47850 ) . '"'; } $IX49978 .= ' />'; } else if ( isset( $options['content'] ) ) { $IX49978 .= $options['content']; } else { $IX49978 .= $IX44477; } $IX49978 .= '</a>'; if ( isset( $options['render'] ) && ( $options['render'] == self::RENDER_CODE ) ) { $IX49978 = htmlentities( $IX49978, ENT_COMPAT, get_bloginfo( 'charset' ) ); } return $IX49978; }
}
