<?php
/**
 * class-affiliates-formula-computer.php
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
 * Parses and computes the value of a tokenized expression.
 */
class Affiliates_Formula_Computer {

	const LIMIT = 1024;

	const ERROR                              = 'error';
	const ERROR_DIVISION_BY_ZERO             = 'division-by-zero';
	const ERROR_UNMATCHED_PARENTHESIS        = 'unmatched-parenthesis';
	const ERROR_UNEXPECTED_OPERATOR          = 'unexpected-operator';
	const ERROR_UNSUPPORTED_OPERATOR         = 'unsupported-operator';
	const ERROR_UNEXPECTED_END_OF_EXPRESSION = 'unexpected-end-of-expression';
	const ERROR_EXCEEDED_PRECEDENCE_LIMIT    = 'exceeded-precedence-limit';
	const ERROR_UNDEFINED_VARIABLE           = 'undefined-variable';

	private $errors = null;

	private $to_human = array(
		self::ERROR                              => 'Error',
		self::ERROR_DIVISION_BY_ZERO             => 'Division by Zero',
		self::ERROR_UNMATCHED_PARENTHESIS        => 'Unmatched Parenthesis',
		self::ERROR_UNEXPECTED_OPERATOR          => 'Unexpected Operator',
		self::ERROR_UNSUPPORTED_OPERATOR         => 'Unsupported Operator',
		self::ERROR_UNEXPECTED_END_OF_EXPRESSION => 'Unexpected End of Expression',
		self::ERROR_EXCEEDED_PRECEDENCE_LIMIT    => 'Exceeded Precedence Limit',
		self::ERROR_UNDEFINED_VARIABLE           => 'Undefined Variable'
	);

	private $variables = array();

	private $trace = false;

	private $traces = array();

	public function __construct( $tokenizer, $variables = null, $params = null ) { $this->tokenizer = $tokenizer; if ( $variables !== null && is_array( $variables ) ) { $this->variables = $variables; } if ( is_array( $params ) ) { if ( isset( $params['to_human'] ) ) { $this->to_human = $params['to_human']; } if ( isset( $params['trace'] ) ) { $this->trace = ( $params['trace'] === true ); } } }

	public function compute() { return $this->evaluate( 1 ); }

	public function get_errors() { return $this->errors; }

	public function has_errors() { return $this->errors !== null && count( $this->errors ) > 0; }

	public function get_trace() { return $this->trace; }

	public function get_traces() { return $this->traces; }

	public function get_errors_pretty( $format = 'html' ) { $IX71942 = ''; if ( $this->errors !== null && count( $this->errors ) > 0 ) { $IX69333 = array(); foreach ( $this->errors as $IX64942 ) { $IX69333[$IX64942['token_index']][] = $IX64942; } $IX21331 = $this->tokenizer->get_tokens(); if ( $IX21331 !== null && count( $IX21331 ) > 0 ) { foreach ( $IX21331 as $IX45337 => $IX11996 ) { $IX88811 = array( 'token' ); $IX11880 = array(); if ( !empty( $IX69333[$IX45337] ) ) { $IX88811[] = 'error'; $IX11880[] = isset( $this->to_human[self::ERROR] ) ? $this->to_human[self::ERROR] : self::ERROR; foreach ( $IX69333[$IX45337] as $IX64942 ) { $IX88811[] = $IX64942['error']; $IX11880[] = isset( $this->to_human[$IX64942['error']] ) ? $this->to_human[$IX64942['error']] : $IX64942['error']; } } $IX25710 = implode( ' ', $IX88811 ); $IX56169 = $format === 'html' ? implode( ' &ndash; ', $IX11880 ) : implode( ' - ', $IX11880 ); $IX71942 .= $format === 'html' ? '<span title="' . $IX56169 . '" class="' . $IX25710 . '">' : ( strlen( $IX56169 ) > 0 ? '[' . $IX56169 . ']' : '' ); if ( isset( $IX11996['value'] ) ) { $IX71942 .= $IX11996['value']; } else if ( isset( $IX11996['token'] ) ) { $IX71942 .= $IX11996['token']; } else { $IX71942 .= $format === 'html' ? '&nbsp;' : ' '; } $IX71942 .= $format === 'html' ? '</span>' : ''; } } if ( isset( $IX69333[$IX45337 + 1] ) ) { $IX88811 = array( 'error' ); $IX11880 = array( isset( $this->to_human[self::ERROR] ) ? $this->to_human[self::ERROR] : self::ERROR ); foreach ( $IX69333[$IX45337 + 1] as $IX64942 ) { $IX88811[] = $IX64942['error']; $IX11880[] = $this->to_human[$IX64942['error']]; } $IX25710 = implode( ' ', $IX88811 ); $IX56169 = $format === 'html' ? implode( ' &ndash; ', $IX11880 ) : implode( ' - ', $IX11880 ); $IX71942 .= $format === 'html' ? '<span title="' . $IX56169 . '" class="' . $IX25710 . '">' : ( strlen( $IX56169 ) > 0 ? '[' . $IX56169 . ']' : '' ); $IX71942 .= $format === 'html' ? '&nbsp;' : ' '; $IX71942 .= $format === 'html' ? '</span>' : ''; } } return $IX71942; }

	private function process_node() { $IX40082 = $this->tokenizer->get_current_token(); if ( $IX40082 !== null ) { switch ( $IX40082['token'] ) { case Affiliates_Formula_Tokenizer::TOKEN_LEFT_PARENTHESIS : $this->tokenizer->get_next_token(); $IX84875 = $this->evaluate( 1 ); $IX90281 = $this->tokenizer->get_current_token(); if ( $IX90281 === null || $IX90281['token'] !== Affiliates_Formula_Tokenizer::TOKEN_RIGHT_PARENTHESIS ) { $this->errors[] = array( 'error' => self::ERROR_UNMATCHED_PARENTHESIS, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); break; } $this->tokenizer->get_next_token(); return $IX84875; break; case Affiliates_Formula_Tokenizer::TOKEN_EXPONENT : case Affiliates_Formula_Tokenizer::TOKEN_MULTIPLY : case Affiliates_Formula_Tokenizer::TOKEN_DIVIDE : case Affiliates_Formula_Tokenizer::TOKEN_MODULO : case Affiliates_Formula_Tokenizer::TOKEN_ADD : case Affiliates_Formula_Tokenizer::TOKEN_SUBTRACT : $this->errors[] = array( 'error' => self::ERROR_UNEXPECTED_OPERATOR, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); break; case Affiliates_Formula_Tokenizer::TOKEN_NUMBER : $IX84875 = $IX40082['value']; $this->tokenizer->get_next_token(); return $IX84875; break; case Affiliates_Formula_Tokenizer::TOKEN_VARIABLE : if ( $this->variables !== null && isset( $this->variables[$IX40082['value']] ) && is_numeric( $this->variables[$IX40082['value']] ) ) { $IX84875 = floatval( $this->variables[$IX40082['value']] ); $this->tokenizer->get_next_token(); return $IX84875; } else { $this->errors[] = array( 'error' => self::ERROR_UNDEFINED_VARIABLE, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); } break; } } $this->errors[] = array( 'error' => self::ERROR_UNEXPECTED_END_OF_EXPRESSION, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); return null; }

	private function evaluate( $precedence ) { $IX28586 = $this->process_node(); if ( $this->trace ) { $IX39851 = array( $IX28586 ); } $IX60540 = 0; while ( $IX60540 < self::LIMIT ) { $IX23734 = $this->tokenizer->get_current_token(); $IX19878 = false; if ( $IX23734 !== null ) { switch ( $IX23734['token'] ) { case Affiliates_Formula_Tokenizer::TOKEN_EXPONENT : case Affiliates_Formula_Tokenizer::TOKEN_MULTIPLY : case Affiliates_Formula_Tokenizer::TOKEN_DIVIDE : case Affiliates_Formula_Tokenizer::TOKEN_MODULO : case Affiliates_Formula_Tokenizer::TOKEN_ADD : case Affiliates_Formula_Tokenizer::TOKEN_SUBTRACT : $IX19878 = true; break; } } if ( $IX23734 === null || !$IX19878 || $IX23734['precedence'] < $precedence ) { break; } $IX53736 = $IX23734['associativity'] === Affiliates_Formula_Tokenizer::LEFT ? $IX23734['precedence'] + 1 : $IX23734['precedence']; $this->tokenizer->get_next_token(); $IX49485 = $this->evaluate( $IX53736 ); if ( $this->trace ) { switch ( $IX23734['token'] ) { case Affiliates_Formula_Tokenizer::TOKEN_EXPONENT : case Affiliates_Formula_Tokenizer::TOKEN_MULTIPLY : case Affiliates_Formula_Tokenizer::TOKEN_DIVIDE : case Affiliates_Formula_Tokenizer::TOKEN_MODULO : case Affiliates_Formula_Tokenizer::TOKEN_ADD : case Affiliates_Formula_Tokenizer::TOKEN_SUBTRACT : $IX39851[] = $IX23734['token']; break; } $IX39851[] = $IX49485; } switch ( $IX23734['token'] ) { case Affiliates_Formula_Tokenizer::TOKEN_EXPONENT : $IX28586 = $IX28586 ** $IX49485; break; case Affiliates_Formula_Tokenizer::TOKEN_MULTIPLY : $IX28586 = $IX28586 * $IX49485; break; case Affiliates_Formula_Tokenizer::TOKEN_DIVIDE : if ( floatval( $IX49485 ) !== 0.0 ) { $IX28586 = $IX28586 / $IX49485; } else { $this->errors[] = array( 'error' => self::ERROR_DIVISION_BY_ZERO, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); } break; case Affiliates_Formula_Tokenizer::TOKEN_MODULO : $IX28586 = $IX28586 % $IX49485; break; case Affiliates_Formula_Tokenizer::TOKEN_ADD : $IX28586 = $IX28586 + $IX49485; break; case Affiliates_Formula_Tokenizer::TOKEN_SUBTRACT : $IX28586 = $IX28586 - $IX49485; break; default : $this->errors[] = array( 'error' => self::ERROR_UNSUPPORTED_OPERATOR, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); } $IX60540++; } if ( $IX60540 >= self::LIMIT ) { $this->errors[] = array( 'error' => self::ERROR_EXCEEDED_PRECEDENCE_LIMIT, 'token_index' => $this->tokenizer->get_current_token_index(), 'token' => $this->tokenizer->get_token_at_index( $this->tokenizer->get_current_token_index() ) ); } if ( $this->trace ) { array_unshift( $IX39851, $IX28586 ); $this->traces[] = $IX39851; } return $IX28586; }

}
