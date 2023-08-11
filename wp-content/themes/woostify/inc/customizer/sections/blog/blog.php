<?php
/**
 * Blog customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Tabs.
$wp_customize->add_setting(
	'woostify_setting[blog_context_tabs]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[blog_context_tabs]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_context_tabs]',
			'choices'  => array(
				'general' => __( 'Settings', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);


// Blog layout.
$wp_customize->add_setting(
	'woostify_setting[blog_list_layout]',
	array(
		'sanitize_callback' => 'woostify_sanitize_choices',
		'default'           => $defaults['blog_list_layout'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[blog_list_layout]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_layout]',
			'label'    => __( 'Blog Layout', 'woostify' ),
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_layout_choices',
				array(
					'standard' => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/standard.jpg',
					'list'     => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/list.jpg',
					'grid'     => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/grid.jpg',
					'zigzag'   => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/zigzag.jpg',
				)
			),
		)
	)
);

// Limit exerpt.
$wp_customize->add_setting(
	'woostify_setting[blog_list_limit_exerpt]',
	array(
		'sanitize_callback' => 'absint',
		'default'           => $defaults['blog_list_limit_exerpt'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_limit_exerpt]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_limit_exerpt]',
			'type'     => 'number',
			'label'    => __( 'Limit Excerpt', 'woostify' ),
			'tab'      => 'general',
		)
	)
);

// End section one divider.
$wp_customize->add_setting(
	'blog_list_section_one_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_list_section_one_divider',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_list_section_one_divider',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

// Blog list structure.
$wp_customize->add_setting(
	'woostify_setting[blog_list_structure]',
	array(
		'default'           => $defaults['blog_list_structure'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_list_structure]',
		array(
			'label'    => __( 'Blog List Structure', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_structure]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_structure_choices',
				array(
					'image'      => __( 'Featured Image', 'woostify' ),
					'title-meta' => __( 'Title', 'woostify' ),
					'post-meta'  => __( 'Post Meta', 'woostify' ),
				)
			),
		)
	)
);

// Blog list post meta.
$wp_customize->add_setting(
	'woostify_setting[blog_list_post_meta]',
	array(
		'default'           => $defaults['blog_list_post_meta'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_list_post_meta]',
		array(
			'label'    => __( 'Blog Post Meta', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_post_meta]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_post_meta_choices',
				array(
					'date'     => __( 'Publish Date', 'woostify' ),
					'author'   => __( 'Author', 'woostify' ),
					'category' => __( 'Category', 'woostify' ),
					'comments' => __( 'Comments', 'woostify' ),
				)
			),
		)
	)
);


// Title color.
$wp_customize->add_setting(
	'woostify_setting[blog_title_color]',
	array(
		'default'           => $defaults['blog_title_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_title_color]',
		array(
			'label'           => __( 'Title Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_title_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_title_font_size]',
	array(
		'default'           => $defaults['blog_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_title_tablet_font_size]',
	array(
		'default'           => $defaults['blog_title_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_title_mobile_font_size]',
	array(
		'default'           => $defaults['blog_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_title_font_size]',
				'tablet'  => 'woostify_setting[blog_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_title_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_title_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_title_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_title_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_title_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_title_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_title_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);


// Metadata  color.
$wp_customize->add_setting(
	'woostify_setting[blog_metadata_color]',
	array(
		'default'           => $defaults['blog_metadata_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_metadata_color]',
		array(
			'label'           => __( 'Meta Data Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_metadata_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_metadata_font_size]',
	array(
		'default'           => $defaults['blog_metadata_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_metadata_tablet_font_size]',
	array(
		'default'           => $defaults['blog_metadata_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_metadata_mobile_font_size]',
	array(
		'default'           => $defaults['blog_metadata_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_metadata_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Meta Data Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_metadata_font_size]',
				'tablet'  => 'woostify_setting[blog_metadata_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_metadata_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_metadata_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_metadata_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_metadata_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_metadata_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_metadata_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_metadata_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);


// Description  color.
$wp_customize->add_setting(
	'woostify_setting[blog_description_color]',
	array(
		'default'           => $defaults['blog_description_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_description_color]',
		array(
			'label'           => __( 'Description Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_description_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_description_font_size]',
	array(
		'default'           => $defaults['blog_description_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);


$wp_customize->add_setting(
	'woostify_setting[blog_description_tablet_font_size]',
	array(
		'default'           => $defaults['blog_description_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_description_mobile_font_size]',
	array(
		'default'           => $defaults['blog_description_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_description_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Description Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_description_font_size]',
				'tablet'  => 'woostify_setting[blog_description_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_description_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_description_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_description_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_description_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_description_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_description_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_description_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);
