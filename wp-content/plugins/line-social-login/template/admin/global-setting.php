<?php
defined( 'ABSPATH') || exit;
?>
<div class="wslu-social-login-main-wrapper">
	<?php 
	require_once( WSLU_LOGIN_PLUGIN . '/template/admin/tab-menu.php');
	if($message_global == 'show'){?>
	<div class="admin-page-framework-admin-notice-animation-container">
		<div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
			<p><?php echo esc_html__('Global setting data have been updated.', 'wp-social');?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social');?></span></button>
		</div>
	</div>
	<?php }?>

	<form action="<?php echo esc_url(admin_url().'admin.php?page=wslu_global_setting');?>" name="global_setting_submit_form" method="post" id="xs_global_form">
		<div class="social-block-wraper">
			<div class="global-section">
				<div class="wslu-single-item">

					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Custom login redirect ', 'wp-social');?></label>
					</div>

					

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="custom_login_url_enable" name="xs_global[custom_login_url][enable]" value="1" <?php echo esc_attr(isset($return_data['custom_login_url']['enable']) && $return_data['custom_login_url']['enable'] == 1) ? 'checked' : ''; ?> >
						<label for="custom_login_url_enable" onclick="<?php echo esc_js( 'xs_show_hide(1);' ); ?>" class="social_switch_button_label"></label>

						<div id="xs_data_tr__1" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['custom_login_url']['enable']) ? 'active_tr' : '');?>">
							<div class="wp-social-dropdown-select">
								<?php
								 	$default_select2_value = isset($return_data['custom_login_url']['data']) ? $return_data['custom_login_url']['data'] : '';
									 // get_select2_dropdown accepts : post type , status, default value, input name attribute
									\WP_Social\Helper\View_Helper::get_select2_dropdown('page', 'publish', $default_select2_value, 'xs_global[custom_login_url][data]')  
								?>
							</div>
							
						</div>
						
					</div>
				</div>

				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to wp-login page ', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="wp_login_page_enable" name="xs_global[wp_login_page][enable]" value="1" <?php echo esc_attr((isset($return_data['wp_login_page']['enable']) && $return_data['wp_login_page']['enable'] == 1) ? 'checked' : ''); ?> >
						<label for="wp_login_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(2);' ); ?>"  class="social_switch_button_label"></label>

						<div id="xs_data_tr__2" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['wp_login_page']['enable']) ? 'active_tr' : '');?>">
								<label class="xs_label_wp_login" for="wp_login_page_data__login_form">
									<input class="wslu-global-radio-input" type="radio" id="wp_login_page_data__login_form" name="xs_global[wp_login_page][data]" value="login_form" <?php echo esc_attr((isset($return_data['wp_login_page']['data']) && $return_data['wp_login_page']['data'] == 'login_form') ? 'checked' : 'checked'); ?>>
									<?php echo esc_html__('wp login form middle ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wp_login_page_data__login_head">
									<input class="wslu-global-radio-input" type="radio" id="wp_login_page_data__login_head" name="xs_global[wp_login_page][data]" value="login_head" <?php echo esc_attr((isset($return_data['wp_login_page']['data']) && $return_data['wp_login_page']['data'] == 'login_head') ? 'checked' : ''); ?>>
									<?php echo esc_html__('wp login form head', 'wp-social')?>
								</label>
								

								<label class="xs_label_wp_login" for="wp_login_page_data__login_footer">
									<input class="wslu-global-radio-input" type="radio" id="wp_login_page_data__login_footer" name="xs_global[wp_login_page][data]" value="login_footer" <?php echo esc_attr((isset($return_data['wp_login_page']['data']) && $return_data['wp_login_page']['data'] == 'login_footer') ? 'checked' : ''); ?>>
									<?php echo esc_html__('wp login footer ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wp_login_page_data__login_message">
									<input class="wslu-global-radio-input" type="radio" id="wp_login_page_data__login_message" name="xs_global[wp_login_page][data]" value="login_message" <?php echo esc_attr((isset($return_data['wp_login_page']['data']) && $return_data['wp_login_page']['data'] == 'login_message') ? 'checked' : ''); ?>>
									<?php echo esc_html__('wp login message section ', 'wp-social')?>
								</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- Wp register Page-->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to wp-register page ', 'wp-social');?>
								</label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="wp_register_page_enable" name="xs_global[wp_register_page][enable]" value="1" <?php echo esc_attr((isset($return_data['wp_register_page']['enable']) && $return_data['wp_register_page']['enable'] == 1) ? 'checked' : ''); ?> >
						<label for="wp_register_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(3);' ); ?>"  class="social_switch_button_label"></label>


						<div id="xs_data_tr__3" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['wp_register_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="wp_register_page_data__register_form">
								<input class="wslu-global-radio-input" type="radio" id="wp_register_page_data__register_form" name="xs_global[wp_register_page][data]" value="register_form" <?php echo esc_attr((isset($return_data['wp_register_page']['data']) && $return_data['wp_register_page']['data'] == 'register_form') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html__('wp register form middle ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="wp_register_page_data__register_head">
								<input class="wslu-global-radio-input" type="radio" id="wp_register_page_data__register_head" name="xs_global[wp_register_page][data]" value="register_head" <?php echo esc_attr((isset($return_data['wp_register_page']['data']) && $return_data['wp_register_page']['data'] == 'register_head') ? 'checked' : ''); ?>>
								<?php echo esc_html__('wp register form head ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="wp_register_page_data__register_footer">
								<input class="wslu-global-radio-input" type="radio" id="wp_register_page_data__register_footer" name="xs_global[wp_register_page][data]" value="register_footer" <?php echo esc_attr((isset($return_data['wp_register_page']['data']) && $return_data['wp_register_page']['data'] == 'register_footer') ? 'checked' : ''); ?>>
								<?php echo esc_html__('wp register footer ', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- fundrasing -->
				<?php if (in_array('wp-fundraising-donation/wp-fundraising.php', apply_filters('active_plugins', get_option('active_plugins')))) : ?>
					<div class="wslu-single-item">
						
						<div class="wslu-left-label">
							<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to Wp-fundraising login page', 'wp-social');?></label>
						</div>

						<div class="wslu-right-content">
							<input class="social_switch_button" type="checkbox" id="wfp_register_page_data_enable" name="xs_global[wfp_fund_login_page][enable]" value="1" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['enable']) && $return_data['wfp_fund_login_page']['enable'] == 1) ? 'checked' : ''); ?> >
							<label for="wfp_register_page_data_enable" onclick="<?php echo esc_js( 'xs_show_hide(33);' ); ?>"  class="social_switch_button_label"></label>


							<div id="xs_data_tr__33" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['wfp_fund_login_page']['enable']) ? 'active_tr' : '');?>">
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_form_outer_before">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_form_outer_before" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_before_outer" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_before_outer') ? 'checked' : 'checked'); ?>>
									<?php echo esc_html__('Wp-fundraising login form outer before ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_form_outer_after">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_form_outer_after" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_after_outer" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_after_outer') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form outer after ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_form_inner_before">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_form_inner_before" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_before_inner" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_before_inner') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form inner before ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_form_inner_after">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_form_inner_after" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_after_inner" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_after_inner') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form inner after ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_login_form_start">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_login_form_start" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_start" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_start') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form start ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_login_form_end">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_login_form_end" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_end" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_end') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form end ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_login_form_button_before">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_login_form_button_before" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_button_before" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_button_before') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form button before ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_login_form_button_after">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_login_form_button_after" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_button_after" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_button_after') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form button after ', 'wp-social')?>
								</label>
								
								<label class="xs_label_wp_login" for="wfp_register_page_data__wfp_login_form_message">
									<input class="wslu-global-radio-input" type="radio" id="wfp_register_page_data__wfp_login_form_message" name="xs_global[wfp_fund_login_page][data]" value="wfp_login_form_message" <?php echo esc_attr((isset($return_data['wfp_fund_login_page']['data']) && $return_data['wfp_fund_login_page']['data'] == 'wfp_login_form_message') ? 'checked' : ''); ?>>
									<?php echo esc_html__('Wp-fundraising login form message ', 'wp-social')?>
								</label>
							</div>
							
						</div>
					</div> <!-- ./ End Single Item -->
				<?php endif; ?>

				<!-- Wp comment Page -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button in wp-comment page ', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
							<input class="social_switch_button" type="checkbox" id="wp_comment_page_enable" name="xs_global[wp_comment_page][enable]" value="1" <?php echo esc_attr((isset($return_data['wp_comment_page']['enable']) && $return_data['wp_comment_page']['enable'] == 1) ? 'checked' : ''); ?> >
							<label for="wp_comment_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(4);' ); ?>" class="social_switch_button_label"></label>


						<div id="xs_data_tr__4" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['wp_comment_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="wp_comment_page_data__comment_form_top">
								<input class="wslu-global-radio-input" type="radio" id="wp_comment_page_data__comment_form_top" name="xs_global[wp_comment_page][data]" value="comment_form_top" <?php echo esc_attr((isset($return_data['wp_comment_page']['data']) && $return_data['wp_comment_page']['data'] == 'comment_form_top') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html__('wp comment form top ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="wp_comment_page_data__comment_form_must_log_in_after">
								<input class="wslu-global-radio-input" type="radio" id="wp_comment_page_data__comment_form_must_log_in_after" name="xs_global[wp_comment_page][data]" value="comment_form_must_log_in_after" <?php echo esc_attr((isset($return_data['wp_comment_page']['data']) && $return_data['wp_comment_page']['data'] == 'comment_form_must_log_in_after') ? 'checked' : ''); ?>>
								<?php echo esc_html__('wp comment form after login', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- WooCommerce login Page -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to WooCommerce login page ', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
							<input class="social_switch_button" type="checkbox" id="woocommerce_login_page_enable" name="xs_global[woocommerce_login_page][enable]" value="1" <?php echo esc_attr((isset($return_data['woocommerce_login_page']['enable']) && $return_data['woocommerce_login_page']['enable'] == 1) ? 'checked' : ''); ?> >
							<label for="woocommerce_login_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(5);' ); ?>" class="social_switch_button_label"></label>


						<div id="xs_data_tr__5" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['woocommerce_login_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="woocommerce_login_page_data__login_form_start">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_login_page_data__login_form_start" name="xs_global[woocommerce_login_page][data]" value="woocommerce_login_form_start" <?php echo esc_attr((isset($return_data['woocommerce_login_page']['data']) && $return_data['woocommerce_login_page']['data'] == 'woocommerce_login_form_start') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html__('WooCommerce login form start ', 'wp-social')?>
							</label>
							

							<label class="xs_label_wp_login" for="woocommerce_login_page_data__login_form">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_login_page_data__login_form" name="xs_global[woocommerce_login_page][data]" value="woocommerce_login_form" <?php echo esc_attr((isset($return_data['woocommerce_login_page']['data']) && $return_data['woocommerce_login_page']['data'] == 'woocommerce_login_form') ? 'checked' : ''); ?>>
								<?php echo esc_html__('WooCommerce login form middle ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="woocommerce_login_page_data__login_form_end">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_login_page_data__login_form_end" name="xs_global[woocommerce_login_page][data]" value="woocommerce_login_form_end" <?php echo esc_attr((isset($return_data['woocommerce_login_page']['data']) && $return_data['woocommerce_login_page']['data'] == 'woocommerce_login_form_end') ? 'checked' : ''); ?>>
								<?php echo esc_html__('WooCommerce login form end ', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- WooCommerce register Page -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to WooCommerce register page ', 'wp-social');?>
								</label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="woocommerce_register_page_enable" name="xs_global[woocommerce_register_page][enable]" value="1" <?php echo esc_attr((isset($return_data['woocommerce_register_page']['enable']) && $return_data['woocommerce_register_page']['enable'] == 1) ? 'checked' : ''); ?> >
						<label for="woocommerce_register_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(6);' ); ?>" class="social_switch_button_label"></label>


						<div id="xs_data_tr__6" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['woocommerce_register_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="woocommerce_register_page_data__register_form_start">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_register_page_data__register_form_start" name="xs_global[woocommerce_register_page][data]" value="woocommerce_register_form_start" <?php echo esc_attr((isset($return_data['woocommerce_register_page']['data']) && $return_data['woocommerce_register_page']['data'] == 'woocommerce_register_form_start') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html__('WooCommerce registration form start ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="woocommerce_register_page_data__register_form">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_register_page_data__register_form" name="xs_global[woocommerce_register_page][data]" value="woocommerce_register_form" <?php echo esc_attr((isset($return_data['woocommerce_register_page']['data']) && $return_data['woocommerce_register_page']['data'] == 'woocommerce_register_form') ? 'checked' : ''); ?>>
								<?php echo esc_html__('WooCommerce registration form middle ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="woocommerce_register_page_data__register_form_end">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_register_page_data__register_form_end" name="xs_global[woocommerce_register_page][data]" value="woocommerce_register_form_end" <?php echo esc_attr((isset($return_data['woocommerce_register_page']['data']) && $return_data['woocommerce_register_page']['data'] == 'woocommerce_register_form_end') ? 'checked' : ''); ?>>
								<?php echo esc_html__('WooCommerce registration form end ', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- WooCommerce billing Page -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to WooCommerce billing page ', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="woocommerce_billing_page_enable" name="xs_global[woocommerce_billing_page][enable]" value="1" <?php echo esc_attr((isset($return_data['woocommerce_billing_page']['enable']) && $return_data['woocommerce_billing_page']['enable'] == 1) ? 'checked' : ''); ?> >
						<label for="woocommerce_billing_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(7);' ); ?>" class="social_switch_button_label"></label>


						<div id="xs_data_tr__7" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['woocommerce_billing_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="woocommerce_register_page_data__before_checkout_billing_form">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_register_page_data__before_checkout_billing_form" name="xs_global[woocommerce_billing_page][data]" value="woocommerce_before_checkout_billing_form" <?php echo esc_attr((isset($return_data['woocommerce_billing_page']['data']) && $return_data['woocommerce_billing_page']['data'] == 'woocommerce_before_checkout_billing_form') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html__('WooCommerce before checkout billing form ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="woocommerce_register_page_data__after_checkout_billing_form">
								<input class="wslu-global-radio-input" type="radio" id="woocommerce_register_page_data__after_checkout_billing_form" name="xs_global[woocommerce_billing_page][data]" value="woocommerce_after_checkout_billing_form" <?php echo esc_attr((isset($return_data['woocommerce_billing_page']['data']) && $return_data['woocommerce_billing_page']['data'] == 'woocommerce_after_checkout_billing_form') ? 'checked' : ''); ?>>
								<?php echo esc_html__('WooCommerce after checkout billing form ', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- BuddyPress Page -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Show button to BuddyPress ', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="buddypress_billing_page_enable" name="xs_global[buddypress_page][enable]" value="1" <?php echo esc_attr((isset($return_data['buddypress_page']['enable']) && $return_data['buddypress_page']['enable'] == 1) ? 'checked' : ''); ?>  >
						<label for="buddypress_billing_page_enable" onclick="<?php echo esc_js( 'xs_show_hide(8);' ); ?>" class="social_switch_button_label"></label>


						<div id="xs_data_tr__8" class="wslu-input-list deactive_tr  <?php echo esc_attr(isset($return_data['buddypress_page']['enable']) ? 'active_tr' : '');?>">
							<label class="xs_label_wp_login" for="buddypress_page_data__bp_before_register_page">
								<input class="wslu-global-radio-input" type="radio" id="buddypress_page_data__bp_before_register_page" name="xs_global[buddypress_page][data]" value="bp_before_register_page" <?php echo esc_attr((isset($return_data['buddypress_page']['data']) && $return_data['buddypress_page']['data'] == 'bp_before_register_page') ? 'checked' : 'checked'); ?>>
								<?php echo esc_html_e('BuddyPress before register form ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="buddypress_page_data__bp_before_account_details_fields">
								<input class="wslu-global-radio-input" type="radio" id="buddypress_page_data__bp_before_account_details_fields" name="xs_global[buddypress_page][data]" value="bp_before_account_details_fields" <?php echo esc_attr((isset($return_data['buddypress_page']['data']) && $return_data['buddypress_page']['data'] == 'bp_before_account_details_fields') ? 'checked' : ''); ?>>
								<?php echo esc_html_e('BuddyPress account details fields ', 'wp-social')?>
							</label>
							
							<label class="xs_label_wp_login" for="buddypress_page_data__bp_after_register_page">
								<input class="wslu-global-radio-input" type="radio" id="buddypress_page_data__bp_after_register_page" name="xs_global[buddypress_page][data]" value="bp_after_register_page" <?php echo esc_attr((isset($return_data['buddypress_page']['data']) && $return_data['buddypress_page']['data'] == 'bp_after_register_page') ? 'checked' : ''); ?>>
								<?php echo esc_html_e('BuddyPress after register form ', 'wp-social')?>
							</label>
						</div>
						
					</div>
				</div> <!-- ./ End Single Item -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">
						<label class="wslu-sec-title" for=""><?php echo esc_html__('Email login credentials to a newly-registered user', 'wp-social');?></label>
					</div>

					<div class="wslu-right-content">
						<input class="social_switch_button" type="checkbox" id="email_new_registered_user" name="xs_global[email_new_registered_user][enable]" value="1" <?php echo esc_attr((isset($return_data['email_new_registered_user']['enable']) && $return_data['email_new_registered_user']['enable'] == 1) ? 'checked' : ''); ?>>
						<label for="email_new_registered_user" class="social_switch_button_label"></label>
					</div>
				</div> <!-- ./ End Single Item -->
				<?php do_action('wp_social_login_global_settings', $return_data); ?>
				<!-- Submit Button -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label">&nbsp;</div>

					<div class="wslu-right-content">
						<?php wp_nonce_field( 'global_setting_submit_form_nonce', 'nonce' ); ?>
						<button type="submit" name="global_setting_submit_form" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes', 'wp-social');?></button>
					</div>
				</div> <!-- ./ End Single Item -->

				<!-- Shortcode section -->
				<div class="wslu-single-item">
					
					<div class="wslu-left-label"><label class="wslu-sec-title" for=""><?php echo esc_html__('Shortcode ', 'wp-social');?></label></div>

					<div class="wslu-right-content">
						<ol class="wslu-social-shortcodes">
							<li>[xs_social_login] </li>
							<li>[xs_social_login provider="facebook,twitter,github" class="custom-class"] </li>
							<li>[xs_social_login provider="facebook" class="custom-class" btn-text="Button Text"]</li>
						</ol>
					</div>
				</div> <!-- ./ End Single Item -->

			</div>

		
		</div>
	</form>
</div>