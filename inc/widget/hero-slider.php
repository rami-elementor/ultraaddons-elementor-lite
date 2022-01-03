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
use Elementor\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Hero_Slider extends Base{

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        //Naming of Args for swiper
        $name           = 'swiper';
        $js_file_url    = ULTRA_ADDONS_ASSETS . 'vendor/swiper/js/swiper.min.js';
        $dependency     =  ['jquery'];//['jquery'];
        $version        = ULTRA_ADDONS_VERSION;
        $in_footer      = true;

        wp_register_script( $name, $js_file_url, $dependency, $version, $in_footer );
        wp_enqueue_script( $name );

        $name          = 'frontend-hero-slider';
        $js_file_url   = ULTRA_ADDONS_ASSETS . 'js/frontend-hero-slider.js';
        $dependency    =  [];//['jquery'];
        $version       = ULTRA_ADDONS_VERSION;
        $in_footer  	  = true;

        wp_register_script( $name , $js_file_url, $dependency, $version, $in_footer );
        wp_enqueue_script( $name );

        //CSS file swiper
        wp_register_style('swiper', ULTRA_ADDONS_ASSETS . 'vendor/swiper/css/swiper.min.css' );
        wp_enqueue_style('swiper' );

    }
	/**
     * By Saiful Islam
     * depend css for this widget
     * 
     * @return Array
     */
    public function get_style_depends() {
        return ['swiper'];
    }

    /**
     * Retrieve the list of scripts the skill bar widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.9.2
     * @access public
     *
     * @return array Widget scripts dependencies.
     * @by Saiful
     */
    public function get_script_depends() {
		return [ 'jquery','swiper','frontend-hero-slider' ];
    }

    
    /**
     * Get your widget name
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string keywords
     */
    public function get_keywords() {
        return [ 'ultraaddons','ua', 'slider', 'hero', 'carousel' ];
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
        $this->slider_settings_controls();
        $this->slider_general_style();
        $this->slider_btn_style();
    }
    
    protected function slider_settings_controls(){
        $this->start_controls_section(
            'slider_settings',
            [
                'label'     => esc_html__( 'Slider Settings', 'ultraaddons' ),
            ]
        );

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ultraaddons' ),
				'label_off' => __( 'No', 'ultraaddons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);	
		
		$this->add_control(
			'speed',
			[
				'label' => __( 'Speed', 'ultraaddons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 500,
				'max' => 3000,
				'step' => 500,
				'default' => 1000,
				'frontend_available' => true,
			]
		);
        $this->add_control(
			'delay',
			[
				'label' => __( 'Delay', 'ultraaddons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 7000,
				'step' => 1000,
				'default' => 5000,
				'frontend_available' => true,
			]
		);
	
		$this->add_control(
			'show_nav',
			[
				'label' => __( 'Nav Button', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ultraaddons' ),
				'label_off' => __( 'No', 'ultraaddons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'stopOnHover',
			[
				'label' => __( 'Stop On Hover', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ultraaddons' ),
				'label_off' => __( 'No', 'ultraaddons' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
		
		$this->add_control(
			'effect',
			[
				'label' => __( 'Effects', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'frontend_available' => true,
				'options' => [
					'fade'  => __( 'Fade', 'ultraaddons' ),
					'flip' => __( 'Flip', 'ultraaddons' ),
					'cube' => __( 'Cube', 'ultraaddons' ),
					'cards' => __( 'Cards', 'ultraaddons' ),
				],
			]
		);
        $this->add_control(
			'slidesPerView',
			[
				'label' => __( 'Slides View', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'frontend_available' => true,
				'options' => [
                    'default'  => __( 'Default', 'ultraaddons' ),
					'1'  => __( 'One', 'ultraaddons' ),
					'2' => __( 'Two', 'ultraaddons' ),
					'3' => __( 'Three', 'ultraaddons' ),
					'4' => __( 'Four', 'ultraaddons' ),
				],
			]
		);
        $this->add_control(
			'spaceBetween',
			[
				'label' => __( 'Space Between', 'ultraaddons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 2,
				'default' => 50,
				'frontend_available' => true,
                'condition' => [
                    'slidesPerView!' => 'default',
                ],
			]
		);
		$this->add_control(
			'direction',
			[
				'label' => __( 'Direction', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'vertical',
				'frontend_available' => true,
				'options' => [
					'vertical'  => __( 'Vertical', 'ultraaddons' ),
					'horizontal' => __( 'Horizontal', 'ultraaddons' ),
				],
			]
		);
        $this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ultraaddons' ),
				'label_off' => __( 'No', 'ultraaddons' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
        $this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ultraaddons' ),
				'label_off' => __( 'No', 'ultraaddons' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
        //'bullets' | 'fraction' | 'progressbar' | 'custom'
        $this->add_control(
			'pagination_type',
			[
				'label' => __( 'Slides View', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bullets',
				'frontend_available' => true,
				'options' => [
					'bullets'  => __( 'Bullets', 'ultraaddons' ),
					'fraction' => __( 'Fraction', 'ultraaddons' ),
					'progressbar' => __( 'Pprogressbar', 'ultraaddons' ),
					'custom' => __( 'Custom', 'ultraaddons' ),
				],
			]
		);

        $this->end_controls_section();
    }
        
    /**
     * General Section for Content Controls
     * 
     * @since 1.0.0.9
     */
    protected function content_general_controls() {
        $this->start_controls_section(
            'general_content',
            [
                'label'     => esc_html__( 'General', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'Title', 'ultraaddons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'ultraaddons' ),
				'label_block' => true,
			]
		);
        $repeater->add_control(
			'list_content', [
				'label' => esc_html__( 'Content', 'ultraaddons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' , 'ultraaddons' ),
				'label_block' => true,
			]
		);
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'ultraaddons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					
				],
			]
		);
        $repeater->add_control(
			'list_btn', [
				'label' => esc_html__( 'Button Text', 'ultraaddons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More' , 'ultraaddons' ),
				'label_block' => true,
			]
		);
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Repeater List', 'ultraaddons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'iPhone', 'ultraaddons' ),
					],
					[
						'list_title' => esc_html__( 'Mackbook', 'ultraaddons' ),
					],

				],
				'title_field' => '{{{ list_title }}}',
			]
		);

        
        $this->end_controls_section();
    }
     /**
     * General Section for Content Controls
     * 
     * @since 1.0.0.9
     */
    protected function slider_general_style() {
        $this->start_controls_section(
            'general_style',
            [
                'label'     => esc_html__( 'General Style', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
			'_slider_text_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ultraaddons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'ultraaddons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ultraaddons' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'ultraaddons' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .ua-slider-container' => 'text-align: {{VALUE}};',
				],
			]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name' => 'slider_title_typo',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .ua-slider-title',
			]
        );
        $this->add_control(
			'slider_title', [
				'label' => __( 'Title Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-title' => 'color: {{VALUE}};',
				],
                'separator'=> 'after',
				'default'=>'#E90C03'
			]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name' => 'slider_small_title_typo',
                'label' => 'Small Title Typography',
                'selector' => '{{WRAPPER}} .ua-slider-sub-title',
			]
        );
        $this->add_control(
			'slider_small_title', [
				'label' => __( 'Small Title Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-sub-title' => 'color: {{VALUE}};',
				],
                'separator'=> 'after',
				'default'=>'#fff'
			]
        );
        
        $this->end_controls_section();
    }
    /**
	 * Button Style.
	 */
	protected function slider_btn_style(){
		$this->start_controls_section(
            'slide_btn_style',
            [
                'label'     => esc_html__( 'Slider Button', 'ultraaddons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->start_controls_tabs(
			'slide_btn_normal_tabs'
		);
		/**
		 * Normal tab
		 */
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'ultraaddons' ),
			]
		);
		$this->add_control(
			'_ua_slide_btn_bg', [
				'label' => __( 'Button Background', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-buttton' => 'background: {{VALUE}};',
				]
			]
        );
		$this->add_control(
			'_ua_slide_btn_color', [
				'label' => __( 'Button Text Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-buttton, i.uicon.uicon-cart' => 'color: {{VALUE}};',
				]
			]
        );
	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
					'name' => 'slide_btn_typography',
					'label' => 'Button Typography',
					'selector' => '{{WRAPPER}} .ua-slider-buttton',
			]
        );
		$this->add_responsive_control(
			'_slide_btn_radius',
			[
				'label'       => esc_html__( 'Button Radius', 'ultraaddons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} .ua-slider-buttton' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'_slide_btn_padding',
			[
				'label'       => esc_html__( 'Button Padding', 'ultraaddons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} .ua-slider-buttton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();
		/**
		 * Button Hover tab
		 */
		$this->start_controls_tab(
			'slide_btn_hover_tabs',
			[
				'label' => __( 'Hover', 'ultraaddons' ),
			]
		);
		$this->add_control(
			'_ua_slide_btn_hover_bg', [
				'label' => __( 'Button Background', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-buttton:hover' => 'background: {{VALUE}};',
				]
			]
        );
		$this->add_control(
			'_ua_slide_btn_hover_color', [
				'label' => __( 'Button Text Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .ua-slider-buttton:hover, .ua-slider-buttton:hover' => 'color: {{VALUE}};',
				]
			]
        );
	
		$this->end_controls_tabs();
		
		$this->end_controls_tab();
		
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
        $settings           = $this->get_settings_for_display();
        ?>
   <!-- Slider main container -->
   <div class="ua-hero">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php 
            if ( $settings['list'] ) {
                $count=0;
                foreach (  $settings['list'] as $item ) {
                    $count = $count+1;
            ?>
            <div class="swiper-slide slide-<?php echo $count;?>">
                <div class="ua-image" style="background: url(<?php echo $item['image']['url'] ;?>)">
                    <div class="ua-slider-container">
                        <h4 class="ua-slider-sub-title">
                            <?php echo $item['list_title'];?>
                        </h4>
                        <div class="animated-area">
                                <h1 class="ua-slider-title"><?php echo $item['list_content'];?></h1>
                                <a href="#" class="ua-slider-buttton"><?php echo $item['list_btn'];?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
        }
        ?>
        </div>

         <?php if( 'yes'== $settings['pagination'] ):?>
            <div class="swiper-pagination"></div>
         <?php endif;?>
         <?php if( 'yes'== $settings['navigation'] ):?>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        <?php endif;?>
    
    </div>
        <?php
        
    }
    
    
}
