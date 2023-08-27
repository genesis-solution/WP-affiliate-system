<?php

defined('ABSPATH') || exit;

$enabled_providers = \WP_Social\App\Settings::get_enabled_provider_conf_counter();

$show_core_provider = \WP_Social\App\Providers::get_core_providers_count();
$show_core_provider = array_keys($show_core_provider);

if(!empty($enabled_providers)) : ?>

    <div class="xs_social_counter_widget <?php echo esc_attr($className); ?>">
        <ul class="xs_counter_url <?php echo esc_attr($widget_style); ?>">

			<?php

			$factory = new \WP_Social\Lib\Provider\Counter_Factory();
			$cache_time = \WP_Social\App\Settings::get_counter_cache_time();

			foreach($show_core_provider as $key) {

				if(!empty($enabled_providers[$key]['enable'])) {

					// check if provider list is provided from widget
                    if(!in_array($key, $provider)) {
                        continue;
                    }

					$p_obj = $factory->make($key);
					//$follower_count = $p_obj->get_cached_count($cache_time);

					$label = isset($counter_provider[$key]['label']) ? $counter_provider[$key]['label'] : '';
					$def = isset($counter_provider[$key]['data']['value']) ? $counter_provider[$key]['data']['value'] : 0;
					$text = isset($counter_provider[$key]['data']['text']) ? $counter_provider[$key]['data']['text'] : '';

					/**
					 * We will give priority to the actual number, if actual number is zero then we will show the default value.
					 */
					$counter = !empty($counter_data[$key]) ? $counter_data[$key] : $def;
					#$counter = ($def) > 0 ? $def : $counter;

					$id = isset($counter_provider[$key]['id']) ? $counter_provider[$key]['id'] : '';
					$user_name = isset($counter_provider[$key]['user_name']) ? $counter_provider[$key]['user_name'] : '';
					$type = isset($counter_provider[$key]['type']) ? $counter_provider[$key]['type'] : '';
					$getUrl = isset($core_provider[$key]['data']['url']) ? $core_provider[$key]['data']['url'] : '#';

					if($key == 'youtube') {
						$url = sprintf($getUrl, strtolower($type), $id);

					} elseif($key == 'linkedin') {

						if($type == 'Profile') {
							$url = sprintf($getUrl, 'in', $id);

						} else {
							$url = sprintf($getUrl, 'company', $id);
						}
					} elseif($key == 'dribbble') {

						$url = get_option('home_url_dribbble_count', 'https://dribbble.com/');

					} elseif($key == 'instagram') {

						$url = sprintf($getUrl, $user_name);

					}else {
						$url = sprintf($getUrl, $id);
					}

					?>
                    <li class="xs-counter-li <?php echo esc_attr($key); ?>" data-key="<?php echo esc_attr($key); ?>">
                        <a href="<?php echo esc_url($url); ?>" target="_blank">
                            <div class="xs-social-icon">
                                <span class="met-social met-social-<?php echo esc_attr($key); ?>"></span>
                            </div>

							<?php

							if(!empty($styleArr[$cntStyleKey]['content'])) {

								if(!empty($styleArr[$cntStyleKey]['content']['number'])) {

									?>
                                    <div class="xs-social-follower">
										<?php echo esc_html(xs_format_num($counter)); ?>
                                    </div>

									<?php
								}

								if(!empty($styleArr[$cntStyleKey]['content']['label'])) {

									?>
                                    <div class="xs-social-follower-text">
										<?php echo esc_html($text); ?>
                                    </div>
									<?php
								}

							} else {

								?>
                                <div class="xs-social-follower">
									<?php echo esc_html(xs_format_num($counter)); ?>
                                </div>

                                <div class="xs-social-follower-text">
									<?php echo esc_html($text); ?>
                                </div>

								<?php
							}
							?>

                            <div class="wslu-hover-content">
                                <div class="xs-social-followers">
									<?php echo esc_html(xs_format_num($counter)); ?>
                                </div>
                                <div class="xs-social-follower-text">
									<?php echo esc_html($text); ?>
                                </div>
                            </div>

                        </a>
                    </li>
					<?php
				}
			}

			?>

        </ul>
    </div>

<?php

endif;
