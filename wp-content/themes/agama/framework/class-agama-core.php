<?php
/**
 * Core
 *
 * The Agama core class.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.1
 * @since 1.5.0 Updated the code.
 */

namespace Agama;

use Agama\Inline_Style;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit; 
}

class Core {
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.5.0
     * @access public
     * @return null|object
     */
    public static $instance = null;
    
    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.5.0
     * @access public
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Class Constructor
     */
    function __construct() {

        $this->migrate_options();

        add_action( 'wp_enqueue_scripts', [ $this, 'scripts_styles' ] );
        add_action( 'customize_preview_init', [ $this, 'customizer_live_preview' ] );
        add_action( 'customize_controls_print_scripts', [ $this, 'customize_controls_scripts' ] );
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_enqueue_scripts' ] );
        add_action( 'after_setup_theme', [ $this, 'agama_setup' ] );
        add_action( 'wp_footer', [ $this, 'footer_scripts' ] );
        
    }

    /**
     * Enqueue scripts and styles for front-end.
     *
     * @since Agama 1.0
     */
    function scripts_styles() {
        global $wp_styles;

        /*
         * Adds JavaScript to pages with the comment form to support
         * sites with threaded comments (when in use).
         */
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        /**
         * FontAwesome Icons
         */
        wp_enqueue_style( 'agama-font-awesome', AGAMA_CSS . 'font-awesome.min.css', [], '4.7.0' );

        // Bootstrap 4.1.3
        wp_enqueue_style( 'agama-bootstrap', AGAMA_CSS . 'bootstrap.min.css', [], '4.1.3' );

        /**
         * Child Theme Stylesheet
         */ 
        $deps = [];
        if( is_child_theme() ) {

            $deps = [ 'agama-parent-style' ];

            // Load Agama stylesheet if child theme active
            wp_enqueue_style( 
                'agama-parent-style', 
                trailingslashit( get_template_directory_uri() ) . 'style.css', 
                false, 
                Agama()->version() 
            );
        } 

        /**
         * Agama || Child Theme Stylesheet
         */
        wp_enqueue_style( 'agama-style', get_stylesheet_uri(), $deps, Agama()->version() );
        wp_add_inline_style( 'agama-style', Inline_Style::init() );

        /**
         * Dark Skin Stylesheet
         */
        if( get_theme_mod('agama_skin', 'light') == 'dark' ) {
            wp_register_style( 'agama-dark', AGAMA_CSS .'skins/dark.css', [], Agama()->version() );
            wp_enqueue_style( 'agama-dark' );
        }

        /**
         * Agama slider script and stylesheet.
         */
        if( ! empty( get_theme_mod( 'agama_slider_slides_repeater', [] ) ) ) {
            wp_enqueue_style( 'agama-slider', AGAMA_CSS . 'camera.min.css', [], Agama()->version() );
            wp_enqueue_script( 'agama-slider', AGAMA_JS . 'min/camera.min.js', [], Agama()->version(), true );
        }

        /**
         * Animate Stylesheet
         */
        wp_enqueue_style( 'agama-animate', AGAMA_CSS . 'animate.min.css', [], '3.5.1' );

        /**
         * Particles JS
         */
        if( get_theme_mod( 'agama_slider_particles', true ) || get_theme_mod( 'agama_header_image_particles', true ) ) {
            wp_enqueue_script( 'agama-particles', AGAMA_JS . 'min/particles.min.js', [], Agama()->version() );
        }

        /**
         * jQuery Plugins
         */
        wp_enqueue_script( 'agama-plugins', AGAMA_JS . 'plugins.js', [ 'jquery' ], Agama()->version() );

        /**
         * jQuery Functions
         */
        wp_register_script( 'agama-functions', AGAMA_JS . 'functions.js', [], Agama()->version(), true );
        $translation_array = [
            'is_admin_bar_showing'			=> esc_attr( is_admin_bar_showing() ),
            'is_home'						=> is_home(),
            'is_front_page'					=> is_front_page(),
            'headerStyle'					=> esc_attr( get_theme_mod( 'agama_header_style', 'transparent' ) ),
            'headerImage'					=> esc_attr( get_header_image() ),
            'top_navigation'				=> esc_attr( get_theme_mod( 'agama_top_navigation', true ) ),
            'background_image'				=> esc_attr( get_header_image() ),
            'primaryColor' 					=> esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ),
            'header_top_margin'				=> esc_attr( get_theme_mod( 'agama_header_top_margin', '0' ) ),
            'slider_particles'				=> esc_attr( get_theme_mod( 'agama_slider_particles', true ) ),
            'slider_enable'					=> esc_attr( get_theme_mod( 'agama_slider_enable', true ) ),
            'slider_height'					=> esc_attr( get_theme_mod( 'agama_slider_height', '0' ) ),
            'slider_time'					=> esc_attr( get_theme_mod( 'agama_slider_time', '7000' ) ),
            'slider_particles_colors'       => array_map( 'esc_attr', get_theme_mod( 'agama_slider_particles_colors', [ 'circles' => '#ac32e4', 'lines' => '#ac32e4' ] ) ),
            'header_image_particles'		=> esc_attr( get_theme_mod( 'agama_header_image_particles', true ) ),
            'header_image_particles_colors'	=> array_map( 'esc_attr', get_theme_mod( 'agama_header_image_particles_colors', [ 'lines' => '#ac32e4', 'circles' => '#fff' ] ) ),
            'blog_layout'                   => esc_attr( get_theme_mod( 'agama_blog_style', 'list' ) ),
            'infinite_scroll'               => esc_attr( get_theme_mod( 'agama_blog_infinite_scroll', false ) ),
            'infinite_trigger'              => esc_attr( get_theme_mod( 'agama_blog_infinite_trigger', 'button' ) )
        ];
        wp_localize_script( 'agama-functions', 'agama', $translation_array );
        wp_enqueue_script( 'agama-functions' );
    }
    
    /** 
     * Customizer Live Preview
     *
     * This outputs the javascript needed to automate the live settings preview.
     * Also keep in mind that this function isn't necessary unless your settings 
     * are using 'transport'=>'postMessage' instead of the default 'transport' => 'refresh'
     * 
     * Used by hook: 'customize_preview_init'
     *
     * @since 1.6.0
     * @return void
     */
    function customizer_live_preview() {
        wp_enqueue_script( 
            'agama-customize-preview', 
            AGAMA_JS . 'customize-preview.js', 
            [ 'jquery', 'customize-preview' ], 
            Agama()->version() 
        );
    }
    
    /**
     * Customize Scripts
     *
     * Hook is triggered within the <head></head> section of the theme customizer.
     *
     * @since 1.5.8
     */
    function customize_controls_scripts() {
        
        /**
         * Enqueue FontAwesome into Customizer <head></head>
         */
        wp_enqueue_style( 'agama-fontawesome', AGAMA_CSS . 'font-awesome.min.css', [], Agama()->version() );
        
    }
    
     /**
     * Customize Enqueue Scripts
     *
     * Enqueue the customizer control scripts.
     *
     * @since 1.6.0
     */
    function customize_enqueue_scripts() {
        wp_enqueue_script( 
            'custom-customize', 
            AGAMA_JS . 'customize-controls.js', 
            [ 'jquery', 'customize-controls' ], 
            Agama()->version(), 
            true 
        );
    }

    /**
     * Agama Setup
     *
     * @since 1.0
     */
    function agama_setup() {
        /*
         * Makes Agama available for translation.
         */
        load_theme_textdomain( 'agama', AGAMA_DIR . 'languages' );

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Adds support for title tag
        add_theme_support( 'title-tag' );

        // Adds RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Customize Selective Refresh Widgets
        add_theme_support( 'customize-selective-refresh-widgets' );

        // This theme supports a variety of post formats.
        add_theme_support( 'post-formats', [ 'aside', 'image', 'link', 'quote', 'status' ] );

        register_nav_menu( 'top', esc_html__( 'Top Menu', 'agama' ) );
        register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'agama' ) );
        register_nav_menu( 'mobile', esc_html__( 'Mobile Menu', 'agama' ) );

        $custom_header_args = [
            'default-image'          => '%2$s/assets/img/header-image.jpg',
            'default-text-color'     => '515151',
            'height'                 => 960,
            'width'                  => 1920,
            'max-width'              => 2000,
            'flex-height'            => true,
            'flex-width'             => true,
            'random-default'         => false,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => ''
        ];

        add_theme_support( 'custom-header', $custom_header_args );
        
        /**
         * Register a selection of default headers to be displayed by the custom header admin UI.
         *
         * @link https://developer.wordpress.org/reference/functions/register_default_headers/
         */
        register_default_headers( [
            'city' => [
                'url'           => '%2$s/assets/img/header-image.jpg',
                'thumbnail_url' => '%2$s/assets/img/header-image.jpg',
                'description'   => esc_html__( 'Header Image', 'agama' )
            ]
        ] );

        /*
         * This theme supports custom background color and image,
         * and here we also set up the default background color.
         */
        add_theme_support( 'custom-background', [
            'default-color' => 'e6e6e6',
        ] );

        // This theme uses a custom image size for featured images, displayed on "standard" posts.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 800, 9999 ); // Unlimited height, soft crop

        // Register custom image sizes
        add_image_size( 'agama-blog-large', 776, 310, true );
        add_image_size( 'agama-blog-medium', 320, 202, true );
        add_image_size( 'agama-blog-small', 400, 300, true );
        add_image_size( 'agama-related-img', 180, 138, true );
        add_image_size( 'agama-recent-posts', 700, 441, true );

        /*
         * Declare WooCommerce Support
         */
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    /**
     * Enqueue Footer Scripts
     *
     * @since Agama v1.0.3
     */
    function footer_scripts() {
        get_template_part( 'template-parts/search', 'overlay' );
        if( get_theme_mod( 'agama_nicescroll', false ) ) {
            echo '
            <script>
            jQuery(document).ready(function($) {
                $("body").niceScroll({
                    cursorwidth:"10px",
                    cursorborder:"1px solid #333",
                    zindex:"9999"
                });
            });
            </script>
            ';
        }
    }

    /**
     * Migrate Theme Options
     *
     * @since 1.3.0
     */
    function migrate_options() {
        $theme   = wp_get_theme();
        $version = $theme->get( 'Version' );
        // If current theme version is bigger than "1.2.9.1" apply next updates.
        if( version_compare( '1.2.9.1', $version, '<' ) ) {
            if( ! get_option( '_agama_1291_migrated' ) ) {
                $nav_color 			= esc_attr( get_theme_mod( 'agama_header_nav_color', '#ac32e4' ) );
                $nav_hover_color	= esc_attr( get_theme_mod( 'agama_header_nav_hover_color', '#000' ) );
                set_theme_mod( 'agama_nav_top_color', $nav_color );
                set_theme_mod( 'agama_nav_top_hover_color', $nav_hover_color );
                set_theme_mod( 'agama_nav_primary_color', $nav_color );
                set_theme_mod( 'agama_nav_primary_hover_color', $nav_hover_color );
                update_option( '_agama_1291_migrated', true );
            }
        }
        // If current theme version is bigger than "1.3.0" apply next updates.
        // Migrate Custom CSS code to WP Additional CSS.
        if( version_compare( '1.3.0', $version, '<' ) ) {
            if( ! get_option( '_agama_130_migrated' ) ) {
                $custom_css = esc_attr( get_theme_mod( 'agama_custom_css', '' ) );
                if( ! empty( $custom_css ) ) {
                    wp_update_custom_css_post( $custom_css );
                    update_option( '_agama_130_migrated', true );
                }
            }
        }
        // If current theme version is bigger than "1.5.6" apply next updates.
        // Update the path of page attribute templates folder from "page-templates" to "templates".
        if ( version_compare( '1.5.6', $version, '<' ) ) {
            if ( ! get_option( '_agama_156_migrated' ) ) {
                $pages = get_pages();
                if ( $pages ) {
                    foreach ( $pages as $page ) {
                        $template = get_post_meta( $page->ID, '_wp_page_template', true );
                        switch ( $template ) {
                            case 'page-templates/template-fluid.php' :
                            case 'page-templates/template-full-width.php' :
                            case 'page-templates/template-empty.php' :
                                $new_location = str_replace( 'page-templates', 'templates', $template );
                                update_post_meta( $page->ID, '_wp_page_template', $new_location );
                                break;
                        }
                    }
                    update_option( '_agama_156_migrated', true );
                }
            }
        }
        // If current theme version is bigger than "1.5.9" apply next updates.
        // Migrate various colors fields to the new ones.
        if ( version_compare( '1.5.9', $version, '<' ) ) {
            if ( ! get_option( '_agama_159_migrated' ) ) {
                
                // Site Title
                $site_title_color = esc_attr( get_theme_mod( 'agama_header_logo_color', '#bdbdbd' ) );
                $site_title_hover_color = esc_attr( get_theme_mod( 'agama_header_logo_hover_color', '#333' ) );
                set_theme_mod( 'agama_site_title_colors', [ 'normal' => $site_title_color, 'hover' => $site_title_hover_color ] );
                
                // Body
                $body_bg_color = esc_attr( get_theme_mod( 'agama_body_background_color', '#e6e6e6' ) );
                set_theme_mod( 'agama_body_background_colors', [ 'left' => $body_bg_color, 'right' => $body_bg_color ] );
                
                // Header Image Particles
                $header_image_particles_c_color = esc_attr( get_theme_mod( 'agama_header_image_particles_circle_color', '#fff' ) );
                $header_image_particles_l_color = esc_attr( get_theme_mod( 'agama_header_image_particles_lines_color', '#ac32e4' ) );
                set_theme_mod( 'agama_header_image_particles_colors', [ 'lines' => $header_image_particles_l_color, 'circles' => $header_image_particles_c_color ] );
                
                // Navigation Top Links
                $nav_top_normal = get_theme_mod( 'agama_navigation_top_font' );
                if ( ! empty( $nav_top_normal['color'] ) ) {
                     $nav_top['normal'] = esc_attr( $nav_top_normal['color'] );
                } else {
                    $nav_top['normal'] = '#757575';
                }
                $nav_top['hover'] = esc_attr( get_theme_mod( 'agama_nav_top_hover_color', '#333333' ) );
                set_theme_mod( 'agama_navigation_top_links_color', 
                    [ 
                        'normal'  => $nav_top['normal'],
                        'visited' => $nav_top['normal'],
                        'hover'   => $nav_top['hover'],
                        'active'  => $nav_top['hover']
                    ] 
                );
                
                // Navigation Primary Links
                $nav_primary_normal = get_theme_mod( 'agama_navigation_primary_font' );
                if ( ! empty( $nav_primary_normal['color'] ) ) {
                     $nav_primary['normal'] = esc_attr( $nav_primary_normal['color'] );
                } else {
                    $nav_primary['normal'] = '#757575';
                }
                $nav_primary['hover'] = esc_attr( get_theme_mod( 'agama_nav_primary_hover_color', '#333333' ) );
                set_theme_mod( 'agama_navigation_primary_links_color', 
                    [ 
                        'normal'  => $nav_primary['normal'],
                        'visited' => $nav_primary['normal'],
                        'hover'   => $nav_primary['hover'],
                        'active'  => $nav_primary['hover']
                    ] 
                );
                
                // Navigation Mobile Links
                $nav_mobile_normal = get_theme_mod( 'agama_mobile_navigation_font' );
                if ( ! empty( $nav_mobile_normal['color'] ) ) {
                     $nav_mobile['normal'] = esc_attr( $nav_mobile_normal['color'] );
                } else {
                    $nav_mobile['normal'] = '#757575';
                }
                $nav_mobile['hover'] = esc_attr( get_theme_mod( 'agama_nav_mobile_hover_color', '#333333' ) );
                set_theme_mod( 'agama_navigation_mobile_links_color', 
                    [ 
                        'normal'  => $nav_mobile['normal'],
                        'visited' => $nav_mobile['normal'],
                        'hover'   => $nav_mobile['hover'],
                        'active'  => $nav_mobile['hover']
                    ] 
                );
                
                // Footer Widget Area Background
                $footer_widget_area_bg = esc_attr( get_theme_mod( 'agama_footer_widget_bg_color', '#314150' ) );
                set_theme_mod( 'agama_footer_widgets_background_colors', [ 'left' => $footer_widget_area_bg, 'right' => $footer_widget_area_bg ] );
                
                // Footer Area Background
                $footer_area_bg = esc_attr( get_theme_mod( 'agama_footer_bottom_bg_color', '#293744' ) );
                set_theme_mod( 'agama_footer_background_colors', [ 'left' => $footer_area_bg, 'right' => $footer_area_bg ] );
                
                update_option( '_agama_159_migrated', true );
            }
        }
        
        // If current theme version is bigger than "1.6.0" apply next updates.
        // Assing the primary menu location also to new mobile location.
        if ( version_compare( '1.6.0', $version, '<' ) ) {
            if ( ! get_option( '_agama_160_migrated' ) ) {
                
                $locations = get_theme_mod( 'nav_menu_locations', [] );
                if ( ! empty( $locations['primary'] ) ) {
                    $locations['mobile'] = esc_attr( $locations['primary'] );
                    set_theme_mod( 'nav_menu_locations', $locations );
                }
                
                update_option( '_agama_160_migrated', true );
            }
        }
        
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
