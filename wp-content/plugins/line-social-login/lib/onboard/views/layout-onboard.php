<!-- onboard_steps nav begins -->
<?php

$settings_sections = [
    'dashboard' => [
        'title' => esc_html__('Dashboard', 'wp-social'),
        'sub-title' => esc_html__('General info', 'wp-social'),
        'icon' => 'icon icon-home',
        // 'view_path' => 'some path to the view file'
    ],
    'widgets' => [
        'title' => esc_html__('Widgets', 'wp-social'),
        'sub-title' => esc_html__('Enable disable widgets', 'wp-social'),
        'icon' => 'icon icon-magic-wand',
    ],
    'modules' => [
        'title' => esc_html__('Modules', 'wp-social'),
        'sub-title' => esc_html__('Enable disable modules', 'wp-social'),
        'icon' => 'icon icon-settings-2',
    ],
    'usersettings' => [
        'title' => esc_html__('User Settings', 'wp-social'),
        'sub-title' => esc_html__('Settings for fb, mailchimp etc', 'wp-social'),
        'icon' => 'icon icon-settings1',
    ],
];

$settings_sections = apply_filters('metform/admin/settings_sections/list', $settings_sections);


$onboard_steps = [
    'step-01' => [
        'title'     => esc_html__('Configuration', 'wp-social'),
        'sub-title' => esc_html__('Configuration info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-wpsocial'),
    ],
    'step-02' => [
        'title'     => esc_html__('Sign Up', 'wp-social'),
        'sub-title' => esc_html__('Sign Up info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-user')
    ],
    'step-03' => [
        'title'     => esc_html__('Website Powerup', 'wp-social'),
        'sub-title' => esc_html__('Website Powerup info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-layout')
    ],
    'step-04' => [
        'title'     => esc_html__('Tutorial', 'wp-social'),
        'sub-title' => esc_html__('Tutorial info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-youtube')
    ],
    'step-05' => [
        'title'     => esc_html__('Surprise', 'wp-social'),
        'sub-title' => esc_html__('Surprise info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-gift')
    ],
    'step-06' => [
        'title'     => esc_html__('Finalizing', 'wp-social'),
        'sub-title' => esc_html__('Finalizing info', 'wp-social'),
        'icon'      => esc_attr('xs-onboard-smile')
    ]
];

if(\Wp_Social\Plugin::instance()->package_type() != 'free'){
    unset($onboard_steps['step-05']);
}else {
    unset($onboard_steps['step-01']);
}

$onboard_steps = apply_filters('elementskit/admin/onboard_steps/list', $onboard_steps);

echo wp_kses('<ul class="wslu-onboard-nav"><div class="wslu-onboard-progressbar"></div>', \WP_Social\Helper\Helper::get_kses_array());
$count     = 1;
foreach ( $onboard_steps as $step_key => $step ):
	$icon = ! empty( $step['icon'] ) ? $step['icon'] : '';
	$title = ! empty( $step['title'] ) ? $step['title'] : '';
	?>
    <li data-step_key="<?php echo esc_attr( $step_key ); ?>"
        class="wslu-onboard-nav-item" <?php echo $count === 1 ? 'active' : '';
	    echo esc_attr($count === count( $onboard_steps ) ? 'last' : ''); ?>">
		
        <?php if ( ! empty( $icon ) ) : ?>
            <i class="wslu-onboard-nav-icon <?php echo esc_attr( $icon ); ?>"></i>
		<?php endif; ?>

		<?php if ( ! empty( $title ) ) : ?>
            <span class="wslu-onboard-nav-text"><?php echo esc_html( $title ); ?></span>
		<?php endif; ?>
    </li>
	<?php $count ++; endforeach;
echo wp_kses('</ul>', \WP_Social\Helper\Helper::get_kses_array());
?>
<!-- onboard_steps nav ends -->

<!-- onboard_steps content begins -->
<?php foreach ( $onboard_steps as $step_key => $step ): ?>

    <!-- includes view file for this step -->
	<?php
	$path = isset( $step['view_path'] )
		? $step['view_path']
		: self::get_dir() . 'views/onboard-steps/' . $step_key . '.php';

	if ( file_exists( $path ) ) {
		echo wp_kses('<div class="wslu-onboard-step-wrapper wslu-onboard-' . esc_attr( $step_key ) . '">', \WP_Social\Helper\Helper::get_kses_array());
		include( $path );
		echo wp_kses('</div>', \WP_Social\Helper\Helper::get_kses_array());
	} ?>

<?php endforeach; ?>
<!-- onboard_steps content ends -->