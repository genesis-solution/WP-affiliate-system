<?php
defined( 'ABSPATH') || exit;

$share_layout_alignment = empty($return_data['layout']) ?
    \WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_VERTICAL :
    \WP_Social\Helper\Helper::sanitize_white_list(
            $return_data['layout'],
            \WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_VERTICAL,
            [\WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_VERTICAL, \WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_HORIZONTAL]
    );

?>

<div class="wslu-social-login-main-wrapper">
    <?php
    require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/tab-menu.php');
    if ($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Styles data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span></button>
            </div>
        </div>
    <?php } ?>

    <?php if( did_action('wslu_social_pro/plugin_loaded') ): ?>
        <template id="hover_preview_template">
            <div class="wslu-single-item__hover-preview">
                <img src="<?php echo esc_url(WSLU_PRO_LOGIN_PLUGIN_URL . 'assets/images/preview/'); ?>"/>
            </div>
        </template>
    <?php endif; ?>

   

    <form class="wslu-share-styles-form" data-action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting&tab=wslu_style_setting'); ?>" action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting&tab=wslu_style_setting'); ?>" name="xs_style_submit_form" method="post" id="xs_style_form">
        <div class="xs-social-block-wraper">
            <div class="xs-global-section">

                <ul class="wslu-display-type-container">
                    <li>
                        <a href="#primary_content" data-id="primary_content">
                            <?php echo esc_html__('Primary Content', 'wp-social'); ?>
                            <span><?php esc_html_e('Choose where to show share buttons.', 'wp-social'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#fixed_display" data-id="fixed_display">
                            <?php echo esc_html__('Fixed Display ', 'wp-social'); ?>
                            <span><?php esc_html_e('Choose where to show share buttons.', 'wp-social'); ?></span>
                        </a>
                    </li>
                </ul>

                
                
                <div class="wslu-display-content">
                    <div class="wslu-single-item" id="wslu-primary_content">
                       
                        
                        <!-- show count -->
                        <div class="wslu-single-item">

                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Show total count', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content horizontial">

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[main_content][show_social_count_share]" value="1" <?php echo esc_attr((!empty($return_data['main_content']['show_social_count_share'])) ? 'checked' : ''); ?>>

                                    <?php echo esc_html__('Yes', 'wp-social'); ?>
                                </label>

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[main_content][show_social_count_share]" value="0" <?php echo esc_attr((empty($return_data['main_content']['show_social_count_share'])) ? 'checked' : ''); ?>>

                                    <?php echo esc_html__('No', 'wp-social'); ?>
                                </label>
                            </div>
                        </div>

                    </div> <!-- ./ End Single Item -->

                <!--------------------------
                 fixed position styles
                --------------------------->

                    <div class="wslu-single-item" id="wslu-fixed_display">
                        <div class="primary-content-setting">

                            <h2 class="primary-content-setting__title" for=""> 
                                    <?php echo esc_html__('Fixed Display', 'wp-social'); ?>
                            </h2>

                            <div class="primary-content-setting__content mb-5">

                                <label for="_login_button_style__login_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">

                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__login_content" name="xs_style[login_button_content]" value="no_content" <?php echo esc_attr((empty($return_data['login_button_content']) || $return_data['login_button_content'] == 'no_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/share-primary-content/disable.png'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Disable ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                </label>
                                

                                <label for="_login_button_style__left_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__left_content" name="xs_style[login_button_content]" value="left_content" <?php echo esc_attr((isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'left_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/fixed-display-preview/left_floating.jpg'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Left Floating ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                       
                                </label>


                                <label for="_login_button_style__right_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__right_content" name="xs_style[login_button_content]" value="right_content" <?php echo esc_attr((isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'right_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/fixed-display-preview/right_floating.jpg'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Right Floating ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                   
                                </label>


                                <label for="_login_button_style__top_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__top_content" name="xs_style[login_button_content]" value="top_content" <?php echo esc_attr((isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'top_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/fixed-display-preview/top_inline.jpg'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Top Inline ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                    
                                </label>


                                <label for="_login_button_style__bottom_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__bottom_content" name="xs_style[login_button_content]" value="bottom_content" <?php echo esc_attr((isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'bottom_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/fixed-display-preview/bottom_inline.jpg'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Bottom Inline ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                    
                                </label>


                                

                                
                            </div>

                        <!-- Show count -->
                        <div class="wslu-single-item">

                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Show total count', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content horizontial">

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[fixed_display][show_social_count_share]" value="1" <?php echo esc_attr((!empty($return_data['fixed_display']['show_social_count_share'])) ? 'checked' : ''); ?>>

                                    <?php echo esc_html__('Yes', 'wp-social'); ?>
                                </label>

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[fixed_display][show_social_count_share]" value="0" <?php echo esc_attr((empty($return_data['fixed_display']['show_social_count_share'])) ? 'checked' : ''); ?>>

                                    <?php echo esc_html__('No', 'wp-social'); ?>
                                </label>
                            </div>
                        </div>
                        
                        </div>
                        

                    </div> <!-- ./ End Single Item -->


                </div>

                 <!-- Layout -->
                <div class="wslu-single-item wslu-share-layout">
                    <div class="wslu-left-label">
                        <label class="wslu-sec-title" for=""><?php echo esc_html__('Layout', 'wp-social'); ?></label>
                    </div>

                    <div class="wslu-right-content horizontial">
                        <label class="social_radio_button_label xs_label_wp_login">
                            <input
                                    class="social_radio_button wslu-layout-btn wslu-global-radio-input"
                                    type="radio"
                                    name="xs_style[layout]"
                                    <?php checked($share_layout_alignment, \WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_HORIZONTAL) ?>
                                    value="<?php echo esc_attr(\WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_HORIZONTAL) ?>" />

                            <?php echo esc_html__('Horizontal', 'wp-social'); ?>
                        </label>

                        <label class="social_radio_button_label wslu-layout-btn xs_label_wp_login">
                            <input
                                    class="social_radio_button wslu-global-radio-input"
                                    type="radio"
                                    name="xs_style[layout]"
	                            <?php checked($share_layout_alignment, \WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_VERTICAL) ?>
                                    value="<?php echo esc_attr(\WP_Social\Keys::KEY_SHARE_LAYOUT_ALIGNMENT_VERTICAL) ?>" >

                            <?php echo esc_html__('Vertical', 'wp-social'); ?>
                        </label>
                    </div>
                </div> <!-- ./ End Single Item -->
                
                <!--------------------------
                 Primary Content Settings
                --------------------------->
                
                <div class="wslu-single-item">
                        <div class="primary-content-setting">

                            <h2 class="primary-content-setting__title" for=""> 
                                <?php echo esc_html__('Primary Content', 'wp-social'); ?>
                            </h2>

                            <div class="primary-content-setting__content">

                                <label for="_login_button_style__login_content1" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__login_content1" name="xs_style[login_content]" value="no_content" <?php echo esc_attr((empty($return_data['login_content']) || $return_data['login_content'] == 'no_content') ? 'checked' : ''); ?>>
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/share-primary-content/disable.png'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                        <?php echo esc_html__('Disable ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                    
                                </label>

                                <label for="_login_button_style__after_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__after_content" name="xs_style[login_content]" value="after_content" <?php echo (isset($return_data['login_content']) && $return_data['login_content'] == 'after_content') ? 'checked' : ''; ?>>
                                    
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/share-primary-content/after_content.png'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('After Content ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                    
                                </label>


                                <label for="_login_button_style__before_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__before_content" name="xs_style[login_content]" value="before_content" <?php echo esc_attr((isset($return_data['login_content']) && $return_data['login_content'] == 'before_content') ? 'checked' : ''); ?>>
                                    
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/share-primary-content/before_content.png'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                            <?php echo esc_html__('Before Content ', 'wp-social'); ?>
                                        </span>
                                    </span>
                                    
                                </label>

                                <label for="_login_button_style__both_content" class="social_radio_button_label xs_label_wp_login primary-content-setting__item">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__both_content" name="xs_style[login_content]" value="both_content" <?php echo esc_attr((isset($return_data['login_content']) && $return_data['login_content'] == 'both_content') ? 'checked' : ''); ?>>
                                   
                                    <span class="primary-content-setting__content__item">
                                        <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/share-primary-content/both_content.png'); ?>"/>
                                        <span class="primary-content-setting__content__item--name">
                                        <?php echo esc_html__('Both', 'wp-social'); ?>
                                        </span>
                                    </span>
                                   
                                </label>

                               

                            </div>
                            
                        </div>
                    
                </div> <!-- ./ End primary content setting -->

                 <!-------------------------------- 
                     Social Share hover aniamtion 
                  -------------------------------->
                 <?php if (isset($share_hover_effects)) : ?>
                    <div class="wslu-single-item">
                        <div class="wlsu-hover-effect">

                        <h2 class="wlsu-hover-effect__title"> 
                            <?php echo esc_html__('Select Hover Effects', 'wp-social'); ?>
                        </h2>
                        <div class="wlsu-hover-effect__content">
                            <?php foreach ($share_hover_effects as $key => $value) : ?>
                                <div class="wlsu-hover-effect__item">
                                    <input 
                                        <?php echo esc_attr((isset($value['exclude']))) ? 'data-exclude="' . esc_attr(json_encode($value['exclude'])) . '"' : '' ?>
                                        type="radio"
                                        class="wlsu-hover-effect-select"
                                        name="xs_style[hover_effect]"
                                        id="<?php echo esc_attr($key); ?>"
                                        value="<?php echo esc_attr($key); ?>" 
                                        <?php echo esc_attr(($mainEffect == $key) ? 'checked' : ''); ?>/>

                                    <label for="<?php echo esc_attr($key); ?>" >
                                        <img src="<?php echo esc_url(WSLU_PRO_LOGIN_PLUGIN_URL . 'assets/images/share-hover-preview/' . $key . '.png'); ?>"/>
                                        <span> <?php echo esc_html($value['name']); ?> </span>
                                    </label>
                                </div>

                            <?php endforeach; ?>
                        </div>
                            
                        </div>

                    </div> 
                <?php endif; ?><!-- ./ End social share hover animation -->
                
                <!-------------------------------- 
                    Social media Styles 
                -------------------------------->
                <h2 class="wlsu-hover-effect__title wlsu-style-data">
                    <?php echo esc_html__('Select Share Style', 'wp-social'); ?>
                </h2>
                <div class="wslu-social-style-data ">
                        
                    <?php
                    foreach ($styleArr as $k => $v) : ?>
                        <div class="wslu-single-social-style-item <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ) ? 'wslu-style-pro': 'wslu-style-free' ); ?>">

                            <label  class="social_radio_button_label xs_label_wp_login">
                                
                                <div class="wslu-style-img xs-login-<?php echo esc_attr($k); ?> <?php echo esc_attr((isset($return_data['login_button_style']) && $return_data['login_button_style'] == $k) ? 'style-active ' : ''); ?>">
                                    <img class="wslu-style-img-h" src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/share/' . $v['design'] . '.png'); ?>" alt="<?php echo esc_attr($k); ?>">
                                    <img class="wslu-style-img-v" src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/share/' . $v['design'].'-v' . '.png'); ?>" alt="<?php echo esc_attr($k); ?>">
                                   
                                    <?php if(!in_array('wp-social-pro/wp-social-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) : ?>
                                        <a href="https://wpmet.com/plugin/wp-social/pricing/" class="wslu-buy-now-btn"><?php esc_html_e('Buy Now', 'wp-social'); ?></a>
                                    <?php endif; ?>
                                </div>

                                <input class="social_radio_button  wslu-global-radio-input share-input-name" type="radio" id="_login_button_style__<?php echo esc_attr($k); ?>" name="xs_style[login_button_style][main]" value="<?php echo esc_attr($k); ?>" <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ) ? 'disabled="disabled"': '' ); ?>>
                                <?php 
                                    echo esc_html__($v['name'], 'wp-social');
                                    echo wp_kses(((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? '<span class="wslu-go-pro-text">(' . esc_html('Pro Only', 'elementskit') . ')</span>' : ''), \WP_Social\Helper\Helper::get_kses_array());
                                ?>

                                <?php
                                    $effect = isset($v['effect']) ? $v['effect'] : [];
                                    if (!empty($effect)) {
                                        foreach ($effect as $kk => $vv) :
                                            ?>
                                        <label for="wslu-effect-<?php echo esc_attr($k); ?>-<?php echo esc_attr($kk); ?>">
                                            <input class="social_radio_button  wslu-global-radio-input" type="radio" id="wslu-effect-<?php echo esc_attr($k); ?>-<?php esc_attr($kk); ?>" value="<?php echo esc_attr($kk); ?>" <?php echo esc_attr((isset($return_data['login_button_style']['effect']) && $return_data['login_button_style']['effect'] == $kk) ? 'checked' : ''); ?>>
                                            <?php echo esc_html__($vv['name'], 'wp-social') ?>
                                        </label>
                                <?php
                                        endforeach;
                                    }
                                    ?> 
                            </label>
                            
                        </div>
                    <?php
                    endforeach; ?>
                </div>

                <div class="wslu-social-style-hidden-inputs">
                    <label>
                        <input type="text" class="wslu-main-content-input" name="xs_style[main_content][style]" value="<?php echo esc_attr($return_data['main_content']['style']); ?>">
                        <?php esc_html_e('Main Content', 'wp-social'); ?>
                    </label>
                    <label>
                        <input type="text" class="wslu-fixed-display-input" name="xs_style[fixed_display][style]" value="<?php echo esc_attr($return_data['fixed_display']['style']); ?>">
                        <?php esc_html_e('Fixed Display', 'wp-social'); ?>
                    </label>
                </div>

                <div class="wslu-right-content wslu-right-content--share">
                <?php wp_nonce_field( 'style_setting_submit_form_share_nonce', 'nonce' ); ?>
                    <button type="submit" name="style_setting_submit_form" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
                </div>

            </div>
        </div>
        <div class="xs-backdrop"></div>
    </form>
</div>