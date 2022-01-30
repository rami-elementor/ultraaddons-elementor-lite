<?php
namespace UltraAddons\Widget;
/**
 * Portfolio
 * 
 * @author Moktadir Rahman <codeastrology.dev2@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use WP_Query;

class Portfolio extends Base {
    use \UltraAddons\Traits\Button_Helper;

    /**
	 * @var \WP_Query
	 */
	private $_query = null;

    /**
     * Set Keyword for search in
     * 
     * @return type array
     */
    public function get_keywords() {
            return [ 'ultraaddons','ua', 'info', 'service', 'box' ];
    }
    
    

        /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        /**
         * Button Control Load using Trait
         * from Button Helper Trait
         */
        // $this->button_register_controls();
        $this->register_query_section_controls();

    }
    
    
    

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    public function render() {
        
		$this->query_posts();
		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->get_posts_tags();

		$this->render_loop_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->render_loop_footer();

		wp_reset_postdata();
	}

    public function get_query() {
		return $this->_query;
	}

    public function query_posts() {
        $settings = $this->get_settings_for_display();

        $args = array(
            'posts_per_page' => isset( $settings['_ua_posts_per_page'] ) ? $settings['_ua_posts_per_page'] : 3,
            'post_status'   => 'publish',
            'post_type' => isset( $settings['_ua_post_type'] ) ? $settings['_ua_post_type'] : 'post',
            'orderby'   => isset( $settings['_ua_order_by'] ) ? $settings['_ua_order_by'] : 'date',
            'order' => isset( $settings['_ua_order'] ) ? $settings['_ua_order'] : 'asc',
            'ignore_sticky_posts' => isset( $settings['_ua_ignore_sticky_posts'] ) && $settings['_ua_ignore_sticky_posts'] == 'yes' ? true : false,
            'post__not_in' => '',
            'author__in' => ''
        );
		$this->_query = new WP_Query( $args );
	}

    protected function render_post() {
		$this->render_post_header();
		$this->render_thumbnail();
		$this->render_overlay_header();
		$this->render_title();
		$this->render_overlay_footer();
		$this->render_post_footer();
	}

    protected function render_post_header() {
		global $post;

		$tags_classes = array_map( function( $tag ) {
			return 'elementor-filter-' . $tag->term_id;
		}, $post->tags );

		$classes = [
			'elementor-portfolio-item',
			'elementor-post',
			implode( ' ', $tags_classes ),
		];

		?>
		<article <?php post_class( $classes ); ?>>
			<a class="elementor-post__thumbnail__link" href="<?php echo get_permalink(); ?>">
		<?php
	}

    protected function render_thumbnail() {
		$settings = $this->get_settings();

		$settings['thumbnail_size'] = [
			'id' => get_post_thumbnail_id(),
		];

		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size' );
		?>
		<div class="elementor-portfolio-item__img elementor-post__thumbnail">
			<?php echo $thumbnail_html; ?>
		</div>
		<?php
	}

    protected function render_overlay_header() {
		?>
		<div class="elementor-portfolio-item__overlay">
		<?php
	}

	protected function render_overlay_footer() {
		?>
		</div>
		<?php
	}

    protected function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = Utils::validate_html_tag( $this->get_settings( 'title_tag' ) );
		?>
		<<?php echo $tag; ?> class="elementor-portfolio-item__title">
		<?php the_title(); ?>
		</<?php echo $tag; ?>>
		<?php
	}

    protected function render_post_footer() {
		?>
		</a>
		</article>
		<?php
	}

    protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail_size',
				'exclude' => [ 'custom' ],
				'default' => 'medium',
				'prefix_class' => 'elementor-portfolio--thumbnail-size-',
			]
		);

		// $this->add_control(
		// 	'masonry',
		// 	[
		// 		'label' => __( 'Masonry', 'ultraaddons' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_off' => __( 'Off', 'ultraaddons' ),
		// 		'label_on' => __( 'On', 'ultraaddons' ),
		// 		'condition' => [
		// 			'columns!' => '1',
		// 		],
		// 		'render_type' => 'ui',
		// 		'frontend_available' => true,
		// 	]
		// );

		$this->add_control(
			'item_ratio',
			[
				'label' => __( 'Item Ratio', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.66,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__thumbnail__link' => 'padding-bottom: calc( {{SIZE}} * 100% )',
					'{{WRAPPER}}:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => __( 'Off', 'ultraaddons' ),
				'label_on' => __( 'On', 'ultraaddons' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            '_ua_post_type',
            [
                'label' => __( 'Source', 'ultraaddons' ),
                'type' => Controls_Manager::SELECT,
                'options' => ultraaddons_get_post_types( [],[ 'elementor_library', 'attachment' ] ),
                'default' => 'post',
            ]
        );

        $this->add_control(
            '_ua_posts_per_page', [
                'label'       => esc_html__('Posts Per Page', 'ultraaddons'),
                'type'        => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Enter Number', 'ultraaddons'),
                'default'     => '3',
            ]
        );

        $this->add_control(
            '_ua_order_by',
            [
                'label'   => __('Order By', 'ultraaddons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'modified'   => __('Modified', 'ultraaddons'),
                    'date'       => __('Date', 'ultraaddons'),
                    'rand'       => __('Rand', 'ultraaddons'),
                    'ID'         => __('ID', 'ultraaddons'),
                    'title'      => __('Title', 'ultraaddons'),
                    'author'     => __('Author', 'ultraaddons'),
                    'name'       => __('Name', 'ultraaddons'),
                    'parent'     => __('Parent', 'ultraaddons'),
                    'menu_order' => __('Menu Order', 'ultraaddons'),
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            '_ua_order',
            [
                'label'   => __('Order', 'ultraaddons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => [
                    'asc'  => __('Ascending Order', 'ultraaddons'),
                    'desc' => __('Descending Order', 'ultraaddons'),
                ],
            ]
        );
        $this->add_control(
            '_ua_ignore_sticky_posts', 
            [
                'label' => __( 'Ignore Sticky Posts', 'ultraaddons' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    '_ua_post_type!' => ['page', 'by_id', 'category'],
                ],
                'description' => __( 'Sticky-posts ordering is visible on frontend only', 'ultraaddons' ),
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_bar',
			[
				'label' => __( 'Filter Bar', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => __( 'Show', 'ultraaddons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ultraaddons' ),
				'label_on' => __( 'On', 'ultraaddons' ),
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label' => __( 'Taxonomy', 'ultraaddons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'options' => $this->get_taxonomies(),
				'condition' => [
					'show_filter_bar' => 'yes',
					'posts_post_type!' => 'by_id',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Items', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		/*
		 * The `item_gap` control is replaced by `column_gap` and `row_gap` controls since v 2.1.6
		 * It is left (hidden) in the widget, to provide compatibility with older installs
		 */

		$this->add_control(
			'item_gap',
			[
				'label' => __( 'Item Gap', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true,
				'classes' => 'elementor-hidden',
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => ' --grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'ultraaddons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-portfolio-item__img, {{WRAPPER}} .elementor-portfolio-item__overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_overlay',
			[
				'label' => __( 'Item Overlay', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_background',
			[
				'label' => __( 'Background Color', 'ultraaddons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} a .elementor-portfolio-item__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_title',
			[
				'label' => __( 'Color', 'ultraaddons' ),
				'separator' => 'before',
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a .elementor-portfolio-item__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-portfolio-item__title',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_filter',
			[
				'label' => __( 'Filter Bar', 'ultraaddons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label' => __( 'Color', 'ultraaddons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-portfolio__filter' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label' => __( 'Active Color', 'ultraaddons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-portfolio__filter.elementor-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_filter',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-portfolio__filter',
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label' => __( 'Space Between', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-portfolio__filter:not(:last-child)' => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-portfolio__filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label' => __( 'Spacing', 'ultraaddons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-portfolio__filters' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

    protected function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

    protected function get_posts_tags() {
		$taxonomy = $this->get_settings( 'taxonomy' );

		foreach ( $this->_query->posts as $post ) {
			if ( ! $taxonomy ) {
				$post->tags = [];

				continue;
			}

			$tags = wp_get_post_terms( $post->ID, $taxonomy );

			$tags_slugs = [];

			foreach ( $tags as $tag ) {
				$tags_slugs[ $tag->term_id ] = $tag;
			}

			$post->tags = $tags_slugs;
		}
	}

    protected function render_filter_menu() {
		$taxonomy = $this->get_settings( 'taxonomy' );

		if ( ! $taxonomy ) {
			return;
		}

		$terms = [];

		foreach ( $this->_query->posts as $post ) {
			$terms += $post->tags;
		}

		if ( empty( $terms ) ) {
			return;
		}

		usort( $terms, function( $a, $b ) {
			return strcmp( $a->name, $b->name );
		} );

		?>
		<ul class="elementor-portfolio__filters">
			<li class="elementor-portfolio__filter elementor-active" data-filter="__all"><?php echo __( 'All', 'elementor-pro' ); ?></li>
			<?php foreach ( $terms as $term ) { ?>
				<li class="elementor-portfolio__filter" data-filter="<?php echo esc_attr( $term->term_id ); ?>"><?php echo $term->name; ?></li>
			<?php } ?>
		</ul>
		<?php
	}

    protected function render_loop_header() {
		if ( $this->get_settings( 'show_filter_bar' ) ) {
			$this->render_filter_menu();
		}
		?>
		<div class="elementor-portfolio elementor-grid elementor-posts-container">
		<?php
	}

    protected function render_loop_footer() {
		?>
		</div>
		<?php
	}

}
