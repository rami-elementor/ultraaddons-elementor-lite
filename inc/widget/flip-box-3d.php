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
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Flip_box_3d extends Base{

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
        return [ 'ultraaddons', 'ua', 'flipbox', '3d', 'flip', 'box' ];
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
        //For Content Section
        $this->content_general_controls();
        //For Design Section Style Tab
        $this->style_design_controls();
		//For Typography Style Tab
        $this->style_typography_controls();
		//For Box Style Tab
        $this->style_box_controls();
    }
	protected function content_general_controls() {
		$placeholder_image = ULTRA_ADDONS_URL . 'assets/images/user.png';
		
        $this->start_controls_section(
            'general_content',
            [
                'label'     => esc_html__( 'Content', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'_ua_flipbox_animation_type',
			[
				'label' => __( 'Animation Style', 'ultraaddons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'ultraaddons' ),
					'vertical'  => __( 'Vertical', 'ultraaddons' ),
				],
			]
		);
		 $this->add_control(
			'_ua_front_image',
			[
				'label' => __( 'Front Image', 'ultraaddons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
						'url' => $placeholder_image,//Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
						'active' => true,
				],

			]
        );
		$this->add_control(
			'icon_type',
			[
				'label'       => esc_html__( 'Back Media', 'ultraaddons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none' => [
						'title' => esc_html__( 'None', 'ultraaddons' ),
						'icon'  => 'fa fa-ban',
					],
					'_ua_back_icon' => [
						'title' => esc_html__( 'Icon', 'ultraaddons' ),
						'icon'  => 'fa fa-cog',
					],
					'back_image' => [
						'title' => esc_html__( 'Image', 'ultraaddons' ),
						'icon'  => 'fas fa-images',
					],
				],
				'default'     => 'icon',
			]
		);
		 $this->add_control(
			'_ua_back_image',
			[
				'label' => __( 'Back Image', 'ultraaddons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
						'url' => $placeholder_image,//Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'back_image',
				],
				'dynamic' => [
						'active' => true,
				],

			]
        );
		$this->add_control(
			'_ua_back_icon',
			[
				'label' => esc_html__( 'Back Icon', 'ultraaddons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => '_ua_back_icon',
				],
			]
		);
		$this->add_control(
			'_ua_icon_size',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 5,
					],
					'em' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'condition' => [
					'icon_type' => '_ua_back_icon',
				],
				'selectors' => [
					'{{WRAPPER}} .back i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'_ua_icon_color', [
				'label' => __( 'Icon Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .back i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type' => '_ua_back_icon',
				],
			]
        ); 
		/* $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		); */
		$this->add_control(
			'_ua_flipbox_front_title',
			[
				'label' => __( 'Front Title', 'ultraaddons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Jhone Doe', 'ultraaddons' ),
				'placeholder' => __( 'Enter your title', 'ultraaddons' ),
				'label_block' => true,
				'separator' =>'before'
			]
		);
	/* 	$this->add_control(
			'_ua_flipbox_front_sub_title',
			[
				'label' => __( 'Front Sub Title', 'ultraaddons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Developer', 'ultraaddons' ),
				'placeholder' => __( 'Enter your title', 'ultraaddons' ),
				'label_block' => true,
			]
		); */
		
		$this->add_control(
			'_ua_flipbox_back_title',
			[
				'label' => __( 'Back Title', 'ultraaddons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Flip Back', 'ultraaddons' ),
				'placeholder' => __( 'Enter your title', 'ultraaddons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'_ua_flipbox_content',
			[
				'label' => __( 'Content', 'ultraaddons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'The quickest & easiest service provider. Loem Ipsum doler sit amit.', 'ultraaddons' ),
				'placeholder' => __( 'Enter your title', 'ultraaddons' ),
				'label_block' => true,
			]
		);
		
	$this->end_controls_section();
	}
	protected function style_design_controls() {
        $this->start_controls_section(
            'flipbox_style',
            [
                'label'     => esc_html__( 'Color', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        
      $this->add_control(
			'flipbox_bg_front', [
				'label' => __( 'Front Background', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .front' => 'background-color: {{VALUE}};',
				],
			]
        );
		
		$this->add_control(
			'_ua_front_title_color', [
				'label' => __( 'Front Title Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .front-title' => 'color: {{VALUE}};',
				],
			]
        );
	
		$this->add_control(
			'flipbox_bg_back', [
				'label' => __( 'Back Background', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .back' => 'background: {{VALUE}};',
				],
			]
        );
		
		$this->add_control(
			'flipbox_title_back', [
				'label' => __( 'Back Title Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .back-title' => 'color: {{VALUE}};',
				],
			]
        );
		$this->add_control(
			'flipbox_content_back', [
				'label' => __( 'Content Color', 'ultraaddons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
						'{{WRAPPER}} .back p' => 'color: {{VALUE}};',
				],
				'separator'=>'before'
			]
        );
		
		$this->end_controls_section();
	}
	protected function style_typography_controls() {
        $this->start_controls_section(
            'flipbox_typo_style',
            [
                'label'     => esc_html__( 'Typography', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
					'name' => 'front_title_typography',
					'label' => 'Front Title Typography',
					'selector' => '{{WRAPPER}} .front-title',

			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
					'name' => 'back_title_typography',
					'label' => 'Back Title Typography',
					'selector' => '{{WRAPPER}} .back-title',

			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
					'name' => 'content_typography',
					'label' => 'Content Typography',
					'selector' => '{{WRAPPER}} .back p',

			]
        );
		
		$this->end_controls_section();
	}
	protected function style_box_controls() {
        $this->start_controls_section(
            '_ua_flipbox_box_style',
            [
                'label'     => esc_html__( 'Box Style', 'ultraaddons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'_ua_box_radius',
			[
				'label'       => esc_html__( 'Box Radius', 'ultraaddons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} .flip-container, .front, .back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'ultraaddons' ),
				'selector' => '{{WRAPPER}} .front,',
				'selector' => '{{WRAPPER}} .back',
			]
		);
		
		
		$this->end_controls_section();
	}

    protected function render() {
		$settings 		= $this->get_settings_for_display();
		$front_image 	= $settings['_ua_front_image'];
		$back_image 	= $settings['_ua_back_image'];
	?>
	
	<div class="flip flip-<?php echo $settings['_ua_flipbox_animation_type']; ?>">
		<div class="front" style="background-image:url(<?php echo esc_url($front_image['url']);?>)">
		   <h1 class="front-title"><?php echo esc_html($settings['_ua_flipbox_front_title']); ?></hi>
		</div>
		<div class="back">
		   <h2 class="back-title"><?php echo esc_html($settings['_ua_flipbox_back_title']); ?></h2>
		   <p><?php echo esc_html($settings['_ua_flipbox_content']); ?></p>
		</div>
	</div>
<?php }
}