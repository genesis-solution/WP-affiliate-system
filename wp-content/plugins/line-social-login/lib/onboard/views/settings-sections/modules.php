<?php

$enable_data = get_option(\WP_Social_Pro\Modules\Manifesto::OPTION_KEY_ACTIVE_MODULE_CONF, []);
$modules = \WP_Social_Pro\Modules\Manifesto::modules_list();

?>

<div class="wslu-admin-fields-container">
    <span class="wslu-admin-fields-container-description"><?php esc_html_e('You can disable the modules you are not using on your site. That will disable all associated assets of those modules to improve your site loading speed.', 'wp-social');?></span>

    <div class="wslu-admin-fields-container-fieldset">
        <div class="attr-hidden" id="elementskit-template-admin-menu">
            <li><a href="edit.php?post_type=elementskit_template"><?php esc_html_e('Header Footer', 'wp-social');?></a></li>
        </div>
        <div class="attr-hidden" id="elementskit-template-widget-menu">
            <li><a href="edit.php?post_type=elementskit_widget"><?php esc_html_e('Widget Builder', 'wp-social');?></a></li>
        </div>
        
        <div class="attr-row">
        <?php foreach ($modules as $key => $module): ?>
            <div class="attr-col-md-6 attr-col-lg-4" <?php echo esc_attr(($module['package'] != 'pro-disabled' ? '' : 'data-attr-toggle="modal" data-target="#elementskit_go_pro_modal"')); ?>>
            <?php
                \WP_Social\Lib\Onboard\Attr::instance()->utils->input([
                    'type'    => 'switch',
                    'name'    => 'module_list[]',
                    'value'   => $key,
                    'class'   => 'wslu-content-type-' . $module['package'],
                    'attr'    => ($module['package'] != 'pro-disabled' ? [] : ['disabled' => 'disabled']),
                    'label'   => $module['title'],
                    'options' => [
                        'checked' => \WP_Social_Pro\Modules\Manifesto::is_module_enable($key, $enable_data, $module['default_active']) ? true : false,
                    ]
                ]);
                ?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>