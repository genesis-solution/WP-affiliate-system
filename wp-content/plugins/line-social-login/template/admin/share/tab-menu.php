<?php
defined( 'ABSPATH') || exit;

$active_tab = isset($_GET["tab"]) ? sanitize_text_field($_GET["tab"]) : 'wslu_counter_setting';
?>

<div class="wslu-main-header">
	<h1>
		<img src="<?php echo esc_url( WSLU_LOGIN_PLUGIN_URL . 'assets/images/icon-title.png' ); ?>" alt="">
		<?php esc_html_e('WP Social Share Settings', 'wp-social'); ?>
	</h1>
</div>

<div class="wslu-nav-tab-wrapper">
	<ul>
		<li><a href="?page=wslu_share_setting" class="nav-tab <?php if($active_tab == 'wslu_counter_setting'){echo esc_attr('nav-tab-active');} ?> "><?php esc_html_e('Share Settings', 'wp-social'); ?></a></li>
		<li><a href="?page=wslu_share_setting&tab=wslu_providers" class="nav-tab <?php if($active_tab == 'wslu_providers'){echo esc_attr('nav-tab-active');} ?>"><?php esc_html_e('Providers', 'wp-social'); ?></a></li>
		<li><a href="?page=wslu_share_setting&tab=wslu_style_setting" class="nav-tab <?php if($active_tab == 'wslu_style_setting'){echo esc_attr('nav-tab-active');} ?>"><?php esc_html_e('Style Settings', 'wp-social'); ?></a></li>
	</ul>
</div>
