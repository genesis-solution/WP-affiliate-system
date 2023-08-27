<?php
defined('ABSPATH') || exit;

$styleArr = \WP_Social\App\Login_Settings::get_login_styles();

?>

<div class="wslu-social-login-main-wrapper">
	<?php
	require_once(WSLU_LOGIN_PLUGIN . '/template/admin/tab-menu.php');

	if($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div id="XS_Social_Login_Settings"
                 class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible"
                 style="margin: 1em 0; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Styles data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss"><span
                            class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span>
                </button>
            </div>
        </div>
	<?php } ?>

    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_global_setting&tab=wslu_style_setting'); ?>"
          name="xs_style_submit_form" method="post" id="xs_style_form">
        <div class="xs-social-block-wraper">
            <div class="xs-global-section">

                <div class="wslu-social-style-data">
					<?php

					/*
						------------------------------
						login style card
						------------------------------
					*/
					foreach($styleArr AS $key => $val) :

						$arg = [
							'saved_style' => isset($saved_style['login_button_style']) ? $saved_style['login_button_style'] : '',
							'style'       => $key,
							'key'         => 'social_login_' . $key,
							'image'       => $val['image'],
							'title'       => $val['title'],
							'package'     => ($val['unlocked'] === false) ? 'pro' : '',
							'name'        => 'xs_style[login_button_style]',
						];

						\WP_Social\Helper\View_Helper::get_style_card($arg);

					endforeach;
					// end of login style card
					?>

                </div>

                <div class="wslu-right-content wslu-right-content--share">
                <?php wp_nonce_field( 'style_setting_submit_form_nonce', 'nonce' ); ?>
                    <button type="submit"
                            name="style_setting_submit_form"
                            class="xs-btn btn-special small">
						<?php echo esc_html__('Save Changes', 'wp-social'); ?>
                    </button>
                </div>

            </div>
        </div>
        <div class="xs-backdrop"></div>
    </form>
</div>
