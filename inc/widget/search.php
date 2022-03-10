<?php
namespace UltraAddons\Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Search extends Base{
    
    /**
     * Set your widget name keyword
     *
     *
     * @since 1.0.0
     * @access public
     *
     * @return string keywords
     */
    public function get_keywords() {
        return [ 'ultraaddons', 'ua', 'search', 'find' ];
    }
    
    
    
    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        //For General Section
        $this->content_general_controls();

       
        //General Control of Style for menu
        $this->content_general_style();
        $this->content_button_style();
    }
    
    
    
    
    /**
     * General Section for Content Controls
     * 
     * @since 1.0.0.9
     */
    protected function content_general_controls() {
        $this->start_controls_section(
                'general',
                [
                        'label' => __( 'General', 'ultraaddons' ),
                ]
        );
        
        
        
        $this->add_control(
                'type',
                [
                        'label'        => __( 'Type', 'ultraaddons' ),
                        'type'         => Controls_Manager::SELECT,
                        'options'      => [
                            'wp'        => __( 'Default Search', 'ultraaddons' ),
                            'wc'        => __( 'WooCommerce Product Search', 'ultraaddons' ),
                            'form-one'    => __( 'Search One', 'ultraaddons' ),
                        ],
                        'default'      => 'wp',
                        'save_default' => true,
                ]
        );
           $this->end_controls_section();
    }

        /**
     * General Style Section for Content Controls
     * 
     * @since 1.0.2.1
     */
     
    protected function content_general_style(){
            $this->start_controls_section(
                    'general_style',
                    [
                            'label' => __( 'Input', 'ultraaddons' ),
                            'tab' => Controls_Manager::TAB_STYLE,
                    ]
            );
            
           $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} .ua-form-one input[type="search"]',
			]
		);
                 $this->add_control(
			'repeater_bar_bg_color',
			[
				'label' => __( 'Background Color', 'ultraaddons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ua-form-one' => 'background-color: {{VALUE}};',
				],
			]
		);
             $this->start_controls_tabs( 'input_tab' );
            //Tab Normal
            $this->start_controls_tab(
                'input_normal',
                [
                    'label'  => esc_html__( 'Normal', 'ultraaddons' )
                ]
            );
             $this->add_group_control(
                Group_Control_Border::get_type(),
                    [
                            'name' => 'border_wrapper',
                            'label' => __( 'Wrapper Border', 'ultraaddons' ),
                            'selector' => '{{WRAPPER}} form.search-form,{{WRAPPER}} form.woocommerce-product-search, .ua-form-one',
                    ]
                );
            $this->add_control(
                    'border_radius',
                    [
                            'label' => __( 'Border Radius', 'ultraaddons' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                    '{{WRAPPER}} form.search-form input.search-field,{{WRAPPER}} form.woocommerce-product-search input.search-field' => 'border-radius: {{TOP}}{{UNIT}} 0{{UNIT}} 0{{UNIT}} {{LEFT}}{{UNIT}};',
                                    '{{WRAPPER}} form.search-form input.search-submit, {{WRAPPER}} form.woocommerce-product-search button' => 'border-radius: 0{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0{{UNIT}};',
                                    '{{WRAPPER}} form.search-form,{{WRAPPER}} form.woocommerce-product-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                    '{{WRAPPER}} form.ua-form-one' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                    ]
            );

            $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                            'name' => 'box_shadow',
                            'label' => __( 'Box Shadow', 'ultraaddons' ),
                            'selector' => '{{WRAPPER}} form.search-form,{{WRAPPER}} form.woocommerce-product-search, form.ua-form-one',
                    ]
            );
            $this->end_controls_tab();
            
            
            
            //Tab Hover
            $this->start_controls_tab(
                'input_hover',
                [
                    'label'  => esc_html__( 'Hover', 'ultraaddons' )
                ]
            );
             $this->add_group_control(
                Group_Control_Border::get_type(),
                    [
                            'name' => 'border_wrapper_hover',
                            'label' => __( 'Wrapper Border', 'ultraaddons' ),
                            'selector' => '{{WRAPPER}} form.search-form:hover,{{WRAPPER}} form.woocommerce-product-search:hover, .ua-form-one:hover',
                    ]
                );
            $this->add_control(
                    'border_radius_hover',
                    [
                            'label' => __( 'Border Radius', 'ultraaddons' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                    '{{WRAPPER}} form.search-form:hover input.search-field,{{WRAPPER}} form.woocommerce-product-search:hover input.search-field' => 'border-radius: {{TOP}}{{UNIT}} 0{{UNIT}} 0{{UNIT}} {{LEFT}}{{UNIT}};',
                                    '{{WRAPPER}} form.search-form:hover input.search-submit, {{WRAPPER}} form.woocommerce-product-search:hover button' => 'border-radius: 0{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0{{UNIT}};',
                                    '{{WRAPPER}} form.search-form:hover,{{WRAPPER}} form.woocommerce-product-search:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                    '{{WRAPPER}} form.ua-form-one:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                    ]
            );

            $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                            'name' => 'box_shadow_hover',
                            'label' => __( 'Box Shadow', 'ultraaddons' ),
                            'selector' => '{{WRAPPER}} form.search-form:hover,{{WRAPPER}} form.woocommerce-product-search:hover, form.ua-form-one:hover',
                    ]
            );
             $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();
    }
        /**
         * @author B M Rafiul Alam
         * @since 1.1.0.11
         */
        
        protected function content_button_style(){
            $this->start_controls_section(
                    'button_style',
                    [
                            'label' => __( 'Button', 'ultraaddons' ),
                            'tab' => Controls_Manager::TAB_STYLE,
                    ]
            );
            $this->add_responsive_control(
                'btn_position',
                [
                        'label' => esc_html__( 'Button Position', 'ultraaddons' ),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                                'left' => [
                                        'title' => esc_html__( 'Left', 'ultraaddons' ),
                                        'icon' => 'eicon-arrow-left',
                                ],
                                'right' => [
                                        'title' => esc_html__( 'Right', 'ultraaddons' ),
                                        'icon' => 'eicon-arrow-right',
                                ],
                        ],
                        'default' => 'right',
                        'condition' => array(
                                'type' => 'form-one',
                        ),
                ]
		);
             $this->start_controls_tabs( 'search_style_general_tab' );
            //Tab Normal
            $this->start_controls_tab(
                'tab_icon_bg',
                [
                    'label'  => esc_html__( 'Normal', 'ultraaddons' )
                ]
            );
            $this->add_control(
                'icon_bg',
                [
                        'label' => __( 'Button Background', 'ultraaddons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                                '{{WRAPPER}} form.search-form input.search-submit' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}} form.woocommerce-product-search button' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}} form.ua-form-one button' => 'background-color: {{VALUE}}',
                        ],
                ]
            );
            
            $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                            'name' => 'border',
                            'label' => __( 'Border', 'ultraaddons' ),
                            'selector' => '{{WRAPPER}} form.search-form input.search-field,{{WRAPPER}} form.woocommerce-product-search input.search-field, .ua-form-one input[type="text"]',
                    ]
            );
             $this->add_control(
                    'btn_border_radius',
                    [
                            'label' => __( 'Border Radius', 'ultraaddons' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                    '{{WRAPPER}} .ua-form-one button' => 'border-radius: {{TOP}}{{UNIT}} 0{{UNIT}} 0{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                    ]
            );
            $this->end_controls_tab();
            
            
            
            //Tab Hover
            $this->start_controls_tab(
                'tab_icon_hover_bg',
                [
                    'label'  => esc_html__( 'Hover', 'ultraaddons' )
                ]
            );
            $this->add_control(
                'icon_hover_bg',
                [
                        'label' => __( 'Button Hover Background', 'ultraaddons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                                '{{WRAPPER}} form.search-form:hover input.search-submit' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}} form.woocommerce-product-search:hover button' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}} form.ua-form-one:hover button' => 'background-color: {{VALUE}}',
                        ],
                ]
            );
            
            $this->add_group_control(
                    Group_Control_Border::get_type(),
                        [
                            'name' => 'border_hover',
                            'label' => __( 'Border', 'ultraaddons' ),
                           'selector' => '{{WRAPPER}} form.search-form:hover,{{WRAPPER}} form.woocommerce-product-search:hover',
                        ]
            );
            
             $this->add_control(
                    'btn_border_radius_hover',
                    [
                            'label' => __( 'Border Radius', 'ultraaddons' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                    '{{WRAPPER}} .ua-form-one:hover button' => 'border-radius: {{TOP}}{{UNIT}} 0{{UNIT}} 0{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                    ]
            );
            $this->end_controls_tab();
            $this->end_controls_tabs();

          $this->end_controls_section();
    }
        
     
    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        global $new_position;
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'id', 'ultraaddons-search-box-wrapper' );
        $type            = $settings['type'];
        $button_position = $settings['btn_position'];
        $new_position = $button_position;
       
        
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="ua-serach-inside">
                <?php
                if( class_exists( 'WooCommerce' ) && $type === 'wc' ){
                    echo get_product_search_form();
                }elseif( $type === 'wp' ){
                        echo get_search_form();
                }elseif($type==='form-one'){
                        echo $this->search_form_template_one();
                }
                ?>
            </div>
               
            
        </div>
        <?php

    }
    public function search_form_template_one(){
             global $new_position;
            ?>
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="ua-form-one">
                <?php 
                if($new_position==='left'):?>
                <button type="submit"><i class="fa fa-search"></i></button>
                <?php endif;?>
                <input type="search" name="s" class="ua-form-one-text" value="<?php the_search_query(); ?>"
            placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'ultraaddons' ); ?>">
                <?php 
                if($new_position==='right'):?>
                <button type="submit"><i class="fa fa-search"></i></button>
                <?php endif;?>
        </form>
    <?php }
    
}