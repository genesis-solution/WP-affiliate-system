<?php

$login_global_settings = get_option('xs_global_setting_data', []);
$share_share_settings = get_option('xs_share_global_setting_data', []);

?>

<div class="wslu-admin-fields-container <?php echo esc_attr(isset($_GET['wp-social-met-onboard-steps']) && sanitize_text_field($_GET['wp-social-met-onboard-steps']) == 'loaded' ? 'wslu-admin-widgets-container' : 'wslu-admin-widget-list'); ?>">
    <span class="wslu-admin-fields-container-description"><?php esc_html_e('You can disable the elements you are not using on your site. That will disable all associated assets of those widgets to improve your site loading speed.', 'wp-social');?></span>

    <div class="wslu-admin-fields-container-fieldset">
        <?php foreach (\WP_Social\Lib\Onboard\Onboard::settings() as $page_key => $pages): ?>
            <h2 class="wslu-widget-group-title"><?php echo esc_html(ucwords(str_replace('_', ' ', $page_key))); ?></h2>
            <div class="attr-row">
            <?php foreach ($pages as $key => $value): ?>
                    <div class="attr-col-md-6 attr-col-lg-5">
                        <?php
                            $checked = false;
                            if ('login' === $page_key) {

                                if (isset($login_global_settings[$key]['enable']) && $login_global_settings[$key]['enable'] == 1) {
                                    $checked = true;
                                }

                            } elseif('share' === $page_key) {

                                if ('show_font_from_theme' === $key) {
                                    $xs_share_global_settings = get_option('xs_share_global_setting_data', []);
                                    if (isset($xs_share_global_settings['show_font_from_theme']) && $xs_share_global_settings['show_font_from_theme'] == 1) {
                                        $checked = true;
                                    }
                                } elseif ('show_social_count_share' === $key) {
                                    $style_setting_data_share = get_option('xs_style_setting_data_share', []);
                                    if (isset($style_setting_data_share['main_content']['show_social_count_share']) && $style_setting_data_share['main_content']['show_social_count_share'] == 1) {
                                        $checked = true;
                                    }
                                }

                            } elseif('counter' === $page_key) {
                                
                                $xs_counter_global_setting_data = get_option('xs_counter_global_setting_data', []);
                                if (isset($xs_counter_global_setting_data['show_font_from_theme']) && $xs_counter_global_setting_data['show_font_from_theme'] == 1) {
                                    $checked = true;
                                }
                            }
                            \WP_Social\Lib\Onboard\Attr::instance()->utils->input([
                                'type'    => 'switch',
                                'name'    => $page_key . '[' . $key . ']',
                                'label'   => esc_html($value['title']),
                                'value'   => $value['value'],
                                'options' => [
                                    'checked' => $checked,
                                ],
                            ]);
                            ?>
                    </div>
            <?php endforeach;?>
            </div>
        <?php endforeach;?>
    </div>
</div>

