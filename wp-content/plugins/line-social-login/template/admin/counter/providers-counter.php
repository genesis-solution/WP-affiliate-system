<?php
defined('ABSPATH') || exit;
?>

<div class="wslu-social-login-main-wrapper">
	<?php

	require(__DIR__ . '/tab-menu.php');

	/**
	 * todo - check this notice box too : WP1-217
	 * make a function and call it here
	 *
	 */

	if($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div id="XS_Social_Login_Settings"
                 class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible"
                 style="margin: 1em 0; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Providers data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span>
                </button>
            </div>
        </div>
	<?php } ?>

    <form action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers'); ?>"
          name="xs_provider_submit_form"
          method="post"
          id="xs_provider_form">

        <div class="xs-social-block-wraper">
            <ul class="xs-social-block" data-action="sort_providers_counter"
                data-sort_url="<?php echo esc_url(admin_url() . 'admin-ajax.php'); ?>">
				<?php
				$m = 1;
				$counter = new \WP_Social\Inc\Counter(false);
				$filed = $counter->xs_counter_providers_data();

				foreach($core_provider as $k => $v) :
					$name = isset($v['label']) ? $v['label'] : ucfirst($k);

					$js_target_id = 'open_counter__' . $k . '__' . $m;

					?>
                    <li data-provider="<?php echo esc_attr($k) ?>">
                        <div class="xs-single-social-block <?php echo esc_attr($k); ?>">

                            <div class="xs-block-header"
                                 onclick="xs_counter_open(this);"
                                 xs-target-id="<?php echo esc_attr($js_target_id); ?>">
                                <div class="xs-social-icon">
                                    <span class="met-social met-social-<?php echo esc_attr($k); ?>"></span>
                                </div>
                                <h2 class="xs-social-icon-title"><?php echo esc_html__($name, 'wp-social'); ?></h2>
                            </div>

                            <div class="xs-block-footer">
                                <div class="left-content">
                                    <div class="configure">

                                        <div class="wslu-single-popup-item wslu-inline">

                                            <input class="social_switch_button"
                                                   onchange="social_counter_enable(this)"
                                                   data-key="<?php echo esc_attr($k); ?>"
                                                   type="checkbox"
                                                   id="<?php echo esc_attr($k); ?>_enable"
                                                   name="xs_counter[social][<?php echo esc_attr($k); ?>][enable]"
                                                   value="1"
												<?php echo esc_attr(empty($enabled_providers[$k]['enable']) ? '' : 'checked'); ?> />

                                            <label for="<?php echo esc_attr($k); ?>_enable"
                                                   class="social_switch_button_label"></label>
                                        </div>

                                    </div>
                                </div>
                                <div class="right-content">
                                    <a href="javascript:void()"
                                       class="wslu-social-provider-btn xs-btn btn-special small"
                                       onclick="xs_counter_open(this);"
                                       xs-target-id="<?php echo esc_attr($js_target_id); ?>">

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
					<?php

					$m++;
				endforeach; ?>
            </ul>
        </div>

        <div class="xs-social-block-wraper-counter">
			<?php
			$m = 1;

			$factory = new \WP_Social\Lib\Provider\Counter_Factory();

			foreach($core_provider as $k => $val) :

				$js_target_id = 'open_counter__' . $k . '__' . $m;

				$v = $counter_provider[$k]; // why this bujruki!? cause i do not have time :P

				$obj = $factory->make($k);

				$name = isset($v['label']) ? $v['label'] : '';

				$setLabel = (isset($counter_provider[$k]['label']) && strlen($counter_provider[$k]['label']) > 2) ? $counter_provider[$k]['label'] : $name;

				$defaultText = isset($v['data']['text']) ? $v['data']['text'] : '';
				$belowText = (isset($counter_provider[$k]['data']['text'])) ? $counter_provider[$k]['data']['text'] : $defaultText;
				$belowValue = (isset($counter_provider[$k]['data']['value']) && $counter_provider[$k]['data']['value'] > 0) ? $counter_provider[$k]['data']['value'] : 0;

				$filedData = isset($filed[$k]) ? $filed[$k] : '';
				if(strlen($name) > 2) {
					?>
                    <div class="xs-modal-dialog <?php echo esc_attr(($getType == $k) ? 'is-open' : ''); ?>"
                         id="<?php echo esc_attr($js_target_id); ?>">
                        <div class="xs-modal-content">

                            <div class="xs-modal-header clear-both">

                                <div class="tabHeader">
                                    <ul class="tab__list clear-both"></ul>
                                </div>
                                <button
                                        type="button"
                                        class="xs-btn"
                                        onclick="xs_counter_open(this);"
                                        xs-target-id="<?php echo esc_attr($js_target_id); ?>">
                                    <span class="wslu-icon met-social met-social-cross"></span>
                                </button>
                            </div>

                            <div class="xs-modal-body">
                                <div class="ekit--tab__post__details tabContent">
                                    <h6 class="wslu-popup-provider-title"><?php echo esc_html__($setLabel, 'wp-social'); ?></h6>

                                    <div class="wslu-popup-data"> <?php

                                        if(is_array($filedData)) {

	                                        $fl_nm = __DIR__. '_'.$k.'__modal_content.php';

											foreach($filedData as $fk => $fv) {

												$label_field = isset($fv['label']) ? $fv['label'] : 'Id';

												$input = isset($fv['input']) ? $fv['input'] : 'text';
												$type = isset($fv['type']) ? $fv['type'] : 'normal';

												$setId = (isset($counter_provider[$k][$fk]) && strlen($counter_provider[$k][$fk]) > 2) ? $counter_provider[$k][$fk] : '';

												$show_access_token_grabbed_msg = false;

												?>

                                                <div class="wslu-single-popup-item <?php echo esc_attr(($type == 'access') ? 'xs-access-button-inline' : ''); ?>">

													<?php

													if($input == 'link') { ?>

                                                        <div class="wslu-admin-accordion-btn-group">
                                                            <a href="<?php echo esc_url($fv['url']) ?>" class="<?php echo esc_attr($fv['class']) ?>" target="_blank">
																<?php echo esc_html($fv['label']) ?>
                                                            </a>
                                                        </div>

													<?php

													} else {

													?>

                                                        <div class="setting-label-wraper">
                                                            <label class="setting-label wslu-sec-title"
                                                                   for="xs_<?php echo esc_attr($k); ?>_<?php echo esc_attr($fk); ?>"> <?php echo esc_html__($label_field, 'wp-social'); ?> </label>
                                                        </div>

													<?php


													if($input == 'text') {

													?>

                                                    <input name="xs_counter[social][<?php echo esc_attr($k); ?>][<?php echo esc_attr($fk); ?>]"
                                                           style="<?php echo esc_attr(($type == 'access') ? 'cursor: no-drop; opacity: .4;' : ''); ?>"
                                                           type="text" id="xs_<?php echo esc_attr($k); ?>_<?php echo esc_attr($fk); ?>"
                                                           value="<?php echo esc_html($setId); ?>"
                                                           class="wslu-global-input">

													<?php

													if($type == 'access') {
														echo wp_kses('<button class="xs-btn btn-special small" data-type="modal-trigger" data-target="example-modal-' . $k . '">'.__("Get Access Token", "wp-social").'</button>', \WP_Social\Helper\Helper::get_kses_array());
													}

													if($show_access_token_grabbed_msg === true) {


													$div_id = 'asd_' . time();


													echo wp_kses('<div id="' . $div_id . '" style="padding:5px; color:green">Access token grabbed successfully, please save the changes.</div>', \WP_Social\Helper\Helper::get_kses_array());


													?> <script>
                                                        setTimeout(function () {
                                                            jQuery('#<?php echo esc_attr($div_id) ?>').slideUp(1000, hide_the_message);
                                                        }, 5000);

                                                        function hide_the_message() {
                                                            jQuery('#<?php echo esc_attr($div_id) ?>').remove();
                                                        }

                                                    </script>

													<?php

													}

													} elseif($input == 'select') {

													$dataSelect = isset($fv['data']) ? $fv['data'] : '';

													if(is_array($dataSelect)) {

													?>

                                                        <select class="wslu-global-input"
                                                                name="xs_counter[social][<?php echo esc_attr($k); ?>][<?php echo esc_attr($fk); ?>]"
                                                                id="xs_<?php echo esc_attr($k); ?>_<?php echo esc_attr($fk); ?>">
															<?php foreach($dataSelect as $dk => $dv) : ?>
                                                                <option value="<?php echo esc_attr($dk); ?>" <?php echo esc_attr(($setId == $dk) ? 'selected' : ''); ?>><?php echo esc_html($dv); ?> </option>
															<?php endforeach; ?>
                                                        </select>
														<?php

													}

													}

													}

													?>

                                                </div>

                                                <?php

												if($type == 'access' && $k == $getType) {
													$setId = get_option('xs_counter_' . $k . '_token') ? get_option('xs_counter_' . $k . '_token') : '';

													if($getType == 'linkedin') {

														$code = isset($_GET['code']) ? sanitize_text_field($_GET['code']) : '';
														if(strlen($code) > 0) {
															$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $k . '';

															$credentials = get_transient('xs_counter_' . $k . '_api_key') . ':' . get_transient('xs_counter_' . $k . '_secret_key');
															$toSend = base64_encode($credentials);

															$args = [
																'method'      => 'POST',
																'httpversion' => '1.1',
																'blocking'    => true,
																'headers'     => [
																	'Authorization' => 'Basic ' . $toSend,
																	'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
																],
																'body'        => ['grant_type'    => 'authorization_code',
																                  'code'          => $code,
																                  'client_id'     => get_transient('xs_counter_' . $k . '_api_key'),
																                  'client_secret' => get_transient('xs_counter_' . $k . '_secret_key'),
																                  'redirect_uri'  => $cur_page,
																],
															];

															add_filter('https_ssl_verify', '__return_false');
															$response = wp_remote_post('https://www.linkedin.com/oauth/v2/accessToken', $args);

															$keys = json_decode(wp_remote_retrieve_body($response));

															if(isset($keys->access_token)) {
																$setId = $keys->access_token;
																update_option('xs_counter_' . $k . '_token', $setId);
																update_option('xs_counter_' . $k . '_app_id', get_transient('xs_counter_' . $k . '_api_key'));
																update_option('xs_counter_' . $k . '_app_secret', get_transient('xs_counter_' . $k . '_secret_key'));
															}
														}
													} elseif($getType == 'dribbble') {

														if(!empty($_GET['code'])) {

															$code = sanitize_text_field($_GET['code']);
															$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $k . '';

															/**
															 * As we have received temporary code
															 * now request for access_token via post method
															 * Right now I could not find any documentation
															 * of how long the access token will live in dribbble api document!
															 *
															 * todo - check deeply of token life time and implement refresh access token strategy
															 */

															$args = [
																'method'      => 'POST',
																'httpversion' => '1.1',
																'blocking'    => true,
																'body'        => [
																	'code'          => $code,
																	'client_id'     => get_option('xs_counter_dribbble_app_id'),
																	'client_secret' => get_option('xs_counter_dribbble_app_secret'),
																	'redirect_uri'  => $cur_page,
																],
															];

															$response = wp_remote_post('https://dribbble.com/oauth/token', $args);
															$token = json_decode(wp_remote_retrieve_body($response));

															if(empty($token->error)) {
																$setId = $token->access_token;
																$created = $token->created_at;
																$show_access_token_grabbed_msg = true;

																update_option('xs_counter_' . $k . '_token', $setId);
																update_option('xs_counter_' . $k . '_created', $created);
															}
														}
													}
												}

                                            }
										}
										?>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="xs_<?php echo esc_attr($k); ?>_text">
													<?php echo esc_html__('Default ' . $setLabel . ' ' . $belowText, 'wp-social'); ?>
                                                </label>
                                            </div>

                                            <input name="xs_counter[social][<?php echo esc_attr($k); ?>][data][value]"
                                                   type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_text"
                                                   value="<?php echo esc_html($belowValue); ?>"
                                                   class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="xs_<?php echo esc_attr($k); ?>_text"> <?php echo esc_html__('Text Below The Number', 'wp-social'); ?></label>
                                            </div>

                                            <input name="xs_counter[social][<?php echo esc_attr($k); ?>][data][text]" type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_text"
                                                   value="<?php echo esc_html($belowText); ?>"
                                                   class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
                                            <div class="setting-label-wraper">
                                                <label class="setting-label wslu-sec-title"
                                                       for="xs_<?php echo esc_attr($k); ?>_label"> <?php echo esc_html__('Label Name', 'wp-social'); ?></label>
                                            </div>
                                            <input name="xs_counter[social][<?php echo esc_attr($k); ?>][label]" type="text"
                                                   id="xs_<?php echo esc_attr($k); ?>_label"
                                                   value="<?php echo esc_html($setLabel); ?>" class="wslu-global-input">
                                        </div>

                                        <div class="wslu-single-popup-item">
											<?php

											if(!in_array($k, ['posts', 'comments'])):

												$provider = strtolower($k);
												$username = '';

												if($k == 'pinterest') {

													$username = empty($counter_provider[$k]['username']) ? '' : sanitize_key($counter_provider[$k]['username']);
													// todo - again some bujruki, need time to cleanup this shit

												} elseif(in_array($k, ['youtube', 'twitter'])) {
													$username = empty($counter_provider[$provider]['id']) ? '' : sanitize_key($counter_provider[$provider]['id']);
												}

												$time = get_option('_xs_social_' . $k . '_last_cached', 0);

												$ago = empty($time) ? esc_html__('No cache found', 'wp-social') : human_time_diff($time, time()) . ' ' . esc_html__('ago', 'wp-social');

												?>

                                                <div class="wslu-catch-clear">
                                                    <button type="button"
                                                            class="wslu-catch-clear--btn"
                                                            onclick="wp_social_clear_cache('<?php echo esc_attr($k) ?>', '<?php echo esc_attr($username) ?>')">
														<?php echo esc_html__('Clear', 'wp-social') ?>
                                                    </button>

                                                    <span class="wslu-catch-clear--text" id="<?php echo esc_attr($k) ?>_cache_msg">
                                                        <?php echo esc_html(__('Cached : ', 'wp-social') . $ago); ?>
                                                    </span>
                                                </div>

											<?php endif; ?>
                                        </div>
                                    </div>

                                </div>

                            </div>

							<?php

							if($k == 'posts' || $k == 'comments') {

								?>
                                <p style="color: #b5b512;">* If default value is given actual value will not show</p>
								<?php
							}

							?>
                            <div class="xs-modal-footer">
                                <button type="submit" name="counter_settings_submit_form"
                                        class="xs-btn btn-special"><?php echo esc_html__('Save Changes', 'wp-social'); ?></button>
                            </div>
                        </div>
                    </div>

					<?php
				}
				$m++;
			endforeach;
			?>
        </div>

    </form>

    <div class="xs-counter-popup-access-box">
		<?php

		if(is_array($filed)) {

			foreach($filed as $fk => $fv) :

				$apiCheck = isset($fv['api']) ? $fv['api'] : '';

				if(is_array($apiCheck)) {
					$name = isset($apiCheck['label']) ? $apiCheck['label'] : 'Key';
					$filedApi = isset($apiCheck['filed']) ? $apiCheck['filed'] : '';

					$popupLabel = (isset($counter_provider[$fk]['label']) && strlen($counter_provider[$fk]['label']) > 2) ? $counter_provider[$fk]['label'] : ucfirst($fk);
					?>
                    <form method="post"
                          action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $fk . ''); ?>">
                        <div class="xs-modal-dialog" id="example-modal-<?php echo esc_attr($fk); ?>">
                            <div class="xs-modal-content post__tab">
                                <div class="xs-modal-header clear-both">
                                    <div class="tabHeader">
                                        <ul class="tab__list clear-both"></ul>
                                    </div>
                                    <button type="button" class="xs-btn" data-modal-dismiss="modal">
                                        <span class="wslu-icon met-social met-social-cross"></span>
                                    </button>
                                </div>
                                <div class="xs-modal-body">
                                    <div class="ekit--tab__post__details tabContent">
                                        <div class="wslu-popup-data">
											<?php
											if(is_array($filedApi)) {
												foreach($filedApi as $fkl => $fvl) {
													$valueAPp = get_option('xs_counter_' . $fk . '_' . $fkl) ? get_option('xs_counter_' . $fk . '_' . $fkl) : '';
													?>
                                                    <div class="wslu-single-popup-item">
                                                        <div class="setting-label-wraper">
                                                            <label class="setting-label wslu-sec-title"
                                                                   for="xs_<?php echo esc_attr($fk); ?>_<?php echo esc_attr($fkl); ?>">
																<?php echo esc_html__($fvl, 'wp-social'); ?>
                                                            </label>
                                                        </div>

                                                        <input type="text"
                                                               name="accesskey[<?php echo esc_attr($fk); ?>][<?php echo esc_attr($fkl); ?>]"
                                                               class="wslu-global-input"
                                                               id="xs_<?php echo esc_attr($fk); ?>_<?php echo esc_attr($fkl); ?>"
                                                               value="<?php echo esc_attr($valueAPp); ?>">
                                                    </div>
													<?php
												}
											}
											?>
                                        </div>
                                    </div>
									<?php
									if($fk == 'instagram') {
										$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $fk . '';
										?>
                                        <p class="document"><?php echo esc_html__('Go to APP Settings and Set Callback URL', 'wp-social'); ?>
                                            <a href="<?php echo esc_url('https://www.instagram.com/developer/clients/manage/'); ?>"> <?php echo esc_html__('App Settings ', 'wp-social'); ?></a>
                                        </p>
                                        <p class="document"><?php echo esc_html__('Add the following URL to the "Valid OAuth redirect URIs" field:', 'wp-social'); ?>
                                            <strong><?php echo esc_url($cur_page); ?></strong></p>
									<?php }
									if($fk == 'linkedin') {
										$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $fk . '';
										?>
                                        <p class="document"><?php echo esc_html__('Go to APP Settings and Set Callback URL', 'wp-social'); ?>
                                            <a href="<?php echo esc_url('https://www.linkedin.com/developers/'); ?>"> <?php echo esc_html__('App Settings ', 'wp-social'); ?></a>
                                        </p>
                                        <p class="document"><?php echo esc_html__('Add the following URL to the "Valid OAuth redirect URIs" field:', 'wp-social'); ?>
                                            <strong><?php echo esc_url($cur_page); ?></strong></p>
									<?php }
									if($fk == 'dribbble') {
										$cur_page = admin_url() . 'admin.php?page=wslu_counter_setting&tab=wslu_providers&xs_access=' . $fk . '';
										?>
                                        <p class="document"><?php echo esc_html__('Go to APP Settings and Set Callback URL', 'wp-social'); ?>
                                            <a href="<?php echo esc_url('https://dribbble.com/account/applications/'); ?>"> <?php echo esc_html__('App Settings ', 'wp-social'); ?></a>
                                        </p>
                                        <div class="document"><?php echo esc_html__('Add the following URL to the "Valid OAuth redirect URIs" field:', 'wp-social'); ?>
                                            <pre style="width: 500px; overflow:scroll; font-weight:bold; padding:10px 10px 10px 0; color:brown"><?php echo esc_url($cur_page); ?></pre>
                                        </div>
									<?php } ?>
                                </div>
                                <div class="xs-modal-footer">
                                    <button type="submit" name="xs_provider_submit_form_access_counter"
                                            class="xs-btn btn-special"><?php echo esc_html__('Generate Key', 'wp-social'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
				<?php }
			endforeach;
		} ?>
        <div class="xs-backdrop <?php echo esc_attr(strlen($getType) > 1 && isset($_GET['code']) ? 'is-open' : ''); ?>"></div>
    </div>
</div>
