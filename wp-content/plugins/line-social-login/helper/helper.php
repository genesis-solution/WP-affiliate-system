<?php

namespace WP_Social\Helper;

defined('ABSPATH') || exit;

class Helper {

	public static function is_true($val1, $val2, $print) {
		return esc_attr($val1 === $val2 ? $print : '');
	}

	public static function sanitize_white_list($val, $def, $white_list) {

		if(in_array($val, $white_list)) {

			return $val;
		}

		return $def;
	}

	public static function get_kses_array(){
		return array(
			'a'                             => array(
				'class'  => array(),
				'href'   => array(),
				'rel'    => array(),
				'title'  => array(),
				'target' => array(),
				'style'  => array(),
				'id'  => array(),
				'onclick'  => array(),
				'data-pid'  => array(),
				'data-uri_hash'  => array(),
				'data-key'  => array(),
				'data-xs-href'  => array(),
			),
			'abbr'                          => array(
				'title' => array(),
			),
			'b'                             => array(
                'class' => array(),
            ),
			'blockquote'                    => array(
				'cite' => array(),
			),
			'cite'                          => array(
				'title' => array(),
			),
			'button'                          => array(
				'data-type' => array(),
				'data-target' => array(),
				'class'  => array(),
			),
			'code'                          => array(),
			'pre'                           => array(),
			'del'                           => array(
				'datetime' => array(),
				'title'    => array(),
			),
			'dd'                            => array(),
			'div'                           => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'dl'                            => array(),
			'dt'                            => array(),
			'em'                            => array(),
			'strong'                        => array(),
			'h1'                            => array(
				'class' => array(),
			),
			'h2'                            => array(
				'class' => array(),
			),
			'h3'                            => array(
				'class' => array(),
			),
			'h4'                            => array(
				'class' => array(),
			),
			'h5'                            => array(
				'class' => array(),
			),
			'h6'                            => array(
				'class' => array(),
			),
			'i'                             => array(
				'class' => array(),
			),
			'img'                           => array(
				'alt'		=> array(),
				'class'		=> array(),
				'height'	=> array(),
				'src'		=> array(),
				'width'		=> array(),
				'style'		=> array(),
				'title'		=> array(),
				'srcset'	=> array(),
				'loading'	=> array(),
				'sizes'		=> array(),
			),
			'figure'                        => array(
				'class'		=> array(),
			),
			'li'                            => array(
				'class' => array(),
			),
			'ol'                            => array(
				'class' => array(),
			),
			'p'                             => array(
				'class' => array(),
			),
			'q'                             => array(
				'cite'  => array(),
				'title' => array(),
			),
			'span'                          => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'iframe'                        => array(
				'width'       => array(),
				'height'      => array(),
				'scrolling'   => array(),
				'frameborder' => array(),
				'allow'       => array(),
				'src'         => array(),
			),
			'strike'                        => array(),
			'br'                            => array(),
			'table'                         => array(),
			'thead'                         => array(),
			'tbody'                         => array(),
			'tfoot'                         => array(),
			'tr'                            => array(),
			'th'                            => array(),
			'td'                            => array(),
			'colgroup'                      => array(),
			'col'                           => array(),
			'strong'                        => array(),
			'data-wow-duration'             => array(),
			'data-wow-delay'                => array(),
			'data-wallpaper-options'        => array(),
			'data-stellar-background-ratio' => array(),
			'ul'                            => array(
				'class' => array(),
			),
			'svg'                           => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true, // <= Must be lower case!
                'preserveaspectratio' => true,
			),
			'g'                             => array( 'fill' => true ),
			'title'                         => array( 'title' => true ),
			'path'                          => array(
				'd'    => true,
				'fill' => true,
			),
			'input'							=> array(
				'class'		=> array(), 
				'type'		=> array(), 
				'value'		=> array()
			)
		);
	}

}
