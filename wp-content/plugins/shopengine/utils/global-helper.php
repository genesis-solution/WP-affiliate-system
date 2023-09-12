<?php

use ShopEngine\Core\MultiLanguage\Language;

if ( !function_exists( 'shopengine_translate' ) ) {
    /**
     * @param $key
     * @param $value
     */
    function shopengine_translator( $key, $value )
    {
        if ( 'polylang' === Language::$translator ) {
            return pll_translate_string( $value, Language::$language_code );
        } elseif ( 'wpml' === Language::$translator ) {
            return apply_filters( 'wpml_translate_single_string', $value, Language::CONTEXT, $key );
        }
        return $value;
    }
}

if ( !function_exists( 'shopengine_content_render' ) ) {
    function shopengine_content_render($content) {
        //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $content;
    }
}