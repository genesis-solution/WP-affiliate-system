<?php
/**
 * fake_bcmath.php
 *
 * Every time you use any of the fake bcmath functions, a puppy dies.
 * So please don't do it and get yourself bcmath enabled.
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
 * @since affiliates-pro 1.1.0
 */

global $fake_bcmath_scale;
$fake_bcmath_scale = null;

function fake_bcadd( $left_operand, $right_operand, $scale = null ) { return fake_bcmath_scale( ( string ) ( doubleval( $left_operand ) + doubleval( $right_operand ) ), $scale ); }

function fake_bccomp( $left_operand, $right_operand, $scale = null ) { $IX56718 = doubleval( fake_bcmath_scale( $left_operand, $scale ) ); $IX54235 = doubleval( fake_bcmath_scale( $right_operand, $scale ) ); $IX71885 = 0; if ( $IX56718 < $IX54235 ) { $IX71885 = -1; } else if ( $IX56718 > $IX54235 ) { $IX71885 = 1; } return $IX71885; }

function fake_bcdiv( $left_operand, $right_operand, $scale = null ) { return fake_bcmath_scale( ( string ) ( doubleval( $left_operand ) / doubleval( $right_operand ) ), $scale ); }

function fake_bcmod( $left_operand, $modulus ) { return ( string ) ( intval( $left_operand ) % intval( $modulus ) ); }

function fake_bcmul( $left_operand, $right_operand, $scale = null ) { return fake_bcmath_scale( ( string ) ( doubleval( $left_operand ) * doubleval( $right_operand ) ), $scale ); }

function fake_bcpow( $left_operand, $right_operand, $scale = null ) { return fake_bcmath_scale( ( string ) ( pow( doubleval( $left_operand ), doubleval( $right_operand ) ) ), $scale ); }

function fake_bcpowmod( $left_operand , $right_operand , $modulus, $scale = null ) { if ( $modulus == 0 ) { $IX36428 = null; } else { $IX36428 = fake_bcmath_scale( ( string ) ( pow( doubleval( $left_operand ), doubleval( $right_operand ) ) % intval( $modulus ) ), $scale ); } return $IX36428; }

function fake_bcscale( $scale ) { global $fake_bcmath_scale; $IX45126 = intval( $scale ); if ( $IX45126 >= 0 ) { $fake_bcmath_scale = $IX45126; return true; } else { return false; } }

function fake_bcsqrt( $operand, $scale = null ) { return fake_bcmath_scale( ( string ) sqrt( doubleval( $operand ) ), $scale ); }

function fake_bcsub( $left_operand, $right_operand, $scale = null ) { return fake_bcmath_scale( ( string ) ( doubleval( $left_operand ) - doubleval( $right_operand ) ), $scale ); }

function fake_bcmath_scale( $value, $scale = null ) { global $fake_bcmath_scale; $IX15382 = null; if ( $scale !== null ) { $IX15382 = intval( $scale ); } else if ( $fake_bcmath_scale !== null ) { $IX15382 = intval( $fake_bcmath_scale ); } if ( $IX15382 !== null ) { return ( string ) round( doubleval( $value ), $IX15382 ); } else { return $value; } }

if ( !function_exists( 'bcadd' ) ) {
	function bcadd( $left_operand, $right_operand, $scale = null ) { return fake_bcadd( $left_operand, $right_operand, $scale ); }
}
if ( !function_exists( 'bccomp' ) ) {
	function bccomp( $left_operand, $right_operand, $scale = null ) { return fake_bccomp( $left_operand, $right_operand, $scale ); }
}
if ( !function_exists( 'bcdiv' ) ) {
	function bcdiv( $left_operand, $right_operand, $scale = null ) { return fake_bcdiv($left_operand, $right_operand, $scale ); }
}
if ( !function_exists( 'bcmod' ) ) {
	function bcmod( $left_operand, $modulus ) { return fake_bcmod( $left_operand, $modulus ); }
}
if ( !function_exists( 'bcmul' ) ) {
	function bcmul( $left_operand, $right_operand, $scale = null ) { return fake_bcmul( $left_operand, $right_operand, $scale ); }
}
if ( !function_exists( 'bcpow' ) ) {
	function bcpow( $left_operand, $right_operand, $scale = null ) { return fake_bcpow($left_operand, $right_operand, $scale ); }
}
if ( !function_exists( 'bcpowmod' ) ) {
	function bcpowmod( $left_operand , $right_operand , $modulus, $scale = null ) { return fake_bcpowmod($left_operand, $right_operand, $modulus, $scale ); }
}
if ( !function_exists( 'bcscale' ) ) {
	function bcscale( $scale ) { return fake_bcscale( $scale ); }
}
if ( !function_exists( 'bcsqrt' ) ) {
	function bcsqrt( $operand, $scale = null ) { return fake_bcsqrt( $operand, $scale ); }
}
if ( !function_exists( 'bcsub' ) ) {
	function bcsub( $left_operand, $right_operand, $scale = null ) { return fake_bcsub( $left_operand, $right_operand, $scale ); }
}
