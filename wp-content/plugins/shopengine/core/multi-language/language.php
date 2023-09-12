<?php

namespace ShopEngine\Core\MultiLanguage;

use ShopEngine\Core\Register\Module_List;
use ShopEngine\Traits\Singleton;

class Language
{
    use Singleton;

    /**
     * @var mixed
     */
    public static $language_code;
    /**
     * @var mixed
     */
    public static $translator;

    const CONTEXT = 'Shopengine Module';

    public function init()
    {
        $this->set_language_code();

        add_filter( 'shopengine_language_code', [$this, 'get_language_code'] );

        /**
         * Fires as an admin screen or script is being initialized.
         */
        add_filter( 'shopengine_multi_language', [$this, 'multi_language'] );

        add_action( 'shopengine/core/settings/on_save', [$this, 'create_language_strings'] );

        // Register Module Strings in Polylang
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Just checking current page
        if ( is_admin() && isset( $_REQUEST['page'] ) && $_REQUEST['page'] === 'mlang_strings' ) {
            $strings = get_option( 'shopengine_module_strings' );
            if ( $strings ) {
                $strings = unserialize( $strings );
                foreach ( $strings as $key => $string ) {
                    pll_register_string( $key, $string, self::CONTEXT );
                }
            }
        }
    }

    /**
     * @param $code
     * @return mixed
     */
    public function set_language_code()
    {
        // WPML Support
        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
            self::$language_code = apply_filters( 'wpml_current_language', 'en' );
            self::$translator    = 'wpml';
            //Polylang Support
        } elseif ( function_exists( 'pll_current_language' ) ) {
            self::$language_code = pll_current_language();
            self::$translator    = 'polylang';
        }
    }

    /**
     * @param string $language_code
     * @return mixed
     */
    public function get_language_code( string $language_code = '' )
    {
        if ( self::$language_code ) {
            return self::$language_code;
        }
        return $language_code;
    }

    /**
     * @param $args
     */
    public function create_language_strings( $args )
    {
        if ( self::$translator ) {
            $modules = Module_List::instance()->get_list( true, 'unfiltered' );

            $strings = [];

            foreach ( $modules as $module_key => $module ) {
                if ( !empty( $module['settings'] ) ) {
                    $settings = $module['settings'];

                    foreach ( $settings as $setting_key => $setting ) {
                        $field_settings = $setting['field_settings'];

                        if ( $field_settings['type'] === 'repeater' ) {
                            $repeater_fields = $field_settings['fields'];

                            foreach ( $repeater_fields as $key => $field ) {
                                if ( isset( $field['translate_able'] ) && $field['translate_able'] === true ) {
                                    $repeater_value_items = $args['modules'][$module_key]['settings'][$setting_key]['value'];

                                    foreach ( $repeater_value_items as $repeater_values ) {
                                        if ( !empty( $repeater_values[$key] ) ) {
                                            if ( !empty( $repeater_values['_uid'] ) ) {
                                                $name           = $module_key . '__' . $setting_key . '__' . $key . '__' . $repeater_values['_uid'];
                                                $strings[$name] = $repeater_values[$key];

                                                $this->save_string_in_wpml( $name, $repeater_values[$key] );
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if ( isset( $setting['translate_able'] ) && $setting['translate_able'] === true ) {
                                $value = $args['modules'][$module_key]['settings'][$setting_key]['value'];
                                if ( !empty( $value ) ) {
                                    $name           = $module_key . '__' . $setting_key;
                                    $strings[$name] = $value;

                                    $this->save_string_in_wpml( $name, $value );
                                }
                            }
                        }
                    }
                }
            }

            update_option( 'shopengine_module_strings', serialize( $strings ) );
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function save_string_in_wpml( string $name, string $value )
    {
        if ( 'wpml' === self::$translator ) {
            do_action( 'wpml_register_single_string', self::CONTEXT, $name, $value );
        }
    }

    /**
     * @param array $args
     * @return mixed
     */
    public function multi_language( array $args )
    {
        $languages = [];

        // WPML Support
        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
            foreach ( apply_filters( 'wpml_active_languages', [] ) as $language_code => $language ) {
                $languages[$language_code] = [
                    'language_code'    => $language_code,
                    'translated_name'  => $language['translated_name'],
                    'country_flag_url' => $language['country_flag_url']
                ];
            }
            $args['status']     = true;
            $args['lang_items'] = $languages;

            return $args;
        }

        // Polylang Support
        if ( function_exists( 'pll_the_languages' ) ) {
            try {
                $pll_languages = pll_the_languages( ['raw' => 1] );
                if ( is_array( $pll_languages ) ) {
                    foreach ( $pll_languages as $language_code => $language ) {
                        $languages[$language_code] = [
                            'language_code'    => $language_code,
                            'translated_name'  => $language['name'],
                            'country_flag_url' => $language['flag']
                        ];
                    }
                    $args['status']     = true;
                    $args['lang_items'] = $languages;
                }
            } catch ( \Throwable $th ) {}
        }
        return $args;
    }
}
