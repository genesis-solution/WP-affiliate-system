<?php
/**
 * class-affiliates-mail.php
 *
 * Copyright 2012 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 2.1.4
 */

/**
 * Mail handler.
 */
class Affiliates_Mail {

	private $mailer = 'mail';

	private $charset = 'UTF-8';

	public function __set( $name, $value ) { switch ( $name ) { case 'mailer' : $this->mailer = $value; break; case 'charset' : $this->charset = $value; break; } }

	public function __get( $name ) { $IX16723 = null; switch ( $name ) { case 'mailer' : $IX16723 = $this->mailer; break; case 'charset' : $IX16723 = $this->charset; break; } return $IX16723; }

	public function __construct() { }

	public function mail( $email, $subject, $message, $tokens = array(), $IX39053 = array(), $IX42227 = array() ) {
//        $IX64535 = 'MIME-Version: 1.0' . "\r\n";
//        $IX64535 .= 'Content-type: text/html; charset="' . get_option( 'blog_charset' ) . '"' . "\r\n";
//        foreach ( $tokens as $IX42674 => $IX41223 ) {
//            if ( key_exists( $IX42674, $tokens ) ) {
//                $IX26134 = $tokens[$IX42674];
//                if ( $IX26134 === null ) { $IX26134 = ''; }
//                $subject = str_replace( "[" . $IX42674 . "]", $IX26134, $subject );
//                $message = str_replace( "[" . $IX42674 . "]", $IX26134, $message ); }
//        }
//        foreach ( $IX39053 as $IX13946 ) {
//            if ( isset( $IX42227[$IX13946]['value'] ) ) {
//                $IX26134 = Affiliates_Utility::filter( $IX42227[$IX13946]['value'] ); }
//            else { $IX26134 = ''; } if ( $IX26134 === null ) { $IX26134 = ''; }
//            $subject = str_replace( "[" . $IX13946 . "]", $IX26134, $subject );
//            $message = str_replace( "[" . $IX13946 . "]", $IX26134, $message ); }
//        @call_user_func( $this->mailer, $email, $subject, $message, $IX64535 );
    }
}
