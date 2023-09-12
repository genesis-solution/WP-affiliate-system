<?php

namespace Elementor;

use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;
use ShopEngine\Core\Elementor_Controls\Controls_Manager as ShopEngine_Controls_Manager;

defined('ABSPATH') || exit;

class ShopEngine_Product_Category_Lists extends \ShopEngine\Base\Widget
{

	public function config()
	{
		return new ShopEngine_Product_Category_Lists_Config();
	}

	protected function register_controls()
	{

		// SETTINGS - SECTION
		$this->start_controls_section(
			'shopengine_product_cat_lists_setting_section',
			array(
				'label' => esc_html__('Settings', 'shopengine'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'shopengine_product_cat_list_styles',
			[
				'label'	=> esc_html__('Category Style', 'shopengine'),
				'type' 	=> Controls_Manager::SELECT,
				'options' => [
					'normal'     => esc_html__('Normal', 'shopengine'), // to do need update
					'style_2'  => esc_html__('Style 2', 'shopengine'),
				],
				'default'	=> 'normal',
			]
		);


		$this->add_control(
			'shopengine_product_cat_lists_cats',
			[
				'label' 		=> esc_html__('Select Category', 'shopengine'),
				'type' 			=> ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'		=> 'ajaxselect2/product_cat',
				'multiple' 		=> true,
				'label_block'	=> true,
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_product_cat_lists_column',
			[
				'label'	=> esc_html__('Column', 'shopengine'),
				'type'	=> Controls_Manager::NUMBER,
				'min' 	=> 1,
				'max' 	=> 12,
				'step' 	=> 1,
				'desktop_default'	=> 3,
				'tablet_default'	=> 2,
				'mobile_default'	=> 1,
				'selectors'	=> [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-lists-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr))',
				]
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_show_cat_image',
			[
				'label'	=> esc_html__('Show Category Image', 'shopengine'),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__('Show', 'shopengine'), // to do need update
				'label_off'	=> esc_html__('Hide', 'shopengine'),
				'return_value'	=> 'yes',
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_show_count',
			[
				'label'	=> esc_html__('Show Porduct Count', 'shopengine'),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__('Show', 'shopengine'),
				'label_off'	=> esc_html__('Hide', 'shopengine'),
				'return_value'	=> 'yes',
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
				'default'	=> 'yes',
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_show_icon',
			[
				'label'	=> esc_html__('Show Icon', 'shopengine'),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__('Show', 'shopengine'),
				'label_off'	=> esc_html__('Hide', 'shopengine'),
				'return_value'	=> 'yes',
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
				'default'	=> 'yes',
			]
		);


		$repeater = new Repeater();

		$repeater->add_control(
			'shopengine_product_cat_list',
			[
				'label'	=> esc_html__('Category', 'shopengine'),
				'type' 	=> ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'		=> 'ajaxselect2/product_cat',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'shopengine_product_cat_lists_icons',
			[
				'label'	=> esc_html__('Icon', 'shopengine'),
				'type' 	=> Controls_Manager::ICONS,
				'default'	=> [
					'value'		=> 'fas fa-chevron-right',
					'library'	=> 'fa-solid',
				],
			]
		);

		$this->add_control(
			'category_lists',
			[
				'label' => esc_html__('Category List', 'shopengine'),
				'type' => Controls_Manager::REPEATER,
				'separator' => 'after',
				'fields' => $repeater->get_controls(),
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'style_2'
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_icon',
			[
				'label'	=> esc_html__('Icon', 'shopengine'),
				'type' 	=> Controls_Manager::ICONS,
				'default'	=> [
					'value'		=> 'fas fa-chevron-right',
					'library'	=> 'fa-solid',
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_text_align',
			[
				'label'	=> esc_html__('Content Alignment', 'shopengine'),
				'type' 	=> Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'	=> esc_html__('Left', 'shopengine'),
						'icon'	=> 'eicon-text-align-left',
					],
					'center' => [
						'title'	=> esc_html__('Center', 'shopengine'),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'shopengine'),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default'	=> 'left',
				'toggle'	=> true,
				'prefix_class'	=> 'elementor-align-',
				'selectors'	=> [
					'{{WRAPPER}} .shopengine-product-category-lists .single-product-category' => 'text-align: {{VALUE}}',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-product-category-lists .single-product-category' => 'text-align: right;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-product-category-lists .single-product-category' => 'text-align: left;',
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->end_controls_section();

		// STYLE - LIST SECTION
		$this->start_controls_section(
			'shopengine_product_cat_lists_list_style_section',
			[
				'label' => esc_html__('List', 'shopengine'),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_product_cat_lists_item_column_gap',
			[
				'label' => esc_html__('Column Gap (px)', 'shopengine'),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'       => [
					'unit'  => 'px',
					'size'  => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-lists-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_product_cat_lists_item_row_gap',
			[
				'label' => esc_html__('Row Gap (px)', 'shopengine'),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'       => [
					'unit'  => 'px',
					'size'  => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-lists-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		//content gap
		$this->add_responsive_control(
			'shopengine_product_cat_lists_item_content_gap',
			[
				'label' => esc_html__('Content Gap (px)', 'shopengine'),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'       => [],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-lists-grid .shopengine-category-items' => 'gap: {{SIZE}}{{UNIT}}',
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'style_2'
				],
			]
		);

		$this->start_controls_tabs(
			'shopengine_product_cat_lists_item_tabs'
		);

		$this->start_controls_tab(
			'shopengine_product_cat_lists_item_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine'),
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_item_bg',
			[
				'label'	=> esc_html__('Background Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#DBEBE3',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item' => 'background: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_item_overlay_bg',
			[
				'label'	=> esc_html__('Overlay Background', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item::before' => 'content: ""; background: {{VALUE}};',
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 	=> 'shopengine_product_cat_lists_item_box_shadow',
				'label' => esc_html__('Box Shadow', 'shopengine'),
				'selector' => '{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item, {{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'shopengine_product_cat_lists_item_border',
				'label' => esc_html__('Border', 'shopengine'),
				'fields_options' => [
					'border' => [
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'border-style: {{VALUE}};',
						]
					],
					'width' => [
						'default' => [
							'top' => '',
							'right' => '',
							'bottom' => '',
							'left' => '',
							'isLinked' => false,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
					],
					'color' => [
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'border-color: {{VALUE}};',
						],
					],
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'style_2'
				],
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_product_cat_lists_item_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine'),
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_item_hover_bg',
			[
				'label'	=> esc_html__('Background Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item:hover' => 'background: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_item_hover_overlay_bg',
			[
				'label'	=> esc_html__('Overlay Background', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists  .single-cat-list-item:hover:before' => 'content: ""; background: {{VALUE}};',
				],
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'normal'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'	=> 'shopengine_product_cat_lists_item_hover_box_shadow',
				'label' => esc_html__('Box Shadow', 'shopengine'),
				'fields_options' => [
					'box_shadow_type'	=> [
						'default'	=> 'yes'
					],
					'box_shadow'		=> [
						'default'	=> [
							'horizontal'	=> 0,
							'vertical'		=> 9,
							'blur'			=> 16,
							'spread'		=> -4,
							'color'			=> 'rgba(0, 0, 0, 0.23)',
						]
					],
				],
				'selector' => '{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item:hover, {{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'shopengine_product_cat_lists_item_hover_border',
				'label' => esc_html__('Border', 'shopengine'),
				'selector' => '{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover',
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'style_2'
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'shopengine_product_cat_lists_padding',
			[
				'label' => esc_html__('Padding (px)', 'shopengine'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'       => '20',
					'right'     => '25',
					'bottom'    => '20',
					'left'      => '25',
					'unit'      => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - TITLE SECTION
		$this->start_controls_section(
			'shopengine_product_cat_lists_title_section',
			[
				'label'	=> esc_html__('Title', 'shopengine'),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_title_color',
			[
				'label'	=> esc_html__('Title Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#3E3E3E',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .product-category-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .product-category-list-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_title_hover_color',
			[
				'label' => esc_html__('Title Hover Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#F03D3F',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .product-category-title:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover .product-category-list-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'shopengine_product_cat_lists_title_typography',
				'label' => esc_html__('Typography', 'shopengine'),
				'selector' => '{{WRAPPER}} .shopengine-product-category-lists .product-category-title, {{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .product-category-list-title',
				'exclude'  => ['text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'	=> [
						'default'	=> 'custom',
					],
					'font_size'	=> [
						'label' => esc_html__('Font Size (px)', 'shopengine'),
						'size_units'	=> ['px'],
						'default' 	=> [
							'size'	=> '20',
							'unit'	=> 'px'
						]
					],
					'font_weight'	=> [
						'default' 	=> '500',
					],
					'text_transform' => [
						'default'	=> '',
					],
					'line_height'	=> [
						'size_units' => ['px'],
						'label'		=> 'Line Height (px)',
						'default' 	=> [
							'size' 	=> '22',
							'unit' 	=> 'px'
						]
					],
					'letter_spacing'	=> [
						'default' 	=> [
							'size' 	=> '',
						]
					],
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_title_margin',
			[
				'label' => esc_html__('Margin (px)', 'shopengine'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '18',
					'left'      => '0',
					'unit'      => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .product-category-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .product-category-title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_product_cat_list_styles' => 'normal',
				],
			]
		);

		$this->end_controls_section();

		// STYLE - COUNT SECTION
		$this->start_controls_section(
			'shopengine_product_cat_lists_count_section',
			[
				'label'	=> esc_html__('Category Count', 'shopengine'),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_product_cat_lists_show_count' => 'yes',
					'shopengine_product_cat_list_styles' => 'normal',
				]
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_color',
			[
				'label'	=> esc_html__('Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#F03D3F',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_hover_color',
			[
				'label' => esc_html__('Title Hover Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-count:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'count_typography',
				'label' => esc_html__('Typography', 'shopengine'),
				'selector' => '{{WRAPPER}} .shopengine-product-category-lists .cat-count',
				'exclude'  => ['text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'	=> [
						'default'	=> 'custom',
					],
					'font_size'	=> [
						'label' => esc_html__('Font Size (px)', 'shopengine'),
						'size_units'	=> ['px'],
						'default' 	=> [
							'size'	=> '16',
							'unit'	=> 'px'
						]
					],
					'font_weight'	=> [
						'default' 	=> '600',
					],
					'line_height'	=> [
						'size_units' => ['px'],
						'label'		=> 'Line Height (px)',
						'default' 	=> [
							'size' 	=> '22',
							'unit' 	=> 'px'
						]
					],
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_margin',
			[
				'label' => esc_html__('Margin (px)', 'shopengine'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '18',
					'left'      => '0',
					'unit'      => 'px',
					'isLinked'  => false,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .cat-count' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// STYLE - BUTTON SECTION
		$this->start_controls_section(
			'shopengine_product_cat_lists_count_btn_section',
			[
				'label'	=> esc_html__('Button', 'shopengine'),
				'tab'	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_product_cat_lists_show_icon' => 'yes',
					'shopengine_product_cat_list_styles' => 'normal',
				]
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_size',
			[
				'label'	=> esc_html__('Button Size (px)', 'shopengine'),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'       => [
					'unit'  => 'px',
					'size'  => '30',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .single-cat-list-item .cat-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_font_size',
			[
				'label' => esc_html__('Button Font Size (px)', 'shopengine'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'       => [
					'unit'  => 'px',
					'size'  => '12',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->start_controls_tabs(
			'shopengine_product_cat_lists_count_button_tabs',
			[
				'separator'  => 'before',
			]
		);

		$this->start_controls_tab(
			'shopengine_product_cat_lists_count_button_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine'),
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_color',
			[
				'label' => esc_html__('Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#858585',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_bg_color',
			[
				'label' => esc_html__('background Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_product_cat_lists_count_button_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine'),
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_hover_color',
			[
				'label' => esc_html__('Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_hover_bg_color',
			[
				'label' => esc_html__('Background Color', 'shopengine'),
				'type'	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '#F03D3F',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_control(
			'shopengine_product_cat_lists_count_button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'shopengine'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default'    => [
					'top'       => '100',
					'right'     => '100',
					'bottom'    => '100',
					'left'      => '100',
					'unit'      => '%',
					'isLinked'  => true,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_count_button_padding',
			[
				'label' => esc_html__('Padding (px)', 'shopengine'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-category-lists .cat-icon' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_product_cat_lists_icon_style_section',
			[
				'label' => esc_html__('Icon Style', 'shopengine'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'     => [
					'shopengine_product_cat_list_styles' => 'style_2'
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_icon_color',
			[
				'label' => esc_html__('Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon :is(svg path)' => 'stroke:{{VALUE}};transition: all 0.3s ease-in-out;',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_icon_color_hover',
			[
				'label' => esc_html__('Hover Color', 'shopengine'),
				'type' 	=> Controls_Manager::COLOR,
				'alpha'	=> false,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover .shopengine-category-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items:hover .shopengine-category-icon :is(svg path)' => 'stroke:{{VALUE}};',
				],
			]
		);

		//icon size
		$this->add_control(
			'shopengine_product_cat_lists_icon_size',
			[
				'label' => esc_html__('Icon Size', 'shopengine'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_product_cat_lists_icon_position',
			[
				'label' => esc_html__('Icon Position', 'shopengine'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon i' => 'vertical-align: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-category-lists .shopengine-category-items .shopengine-category-icon svg' => 'vertical-align: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function screen()
	{
		$settings = $this->get_settings_for_display();

		extract($settings);

		$tpl = Products::instance()->get_widget_template($this->get_name());

		include $tpl;
	}
}
