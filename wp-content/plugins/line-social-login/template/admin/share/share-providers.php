<?php
defined('ABSPATH') || exit;
?>

<div class="wslu-social-login-main-wrapper"> <?php

	require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/tab-menu.php');

	if($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings"
                 class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible"
                 style="margin: 1em 0px; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Providers data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss"><span
                            class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span>
                </button>
            </div>
        </div>
	<?php } ?>


    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting&tab=wslu_providers'); ?>"
          name="xs_provider_submit_form" method="post" id="xs_provider_form">
        <div class="xs-social-block-wraper">
            <ul class="xs-social-block" data-action="sort_providers_share" data-sort_url="<?php echo esc_url(admin_url() . 'admin-ajax.php'); ?>">
				<?php

				foreach($core_provider as $k => $val):

					$label = empty($saved_settings['social'][$k]['data']['label']) ? $val['label'] : $saved_settings['social'][$k]['data']['label'];
					?>

                    <li data-provider="<?php echo esc_attr($k)?>">
                        <div class="xs-single-social-block <?php echo esc_attr($k); ?>">
                            <div class="xs-block-header" data-type="modal-trigger"
                                 data-target="example-modal-<?php echo esc_attr($k); ?>">
                                <span class="drag-icon"></span>
                                <div class="xs-social-icon">
                                    <span class="met-social met-social-<?php echo esc_attr($k); ?>"></span>
                                </div>
                                <h2 class="xs-social-icon-title"><?php echo esc_html($label); ?></h2>
                            </div>
                            <div class="xs-block-footer">
                                <div class="left-content">

                                    <div class="wslu-single-popup-item wslu-inline">
                                        <input
                                                onchange="social_share_enable(this)"
                                                data-key="<?php echo esc_attr($k); ?>"
                                                class="social_switch_button"
                                                type="checkbox"
                                                id="<?php echo esc_attr($k); ?>_enable"
                                                value="1"
											<?php echo esc_attr(empty($enabled_providers[$k]['enable']) ? '' : 'checked'); ?> />

                                        <label for="<?php echo esc_attr($k); ?>_enable"
                                               class="social_switch_button_label"></label>
                                    </div>

                                </div>
                                <div class="right-content">
                                    <a
                                            href="javascript:void()"
                                            class="wslu-social-provider-btn xs-btn btn-special small"
                                            data-type="modal-trigger"
                                            data-target="example-modal-<?php echo esc_attr($k); ?>">
										<?php echo esc_attr(empty($enabled_providers[$k]['enable']) ? esc_html__('Getting Started', 'wp-social') : esc_html__('Settings', 'wp-social')); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
				<?php

				endforeach; ?>

            </ul>
        </div>


		<?php

		foreach($core_provider AS $k => $val):

			$label = empty($saved_settings['social'][$k]['data']['label']) ? $val['label'] : $saved_settings['social'][$k]['data']['label'];
			$old_count = empty($saved_settings['social'][$k]['data']['old_count']) ? 0 : $saved_settings['social'][$k]['data']['old_count'];

			$defaultText = isset($val['data']['text']) ? $val['data']['text'] : 'Share';

			$belowText = isset($share_provider[$k]['data']['text']) ? $share_provider[$k]['data']['text'] : $defaultText;
			$belowValue = isset($share_provider[$k]['data']['value']) ? $share_provider[$k]['data']['value'] : 0;

			?>

            <div class="xs-modal-dialog" id="example-modal-<?php echo esc_attr($k); ?>">
                <div class="xs-modal-content post__tab">
                    <div class="xs-modal-header clear-both">
                        <div class="tabHeader">
                            <ul class="tab__list clear-both"></ul>
                            <button type="button" class="xs-btn" data-modal-dismiss="modal"><span
                                        class="wslu-icon met-social met-social-cross"></span></button>
                        </div>
                    </div>

                    <div class="xs-modal-body">
                        <div class="ekit--tab__post__details tabContent">
                            <h6 class="wslu-popup-provider-title"><?php echo esc_html__($label, 'wp-social'); ?></h6>

                            <div class="tabItem active">
                                <div class="setting-section">
                                    <div class="wslu-popup-data">

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($k); ?>_value">
													<?php echo esc_attr('Default ' . $label . ' Share Count', 'wp-social'); ?>
                                                </label>
                                            </div>

                                            <input name="xs_share[social][<?php echo esc_attr($k); ?>][data][value]" type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_value"
                                                   value="<?php echo esc_html($belowValue); ?>"
                                                   class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($k); ?>_text"><?php echo esc_html_e('Text Below The Number', 'wp-social'); ?> </label>
                                            </div>

                                            <input name="xs_share[social][<?php echo esc_attr($k); ?>][data][text]" type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_text"
                                                   value="<?php echo esc_html($belowText); ?>"
                                                   class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="<?php echo esc_attr($k); ?>_label"><?php echo esc_html__('Label Name', 'wp-social'); ?> </label>
                                            </div>

                                            <input name="xs_share[social][<?php echo esc_attr($k); ?>][data][label]" type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_label"
                                                   value="<?php echo esc_html($label); ?>" class="wslu-global-input">
                                        </div>

                                        <?php

                                        apply_filters('wp_social_pro/provider/share/after_user_data_form', $k, $old_count);

                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="xs-modal-footer">
                        <button type="submit" name="share_settings_submit_form"
                                class="xs-btn btn-special"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
                    </div>
                </div>
            </div>

		<?php

		endforeach; ?>
        <div class="xs-backdrop"></div>
    </form>
</div>