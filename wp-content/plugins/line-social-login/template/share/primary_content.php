<?php

use WP_Social\App\Settings;

defined('ABSPATH') || exit;


$uri_hash = md5($current_url);


if(!empty($styles[$selected_share_style]['package']) && $styles[$selected_share_style]['package'] == 'pro' && !WP_Social::is_pro_active()) {

	?>
    <div class="xs_social_share_widget xs_share_url">
        <ul>
            <li class="xs-share-li wslu-no-extra-data">Pro plugin deactivated or invalid</li>
        </ul>
    </div>
	<?php

	return;
}

if(empty($wanted_providers)) {

	return;
}

?>

    <div class="xs_social_share_widget xs_share_url <?php echo esc_attr($widget_style) ?>">

		<?php if($show_count_markup): ?>

            <div class="wslu-share-count">
                <span class="wslu-share-count--total"><?php echo esc_attr(xs_format_num($total_share_count)); ?></span>
                <span class="wslu-share-count--text"><?php esc_html_e('Shares', 'wp-social') ?></span>
            </div>

		<?php endif; ?>

        <ul>
			<?php
			$content = isset($styles[$selected_share_style]['content']) ? $styles[$selected_share_style]['content'] : '';

			foreach($wanted_providers as $key => $inf) {

				$counter = $share_counting[$key]['count'];

				$label = isset($share_settings[$key]['data']['label']) ? $share_settings[$key]['data']['label'] : ucfirst($key);
				$def = isset($share_settings[$key]['data']['value']) ? intval($share_settings[$key]['data']['value']) : 0;
				$text = isset($share_settings[$key]['data']['text']) ? $share_settings[$key]['data']['text'] : '';

				$getUrl = isset($core_provider[$key]['url']) ? $core_provider[$key]['url'] : '';
				$pData = isset($core_provider[$key]['params']) ? $core_provider[$key]['params'] : [];

				$urlCon = empty($core_provider[$key]['params']) ? [] : $core_provider[$key]['params'];

				$old_count = isset($share_settings[$key]['data']['old_count']) ? intval($share_settings[$key]['data']['old_count']) : 0;
				$old_count = apply_filters('wp_social_pro/provider/share/old_count', $old_count, $key);
				$counter = $counter + $old_count;

				foreach($urlCon as $k => $v) {

					$urlCon[$k] = str_replace(
						['[%url%]', '[%title%]', '[%author%]', '[%details%]', '[%source%]', '[%media%]', '[%app_id%]'],
						[$current_url, $title, $author, $details, $source, $media, $app_id],
						$v
					);
				}

				$params = http_build_query($urlCon, '&');

				$cls = $key . ' ' . $extra_data_cls;

				?>
                <li class="xs-share-li <?php echo esc_attr($cls) ?>">
                    <a href="javascript:void();"
                       id="xs_feed_<?php echo esc_attr($key) ?>"
                       onclick="xs_social_sharer(this);"
                       data-pid="<?php echo esc_attr($postId) ?>"
                       data-uri_hash="<?php echo esc_attr($uri_hash) ?>"
                       data-key="<?php echo esc_attr($key); ?>"
                       data-xs-href="<?php echo esc_url($getUrl . '?' . $params); ?>">

                        <div class="xs-social-icon">
                            <span class="met-social met-social-<?php echo esc_attr($key); ?>"> </span>
                        </div>

						<?php

                        if(!empty($styles[$selected_share_style]['content']) != '') : ?>
                            <div class="wslu-both-counter-text ">

								<?php if(Settings::has_number_content_in_selected_style($selected_share_style, $styles)) : ?>
                                    <div class="xs-social-follower">
										<?php echo esc_html(xs_format_num($counter)); ?>
                                    </div>
								<?php endif; ?>

								<?php if(Settings::has_text_content_in_selected_style($selected_share_style, $styles)) : ?>
                                    <div class="xs-social-follower-text">
										<?php echo esc_html($text); ?>
                                    </div>
								<?php endif; ?>

								<?php if(Settings::has_label_content_in_selected_style($selected_share_style, $styles)) : ?>
                                    <div class="xs-social-follower-label">
										<?php echo esc_html($label); ?>
                                    </div>
								<?php endif; ?>
                            </div>
						<?php endif; ?>

                        <div class="wslu-hover-content">
                            <div class="xs-social-followers">
								<?php echo esc_html(xs_format_num($counter)); ?>
                            </div>
                            <div class="xs-social-follower-text">
								<?php echo esc_html($text); ?>
                            </div>
                            <div class="xs-social-follower-label">
								<?php echo esc_html($label); ?>
                            </div>
                        </div>
                    </a>
                </li>
				<?php
			} ?>
        </ul>

    </div>
<?php
