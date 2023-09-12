<?php

namespace ShopEngine\Compatibility\Migrations;

use ShopEngine\Core\Builders\Action;
use ShopEngine\Traits\Singleton;

class LangMigration
{
    const COOKIE_KEY = 'shopengine_wishlist_offline';

    use Singleton;

    public function init()
    {
        $shopengine_activated_templates = get_option(Action::ACTIVATED_TEMPLATES);
        if (!$shopengine_activated_templates) {

            global $wpdb;

            $options             = $wpdb->get_results("SELECT * FROM {$wpdb->base_prefix}options WHERE option_name LIKE '%shopengine_template__post_meta__%'");
            $activated_templates = [];
            foreach ($options as $option) {
                $template_type_and_category = explode('__', str_replace('shopengine_template__post_meta__', '', $option->option_name));
                if (0 != $option->option_value) {
                    $value = [
                        'template_id' => $option->option_value,
                        'status'      => true,
                        'category_id' => isset($template_type_and_category[1]) ? intval($template_type_and_category[1]) : 0
                    ];
                    update_post_meta($option->option_value, 'language_code', 'en');
                    $activated_templates[$template_type_and_category[0]]['default']      = 'en';
                    $activated_templates[$template_type_and_category[0]]['lang']['en'][] = $value;
                }
            }
            Action::set_activated_templates($activated_templates);
        }
    }
}
