<?php

namespace ShopEngine\Core\Builders;

use Elementor\Core\Files\Uploads_Manager;
use ShopEngine\Core\Sample_Designs\Base;
use ShopEngine\Core\Template_Cpt;
use ShopEngine\Traits\Singleton;
use WP_Filesystem_Direct;

defined( 'ABSPATH' ) || exit;

class Action
{
    use Singleton;

    const PK__SHOPENGINE_TEMPLATE = 'shopengine_template__post_meta';
    const EDIT_WITH_GUTENBERG     = 'gutenberg';
    const EDIT_WITH_ELEMENTOR     = 'elementor';
    const ACTIVATED_TEMPLATES     = 'shopengine_activated_templates';

    /**
     * @var mixed
     */
    private static $form_settings;
    /**
     * @var string
     */
    private static $edit_with = '';
    /**
     * @var mixed
     */
    public $template_id;
    /**
     * @var mixed
     */
    public $category_id;
    /**
     * @var mixed
     */
    public $old_language_code;
    /**
     * @var mixed
     */
    public $template_type;
    /**
     * @var mixed
     */
    public $language_code;
    /**
     * @var mixed
     */
    public $template_status;

    /**
     * @param $template_id
     * @param $form_settings
     * @return mixed
     */
    public function store( $template_id, $form_settings )
    {
        $this->set_form_values( $form_settings );
        $this->template_id       = $template_id;
        $this->template_type     = self::get_form_value( 'form_type', 'single' );
        $this->category_id       = self::get_form_value( 'category_id', 0 );
        $this->language_code     = self::get_form_value( 'language_code', 'en' );
        $this->old_language_code = self::get_form_value( 'old_language_code', 'en' );

        if ( $this->template_id == 0 ) {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
            $wp_rewrite->init();

            return $this->insert();
        } else {
            return $this->update();
        }
    }

    public function insert()
    {
        $form_settings = self::$form_settings;
        $title         = ( $form_settings['form_title'] != '' ) ? $form_settings['form_title'] : 'New Template # ' . time();

        $template_id = wp_insert_post( [
            'post_title'  => $title,
            'post_status' => 'publish',
            'post_type'   => Template_Cpt::TYPE
        ] );

        $this->template_id = $template_id;

        $activated_templates = $this->create_template( self::get_activated_templates() );
        self::set_activated_templates( $activated_templates );

        /**
         * Get template default meta
         */
        $edit_with = self::get_form_value( 'edit_with_option', self::EDIT_WITH_GUTENBERG );

        /**
         * Set template default meta
         */
        update_post_meta( $template_id, self::get_meta_key_for_type(), $this->template_type );
        update_post_meta( $template_id, self::PK__SHOPENGINE_TEMPLATE, $form_settings );
        update_post_meta( $template_id, self::get_meta_key_for_edit_with(), $edit_with );

        /**
         * If this template is dependent on elementor page builder then this meta will be saved
         */

        if ( $edit_with === self::EDIT_WITH_ELEMENTOR ) {
            /**
             * Auto elementor canvas style
             */

            if ( in_array( $this->template_type, ['quick_checkout', 'quick_view'] ) ) {
                update_post_meta( $template_id, '_wp_page_template', 'elementor_canvas' );
            } else {
                update_post_meta( $template_id, '_wp_page_template', 'elementor_header_footer' );
            }

            update_post_meta( $template_id, '_elementor_edit_mode', 'builder' );
            update_post_meta( $template_id, '_elementor_version', '3.4.6' );
        }

        if ( !empty( $form_settings['sample_design'] ) ) {
            /**
             *  Get ready made template data
             */
            $template_path = Base::instance()->get_content_path( $form_settings['sample_design'] );

            if ( is_file( $template_path ) ) {
                require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

                $wp_filesystem = new \WP_Filesystem_Direct(null);
                $fileContent = $wp_filesystem->get_contents($template_path);

                if(!is_null( $fileContent ) && $edit_with === 'gutenberg'){
                    wp_update_post([
                        'ID' => $this->template_id,
                        'post_content' => $fileContent
                    ]);
                }

                if ( !is_null( $fileContent ) && $edit_with === 'elementor' ) {

                    add_filter('elementor/files/allow_unfiltered_upload', '__return_true');

                    $result = \Elementor\Plugin::$instance->templates_manager->import_template( [
                        'fileData' => base64_encode( $fileContent ),
                        'fileName' => 'shopengine-content.json'
                    ] );

                    $imported_template_id = $result[0]['template_id'];
                    $template_data        = get_post_meta( $imported_template_id, '_elementor_data', true );
                    update_post_meta( $template_id, '_elementor_data', $template_data );
                    wp_delete_post( $imported_template_id );
                }
            }
        }

        return [
            'saved'  => true,
            'data'   => [
                'id'                  => $template_id,
                'title'               => $title,
                'type'                => Template_Cpt::TYPE,
                'activated_templates' => $activated_templates
            ],
            'status' => esc_html__( 'Template settings inserted', 'shopengine' )
        ];
    }

    public function update()
    {
        $form_settings = self::$form_settings;

        $title = ( $form_settings['form_title'] != '' ) ? $form_settings['form_title'] : 'New Template # ' . time();

        wp_update_post( [
            'ID'          => $this->template_id,
            'post_title'  => $title,
            'post_status' => 'publish'
        ] );

        update_post_meta( $this->template_id, self::PK__SHOPENGINE_TEMPLATE, $form_settings );
        update_post_meta( $this->template_id, self::get_meta_key_for_type(), $this->template_type );

        $activated_templates = $this->update_template( self::get_activated_templates() );
        self::set_activated_templates( $activated_templates );

        $response = [
            'saved'  => true,
            'data'   => [
                'id'                  => $this->template_id,
                'title'               => $title,
                'type'                => Template_Cpt::TYPE,
                'activated_templates' => $activated_templates
            ],
            'status' => esc_html__( 'Template settings updated', 'shopengine' )
        ];

        if ( isset( $form_settings['category_id'] ) ) {
            $response['data']['category_title'] = get_the_category_by_ID( $form_settings['category_id'] );
        }

        return $response;
    }

    /**
     * @param $templates
     * @return mixed
     */
    public function create_template( $templates )
    {
        update_post_meta( $this->template_id, 'language_code', $this->language_code );

        if ( isset( $templates[$this->template_type]['lang'][$this->language_code] ) ) {
            $category_key = self::get_template_key( $templates[$this->template_type]['lang'][$this->language_code], 'category_id', $this->category_id );

            if ( is_integer( $category_key ) ) {
                $templates[$this->template_type]['lang'][$this->language_code][$category_key] = $this->template_values();
                return $templates;
            }
        }

        $templates[$this->template_type]['lang'][$this->language_code][] = $this->template_values();

        return $templates;
    }

    /**
     * @param $templates
     * @return mixed
     */
    public function update_template( array $templates )
    {

        if ( isset( $templates[$this->template_type]['lang'][$this->old_language_code] ) ) {
            $key = self::get_template_key( $templates[$this->template_type]['lang'][$this->old_language_code], 'template_id', $this->template_id );

            if ( is_integer( $key ) ) {
                unset( $templates[$this->template_type]['lang'][$this->old_language_code][$key] );
            }
        }

        return $this->create_template( $templates );
    }

    public function template_values()
    {
        return [
            'template_id' => $this->template_id,
            'status'      => self::get_form_value( 'status', false ),
            'category_id' => $this->category_id
        ];
    }

    /**
     * @param $post_id
     * @return mixed
     */
    public function get_all_data( $post_id )
    {
        $language_code = get_post_meta( $post_id, 'language_code', true );

        if ( empty( $language_code ) ) {
            $language_code = 'en';
        }

        $activated_templates      = self::get_activated_templates();
        $post                     = get_post( $post_id );
        $data                     = get_post_meta( $post->ID, self::PK__SHOPENGINE_TEMPLATE, true );
        $data['language_code']    = $language_code;
        $data['edit_with_option'] = get_post_meta( $post->ID, self::get_meta_key_for_edit_with(), true );

        if ( !empty( $activated_templates[$data['form_type']]['lang'][$language_code] ) ) {
            $templates = $activated_templates[$data['form_type']]['lang'][$language_code];
            $key       = self::get_template_key( $templates, 'template_id', $post->ID );

            if ( is_integer( $key ) ) {
                $data['status'] = $templates[$key]['status'];
            } else {
                $data['status'] = false;
            }
        }

        return $data;
    }

    /**
     * @param $template_id
     */
    public static function delete_template_form_activated_list( $template_id )
    {
        $data = get_post_meta( $template_id, Action::PK__SHOPENGINE_TEMPLATE, true );

        if ( is_array( $data ) && isset( $data['form_type'] ) ) {
            $language_code = get_post_meta( $template_id, 'language_code', true );

            $activated_templates = self::get_activated_templates();

            if ( empty( $language_code ) ) {
                $language_code = 'en';
            }

            if ( !empty( $activated_templates[$data['form_type']]['lang'][$language_code] ) ) {
                $templates = $activated_templates[$data['form_type']]['lang'][$language_code];
                $key       = self::get_template_key( $templates, 'template_id', $template_id );

                if ( is_integer( $key ) ) {
                    unset( $activated_templates[$data['form_type']]['lang'][$language_code][$key] );
                }
            }

            self::set_activated_templates( $activated_templates );
        }
    }

    public static function get_activated_templates()
    {
        $activated_templates = get_option( self::ACTIVATED_TEMPLATES );

        if ( false === $activated_templates ) {
            return [];
        }

        return unserialize( $activated_templates );
    }

    /**
     * @param array $activated_templates
     */
    public static function set_activated_templates( array $activated_templates )
    {
        return update_option( Action::ACTIVATED_TEMPLATES, serialize( $activated_templates ) );
    }

    /**
     * @param $template_id
     * @param array $activated_templates
     * @return mixed
     */
    public static function get_template_data( $template_id, array $activated_templates )
    {
        $language_code = get_post_meta( intval( $template_id ), 'language_code', true );
        $data          = get_post_meta( $template_id, Action::PK__SHOPENGINE_TEMPLATE, true );

        if ( is_array( $data ) && isset( $data['form_type'] ) ) {
            if ( isset( $activated_templates[$data['form_type']]['lang'][$language_code] ) ) {
                $templates    = $activated_templates[$data['form_type']]['lang'][$language_code];
                $template_key = self::get_template_key( $templates, 'template_id', $template_id );

                if ( is_integer( $template_key ) ) {
                    return $templates[$template_key];
                }
            }
        }

        return false;
    }

    /**
     * @param $template_id
     * @param array $activated_templates
     * @return mixed
     */
    public static function is_template_active( $template_id, array $activated_templates )
    {
        $template_data = self::get_template_data( $template_id, $activated_templates );
        return $template_data['status'] ?? false;
    }

    /**
     * @param $template_id
     * @param array $activated_templates
     * @return mixed
     */
    public static function get_template_category_id( $template_id, array $activated_templates )
    {
        $template_data = self::get_template_data( $template_id, $activated_templates );
        return $template_data['category_id'] ?? false;
    }

    /**
     * @param $templates
     * @param $type
     * @param $category_id_or_template_id
     */
    public static function get_template_key( $templates, $type = 'category_id', $category_id_or_template_id = 0 )
    {

        foreach ( $templates as $key => $template ) {
            if ( $template[$type] == $category_id_or_template_id ) {
                return $key;
            }
        }

        return false;
    }

    public static function get_meta_key_for_type()
    {
        return self::PK__SHOPENGINE_TEMPLATE . '__type';
    }

    public static function get_meta_key_for_edit_with()
    {
        return self::PK__SHOPENGINE_TEMPLATE . '__edit_with';
    }

    /**
     * @param $template_id
     */
    public static function edit_with( $template_id )
    {

        if ( static::$edit_with ) {
            return static::$edit_with;
        }

        $edit_with         = get_post_meta( $template_id, Action::get_meta_key_for_edit_with(), true );
        static::$edit_with = empty( $edit_with ) ? Action::EDIT_WITH_ELEMENTOR : $edit_with;

        return static::$edit_with;
    }

    /**
     * @param $pid
     * @return mixed
     */
    public static function is_edit_with_gutenberg( $pid )
    {
        $edit_with = get_post_meta( $pid, Action::get_meta_key_for_edit_with(), true );
        $edit_with = empty( $edit_with ) ? Action::EDIT_WITH_ELEMENTOR : $edit_with;

        return $edit_with === self::EDIT_WITH_GUTENBERG;
    }

    /**
     * @param $field
     * @param $default
     */
    private static function get_form_value( $field, $default = '' )
    {
        return !empty( self::$form_settings[$field] ) ? self::$form_settings[$field] : $default;
    }

    /**
     * @param $form_settings
     * @param $fields
     */
    private function set_form_values( $form_settings, $fields = null )
    {
        $fields = $this->get_fields();

        foreach ( $form_settings as $key => $value ) {
            if ( isset( $fields[$key] ) ) {
                self::$form_settings[$key] = $value;
            }
        }
    }

    public function get_fields()
    {
        return [
            'form_title'        => [
                'name' => 'form_title'
            ],
            'form_type'         => [
                'name' => 'form_type'
            ],
            'status'            => [
                'name' => 'status'
            ],
            'edit_with_option'  => [
                'name' => 'edit_with_option'
            ],
            'sample_design'     => [
                'name' => 'sample_design'
            ],
            'category_id'       => [
                'name' => 'category_id'
            ],
            'language_code'     => [
                'name' => 'language_code'
            ],
            'old_language_code' => [
                'name' => 'old_language_code'
            ]
        ];
    }
}
