<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.3.7
 * @access public
 */
final class Agama_Customizer_Upsell {

    /**
     * Returns the instance.
     *
     * @since  1.3.7
     * @access public
     * @return object
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self;
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Constructor method.
     *
     * @since  1.3.7
     * @access private
     * @return void
     */
    private function __construct() {}

    /**
     * Sets up initial actions.
     *
     * @since  1.3.7
     * @access private
     * @return void
     */
    private function setup_actions() {

        // Register panels, sections, settings, controls, and partials.
        add_action( 'customize_register', [ $this, 'sections' ] );
        
        // Register upsell fields.
        $this->fields();

        // Register scripts and styles for the controls.
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_control_scripts' ], 0 );
    }

    /**
     * Sets up the customizer sections.
     *
     * @since  1.3.7
     * @access public
     * @param  object $manager Customizer manager.
     * @return void
     */
    public function sections( $manager ) {

        // Load custom sections.
        get_template_part( 'framework/admin/customizer/agama-upsell/class-agama-customize-theme-info-main' );
        get_template_part( 'framework/admin/customizer/agama-upsell/class-agama-customize-upsell-section' );

        // Register custom section types.
        $manager->register_section_type( 'Agama_Customizer_Theme_Info_Main' );

        // Main Documentation Link In Customizer Root.
        $manager->add_section(
            new Agama_Customizer_Theme_Info_Main(
                $manager, 
                'agama-theme-info', 
                array(
                    'theme_info_title' => esc_html__( 'Extend Agama', 'agama' ),
                    'label_url'        => esc_url( 'https://theme-vision.com/agama-pro/' ),
                    'label_text'       => esc_html__( 'Upgrade to Pro', 'agama' ),
                    'priority'         => 1
                )
            )
        );
        
        // General Section Upsell
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager,
                'agama-upsell-general-sections',
                [
                    'panel'     => 'agama_general_panel',
                    'priority'  => 500,
                    'options'   => [
                        __( 'Get More Options', 'agama' )
                    ]
                ]
            )
        );
        
        // Typography Section Upsell
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager,
                'agama-upsell-typography-sections',
                [
                    'panel'     => 'agama_typography_panel',
                    'priority'  => 500,
                    'options'   => [
                        __( 'Get More Options', 'agama' )
                    ]
                ]
            )
        );
        
        // Colors & Styling Section Upsell
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager,
                'agama-upsell-colors-sections',
                [
                    'panel'     => 'agama_colors_panel',
                    'priority'  => 500,
                    'options'   => [
                        __( 'Get More Options', 'agama' )
                    ]
                ]
            )
        );
        
        // WooCommerce Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-woocommerce-sections', 
                array(
                    'panel'       => 'woocommerce',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'General', 'agama' ),
                        esc_html__( 'Styling', 'agama' )
                    )
                )
            )
        );
        
        // Footer Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-footer-sections', 
                array(
                    'panel'       => 'agama_footer_panel',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'Widgets', 'agama' )
                    )
                )
            )
        );
    }
    
    /**
     * Sets up the customizer upsell fields.
     *
     * @since  1.5.8
     * @access public
     * @return void
     */
    public function fields() {
        
        get_template_part( 'framework/admin/customizer/agama-upsell/class-customizer-upsell-field-control' );
        /**
         * General -> Body
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_colors_body_section',
            'settings'  => 'agama_general_body_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * General -> Skins
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_general_skins_section',
            'settings'  => 'agama_general_skins_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * General -> Comments
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_comments_section',
            'settings'  => 'agama_General_comments_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * General -> Extra
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_extra_section',
            'settings'  => 'agama_general_extra_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Layout -> General
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_layout_general_section',
            'settings'  => 'agama_layout_general_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Sidebar
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_layout_sidebar_section',
            'settings'  => 'agama_layout_sidebar_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Header -> General
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_header_section',
            'settings'  => 'agama_header_general_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Header -> Logo
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_header_logo_section',
            'settings'  => 'agama_header_logo_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Header Styling
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_header_styling_section',
            'settings'  => 'agama_header_styling_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Navigation -> Mobile
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_nav_mobile_section',
            'settings'  => 'agama_navigation_mobile_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Breadcrumb
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_breadcrumb_section',
            'settings'  => 'agama_breadcrumb_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Slider -> Slides
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_slider_slides_section',
            'settings'  => 'agama_slider_slides_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Slides', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Front Page Boxes
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_frontpage_boxes_section',
            'settings'  => 'agama_frontpage_boxes_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Blog -> General
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_blog_general_section',
            'settings'  => 'agama_blog_general_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Blog -> Single Post
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_blog_single_post_section',
            'settings'  => 'agama_blog_single_post_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Blog -> Post Meta
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_blog_post_meta_section',
            'settings'  => 'agama_blog_post_meta_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Footer -> General
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_footer_general_section',
            'settings'  => 'agama_footer_general_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
        /**
         * Footer -> Styling
         */
        Kirki::add_field( 'agama_options', [
            'section'   => 'agama_footer_styling_section',
            'settings'  => 'agama_footer_styling_upsell',
            'type'      => 'agama-upsell',
            'default'   => __( 'Get More Options', 'agama' ),
            'priority'  => 999
        ] );
    }

    /**
     * Loads theme customizer CSS.
     *
     * @since  1.3.7
     * @access public
     * @return void
     */
    public function enqueue_control_scripts() {

        wp_enqueue_script( 
            'agama-upsell-js', 
            AGAMA_CUSTOMIZER_URI . 'agama-upsell/js/agama-upsell-customize-controls.js', 
            [ 'customize-controls' ], 
            Agama()->version() 
        );

        wp_enqueue_style( 
            'agama-theme-info-style', 
            AGAMA_CUSTOMIZER_URI . 'agama-upsell/css/upsell.css', 
            [], 
            Agama()->version()
        );

    }
}
Agama_Customizer_Upsell::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
