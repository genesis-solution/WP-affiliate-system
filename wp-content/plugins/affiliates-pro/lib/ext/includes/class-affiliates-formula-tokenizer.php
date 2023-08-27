<?php
/**
 * class-affiliates-formula-tokenizer.php
 *
 * Copyright 2019 "kento" Karim Rahimpur - www.itthinx.com
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

/**
 * Arithmetic formula tokenizer.
 */
class Affiliates_Formula_Tokenizer {

	const ASSOCIATIVITY  = 'associativity';
	const PRECEDENCE     = 'precedence';
	const LEFT           = 'left';
	const RIGHT          = 'right';

	const TOKEN_EXPONENT = '**';
	const TOKEN_MULTIPLY = '*';
	const TOKEN_DIVIDE   = '/';
	const TOKEN_MODULO   = '%';
	const TOKEN_ADD      = '+';
	const TOKEN_SUBTRACT = '-';

	const TOKEN_LEFT_PARENTHESIS  = '(';
	const TOKEN_RIGHT_PARENTHESIS = ')';

	const TOKEN_NUMBER      = 'number';
	const TOKEN_VARIABLE    = 'variable';
	const TOKEN_PLACEHOLDER = 'placeholder';

	static $operators = array(
		self::TOKEN_EXPONENT => array(
			self::ASSOCIATIVITY => self::RIGHT,
			self::PRECEDENCE    => 3,
		),
		self::TOKEN_MULTIPLY => array(
			self::ASSOCIATIVITY => self::LEFT,
			self::PRECEDENCE    => 2,
		),
		self::TOKEN_DIVIDE => array(
			self::ASSOCIATIVITY => self::LEFT,
			self::PRECEDENCE    => 2,
		),
		self::TOKEN_MODULO => array(
			self::ASSOCIATIVITY => self::LEFT,
			self::PRECEDENCE    => 2,
		),
		self::TOKEN_ADD => array(
			self::ASSOCIATIVITY => self::LEFT,
			self::PRECEDENCE    => 1
		),
		self::TOKEN_SUBTRACT => array(
			self::ASSOCIATIVITY => self::LEFT,
			self::PRECEDENCE    => 1,
		)
	);

	private $expression = null;

	private $current_token = null;

	private $tokens = null;

	public function __construct( $expression ) { if ( is_string( $expression ) ) { $this->expression = $expression; $this->tokenize(); } }

	public function tokenize() { if ( $this->expression !== null ) { $IX47927 = preg_replace( '/\s+/', '', $this->expression ); $IX35978 = null; preg_match_all( '/' . '\d+\.\d*' . '|' . '\d*\.\d+' . '|' . '\d+' . '|' . '{[a-zA-Z_][a-zA-Z0-9_]*}' . '|' . '[a-zA-Z_][a-zA-Z0-9_]*' . '|' . '\(' . '|' . '\)' . '|' . '\*\*' . '|' . '\*' . '|' . '\/' . '|' . '%' . '|' . '\+' . '|' . '\-' . '/', $IX47927, $IX35978 ); $this->tokens = array(); $IX89393 = 0; foreach ( $IX35978[0] as $IX63200 ) { $IX50303 = null; $IX42635 = null; $IX23922 = null; $IX34269 = null; switch ( $IX63200 ) { case self::TOKEN_EXPONENT : case self::TOKEN_MULTIPLY : case self::TOKEN_DIVIDE : case self::TOKEN_MODULO : case self::TOKEN_ADD : case self::TOKEN_SUBTRACT : $IX34269 = $IX63200; $IX42635 = self::$operators[$IX63200][self::ASSOCIATIVITY]; $IX23922 = self::$operators[$IX63200][self::PRECEDENCE]; break; case self::TOKEN_LEFT_PARENTHESIS : $IX34269 = $IX63200; $IX89393++; break; case self::TOKEN_RIGHT_PARENTHESIS : $IX34269 = $IX63200; $IX89393--; break; default : if ( is_numeric( $IX63200 ) ) { $IX34269 = self::TOKEN_NUMBER; $IX50303 = floatval( $IX63200 ); break; } else { if ( strpos( $IX63200, '{' ) !== false ) { $IX34269 = self::TOKEN_PLACEHOLDER; $IX50303 = substr( $IX63200, 1, strlen( $IX63200 ) - 2 ); } else { $IX34269 = self::TOKEN_VARIABLE; $IX50303 = $IX63200; } } } if ( $IX34269 !== null ) { $this->tokens[] = array( 'token' => $IX34269, 'value' => $IX50303, 'associativity' => $IX42635, 'precedence' => $IX23922, 'level' => $IX89393 ); } } } }

	public function to_string() { $IX30714 = array(); if ( $this->tokens !== null ) { foreach ( $this->tokens as $IX98788 ) { if ( isset( $IX98788['value'] ) ) { $IX30714[] = $IX98788['value']; } else if ( isset( $IX98788['token'] ) ) { $IX30714[] = $IX98788['token']; } } } $IX30714 = implode( ' ', $IX30714 ); return $IX30714; }

	public function get_tokens() { return $this->tokens; }

	public function get_next_token() { $IX28810 = null; if ( $this->tokens !== null && count( $this->tokens ) > 0 ) { if ( $this->current_token === null ) { $this->current_token = 0; } else { $this->current_token++; } if ( $this->current_token < count( $this->tokens ) ) { $IX28810 = $this->tokens[$this->current_token]; } } return $IX28810; }

	public function get_current_token() { $IX64955 = null; if ( $this->tokens !== null && count( $this->tokens ) > 0 ) { if ( $this->current_token === null ) { $this->current_token = 0; } if ( $this->current_token < count( $this->tokens ) ) { $IX64955 = $this->tokens[$this->current_token]; } } return $IX64955; }

	public function get_current_token_index() { return $this->current_token; }

	/**
	 * Returns the token at the given index or null if there is none.
	 *
	 * @param int $token_index 0, 1, ...
	 *
	 * @return array|null
	 */
	public function get_token_at_index( $token_index ) { $IX33235 = null; if ( $this->tokens !== null && count( $this->tokens ) > 0 ) { if ( $token_index < count( $this->tokens ) ) { $IX33235 = $this->tokens[$token_index]; } } return $IX33235; }
}
