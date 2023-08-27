<?php
defined('ABSPATH') || exit;
?>

<div class="wslu-social-login-main-wrapper">
	<?php
    require_once(WSLU_LOGIN_PLUGIN . '/template/admin/tab-menu.php');

	if($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings"
                 class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible"
                 style="margin: 1em 0px; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Providers data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span>
                </button>
            </div>
        </div>
	<?php } ?>


    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_global_setting&tab=wslu_providers'); ?>"
          name="xs_provider_submit_form" method="post" id="xs_provider_form">
        <div class="xs-social-block-wraper">
            <ul class="xs-social-block" data-action="sort_providers_login" data-sort_url="<?php echo esc_url(admin_url() . 'admin-ajax.php'); ?>">
				<?php
                foreach($core_provider as $k => $val): ?>

                    <li data-provider="<?php echo esc_attr($val)?>">
                        <div class="xs-single-social-block <?php echo esc_attr($k); ?>">
                            <div class="xs-block-header" data-type="modal-trigger"
                                 data-target="example-modal-<?php echo esc_attr($k); ?>">
                                <span class="drag-icon"></span>
                                <span class="wslu-social-icon met-social met-social-<?php echo esc_attr($k); ?>"></span>
                                <h2 class="xs-social-icon-title"><?php echo esc_html($val, 'wp-social'); ?></h2>
                            </div>

                            <div class="xs-block-footer">
                                <div class="left-content">

                                <?php \WP_Social\Helper\View_Helper::get_enable_switch($k, empty($enabled_providers[$k]['enable']), 'enable_provider_login') ?>

                                </div>
                                <div class="right-content">
                                    <a href="javascript:void()"
                                       class="wslu-social-provider-btn xs-btn btn-special small"
                                       data-type="modal-trigger"
                                       data-target="example-modal-<?php echo esc_attr($k); ?>">

                                       <?php
                                           if(!empty($enabled_providers[$k]['enable'])) {
                                                echo esc_html__('Settings', 'wp-social'); ?><?php
                                            } else {
                                                echo esc_html__('Getting Started', 'wp-social');
                                            }
                                        ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php


		foreach($core_provider AS $keyTypeAll => $valueTypeAll):

            $classSet = 'getting';

			$api_ins = \WP_Social\App\Providers::xs_login_service_provider_instruction($keyTypeAll);

			if(!empty($enabled_providers[$keyTypeAll]['enable'])) {
				$classSet = 'setting';
			}
			?>

            <div class="xs-modal-dialog" id="example-modal-<?php echo esc_attr($keyTypeAll); ?>">
                <div class="xs-modal-content post__tab">
                    <div class="xs-modal-header clear-both">
                        <div class="tabHeader">
                            <ul class="tab__list clear-both">
                                <li class="<?php echo esc_attr($classSet== 'getting' ? 'active' : ''); ?> tab__list__item"><?php echo esc_html__('Getting Started', 'wp-social'); ?></li>
                                <li class="<?php echo esc_attr($classSet== 'setting' ? 'active' : ''); ?> tab__list__item"><?php echo esc_html__('Settings', 'wp-social'); ?></li>
                                <li class="<?php echo esc_attr($classSet== 'button' ? 'active' : '');  ?> tab__list__item"><?php echo esc_html__('Buttons', 'wp-social'); ?></li>
                                <li class="tab__list__item "><?php echo esc_html__('Usage', 'wp-social'); ?></li>
                            </ul>
                        </div>
                        <button type="button" class="xs-btn" data-modal-dismiss="modal">
                            <span class="wslu-icon met-social met-social-cross"></span>
                        </button>
                    </div>
                    <div class="xs-modal-body">
                        <div class="ekit--tab__post__details tabContent">
                            <h6 class="wslu-popup-provider-title"><?php echo esc_html__($valueTypeAll, 'wp-social'); ?></h6>
                            <div class="tabItem <?php echo esc_attr($classSet == 'getting' ? 'active' : ''); ?>">
                                <div class="getting-section">

                                    <div class="wslu-popup-data">
                                        <div class="wslu-single-popup-item">
                                            <h3 class="wslu-sec-title"><?php echo esc_html__('Getting Started ', 'wp-social'); ?></h3>
                                            <p><?php echo esc_html($api_ins['getting_txt']); ?> </p>
                                        </div>
                                        <div class="wslu-single-popup-item">
                                            <h3 class="wslu-sec-title"><?php echo esc_html__('Create ' . $valueTypeAll . ' App', 'wp-social'); ?></h3>

                                            <ol class="xs_social_ol">

                                                <li>
													<?php esc_html_e('Check how to create App/Project On ' . $valueTypeAll . ' developer account - ', 'wp-social') ?>
                                                    <a href="<?php echo esc_url($api_ins['doc_url']) ?>"
                                                       target="_blank"><?php echo esc_url($api_ins['doc_url']) ?></a>
                                                </li>

                                                <li>
													<?php
													esc_html_e('Must add the following URL to the "Valid OAuth redirect URIs" field: ', 'wp-social');
													echo wp_kses(' <strong>' . esc_url(get_site_url() . '/wp-json/wslu-social-login/type/' . $keyTypeAll) . '</strong>', \WP_Social\Helper\Helper::get_kses_array() );
													echo wp_kses('<br>', \WP_Social\Helper\Helper::get_kses_array()).esc_html($api_ins['local_ins']);
													?>
                                                </li>

                                                <li> <?php echo esc_html__('After getting the App ID & App Secret, Go to "Settings" tab and put those information ', 'wp-social'); ?>

                                                <li> <?php echo esc_html__('Click on "Save Changes"', 'wp-social'); ?></li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tabItem <?php echo esc_attr( $classSet == 'setting' ? 'active' : ''); ?>">
                                <div class="setting-section">

                                    <div class="wslu-popup-data" id="<?php echo esc_attr($keyTypeAll); ?>_form_table">

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title" for="<?php echo esc_attr($keyTypeAll); ?>_appid">
                                                    <?php esc_html_e("App ID - ", "wp-social"); ?><em><?php esc_html_e("(Required)", "wp-social"); ?> </em> 
                                                </label>
                                            </div>
                                            <input placeholder="741888455955744"
                                                   name="xs_social[<?php echo esc_attr($keyTypeAll); ?>][id]" type="text"
                                                   id="<?php echo esc_attr($keyTypeAll); ?>_appid"
                                                   value="<?php echo esc_html(isset($saved_settings[$keyTypeAll]['id']) ? $saved_settings[$keyTypeAll]['id'] : ''); ?>"
                                                   class="wslu-global-input">
                                        </div>


                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($keyTypeAll); ?>_secret"><?php esc_html_e("App Secret - ", "wp-social"); ?><em><?php esc_html_e("(Required)", "wp-social"); ?> </em> </label>
                                            </div>
                                            <input placeholder="32fd74bcaacf588c4572946f201eee8e"
                                                   name="xs_social[<?php echo esc_attr($keyTypeAll); ?>][secret]" type="text"
                                                   id="<?php echo esc_attr($keyTypeAll); ?>_secret"
                                                   value="<?php echo esc_html(isset($saved_settings[$keyTypeAll]['secret']) ? $saved_settings[$keyTypeAll]['secret'] : ''); ?>"
                                                   class="wslu-global-input">
                                        </div>
                                    </div> <!-- ./End Popup Data -->

                                </div>
                            </div>
                            <div class="tabItem">
                                <div class="button-section">

                                    <div class="wslu-popup-data">
                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($keyTypeAll); ?>_login_label"><?php echo esc_html__('Login Label Text ', 'wp-social'); ?> </label>
                                            </div>

                                            <input placeholder="Login with <?php echo esc_html($valueTypeAll); ?>"
                                                   name="xs_social[<?php echo esc_attr($keyTypeAll); ?>][login_label]" type="text"
                                                   id="<?php echo esc_attr($keyTypeAll); ?>_login_label"
                                                   value="<?php echo esc_attr( isset($saved_settings[$keyTypeAll]['login_label']) ? $saved_settings[$keyTypeAll]['login_label'] : 'Login with ' . $valueTypeAll . ''); ?>"
                                                   class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($keyTypeAll); ?>_logout_label"><?php echo esc_html__('Logout Label Text ', 'wp-social'); ?> </label>
                                            </div>
                                            <input placeholder="Logout with <?php echo esc_html($valueTypeAll); ?>"
                                                   name="xs_social[<?php echo esc_attr($keyTypeAll); ?>][logout_label]"
                                                   type="text" id="<?php echo esc_attr($keyTypeAll); ?>_logout_label"
                                                   value="<?php echo esc_html(isset($saved_settings[$keyTypeAll]['logout_label']) ? $saved_settings[$keyTypeAll]['logout_label'] : 'Logout from ' . $valueTypeAll . ''); ?>"
                                                   class="wslu-global-input">
                                        </div>
                                    </div> <!-- ./End Popup Data -->

                                </div>
                            </div>
                            <div class="tabItem">
                                <div class="usage-section">

                                    <div class="wslu-popup-data">
                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"><?php echo esc_html__('Shortcode', 'wp-social'); ?> </label>
                                            </div>

                                            <ol class="xs_social_ol">
                                                <li>[xs_social_login provider="<?php echo esc_html($keyTypeAll); ?>"
                                                    class="custom-class"]
                                                </li>
                                                <li>[xs_social_login provider="<?php echo esc_html($keyTypeAll); ?>"
                                                    class="custom-class" btn-text="Button Text
                                                    for <?php echo esc_html($valueTypeAll); ?>"]
                                                </li>
                                                <li>[xs_social_login provider="<?php echo esc_html($keyTypeAll); ?>
                                                    "]Button Text for <?php echo esc_html($valueTypeAll); ?>
                                                    [/xs_social_login]
                                                </li>
                                            </ol>

                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"><?php echo esc_html__('Simple Link', 'wp-social'); ?> </label>
                                            </div>

                                            <ul>
                                                <li><?php echo esc_html('<a rel="nofollow" href="' . esc_url(get_site_url() . '/wp-json/wslu-social-login/type/' . $keyTypeAll) . '"> '.esc_html__('Login with', 'wp-social').'' . esc_html($valueTypeAll) . ' </a>'); ?></li>
                                            </ul>
                                        </div>
                                    </div> <!-- ./End Popup Data -->

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="xs-modal-footer">
                        <button type="submit" name="xs_provider_submit_form"
                                class="xs-btn btn-special"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
        <div class="xs-backdrop"></div>
    </form>
</div>
