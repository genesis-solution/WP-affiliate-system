<?php
defined('ABSPATH') || exit;

$login_sync_saved_data = get_option('wp_social_login_sync');
$login_sync_saved_data_image_too = get_option('wp_social_login_sync_image_too');

?>
<div class="wslu-social-login-main-wrapper">

    <!-- Page Header start -->
    <div class="wslu-main-header">
        <h1>
            <img src="<?php echo esc_url( WSLU_LOGIN_PLUGIN_URL . 'assets/images/icon-title.png' ); ?>" alt="">
            <?php echo esc_html__('WP Syncing Setting', 'wp-social'); ?>
        </h1>
        <br>
    </div> <!-- page header end -->

    <?php
        if ($message_global == 'show') { ?>
		<div class="admin-page-framework-admin-notice-animation-container">
			<div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
				<p><?php echo esc_html__('Syncing setting data have been updated.', 'wp-social'); ?></p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span></button>
			</div>
		</div>
	<?php } ?>

    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_settings'); ?>" method="POST">
        <!-- 
            Syncing user info when login/register
         -->
        <div class="wslu-single-item">
            <div class="wslu-left-label">
                <label class="wslu-sec-title" for=""><?php echo esc_html__('Syncing user info when login/register', 'wp-social') ?></label>
            </div>
            <div class="wslu-right-content">
                    <input 
                        type="checkbox"
                        id="wslu-sync-user-info" 
                        class="social_switch_button"
                        name="sync" 
                        value="yes" 
                        <?php echo esc_attr(\WP_Social\Helper\Helper::is_true($login_sync_saved_data, 'yes', 'checked')) ?>
                    >
                    <label for="wslu-sync-user-info" onclick="xs_show_hide(1);" class="social_switch_button_label"></label>
            </div>
        </div>

        <!-- 
            Sync User profile image too
         -->
         <div class="wslu-single-item initial-hidden <?php echo esc_attr(\WP_Social\Helper\Helper::is_true($login_sync_saved_data, 'yes', 'active_tr')) ?>" id="xs_data_tr__1">
            <div class="wslu-left-label">
                <label class="wslu-sec-title" for=""><?php echo esc_html__('Sync user profile image too', 'wp-social') ?></label>
            </div>
            <div class="wslu-right-content">
                    <input 
                        type="checkbox"
                        id="wslu-sync-user-profile-img" 
                        class="social_switch_button"
                        name="sync_image" 
                        value="yes" 
                        <?php echo esc_attr(\WP_Social\Helper\Helper::is_true($login_sync_saved_data_image_too, 'yes', 'checked')) ?>
                    >
                    <label for="wslu-sync-user-profile-img" class="social_switch_button_label"></label>
            </div>
        </div>

        <br><br>
        <?php wp_nonce_field( 'sycn_setting_nonce', 'nonce' ); ?>
        <button type="submit" name="sycn_setting" value="sycn_setting" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social') ?></button>
    </form>
</div>
