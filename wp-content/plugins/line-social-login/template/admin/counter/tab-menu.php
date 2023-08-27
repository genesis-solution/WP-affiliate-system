<?php
defined( 'ABSPATH') || exit;

$def_tab = 'wslu_counter_setting';
$active_tab = empty($_GET["tab"]) ? $def_tab : \WP_Social\Helper\Helper::sanitize_white_list($_GET["tab"], $def_tab, \WP_Social\Keys::WSLU_COUNTER_TABS) ;

?>

<div class="wslu-main-header">
	<h1>
        <img src="<?php echo esc_url( WSLU_LOGIN_PLUGIN_URL . 'assets/images/icon-title.png' ); ?>" alt="">
        <?php esc_html_e('WP Social Counter Settings', 'wp-social'); ?>
    </h1>
</div>

<div class="wslu-nav-tab-wrapper">
	<ul>
		<li>
            <a href="?page=wslu_counter_setting" class="nav-tab <?php echo esc_attr(($active_tab === $def_tab) ? 'nav-tab-active' : '') ?> ">
                <?php esc_html_e('Counter Settings', 'wp-social'); ?>
            </a>
        </li>
		<li>
            <a href="?page=wslu_counter_setting&tab=wslu_providers" class="nav-tab <?php echo esc_attr(($active_tab === 'wslu_providers') ? 'nav-tab-active' : '') ?>">
                <?php esc_html_e('Providers', 'wp-social'); ?>
            </a>
        </li>
		<li>
            <a href="?page=wslu_counter_setting&tab=wslu_style_setting" class="nav-tab <?php echo esc_attr(($active_tab === 'wslu_style_setting') ? 'nav-tab-active' : '') ?>">
                <?php esc_html_e('Style Settings', 'wp-social'); ?>
            </a>
        </li>
	</ul>
</div>
