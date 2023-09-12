<?php

namespace Elementor;

defined('ABSPATH') || exit;

use ShopEngine\Widgets\Products;

class ShopEngine_Cart_Table extends \ShopEngine\Base\Widget {

	public function config() {
		return new ShopEngine_Cart_Table_Config();
	}


	protected function register_controls() {

        /*
        * Setting Tab - Content
        */
		$this->start_controls_section(
			'shopengine_section_cart_table_general',
			[
				'label'     => esc_html__('General', 'shopengine'),
				'type'      => Controls_Manager::TAB_SETTINGS,
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer__buttons',
			[
				'label'     => esc_html__('Buttons', 'shopengine'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_continue_shopping',
			[
				'label'        => esc_html__('Hide Continue Shopping Button?', 'shopengine'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine'),
				'label_off'    => esc_html__('No', 'shopengine'),
				'return_value' => 'none',
				'default'      => 'inline-block',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer  .return-to-shop' => 'display: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'show_clear_all',
			[
				'label'        => esc_html__('Hide Clear All Button?', 'shopengine'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine'),
				'label_off'    => esc_html__('No', 'shopengine'),
				'return_value' => 'none',
				'default'      => 'inline-block',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer button[name=empty_cart]' => 'display: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_section_cart_table_content',
			[
				'label'     => esc_html__('Content', 'shopengine'),
				'type'      => Controls_Manager::TAB_SETTINGS,
			]
		);
		
		$this->add_control(
			'shopengine_cart_table_title',
			[
				'label'     => esc_html__('Title', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Product Name', 'shopengine')
			]
		);

		$this->add_control(
			'shopengine_cart_table_price',
			[
				'label'     => esc_html__('Price', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Price', 'shopengine')
			]
		);

		$this->add_control(
			'shopengine_cart_table_quantity',
			[
				'label'     => esc_html__('Quantity', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Quantity', 'shopengine')
			]
		);

		$this->add_control(
			'shopengine_cart_table_subtotal',
			[
				'label'     => esc_html__('Subtotal', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Subtotal', 'shopengine')
			]
		);
		
		$this->add_control(
			'shopengine_cart_continue_shopping_btn',
			[
				'label'     => esc_html__('Continue Shopping', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Continue Shopping', 'shopengine')
			]
		);

		$this->add_control(
			'shopengine_cart_table_update',
			[
				'label'     => esc_html__('Update Cart', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Update Cart', 'shopengine')
			]
		);

		$this->add_control(
			'shopengine_cart_table_clear_all',
			[
				'label'     => esc_html__('Clear All', 'shopengine'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Clear All', 'shopengine')
			]
		);

		$this->end_controls_section();

        /*
			==============================
        	Style Tab - Cart Table Header
			=============================
        */
        $this->start_controls_section(
            'shopengine_section__cart_table_head',
            [
                'label' => esc_html__('Table Header', 'shopengine'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_cart_table_head__bg_color',
            [
                'label' 	=> esc_html__( 'Background Color', 'shopengine' ),
                'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
                'default'   => '#F2F2F2',
				'alpha'		=> false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-cart-table .shopengine-table__head' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_cart_table_head__color',
            [
                'label' 	=> esc_html__( 'Text Color', 'shopengine' ),
                'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
                'default'   => '#3a3a3a',
				'alpha'		=> false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-cart-table .shopengine-table__head div' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'shopengine_cart_table_head_typography',
                'label'    => esc_html__('Typography', 'shopengine'),
                'name'		=> 'shopengine_cart_table_head_typography',
                'label'		=> esc_html__('Typography', 'shopengine'),
                'selector'	=> '{{WRAPPER}} .shopengine-cart-table .shopengine-table__head div',
				'exclude'	=> ['font_style', 'text_decoration', 'font_family'],
                'fields_options'    => [
                    'typography'    => [
                        'default'   => 'custom',
                    ],
                    'font_weight'   => [
                        'default'   => '600',
                    ],
                    'font_size'     => [
						'label'     => esc_html__('Font Size (px)', 'shopengine'),
                        'default'   => [
                            'size'  => '16',
                            'unit'  => 'px'
                        ],
						'size_units' => ['px']
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
					'line_height'    => [
						'label'      => esc_html__('Line-Height (px)', 'shopengine'),
						'default'    => [
							'size' => '19',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			)
		);

		$this->add_responsive_control(
			'shopengine_cart_table_head__padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '12',
					'right'    => '40',
					'bottom'   => '12',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__head' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_cart_table_head__border',
				'label'          => esc_html__('Border', 'shopengine'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-cart-table .shopengine-table__head' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__head' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#f2f2f2'
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__head',
				'separator'	=> 'before'
			]
		);

		$this->end_controls_section(); // end ./ Style Tab - Cart Table Header

		/*
			===============================
		 	Style Tab - Cart Table Body
			===============================
		 */

		$this->start_controls_section(
			'shopengine_section__cart_table_content',
			[
				'label' => esc_html__('Table Body', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_cart_table_single_cart_item_bg',
			[
				'label'     => esc_html__('Background', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body' => 'background: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'shopengine_cart_table_content__text_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#979797',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body :is(.shopengine-table__body-item--td, div, a, span)' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_border_color',
			[
				'label'     => esc_html__('Border Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F2F2F2',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body' => 'border-style: solid; border-width: 0 1px 1px 1px; border-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_content__text_hover_color',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#979797',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-table__body-item--td a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_content__price_color',
			[
				'label'     => esc_html__('Price Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#222222',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-table__body-item--td .amount :is(span, bdi)'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-cart-table table tbody .product-subtotal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_cart_table_content_typography',
				'label'          => esc_html__('Typography', 'shopengine'),
				'selector'       => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-table__body-item--td :is(a, .amount, bdi)',
				'exclude'		=> ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_weight'    => [
						'default' => '500',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine'),
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine'),
						'default'    => [
							'size' => '18',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			)
		);

		$this->add_responsive_control(
			'shopengine_cart_table_content_padding',
			[
				'label'           => esc_html__('Content Padding (px)', 'shopengine'),
				'type'            => Controls_Manager::DIMENSIONS,
				'size_units'      => ['px'],
				'desktop_default' => [
					'top'      => '30',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'tablet_default'  => [
					'top'      => '20',
					'right'    => '30',
					'bottom'   => '20',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'       => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],

			]
		);


		$this->add_control(
			'shopengine_cart_table_cell_gap',
			[
				'label'      => esc_html__('Row Gap', 'shopengine'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section(); // end ./ Style Tab - Cart Table Body

		/*
			===============================
		 	Style Tab - produt image
			===============================
		 */

		$this->start_controls_section(
			'shopengine_ct_product_image',
			[
				'label' => esc_html__('Product Image', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_ct_product_image_border',
				'label'          => esc_html__('Border', 'shopengine'),
				'exclude'        => ['color'],
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
				],
				'selector'       => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img',
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'shopengine_ct_product_image_border_clr',
			[
				'label'     => esc_html__('Border Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F2F2F2',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img'    => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_ct_product_image_border_radius',
			[
				'label'     => esc_html__('Border Radius (px)', 'shopengine'),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'   => [
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before'
			]
		);

		$this->add_control(
			'shopengine_ct_product_image_width',
			[
				'label'      => esc_html__('Width', 'shopengine'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_ct_product_image_padding',
			[
				'label'           => esc_html__('Padding (px)', 'shopengine'),
				'type'            => Controls_Manager::DIMENSIONS,
				'size_units'      => ['px'],
				'selectors'       => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body .product-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // end ./ Style Tab - produt image


		/*
			===============================
		 	Style Tab - produt item
			===============================
		 */

		$this->start_controls_section(
			'shopengine_ct_product_item',
			[
				'label' => esc_html__('Product Item', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_ct_product_item_background',
			[
				'label' => esc_html__( 'Show Item Background?', 'shopengine' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopengine' ),
				'label_off' => esc_html__( 'Hide', 'shopengine' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'shopengine_ct_product_item_background_notice',
			[
				'label'         => esc_html__( 'Notice', 'shopengine' ),
				'type'          => \Elementor\Controls_Manager::RAW_HTML,
				'show_label'    => false,
				'raw'           => esc_html__( 'If you allow Item background please control padding from Product item section', 'shopengine' ),
				'content_classes'=> 'elementor-panel-alert elementor-panel-alert-info',
				'condition'      => [
					'shopengine_ct_product_item_background' => 'yes',
				], 
			]
		);

		$this->add_control(
			'shopengine_ct_product_item_even_background',
			[
				'label'      => esc_html__( 'Even Background Color', 'shopengine' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'default'    => '#F9FAFB',
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item:nth-child(even)' => 'background-color: {{VALUE}}',
				],
				'condition'  => [
					'shopengine_ct_product_item_background' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_ct_product_item_odd_background',
			[
				'label' => esc_html__( 'Odd Background Color', 'shopengine' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'    => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
				'condition'      => [
					'shopengine_ct_product_item_background' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_ct_product_item_border',
				'label'          => esc_html__('Border', 'shopengine'),
				'separator'      => 'before',
				'fields_options' => [
					'width'  => [
						'label'   => esc_html__('Border Width', 'shopengine'),
						'default' => [
							'top'      => 1,
							'right'    => 1,
							'bottom'   => 1,
							'left'     => 1,
							'isLinked' => true,
						],
						'responsive' => false,
					],
					'color'  => [
						'label'   => esc_html__('Border Color', 'shopengine'),
						'default' => '#dee3ea',
						'alpha'	  => false,
					],
				],
				'selector'  => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item',
			]
		);

		$this->add_responsive_control(
			'shopengine_ct_product_item_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // end ./ Style Tab - Product Item

		/*
			===============================
		 	Style Tab - Quantity
			===============================
		 */

		$this->start_controls_section(
			'shopengine_ct_quantity_section',
			[
				'label' => esc_html__('Quantity', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_cart_table_qty_btn_text_clr',
			[
				'label'     => esc_html__('Text Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-cart-quantity :is(.minus-button, .plus-button, .quantity, input)' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_qty_btn_hover_text_clr',
			[
				'label'     => esc_html__('Hover Text Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ACA3A3',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-cart-quantity :is(.minus-button, .plus-button):hover' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_qty_btn_background_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td .shopengine-cart-quantity' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_qty_btn_border_clr',
			[
				'label'     => esc_html__('Border Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F2F2F2',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body .shopengine-cart-quantity :is(.minus-button, .plus-button, .quantity)' => 'border-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_qty_btn_border_radius',
			[
				'label'     => esc_html__('Border Radius (px)', 'shopengine'),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td .shopengine-cart-quantity .minus-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-top-right-radius: 0px; border-bottom-right-radius: 0px;',
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td .shopengine-cart-quantity .plus-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-top-left-radius: 0px; border-bottom-left-radius: 0px;',
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td .shopengine-cart-quantity' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'separator'  => 'before'
			]
		);

		$this->end_controls_section(); // end ./ Style Tab - Quantity

		/*
		 * Style Tab - Cart Table Footer
		 */

		$this->start_controls_section(
			'shopengine_cart_table_footer_section',
			[
				'label' => esc_html__('Table Footer', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_bg',
			[
				'label'     => esc_html__('Background', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_cart_table_footer_padding',
			[
				'label'           => esc_html__('Padding (px)', 'shopengine'),
				'type'            => Controls_Manager::DIMENSIONS,
				'size_units'      => ['px'],
				'desktop_default' => [
					'top'      => '30',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'       => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__footer' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_cart_table_footer_alignment',
			[
				'label' =>esc_html__('Alignment', 'shopengine'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' =>esc_html__('Left', 'shopengine'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' =>esc_html__('Center', 'shopengine'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' =>esc_html__('Right', 'shopengine'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer' => 'justify-content: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-cart-table .shopengine-table__footer' => 'justify-content: end;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-cart-table .shopengine-table__footer' => 'justify-content: start;',
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_styles',
			[
				'label'     => esc_html__('Button Styles', 'shopengine'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'          => 'shopengine_cart_table_footer_btn_typography',
				'label'         => esc_html__('Typography', 'shopengine'),
				'selector'      => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button',
				'exclude'		=> ['font_family', 'letter_spacing', 'line_height', 'text_decoration', 'font_style'], 
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_weight'    => [
						'default' => '600',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine'),
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
				
				],
			)
		);

		

		$this->start_controls_tabs('shopengine_cart_table_footer_button_style__tabs');

		$this->start_controls_tab('shopengine_cart_table_footer_button_tab__normal',
			[
				'label' => esc_html__('Normal', 'shopengine'),
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_normal_color',
			[
				'label'     => esc_html__('Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#979797',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer :is(.shopengine-footer-button, a, i)'   => 'color: {{VALUE}} !important;'
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_normal_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f1f1',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('shopengine_cart_table_footer_button_tab__hover',
				[
					'label' => esc_html__('Hover', 'shopengine'),
				]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer :is(.shopengine-footer-button, a):hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button:hover :is(a, i, span)' => 'color: {{VALUE}} !important;'
				]
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_hover_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'shopengine_cart_table_footer_btn_padding',
			[
				'label'      => esc_html__('Button Padding', 'shopengine'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '13',
					'right'    => '22',
					'bottom'   => '15',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_cart_table_footer_btn_border_radius',
			[
				'label'     => esc_html__('Border Radius (px)', 'shopengine'),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'   => [
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__footer .shopengine-footer-button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before'
			]
		);

		$this->end_controls_section();

		/* Cart Table Remove Button Style start */
		$this->start_controls_section(
			'shopengine_cart_table_remove_button_style_section',
			[
				'label' => esc_html__('Remove Button', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'shopengine_table_remove_button_icon_change',
			[
				'label' =>esc_html__('Remove Icon', 'shopengine'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-times',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_cart_table_remove_button_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'default'    => [
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->start_controls_tabs(
			'shopengine_cart_table_remove_button_style_tabs'
		);
		
		$this->start_controls_tab(
			'shopengine_cart_table_normal_remove_button_style_tab',
			[
				'label' => esc_html__( 'Normal', 'shopengine' ),
			]
		);

		$this->add_control(
			'shopengine_cart_table_remove_btn_color',
			[
				'label'     => esc_html__('Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove :is(a,span)' => 'color: {{VALUE}} !important;'
				]
			]
		);

		$this->add_control(
			'shopengine_cart_table_remove_btn_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove :is(a)' => 'background-color: {{VALUE}};',
				],
			]
		);

		//opacity control with slider
		$this->add_control(
			'shopengine_cart_table_remove_btn_opacity',
			[
				'label' => esc_html__('Opacity', 'shopengine'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_cart_table_remove_btn_border',
				'label'          => esc_html__('Border', 'shopengine'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#f2f2f2'
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a',
				'separator'	=> 'before'
			]
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'shopengine_cart_table_hover_remove_button_style_tab',
			[
				'label' => esc_html__( 'Hover', 'shopengine' ),
			]
		);

		$this->add_control(
			'shopengine_cart_table_remove_btn_color_hover',
			[
				'label'     => esc_html__('Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove :is(a,span):hover' => 'color: {{VALUE}} !important;'
				]
			]
		);

		$this->add_control(
			'shopengine_cart_table_remove_btn_bg_color_hover',
			[
				'label'     => esc_html__('Background Color', 'shopengine'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove :is(a):hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		//opacity control with slider
		$this->add_control(
			'shopengine_cart_table_remove_btn_opacity_hover',
			[
				'label' => esc_html__('Opacity', 'shopengine'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a:hover' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_cart_table_remove_btn_border_hover',
				'label'          => esc_html__('Border', 'shopengine'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a:hover' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#f2f2f2'
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-cart-table .shopengine-table__body-item--td:first-child .product-thumbnail .product-remove a:hover',
				'separator'	=> 'before'
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/* Cart Table Remove Button Style end */

		/*---------------------------
		global font family
		-----------------------------*/
		$this->start_controls_section(
			'shopengine_cart_table_typography',
			array(
				'label' => esc_html__('Global Font', 'shopengine'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_cart_table_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine'),
				'type'        => Controls_Manager::FONT,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .shopengine-cart-table :is(.shopengine-table__body, .shopengine-table__head, .shopengine-table__footer) :is(div, span, a, button, bdi)' => 'font-family: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function screen() {

		$settings = $this->get_settings_for_display();

		$post_type = get_post_type();

		$tpl = Products::instance()->get_widget_template($this->get_name());

		include $tpl;
	}
}
