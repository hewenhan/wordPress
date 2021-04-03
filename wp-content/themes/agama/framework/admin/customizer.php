<?php
/**
 * Customizer Options
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include necessary files.
get_template_part( 'framework/admin/class-partial-refresh' );

// If Agama PRO plugin not active include the upsell class.
if ( ! class_exists( 'Agama\PRO\Plugin' ) ) {
    get_template_part( 'framework/admin/customizer/agama-upsell/class-customize' );
}

// Disable Kirki Telemetry Module
add_filter( 'kirki_telemetry', '__return_false' );

/**
 * Update Kirki Path's
 *
 * @since 1.2.0
 */
if ( ! function_exists( 'agama_theme_kirki_update_url' ) ) {
    function agama_theme_kirki_update_url( $config ) {
        $config['url_path'] = AGAMA_URI . 'framework/admin/kirki/';
        return $config;
    }
}
add_filter( 'kirki/config', 'agama_theme_kirki_update_url' );

/**
 * Customize Register
 *
 * Access to $wp_customize object.
 *
 * @since 1.4.4
 * @return null
 */
function agama_customize_register( $wp_customize ) {
    
    $wp_customize->get_section( 'title_tagline' )->priority         = 2;
    $wp_customize->get_setting( 'blogname' )->transport             = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport       = 'postMessage';
    $wp_customize->get_control( 'background_image' )->section       = 'agama_colors_body_section';
    $wp_customize->get_control( 'background_preset' )->section      = 'agama_colors_body_section';
    $wp_customize->get_control( 'background_position' )->section    = 'agama_colors_body_section';
    $wp_customize->get_control( 'background_size' )->section        = 'agama_colors_body_section';
    $wp_customize->get_control( 'background_repeat' )->section      = 'agama_colors_body_section';
    $wp_customize->get_control( 'background_attachment' )->section  = 'agama_colors_body_section';
    $wp_customize->get_setting( 'header_image' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'header_image_data'  )->transport   = 'postMessage';
    $wp_customize->selective_refresh->add_partial(
        'header_image',
        [
            'selector'        => '.agama-header-image-overlay',
            'render_callback' => [ 'Agama_Partial_Refresh', 'header_image' ]
        ]
    );
}
add_action( 'customize_register', 'agama_customize_register' );

##############################################
# SETUP THEME CONFIG
##############################################
    Kirki::add_config( 'agama_options', array(
        'option_type' => 'theme_mod',
        'capability'  => 'edit_theme_options'
    ) );
#######################################################
# GENERAL PANEL
#######################################################
	Kirki::add_panel( 'agama_general_panel', array(
		'title'			=> esc_attr__( 'General', 'agama' ),
		'priority'		=> 10
	) );
    #######################################################
    # SEARCH PAGE SECTION
    #######################################################
    Kirki::add_section( 'agama_search_page_section', array(
        'title'         => __( 'Search Page', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Thumbnails', 'agama' ),
		'tooltip'	    => __( 'Enable posts featured thumbnails on search page.', 'agama' ),
		'section'		=> 'agama_search_page_section',
		'settings'		=> 'agama_search_page_thumbnails',
		'type'			=> 'switch',
		'default'		=> false
	) );
    ###############################################
    # STATIC FRONT PAGE SECTION
    ###############################################
    Kirki::add_section( 'static_front_page', array(
		'title'			=> __( 'Static Front Page', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_general_panel',
	) );
    ####################################################
    # COMMENTS SECTION
    ####################################################
    Kirki::add_section( 'agama_comments_section', array(
        'title'         => __( 'Comments', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'HTML Tags Suggestion', 'agama' ),
		'tooltip'	    => __( 'Enable tags usage suggestion below comment form ?', 'agama' ),
		'settings'		=> 'agama_comments_tags_suggestion',
		'section'		=> 'agama_comments_section',
		'type'			=> 'switch',
		'default'		=> true
	) );
    #################################################
    # EXTRA SECTION
    #################################################
    Kirki::add_section( 'agama_extra_section', array(
        'title'         => __( 'Extra', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Nicescroll', 'agama' ),
		'tooltip'	    => __( 'Enable browser nicescroll.', 'agama' ),
		'section'		=> 'agama_extra_section',
		'settings'		=> 'agama_nicescroll',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Back to Top', 'agama' ),
		'tooltip'	    => __( 'Enable back to top button.', 'agama' ),
		'section'		=> 'agama_extra_section',
		'settings'		=> 'agama_to_top',
		'type'			=> 'switch',
		'default'		=> true
	) );
    ########################################
    # GENERAL ADDITIONAL CSS SECTION
    ########################################
    Kirki::add_section( 'custom_css', array(
		'title'			=> __( 'Additional CSS', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_general_panel'
	) );
######################################################
# TYPOGRAPHY PANEL
######################################################
    Kirki::add_panel( 'agama_typography_panel', [
        'title'     => __( 'Typography', 'agama' ),
        'priority'  => 20
    ] );
    ##########################################################
    # TYPOGRAPHY SITE TITLE SECTION
    ##########################################################
    Kirki::add_section( 'agama_typography_site_title_section', [
		'title'			=> esc_attr__( 'Site Title', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_typography_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Site Title', 'agama' ),
		'tooltip'	        => esc_attr__( 'Customize site title font.', 'agama' ),
		'section'		    => 'agama_typography_site_title_section',
		'settings'		    => 'agama_logo_font',
		'type'			    => 'typography',
        'transport'         => 'auto',
		'default'			=> [
			'font-family' 	=> 'Montserrat',
            'variant'       => '900',
			'font-size'		=> '35px'
		],
        'output'			=> [
			[
				'element' 	=> '#masthead:not(.shrinked) .site-title a'
			]
		]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Site Title Shrinked', 'agama' ),
		'tooltip'	        => esc_attr__( 'Customize header shrinked site title font size.', 'agama' ),
		'section'		    => 'agama_typography_site_title_section',
		'settings'		    => 'agama_logo_shrink_font',
		'type'			    => 'typography',
        'transport'         => 'auto',
        'default'		    => [
            'font-family'   => 'Montserrat',
            'variant'       => '900',
			'font-size'	    => '28px'
		],
		'output'		    => [
			[
				'element'   => '#masthead.shrinked .site-title a'
			]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'default'
            ]
        ]
	] );
    ##########################################################
    # TYPOGRAPHY BODY SECTION
    ##########################################################
    Kirki::add_section( 'agama_typography_body_section', [
		'title'			=> esc_attr__( 'Body', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_typography_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'     => esc_attr__( 'Body Font', 'agama' ),
        'tooltip'   => esc_attr__( 'Customize body font.', 'agama' ),
        'section'   => 'agama_typography_body_section',
        'settings'  => 'agama_body_font',
        'type'      => 'typography',
        'transport' => 'auto',
        'default'   => [
            'font-family'       => 'Raleway',
            'variant'           => '400',
            'font-size'         => '14px',
            'line-height'       => '1',
            'letter-spacing'    => '0',
            'subsets'           => [],
            'color'             => '#747474',
            'text-transform'    => 'none',
            'text-align'        => 'left'
        ],
        'output' => [
            [
                'element' => 'body'
            ]
        ]
    ] );
    ##########################################################
    # TYPOGRAPHY NAVIGATION TOP SECTION
    ##########################################################
    Kirki::add_section( 'agama_typography_navigation_top_section', [
		'title'			=> esc_attr__( 'Navigation Top', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_typography_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_attr__( 'Font', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize top navigation font.', 'agama' ),
        'section'           => 'agama_typography_navigation_top_section',
        'settings'          => 'agama_navigation_top_font',
        'type'              => 'typography',
        'transport'         => 'auto',
        'output'            => [
            [
                'element'   => '#agama-top-nav a'    
            ]
        ],
        'default' => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'text-transform'    => 'uppercase'
        ],
        'active_callback' => [
            [
                'setting'  => 'agama_header_style',
                'operator' => '!==',
                'value'    => 'transparent'
            ]
        ]
    ] );
    ##########################################################
    # TYPOGRAPHY NAVIGATION PRIMARY SECTION
    ##########################################################
    Kirki::add_section( 'agama_typography_navigation_primary_section', [
		'title'			=> esc_attr__( 'Navigation Primary', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_typography_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'                 => esc_attr__( 'Font', 'agama' ),
        'tooltip'               => esc_attr__( 'Customize primary navigation font.', 'agama' ),
        'section'               => 'agama_typography_navigation_primary_section',
        'settings'              => 'agama_navigation_primary_font',
        'type'                  => 'typography',
        'transport'             => 'auto',
        'output'                => [
            [
                'element'       => '#agama-primary-nav a'    
            ]
        ],
        'default'               => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'text-transform'    => 'uppercase'
        ]
    ] );
     ##########################################################
    # TYPOGRAPHY NAVIGATION MOBILE SECTION
    ##########################################################
    Kirki::add_section( 'agama_typography_navigation_mobile_section', [
		'title'			=> esc_attr__( 'Navigation Mobile', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_typography_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_attr__( 'Font', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize mobile navigation font.', 'agama' ),
        'section'           => 'agama_typography_navigation_mobile_section',
        'settings'          => 'agama_mobile_navigation_font',
        'type'              => 'typography',
        'transport'         => 'auto',
        'output'            => [
            [
                'element'   => '#agama-mobile-nav a'    
            ],
            [
                'element'   => '#agama-mobile-nav ul > li.menu-item-has-children.open > a'
            ],
            [
                'element'   => '#agama-mobile-nav ul > li > ul li.menu-item-has-children > a'
            ]
        ],
        'default'               => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'text-transform'    => 'uppercase'
        ]
    ] );
######################################################
# COLORS & STYLING PANEL
######################################################
    Kirki::add_panel( 'agama_colors_panel', [
        'title'     => __( 'Colors & Styling', 'agama' ),
        'priority'  => 20
    ] );
    ######################################################
    # COLORS GENERAL SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_general_section', [
		'title'			=> esc_attr__( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> __( 'Skin', 'agama' ),
		'tooltip'	    => __( 'Select theme skin.', 'agama' ),
		'section'		=> 'agama_colors_general_section',
		'settings'		=> 'agama_skin',
		'type'			=> 'select',
		'choices'		=> [
			'light'		=> __( 'Light', 'agama' ),
			'dark'		=> __( 'Dark', 'agama' )
		],
		'default'		=> 'light'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Primary Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Set theme primary color.', 'agama' ),
		'section'		=> 'agama_colors_general_section',
		'settings'		=> 'agama_primary_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'output'		=> [
			[
				'element'	=> 'a:hover, .mobile-menu-toggle-label, .vision-search-submit:hover, .entry-title a:hover, .entry-meta a:not(.button):hover, .entry-content a:hover, .comment-content a:hover, .single-line-meta a:hover, a.comment-reply-link:hover, a.comment-edit-link:hover, article header a:hover, .comments-title span, .comment-reply-title span, .widget a:hover, .comments-link a:hover, .entry-header header a:hover, .tagcloud a:hover, footer[role="contentinfo"] a:hover',
				'property'	=> 'color'
			],
			[
				'element'	=> '.mobile-menu-toggle-inner, .mobile-menu-toggle-inner::before, .mobile-menu-toggle-inner::after, .woocommerce span.onsale, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .loader-ellips__dot',
				'property'	=> 'background-color'
			],
            [
                'element'   => '#masthead:not(.header_v1), ul.agama-navigation ul:not(.mega-menu-column)',
                'property'  => 'border-top-color'
            ],
			[
				'element'	=> '#masthead.header_v2, .tagcloud a:hover, .wpcf7-text:focus, .wpcf7-email:focus, .wpcf7-textarea:focus',
				'property'	=> 'border-color'
			],
		],
		'transport'		=> 'auto',
		'default'		=> '#ac32e4'
	] );
    ######################################################
    # COLORS SITE TITLE SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_site_title_section', [
		'title'			=> esc_attr__( 'Site Title', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_html__( 'Site Title', 'agama' ),
        'tooltip'       => esc_html__( 'Customize site title colors.', 'agama' ),
        'section'       => 'agama_colors_site_title_section',
        'settings'      => 'agama_site_title_colors',
        'type'          => 'multicolor',
        'transport'     => 'auto',
        'choices'       => [
            'normal'    => esc_html__( 'Normal', 'agama' ),
            'hover'     => esc_html__( 'Hover', 'agama' )
        ],
        'default'       => [
            'normal'    => '#bdbdbd',
            'hover'     => '#333333'
        ],
        'output'        => [
            [
                'choice'    => 'normal',
                'element'   => '#masthead h1 a',
                'property'  => 'color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '#masthead h1 a:hover',
                'property'  => 'color'
            ]
        ]
    ] );
    ######################################################
    # COLORS BODY SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_body_section', [
		'title'			=> esc_attr__( 'Body', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'     => esc_attr__( 'Background Colors', 'agama' ),
        'tooltip'   => esc_attr__( 'Select body background color.', 'agama' ),
        'section'   => 'agama_colors_body_section',
        'settings'  => 'agama_body_background_colors',
        'type'      => 'multicolor',
        'transport' => 'postMessage',
        'choices'   => [
            'left'  => esc_html__( 'Left', 'agama' ),
            'right' => esc_html__( 'Right', 'agama' )
        ],
        'default'   => [
            'left'  => '#e6e6e6',
            'right' => '#e6e6e6'
        ],
        'priority' => 1
    ] );
    ######################################################
    # COLORS HEADER SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_header_section', [
		'title'			=> esc_attr__( 'Header', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Background Color', 'agama' ),
		'tooltip'		    => esc_attr__( 'Doesn\'t work with header V1 style.', 'agama' ),
		'section'		    => 'agama_colors_header_section',
		'settings'		    => 'agama_header_bg_color',
		'type'			    => 'color',
        'transport'         => 'auto',
        'choices'           => [
            'alpha'		    => true
        ],
        'default'		    => 'rgba(255, 255, 255, 1)',
		'output'		    => [
			[
				'element'	=> '#masthead:not(.header_v1)',
				'property'	=> 'background-color'
			],
			[
				'element'	=> '#masthead nav:not(.mobile-menu) ul li ul',
				'property'	=> 'background-color'
			]
		],
		'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Shrinked BG Color', 'agama' ),
		'tooltip'		    => esc_attr__( 'Work\'s only with header V1 & V3.', 'agama' ),
		'section'		    => 'agama_colors_header_section',
		'settings'		    => 'agama_header_shrink_bg_color',
		'type'			    => 'color',
        'choices'           => [
            'alpha'		    => true
        ],
		'transport'		    => 'auto',
		'output'		    => [
			[
				'element'	=> '#masthead.shrinked, #masthead.shrinked nav ul li ul',
				'property'	=> 'background-color'
			],
            [
                'element'   => '#masthead.shrinked #agama-mobile-nav ul',
                'property'  => 'background-color'
            ]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'default'
            ]
        ],
		'default'		    => 'rgba(255, 255, 255, .9)'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Header Borders Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select header borders color.', 'agama' ),
		'section'		=> 'agama_colors_header_section',
		'settings'		=> 'agama_header_border_color',
		'type'			=> 'color',
        'transport'		=> 'auto',
        'choices'       => [
            'alpha'	    => true
        ],
        'default'		=> 'rgba(238, 238, 238, 1)',
		'output'		=> [
			[
				'element'	=> '.header_v2 #agama-primary-nav, #agama-top-social li',
				'property'	=> 'border-color'
			],
            [
                'element'   => '.agama-top-nav-wrapper',
                'property'  => 'box-shadow',
                'prefix'    => '0 1px 4px 0 '
            ]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ]
	] );
    ######################################################
    # COLORS HEADER IMAGE SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_header_image_section', [
		'title'			=> esc_attr__( 'Header Image', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> __( 'Enable particles?', 'agama' ),
		'settings'		=> 'agama_header_image_particles',
		'section'		=> 'agama_colors_header_image_section',
		'type'			=> 'checkbox',
		'default'		=> true
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Particles Colors', 'agama' ),
		'tooltip'	        => __( 'Select header image particles colors.', 'agama' ),
		'settings'		    => 'agama_header_image_particles_colors',
		'section'		    => 'agama_colors_header_image_section',
		'type'			    => 'multicolor',
        'choices'           => [
            'lines'         => __( 'Lines', 'agama' ),
            'circles'       => __( 'Circles', 'agama' )
        ],
		'default'		    => [
            'lines'         => '#ac32e4',
            'circles'       => '#fff'
        ],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_image_particles',
                'operator'  => '==',
                'value'     => true
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> __( 'Enable background overlay?', 'agama' ),
		'settings'		=> 'agama_header_image_overlay',
		'section'		=> 'agama_colors_header_image_section',
		'type'			=> 'checkbox',
		'default'		=> true
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Background Overlay Colors', 'agama' ),
		'tooltip'	        => __( 'Select header image background overlay colors.', 'agama' ),
		'settings'		    => 'agama_header_image_background',
		'section'		    => 'agama_colors_header_image_section',
		'type'			    => 'multicolor',
        'transport'         => 'postMessage',
        'choices'           => [
            'left'          => __( 'Left', 'agama' ),
            'right'         => __( 'Right', 'agama' )
        ],
		'default'		    => [
            'left'          => 'rgba(160,47,212,0.8)',
            'right'         => 'rgba(69,104,220,0.8)'
        ],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_image_overlay',
                'operator'  => '==',
                'value'     => true
            ]
        ]
	] );
    ######################################################
    # COLORS NAVIGATION TOP SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_navigation_top_section', [
		'title'			=> esc_attr__( 'Navigation Top', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_html__( 'Links Color', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize navigation top links color.', 'agama' ),
        'settings'          => 'agama_navigation_top_links_color',
        'section'           => 'agama_colors_navigation_top_section',
        'type'              => 'multicolor',
        'transport'         => 'auto',
        'choices'           => [
            'normal'        => esc_html__( 'Normal', 'agama' ),
            'visited'       => esc_html__( 'Visited', 'agama' ),
            'hover'         => esc_html__( 'Hover', 'agama' ),
            'active'        => esc_html__( 'Active', 'agama' )
        ],
        'default'           => [
            'normal'        => '#757575',
            'visited'       => '#757575',
            'hover'         => '#333333',
            'active'        => '#333333'
        ],
        'output'            => [
            [
                'choice'    => 'normal',
                'element'   => '#agama-top-nav a',
                'property'  => 'color'
            ],
            [
                'choice'    => 'visited',
                'element'   => '#agama-top-nav a:visited',
                'property'  => 'color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '#agama-top-nav a:hover',
                'property'  => 'color'
            ],
            [
                'choice'    => 'active',
                'element'   => '#agama-top-nav a:active',
                'property'  => 'color'
            ]
        ],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ]
    ] );
    ######################################################
    # COLORS NAVIGATION PRIMARY SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_navigation_primary_section', [
		'title'			=> esc_attr__( 'Navigation Primary', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_html__( 'Links Color', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize navigation primary links color.', 'agama' ),
        'settings'          => 'agama_navigation_primary_links_color',
        'section'           => 'agama_colors_navigation_primary_section',
        'type'              => 'multicolor',
        'transport'         => 'auto',
        'choices'           => [
            'normal'        => esc_html__( 'Normal', 'agama' ),
            'visited'       => esc_html__( 'Visited', 'agama' ),
            'hover'         => esc_html__( 'Hover', 'agama' ),
            'active'        => esc_html__( 'Active', 'agama' )
        ],
        'default'           => [
            'normal'        => '#757575',
            'visited'       => '#757575',
            'hover'         => '#333333',
            'active'        => '#333333'
        ],
        'output'            => [
            [
                'choice'    => 'normal',
                'element'   => '#agama-primary-nav ul.agama-navigation a',
                'property'  => 'color'
            ],
            [
                'choice'    => 'visited',
                'element'   => '#agama-primary-nav ul.agama-navigation a:visited',
                'property'  => 'color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '#agama-primary-nav ul.agama-navigation a:hover',
                'property'  => 'color'
            ],
            [
                'choice'    => 'active',
                'element'   => '#agama-primary-nav ul.agama-navigation a:active',
                'property'  => 'color'
            ]
        ]
    ] );
    ######################################################
    # COLORS NAVIGATION MOBILE SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_navigation_mobile_section', [
		'title'			=> esc_attr__( 'Navigation Mobile', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_html__( 'Links Color', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize navigation mobile links color.', 'agama' ),
        'settings'          => 'agama_navigation_mobile_links_color',
        'section'           => 'agama_colors_navigation_mobile_section',
        'type'              => 'multicolor',
        'transport'         => 'auto',
        'choices'           => [
            'normal'        => esc_html__( 'Normal', 'agama' ),
            'visited'       => esc_html__( 'Visited', 'agama' ),
            'hover'         => esc_html__( 'Hover', 'agama' ),
            'active'        => esc_html__( 'Active', 'agama' )
        ],
        'default'           => [
            'normal'        => '#757575',
            'visited'       => '#757575',
            'hover'         => '#333333',
            'active'        => '#333333'
        ],
        'output'            => [
            [
                'choice'    => 'normal',
                'element'   => '#agama-mobile-nav a',
                'property'  => 'color'
            ],
            [
                'choice'    => 'visited',
                'element'   => '#agama-mobile-nav a:visited',
                'property'  => 'color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '#agama-mobile-nav a:hover',
                'property'  => 'color'
            ],
            [
                'choice'    => 'active',
                'element'   => '#agama-mobile-nav a:active',
                'property'  => 'color'
            ]
        ]
    ] );
    ######################################################
    # COLORS NAVBAR BUTTONS SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_navbar_buttons_section', [
		'title'			=> esc_attr__( 'Navbar Buttons', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_Field( 'agama_options', [
        'label'     => esc_html__( 'Disable navbar buttons box shadow.', 'agama' ),
        'settings'  => 'agama_navbar_buttons_shadow',
        'section'   => 'agama_colors_navbar_buttons_section',
        'type'      => 'checkbox',
        'transport' => 'postMessage',
        'default'   => false
    ] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_html__( 'Navbar Buttons', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize navbar buttons color.', 'agama' ),
        'settings'          => 'agama_navbar_buttons_color',
        'section'           => 'agama_colors_navbar_buttons_section',
        'type'              => 'multicolor',
        'transport'         => 'auto',
        'choices'           => [
            'normal'        => esc_html__( 'Normal', 'agama' ),
            'hover'         => esc_html__( 'Hover', 'agama' ),
        ],
        'default'           => [
            'normal'        => '#757575',
            'hover'         => '#333333',
        ],
        'output'            => [
            [
                'choice'    => 'normal',
                'element'   => '#masthead ul.navbar-buttons a, .mobile-menu-toggle .mobile-menu-toggle-label',
                'property'  => 'color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '#masthead ul.navbar-buttons a:hover, .mobile-menu-toggle:hover .mobile-menu-toggle-label',
                'property'  => 'color'
            ],
            [
                'choice'    => 'normal',
                'element'   => '.mobile-menu-toggle .mobile-menu-toggle-inner, .mobile-menu-toggle .mobile-menu-toggle-inner::before, .mobile-menu-toggle .mobile-menu-toggle-inner::after',
                'property'  => 'background-color'
            ],
            [
                'choice'    => 'hover',
                'element'   => '.mobile-menu-toggle:hover .mobile-menu-toggle-inner, .mobile-menu-toggle:hover .mobile-menu-toggle-inner::before, .mobile-menu-toggle:hover .mobile-menu-toggle-inner::after',
                'property'  => 'background-color'
            ]
        ]
    ] );
    ######################################################
    # COLORS BREADCRUMB SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_breadcrumb_section', [
		'title'			=> esc_attr__( 'Breadcrumb', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Background Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb background color.', 'agama' ),
		'section'		=> 'agama_colors_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_bg_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#F5F5F5',
        'output'        => [
            [
                'element'   => '#page-title',
                'property'  => 'background-color'
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Font Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb font color.', 'agama' ),
		'section'		=> 'agama_colors_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_text_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#444',
        'output'        => [
            [
                'element'  => '#page-title h1, .breadcrumb > .active',
                'property' => 'color'
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Links Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb links color.', 'agama' ),
		'section'		=> 'agama_colors_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_links_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#444',
        'output'        => [
            [
                'element'  => '#page-title a',
                'property' => 'color'
            ]
        ]
	] );
    ######################################################
    # COLORS SLIDER SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_slider_section', [
		'title'			=> esc_attr__( 'Slider', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_html__( 'Enable background overlay?', 'agama' ),
		'tooltip'	    => esc_attr__( 'Enable slider background color overlay.', 'agama' ),
		'section'		=> 'agama_colors_slider_section',
		'settings'		=> 'agama_slider_overlay',
		'type'			=> 'checkbox',
		'default'		=> true
	] );
    Kirki::add_field( 'agama_options', [
		'label'				=> esc_html__( 'Background Overlay Color', 'agama' ),
		'tooltip'		    => esc_attr__( 'Set custom overlay background color.', 'agama' ),
		'section'			=> 'agama_colors_slider_section',
		'settings'			=> 'agama_slider_overlay_bg_color',
        'transport'         => 'auto',
		'type'				=> 'color',
		'choices'     		=> [
			'alpha' 		=> true
		],
		'active_callback'	=> [
			[
				'setting'	=> 'agama_slider_overlay',
				'operator'	=> '==',
				'value'		=> true
			]
		],
		'output'			=> [
            [
                'element'	=> '.camera_overlayer',
                'property'	=> 'background'
            ]
		],
		'default'			=> 'rgba(26,131,192,0.5)'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_html__( 'Enable the particles?', 'agama' ),
		'tooltip'	    => esc_attr__( 'Enable particles on slider ?', 'agama' ),
		'settings'		=> 'agama_slider_particles',
		'section'		=> 'agama_colors_slider_section',
		'type'			=> 'checkbox',
		'default'		=> true
	] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_html__( 'Particles Colors', 'agama' ),
        'tooltip'       => esc_attr__( 'Select particles colors.', 'agama' ),
        'settings'      => 'agama_slider_particles_colors',
        'section'       => 'agama_colors_slider_section',
        'type'          => 'multicolor',
        'choices'       => [
            'circles'   => esc_html__( 'Circles', 'agama' ),
            'lines'     => esc_html__( 'Lines', 'agama' )
        ],
        'default'       => [
            'circles'   => '#ac32e4',
            'lines'     => '#ac32e4'
        ],
        'active_callback'   => [
            [
                'setting'   => 'agama_slider_particles',
                'operator'  => '==',
                'value'     => true
            ]
        ]
    ] );
    ######################################################
    # COLORS FOOTER SECTION
    ######################################################
    Kirki::add_section( 'agama_colors_footer_section', [
		'title'			=> esc_attr__( 'Footer', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_colors_panel'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_html__( 'Widget Area Background Colors', 'agama' ),
		'tooltip'	    => esc_html__( 'Customize the footer widget area background colors.', 'agama' ),
		'section'		=> 'agama_colors_footer_section',
		'settings'		=> 'agama_footer_widgets_background_colors',
		'type'			=> 'multicolor',
        'transport'		=> 'postMessage',
        'choices'       => [
            'left'      => esc_html__( 'Left', 'agama' ),
            'right'     => esc_html__( 'Right', 'agama' )
        ],
		'default'		=> [
            'left'      => '#314150',
            'right'     => '#314150'
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_html__( 'Footer Area Background Colors', 'agama' ),
		'tooltip'	    => esc_html__( 'Customize the footer area background colors.', 'agama' ),
		'section'		=> 'agama_colors_footer_section',
		'settings'		=> 'agama_footer_background_colors',
		'type'			=> 'multicolor',
        'transport'		=> 'postMessage',
        'choices'       => [
            'left'      => esc_html__( 'Left', 'agama' ),
            'right'     => esc_html__( 'Right', 'agama' )
        ],
		'default'		=> [
            'left'      => '#293744',
            'right'     => '#293744'
        ]
	] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_html__( 'Copyright Links Color', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom color for copyright links in footer area.', 'agama' ),
        'section'       => 'agama_colors_footer_section',
        'settings'      => 'agama_footer_site_info_links_color',
        'type'          => 'color',
        'transport'     => 'auto',
        'output'        => [
            [
                'element'   => 'footer .site-info a',
                'property'  => 'color'
            ]
        ],
        'default'       => '#cddeee'
    ] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_html__( 'Social Icons Color', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom color for social icons in footer area.', 'agama' ),
        'section'       => 'agama_colors_footer_section',
        'settings'      => 'agama_footer_social_icons_color',
        'type'          => 'color',
        'transport'     => 'auto',
        'output'        => [
            [
                'element'   => 'footer .social a',
                'property'  => 'color'
            ]
        ],
        'default'       => '#cddeee'
    ] );
######################################################
# LAYOUT PANEL
######################################################
    Kirki::add_panel( 'agama_layout_panel', array(
        'title'         => __( 'Layout', 'agama' ),
        'priority'      => 20
    ) );
    ##########################################################
    # LAYOUT GENERAL SECTION
    ##########################################################
	Kirki::add_section( 'agama_layout_general_section', [
		'title'			=> esc_attr__( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_layout_panel'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Layout Style', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select layout style.', 'agama' ),
		'section'		=> 'agama_layout_general_section',
		'settings'		=> 'agama_layout_style',
		'type'			=> 'select',
        'transport'     => 'postMessage',
		'choices'		=> [
			'fullwidth'	=> esc_attr__( 'Full-Width', 'agama' ),
			'boxed'		=> esc_attr__( 'Boxed', 'agama' )
		],
		'default'		=> 'fullwidth'
	] );
    ##########################################################
    # LAYOUT SIDEBAR SECTION
    ##########################################################
    Kirki::add_section( 'agama_layout_sidebar_section', [
        'title'      => esc_attr__( 'Sidebar', 'agama' ),
        'capability' => 'edit_theme_options',
        'panel'      => 'agama_layout_panel'
    ] );
	Kirki::add_field( 'agama_options', [
		'label'		=> esc_attr__( 'Sidebar Position', 'agama' ),
		'tooltip'	=> esc_attr__( 'Select sidebar position.', 'agama' ),
		'section'	=> 'agama_layout_sidebar_section',
		'settings'	=> 'agama_sidebar_position',
		'type'		=> 'select',
        'transport' => 'postMessage',
		'choices'	=> [
			'left'	=> esc_attr__( 'Left', 'agama' ),
			'right' => esc_attr__( 'Right', 'agama' )
		],
		'default'	=> 'right'
	] );
###################################################################################
# HEADER
###################################################################################
	Kirki::add_panel( 'agama_header_panel', array(
		'title'			=> __( 'Header', 'agama' ),
		'priority'		=> 30
	) );
	##################################################
	# HEADER GENERAL SECTION
	##################################################
	Kirki::add_section( 'agama_header_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_header_panel'
	) );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Style', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select header style.', 'agama' ),
		'section'		    => 'agama_header_section',
		'settings'		    => 'agama_header_style',
		'type'			    => 'radio-buttonset',
		'choices'		    => [
			'transparent'	=> esc_attr__( 'Header V1', 'agama' ),
			'default'		=> esc_attr__( 'Header V2', 'agama' ),
			'sticky'		=> esc_attr__( 'Header V3', 'agama' )
		],
		'default'		    => 'transparent'
	] );
    Kirki::add_field( 'agama_options', [
		'label'				=> esc_attr__( 'Enable Top Navigation', 'agama' ),
		'section'			=> 'agama_header_section',
		'settings'			=> 'agama_top_navigation',
		'type'				=> 'checkbox',
		'default'			=> true,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ],
        'partial_refresh'   => [
            'agama_top_navigation' => [
                'selector'         => [ '#agama-top-nav', 'div.top-links div' ],
                'render_callback'  => [ 'Agama_Partial_Refresh', 'preview_top_navigation' ]
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Enable Social Icons', 'agama' ),
		'section'		    => 'agama_header_section',
		'settings'		    => 'agama_top_nav_social',
		'type'			    => 'checkbox',
		'default'		    => true,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ],
        'partial_refresh'   => [
            'agama_top_nav_social' => [
                'selector'         => [ '#agama-top-social' ],
                'render_callback'  => [ 'Agama_Partial_Refresh', 'preview_top_nav_social_icons' ]
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'	           => esc_attr__( 'Top Margin', 'agama' ),
		'tooltip'          => esc_attr__( 'Set header top margin in PX. This feature works only with header V2', 'agama' ),
		'section'          => 'agama_header_section',
		'settings'         => 'agama_header_top_margin',
		'type'	           => 'slider',
		'choices'          => [
			'step'         => '1',
			'min'          => '0',
			'max'          => '100'
		],
        'transport'        => 'auto',
        'output'           => [
            [
                'element'  => 'body.header_v2 #agama-main-wrapper',
                'property' => 'margin-top',
                'suffix'   => 'px'
            ]
        ],
         'active_callback' => [
            [
                'setting'  => 'agama_header_style',
                'operator' => '==',
                'value'    => 'default'
            ]
        ],
		'default'		   => '0'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			   => esc_attr__( 'Top Border', 'agama' ),
		'tooltip'	       => esc_attr__( 'Select header top border height in PX. This feature works with header V2 & V3.', 'agama' ),
		'section'		   => 'agama_header_section',
		'settings'		   => 'agama_header_top_border_size',
		'type'			   => 'slider',
        'choices'          => [
            'min'          => '0',
            'max'          => '20',
            'step'         => '1'
        ],
        'transport'        => 'auto',
        'output'           => [
            [
                'element'  => '#masthead:not(.header_v1)',
                'property' => 'border-top-width',
                'suffix'   => 'px'
            ]
        ],
        'active_callback'  => [
            [
                'setting'  => 'agama_header_style',
                'operator' => 'contains',
                'value'    => [ 'default', 'sticky' ]
            ]
        ],
		'default'		   => '3'
	] );
	#######################################################
	# HEADER LOGO SECTION
	#######################################################
	Kirki::add_section( 'agama_header_logo_section', array(
		'title'			=> esc_attr__( 'Logo', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_header_panel'
	) );
    Kirki::add_field( 'agama_options', array(
        'type'          => 'radio-image',
        'settings'      => 'agama_media_logo',
        'section'       => 'agama_header_logo_section',
        'default'       => 'desktop',
        'priority'      => 10,
        'transport'     => 'auto',
        'choices'       => array(
            'desktop'   => get_template_directory_uri() . '/assets/img/desktop.png',
            'tablet'    => get_template_directory_uri() . '/assets/img/tablet.png',
            'mobile'    => get_template_directory_uri() . '/assets/img/mobile.png',
        ),
        'output'        => array(
            array(
                'element'   => '',
                'property'  => ''
            )
        )
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Desktop Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for desktop devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'desktop'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Desktop Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set desktop logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-desktop',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'desktop'
            ),
            array(
                'setting'   => 'agama_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Tablet Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for tablet devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_tablet_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'tablet'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Tablet Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set tablet logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_tablet_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-tablet',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'tablet'
            ),
            array(
                'setting'   => 'agama_tablet_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Mobile Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for mobile devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_mobile_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'mobile'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Mobile Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set mobile logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_mobile_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-mobile',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'mobile'
            ),
            array(
                'setting'   => 'agama_mobile_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    #######################################################
	# HEADER NAVBAR BUTTONS SECTION
	#######################################################
    Kirki::add_section( 'agama_navbar_buttons_section', [
		'title'			=> esc_html__( 'Navbar Buttons', 'agama' ),
		'panel'			=> 'agama_header_panel',
        'capability'    => 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_html__( 'Navbar Buttons', 'agama' ),
        'tooltip'       => esc_html__( 'Customize the navbar buttons.', 'agama' ),
        'settings'      => 'agama_navbar_buttons',
        'section'       => 'agama_navbar_buttons_section',
        'type'          => 'sortable',
        'default'       => [
            'search', 'cart', 'mobile'  
        ],
        'choices'       => [
            'search'    => esc_html__( 'Search Icon', 'agama' ),
            'cart'      => esc_html__( 'Cart Icon', 'agama' ),
            'mobile'    => esc_html__( 'Mobile Icon', 'agama' )
        ]
    ] );
	##########################################
	# HEADER IMAGE SECTION
	##########################################
	Kirki::add_section( 'header_image', [
		'title'			=> __( 'Header Image', 'agama' ),
		'panel'			=> 'agama_header_panel',
        'capability'    => 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'label'         => __( 'Viewport Height (vh)', 'agama' ),
        'description'   => __( 'Set header image viewport height.', 'agama' ),
        'settings'  => 'agama_header_image_height',
        'section'   => 'header_image',
        'transport' => 'auto',
        'type'      => 'slider',
        'choices'   => [
            'min'   => 5,
            'max'   => 100,
            'step'  => 5
        ],
        'default'   => 50,
        'output'    => [
           [
               'element'  => '#agama-header-image .header-image',
               'property' => 'height',
               'suffix'   => 'vh'
           ]
        ],
        'priority'  => 1
    ] );
    Kirki::add_field( 'agama_options', [
        'label'         => esc_attr__( 'Bottom Shape', 'agama' ),
        'description'   => esc_attr__( 'Select the header image bottom shape.', 'agama' ),
        'section'       => 'header_image',
        'settings'      => 'agama_header_image_bottom_shape',
        'type'          => 'select',
        'choices'       => [
            'none'      => __( 'None', 'agama' ),
            'waves'     => __( 'Waves', 'agama' )
        ],
        'default'       => 'waves',
        'priority'      => 1
    ] );
###############################################
# NAVIGATIONS PANEL
###############################################
	Kirki::add_panel( 'agama_nav_panel', array(
		'title'			=> __( 'Navigations', 'agama' ),
		'priority'		=> 40
	) );
	######################################################
	# NAVIGATION MOBILE SECTION
	######################################################
	Kirki::add_section( 'agama_nav_mobile_section', [
		'title'			=> esc_attr__( 'Navigation Mobile', 'agama' ),
		'panel'			=> esc_attr__( 'agama_nav_panel', 'agama' ),
		'capability'	=> 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Menu Icon Title', 'agama' ),
		'tooltip'	    => esc_attr__( 'Set custom mobile menu title.', 'agama' ),
		'settings'		=> 'agama_nav_mobile_icon_title',
		'section'		=> 'agama_nav_mobile_section',
		'type'			=> 'text',
		'default'		=> ''
	] );
#########################################
# MENUS PANEL
#########################################
    Kirki::add_panel( 'nav_menus', array(
        'title'     => __( 'Menus', 'agama' ),
        'priority'  => 50
    ) );
##################################################
# SLIDER
##################################################
	Kirki::add_panel( 'agama_slider_panel', array(
		'title'			=> __( 'Slider', 'agama' ),
		'tooltip'	    => __( 'Slider settings.', 'agama' ),
		'priority'		=> 60,
	) );
	##########################################################
	# SLIDER GENERAL SECTION
	##########################################################
	Kirki::add_section( 'agama_slider_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Slider Height', 'agama' ),
		'tooltip'	    => __( 'Set slider height in pixels (px). Set 0 for full screen slider.', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_height',
		'type'			=> 'number',
		'choices'		=> array(
			'min'		=> '0',
			'max'		=> '1000',
			'step'		=> '1'
		),
		'default'		=> '0'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Sliding Time', 'agama' ),
		'tooltip'	    => __( 'Milliseconds between the end of the sliding effect and the start of the nex one. 1000ms = 1sec', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_time',
		'type'			=> 'number',
		'choices'		=> array(
			'min'		=> '1000',
			'max'		=> '28000',
			'step'		=> '1'
		),
		'default'		=> '7000'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Visibility', 'agama' ),
		'tooltip'	    => __( 'Select where the slider should be visible.', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'homepage'	=> __( 'Home Page', 'agama' ),
			'frontpage'	=> __( 'Front Page', 'agama' )
		),
		'default'		=> 'homepage'
	) );
    ###################################################
	# SLIDES SECTION
	###################################################
	Kirki::add_section( 'agama_slider_slides_section', [
		'title'			=> esc_html__( 'Slides', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'type' => 'repeater',
        'label' => esc_html__( 'Slides', 'agama' ),
        'section' => 'agama_slider_slides_section',
        'priority' => 10,
        'row_label' => [
            'type' => 'field',
            'value' => esc_html__( 'Slide', 'agama' ),
            'field' => 'title'
        ],
        'button_label' => esc_html__( 'Add New', 'agama' ),
        'settings' => 'agama_slider_slides_repeater',
        'default' => [],
        'fields' => [
            'image' => [
                'type'        => 'image',
                'label'       => esc_html__( 'Box Image', 'agama' ),
                'description' => esc_html__( 'Upload box image.', 'agama' ),
                'choices'     => [
                    'save_as' => 'url'
                ],
                'default'     => ''
            ],
            'title' => [
                'type'        => 'text',
                'label'       => esc_html__( 'Title', 'agama' ),
                'description' => esc_html__( 'The box title.', 'agama' ),
                'default'     => esc_html__( 'Welcome to Agama', 'agama' )
            ],
            'title_color' => [
                'type'        => 'color',
                'label'       => esc_html__( 'Title Color', 'agama' ),
                'description' => esc_html__( 'Select slide title color.', 'agama' ),
                'default'     => '#fff'
            ],
            'title_animation' => [
                'type'        => 'select',
                'label'       => esc_html__( 'Title Animation', 'agama' ),
                'description' => esc_html__( 'Select slide title animation in.', 'agama' ),
                'choices'     => AgamaAnimate::choices(),
                'default'     => 'bounce',
            ],
            'button_title' => [
                'type'        => 'text',
                'label'       => esc_html__( 'Button Title', 'agama' ),
                'description' => esc_html__( 'Enter the slide button title.', 'agama' ),
                'default'     => esc_html__( 'Learn More', 'agama' )
            ],
            'button_link' => [
                'type'        => 'link',
                'label'       => esc_html__( 'Button Link', 'agama' ),
                'description' => esc_html__( 'Add custom button link.', 'agama' ),
                'default'     => ''
            ],
            'button_color' => [
                'type'        => 'color',
                'label'       => esc_html__( 'Button Color', 'agama' ),
                'description' => esc_html__( 'Select button color.'. 'agama' ),
                'default'     => '#ac32e4'
            ],
            'button_animation' => [
                'type'        => 'select',
                'label'       => esc_html__( 'Button Animation', 'agama' ),
                'description' => esc_html__( 'Select button animation in.', 'agama' ),
                'choices'     => AgamaAnimate::choices(),
                'default'     => 'bounce'
            ]
        ],
        'choices' => apply_filters( 'agama/slider_repeater_choices', [ 'limit' => 2 ] )
    ] );
###################################################################################
# BREADCRUMB
###################################################################################
	Kirki::add_section( 'agama_breadcrumb_section', array(
		'title'			=> __( 'Breadcrumb', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 50,
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb', 'agama' ),
		'tooltip'	    => __( 'Enable breadcrumb ?', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb on Home Page', 'agama' ),
		'tooltip'	    => __( 'Enable breadcrumb on home page ?', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_homepage',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb Style', 'agama' ),
		'tooltip'	    => __( 'Select breadcrumb style.', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_style',
		'type'			=> 'select',
		'choices'		=> array(
			'mini'		=> __( 'Mini', 'agama' ),
			'normal'	=> __( 'Normal', 'agama' )
		),
		'default'		=> 'mini'
	) );
###################################################################################
# FRONTPAGE BOXES
###################################################################################
	Kirki::add_panel( 'agama_frontpage_boxes_panel', array(
		'title'			=> __( 'Front Page Boxes', 'agama' ),
		'tooltip'	    => __( 'Front page boxes section.', 'agama' ),
		'priority'		=> 70
	) );
	#############################################################
	# FRONTPAGE BOXES GENERAL SECTION
	#############################################################
	Kirki::add_section( 'agama_frontpage_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Visibility', 'agama' ),
		'tooltip'	    => __( 'Select where you want front page boxes to be visible.', 'agama' ),
		'section'		=> 'agama_frontpage_general_section',
		'settings'		=> 'agama_frontpage_boxes_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'homepage'	=> __( 'Home Page', 'agama' ),
			'frontpage'	=> __( 'Front Page', 'agama' ),
			'allpages'	=> __( 'All Pages', 'agama' )
		),
		'default'		=> 'homepage'
	) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Front Page Boxes Heading', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom heading for front page boxes. Empty = Disabled', 'agama' ),
        'section'       => 'agama_frontpage_general_section',
        'settings'      => 'agama_frontpage_boxes_heading',
        'type'          => 'text',
        'default'       => esc_html__( 'Front Page Boxes', 'agama' )
    ) );
    ####################################
    # FRONTPAGE BOXES
    ####################################
    Kirki::add_section( 'agama_frontpage_boxes_section', [
		'title'			=> __( 'Boxes', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'type' => 'repeater',
        'label' => esc_html__( 'Boxes', 'agama' ),
        'section' => 'agama_frontpage_boxes_section',
        'priority' => 10,
        'row_label' => [
            'type' => 'field',
            'value' => esc_html__( 'Front Page Box', 'agama' ),
            'field' => 'title'
        ],
        'button_label' => esc_html__( 'Add New', 'agama' ),
        'settings' => 'agama_frontpage_boxes_repeater',
        'default' => [],
        'fields' => [
            'title' => [
                'type'        => 'text',
                'label'       => esc_html__( 'Box Title', 'agama' ),
                'description' => esc_html__( 'The box title.', 'agama' ),
                'default'     => '',
            ],
            'image' => [
                'type'        => 'image',
                'label'       => esc_html__( 'Box Image', 'agama' ),
                'description' => esc_html__( 'Upload box image.', 'agama' ),
                'choices'     => [
                    'save_as' => 'url'
                ],
                'default'     => ''
            ],
            'icon'  => [
                'type'        => 'text',
                'label'       => esc_html__( 'Box Icon', 'agama' ),
                'description' => sprintf( '%s <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">%s</a> %s', esc_html__( 'Enter the', 'agama' ), 'FontAwesome', esc_html__( 'icon name. ex: "fa-tablet"', 'agama' ) ),
                'default'     => '',
            ],
            'icon_color' => [
                'type'        => 'color',
                'label'       => esc_html__( 'Icon Color', 'agama' ),
                'description' => esc_html__( 'Select icon color.', 'agama' ),
                'default'     => '#ac32e4'
            ],
            'url' => [
                'type'        => 'link',
                'label'       => esc_html__( 'Box Image/Icon URL', 'agama' ),
                'description' => esc_html__( 'Enter box icon/image url.', 'agama' ),
                'default'     => ''
            ],
            'text' => [
                'type'        => 'textarea',
                'label'       => esc_html__( 'Box Text', 'agama' ),
                'description' => esc_html__( 'Enter box text.', 'agama' ),
                'default'     => ''
            ],
            'animated' => [
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Is box animated?', 'agama' ),
                'default'     => false
            ],
            'animation' => [
                'type'        => 'select',
                'label'       => esc_html__( 'Animation', 'agama' ),
                'description' => esc_html__( 'Select box animation.', 'agama' ),
                'choices'     => AgamaAnimate::choices(),
                'default'     => 'bounce'
            ],
            'animation_delay' => [
                'type'        => 'number',
                'label'       => esc_html__( 'Animation Delay', 'agama' ),
                'description' => esc_html__( 'Select animation delay in miliseconds.', 'agama' ),
                'default'     => 100
            ]
        ],
        'choices' => apply_filters( 'agama/frontpage_boxes_choices', [ 'limit' => 4 ] )
    ] );
###################################################################################
# BLOG
###################################################################################
	Kirki::add_panel( 'agama_blog_panel', array(
		'title'			=> __( 'Blog', 'agama' ),
		'tooltip'	    => __( 'Blog panel.', 'agama' ),
		'priority'		=> 80
	) );
	########################################################
	# BLOG GENERAL SECTION
	########################################################
	Kirki::add_section( 'agama_blog_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Layout', 'agama' ),
		'tooltip'	        => __( 'Select blog layout.', 'agama' ),
		'section'		    => 'agama_blog_general_section',
		'settings'		    => 'agama_blog_layout',
		'type'			    => 'select',
		'choices'		    => array(
			'list'			=> __( 'List Layout', 'agama' ),
			'grid'			=> __( 'Grid Layout', 'agama' ),
			'small_thumbs'	=> __( 'Small Thumbs Layout', 'agama' )
		),
		'default'		    => 'list'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Posts Animated', 'agama' ),
		'tooltip'	    => __( 'Enable posts loading animation ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_posts_load_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Posts Animation', 'agama' ),
		'tooltip'	    => __( 'Select posts loading animation.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_posts_load_animation',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_posts_load_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> 'bounceInUp'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Featured Image Permalink', 'agama' ),
		'tooltip'		=> __( 'Enable post featured image permalink ? If enabled the post featured images will become clickable links.', 'agama' ),
		'section'			=> 'agama_blog_general_section',
		'settings'			=> 'agama_blog_thumbnails_permalink',
		'type'				=> 'switch',
		'default'			=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Excerpt', 'agama' ),
		'tooltip'	    => __( 'Set posts lenght on blog loop page.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_excerpt',
		'type'			=> 'slider',
		'choices'		=> array(
			'step'		=> '1',
			'min'		=> '0',
			'max'		=> '500'
		),
		'default'		=> '70'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Read More', 'agama' ),
		'tooltip'	    => __( 'Enable read more url on blog excerpt ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_readmore_url',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'About Author', 'agama' ),
		'tooltip'	    => __( 'Enable about author section below single post content ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_about_author',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Infinite Scroll', 'agama' ),
		'tooltip'	    => __( 'Enable infinite scroll ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_infinite_scroll',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Infinite Trigger', 'agama' ),
		'tooltip'	    => __( 'Select infinite scroll trigger.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_infinite_trigger',
		'type'			=> 'select',
		'choices'		=> array(
			'auto'		=> __( 'Automatic', 'agama' ),
			'button'	=> __( 'Button', 'agama' )
		),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_infinite_scroll',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> 'button'
	) );
	############################################################
	# BLOG SINGLE POST SECTION
	############################################################
	Kirki::add_section( 'agama_blog_single_post_section', array(
		'title'			=> __( 'Single Post', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Featured Image on Single Post', 'agama' ),
		'tooltip'	    => __( 'Turn on to display featured images on single blog posts.', 'agama' ),
		'section'		=> 'agama_blog_single_post_section',
		'settings'		=> 'agama_blog_single_post_thumbnail',
		'type'			=> 'switch',
		'default'		=> true
	) );
	##########################################################
	# BLOG POST META SECTION
	##########################################################
	Kirki::add_section( 'agama_blog_post_meta_section', array(
		'title'			=> __( 'Post Meta', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta', 'agama' ),
		'tooltip'	    => __( 'Enable blog post meta.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_meta',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Author', 'agama' ),
		'tooltip'	    => __( 'Enable single post author section.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_author',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Date', 'agama' ),
		'tooltip'	    => __( 'Enable post publish date.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_date',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Category', 'agama' ),
		'tooltip'	    => __( 'Enable post category.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_category',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Comments', 'agama' ),
		'tooltip'	    => __( 'Enable post meta comments counter.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_comments',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
############################################################
# SOCIAL ICONS
############################################################
	Kirki::add_section( 'agama_social_icons_section', [
		'title'			=> esc_attr__( 'Social Icons', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 90,
	] );
    Kirki::add_field( 'agama_options', [
        'type'          => 'repeater',
        'label'         => esc_attr__( 'Social Icons', 'agama' ),
        'section'       => 'agama_social_icons_section',
        'settings'      => 'agama_social_icons',
        'row_label'     => [
            'type'      => 'field',
            'value'     => esc_attr__( 'Social Icon', 'agama' ),
            'field'     => 'icon'
        ],
        'button_label'  => esc_attr__( 'Add New', 'agama' ),
        'default'       => [
            [
                'target' => '',
                'icon'   => 'rss',
                'url'    => esc_url_raw( get_bloginfo('rss2_url') )
            ]
        ],
        'fields' => [
            'target' => [
                'type'          => 'checkbox',
                'label'         => esc_attr__( 'Open in New Tab ?', 'agama' ),
            ],
            'icon' => [
                'type'          => 'select',
                'label'         => esc_attr__( 'Icon', 'agama' ),
                'description'   => esc_attr__( 'Select social icon.', 'agama' ),
                'choices'       => [
                    ''              => esc_attr__( '-- Select --', 'agama' ),
                    'amazon'        => esc_attr__( 'Amazon', 'agama' ),
                    'android'       => esc_attr__( 'Android', 'agama' ),
                    'behance'       => esc_attr__( 'Behance', 'agama' ),
                    'bitbucket'     => esc_attr__( 'Bitbucket', 'agama' ),
                    'bitcoin'       => esc_attr__( 'BitCoin', 'agama' ),
                    'delicious'     => esc_attr__( 'Delicious', 'agama' ),
                    'deviantart'    => esc_attr__( 'DeviantArt', 'agama' ),
                    'dropbox'       => esc_attr__( 'DropBox', 'agama' ),
                    'dribbble'      => esc_attr__( 'Dribbble', 'agama' ),
                    'digg'          => esc_attr__( 'Digg', 'agama' ),
                    'email'         => esc_attr__( 'Email', 'agama' ),
                    'facebook'      => esc_attr__( 'Facebook', 'agama' ),
                    'flickr'        => esc_attr__( 'Flickr', 'agama' ),
                    'github'        => esc_attr__( 'GitHub', 'agama' ),
                    'google'        => esc_attr__( 'Google', 'agama' ),
                    'instagram'     => esc_attr__( 'Instagram', 'agama' ),
                    'linkedin'      => esc_attr__( 'LinkedIn', 'agama' ),
                    'myspace'       => esc_attr__( 'MySpace', 'agama' ),
                    'paypal'        => esc_attr__( 'PayPal', 'agama' ),
                    'phone'         => esc_attr__( 'Phone', 'agama' ),
                    'pinterest'     => esc_attr__( 'Pinterest', 'agama' ),
                    'reddit'        => esc_attr__( 'Reddit', 'agama' ),
                    'rss'           => esc_attr__( 'RSS', 'agama' ),
                    'skype'         => esc_attr__( 'Skype', 'agama' ),
                    'soundcloud'    => esc_attr__( 'SoundCloud', 'agama' ),
                    'spotify'       => esc_attr__( 'Spotify', 'agama' ),
                    'stack-overflow'=> esc_attr__( 'StackOverflow', 'agama' ),
                    'steam'         => esc_attr__( 'Steam', 'agama' ),
                    'stumbleupon'   => esc_attr__( 'Stumbleupon', 'agama' ),
                    'telegram'      => esc_attr__( 'Telegram', 'agama' ),
                    'tumblr'        => esc_attr__( 'Tumblr', 'agama' ),
                    'twitch'        => esc_attr__( 'Twitch', 'agama' ),
                    'twitter'       => esc_attr__( 'Twitter', 'agama' ),
                    'vimeo'         => esc_attr__( 'Vimeo', 'agama' ),
                    'vk'            => esc_attr__( 'VK', 'agama' ),
                    'yahoo'         => esc_attr__( 'Yahoo', 'agama' ),
                    'youtube'       => esc_attr__( 'YouTube', 'agama' )
                ]
            ],
            'url' => [
                'type'          => 'text',
                'label'         => esc_attr__( 'Page URL', 'agama' ),
                'description'   => esc_attr__( 'Add social icon page url.', 'agama' )
            ]
        ]
    ] );
###################################################################################
# SHARE ICONS
###################################################################################
    Kirki::add_section( 'agama_share_icons_section', array(
		'title'			=> esc_html__( 'Social Share', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 90,
	) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> esc_html__( 'Enable', 'agama' ),
		'tooltip'	    => esc_html__( 'Enable social share icons ?', 'agama' ),
		'section'		=> 'agama_share_icons_section',
		'settings'		=> 'agama_share_box',
		'type'			=> 'switch',
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> esc_html__( 'Visibility', 'agama' ),
		'tooltip'	    => esc_html__( 'Select where to show share box.', 'agama' ),
		'section'		=> 'agama_share_icons_section',
		'settings'		=> 'agama_share_box_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'posts'		=> esc_html__( 'Posts', 'agama' ),
			'pages'		=> esc_html__( 'Pages', 'agama' ),
			'all'		=> esc_html__( 'Post & Pages', 'agama' )
		),
		'default'		=> 'posts'
	) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Share Icons', 'agama' ),
        'tooltip'       => esc_html__( 'Enable and sort share icons per your own needs.', 'agama' ),
        'section'       => 'agama_share_icons_section',
        'settings'      => 'agama_social_share_icons',
        'type'          => 'sortable',
        'choices'       => array(
            'facebook'  => esc_html__( 'Facebook', 'agama' ),
            'twitter'   => esc_html__( 'Twitter', 'agama' ),
            'pinterest' => esc_html__( 'Pinterest', 'agama' ),
            'linkedin'  => esc_html__( 'LinkedIn', 'agama' ),
            'rss'       => esc_html__( 'RSS', 'agama' ),
            'email'     => esc_html__( 'Email', 'agama' )
        ),
        'default'       => array(
            'facebook',
            'twitter',
            'pinterest',
            'linkedin',
            'rss',
            'email'
        )
    ) );
###################################################################################
# WIDGETS PANEL
###################################################################################
    Kirki::add_panel( 'widgets', array(
		'title'			=> __( 'Widgets', 'agama' ),
		'priority'		=> 120
	) );
###################################################################################
# FOOTER
###################################################################################
	Kirki::add_section( 'agama_footer_section', [
		'title'			=> esc_html__( 'Footer', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'priority'      => 130
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Enable footer social icons?', 'agama' ),
		'tooltip'	        => esc_attr__( 'Enable social icons in footer right area.', 'agama' ),
		'section'		    => 'agama_footer_section',
		'settings'		    => 'agama_footer_social',
		'type'			    => 'checkbox',
		'default'		    => true,
        'partial_refresh'   => [
            'agama_footer_social' => [
                'selector'        => '#agama-footer div.social',
                'render_callback' => [ 'Agama_Partial_Refresh', 'preview_footer_social_icons' ]
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Copyright', 'agama' ),
		'tooltip'	        => __( 'Add custom copyright text in footer area.', 'agama' ),
		'section'		    => 'agama_footer_section',
		'settings'		    => 'agama_footer_copyright',
		'type'			    => 'code',
		'choices'		    => [
			'language'	    => 'html'
		],
		'default'		    => '',
        'partial_refresh'   => [
            'agama_footer_copyright' => [
                'selector'        => '#agama-footer div.site-info',
                'render_callback' => [ 'Agama_Partial_Refresh', 'preview_footer_copyright' ]
            ]
        ]
	] );
#######################################
# REMOVE SECTIONS
#######################################
    Kirki::remove_section( 'background_image' );
    Kirki::remove_section( 'colors' );

/**
 * Generating Dynamic CSS
 *
 * @since Agama 1.0
 */
function agama_customize_css() { ?>
	<style type="text/css" id="agama-customize-css">
    <?php $mobile_nav = get_theme_mod( 'agama_mobile_navigation_font', array( 'color' => '#757575' ) ); ?>
    #agama-mobile-nav ul > li.menu-item-has-children > .dropdown-toggle,
    #agama-mobile-nav ul > li.menu-item-has-children > .dropdown-toggle.collapsed {
        color: <?php echo $mobile_nav['color']; ?>;
    }
        
    <?php if( is_page_template( 'templates/template-fluid.php' ) ): ?>
    div#page { padding: 0; }
    .vision-row { max-width: 100%; }
    <?php endif; ?>
	
	<?php 
	if( 
		! get_theme_mod( 'agama_blog_post_meta', true ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'list' || 
		! get_theme_mod( 'agama_blog_post_date', true ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'list'
	): ?>
	.list-style .entry-content { margin-left: 0 !important; }
	<?php endif; ?>
	
	.sm-form-control:focus {
		border: 2px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?> !important;
	}
	
	.entry-content .more-link {
		border-bottom: 1px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
		color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.comment-content .comment-author cite {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
		border: 1px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	#respond #submit {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	<?php if( is_rtl() ): ?>
	blockquote {
		border-right: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	<?php else: ?>
	blockquote {
		border-left: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	<?php endif; ?>
	
	#page-title a:hover { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>; }
	
	.breadcrumb a:hover { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>; }
	
	<?php if( get_theme_mod('agama_blog_infinite_scroll', false) && get_theme_mod('agama_blog_layout', 'list') == 'grid' ): ?>
	#infscr-loading {
		position: absolute;
		bottom: 0;
		left: 25%;
	}
	<?php endif; ?>
	
	button,
	.button,
	.entry-date .date-box {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.button-3d:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.entry-date .format-box i {
		color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.vision_tabs #tabs li.active a {
		border-top: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	#toTop:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.footer-widgets .widget-title:after {
		background: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'agama_customize_css' );

/**
 * Styling Agama Support Section
 *
 * @since 1.0.7
 */
function customize_styles_agama_support( $input ) { ?>
	<style type="text/css">
		a:-webkit-any-link {
			text-decoration: none;
		}
        .accordion-section.control-section h3:before,
        .accordion-section.control-section.control-panel.control-panel-default h3:before,
        .accordion-section.control-section.control-section-kirki-default h3:before {
            font-family: FontAwesome;
        }
        #accordion-section-title_tagline h3:before {
            content: '\f2ba';
        }
        #accordion-panel-agama_general_panel h3:before {
            content: '\f085';
        }
        #accordion-panel-agama_typography_panel h3:before {
            content: '\f031';
        }
        #accordion-panel-agama_colors_panel h3:before {
            content: '\f1fc';
        }
        #accordion-panel-agama_layout_panel h3:before {
            content: '\f0db';
        }
        #accordion-panel-agama_header_panel h3:before {
            content: '\f1dc';
        }
        #accordion-panel-agama_nav_panel h3:before {
            content: '\f0c9';
        }
        #accordion-panel-agama_slider_panel h3:before {
            content: '\f1de';
        }
        #accordion-section-agama_breadcrumb_section h3:before {
            content: '\f09d';
        }
        #accordion-panel-agama_frontpage_boxes_panel h3:before {
            content: '\f009';
        }
        #accordion-panel-agama_blog_panel h3:before {
            content: '\f1ad';
        }
        #accordion-panel-agama_styling_panel h3:before {
            content: '\f1fc';
        }
        #accordion-section-agama_social_icons_section h3:before {
            content: '\f230';
        }
        #accordion-section-agama_share_icons_section h3:before {
            content: '\f1e0';
        }
        #accordion-panel-woocommerce h3:before {
            content: '\f291';
        }
        #accordion-section-agama_footer_section h3:before {
            content: '\f2d1';
        }
        #accordion-panel-nav_menus h3:before {
            content: '\f0c9';
        }
        #accordion-panel-widgets h3:before {
            content: '\f0ca';
        }
		.theme-headers label > input[type="radio"] {
		  display:none;
		}
		.theme-headers label > input[type="radio"] + img{
		  cursor:pointer;
		  border:2px solid transparent;
		}
		.theme-headers label > input[type="radio"]:checked + img{
		  border:2px solid #f00;
		}
		.agama-customize-heading h3 {
			border: 1px dashed #4A73AA;
			font-weight: 600;
			text-align: center;
			color: #4A73AA;
		}
		/* Override WordPress Customizer Defaults */
		#customize-controls .customize-info .customize-help-toggle:focus, 
		#customize-controls .customize-info .customize-help-toggle:hover, 
		#customize-controls .customize-info.open .customize-help-toggle {
			color: #0085ba;
		}
		#available-menu-items .item-add:focus:before, 
		#customize-controls .customize-info .customize-help-toggle:focus:before, 
		.customize-screen-options-toggle:focus:before, .menu-delete:focus, 
		.menu-item-bar .item-delete:focus:before, 
		.wp-customizer .menu-item .submitbox .submitdelete:focus, 
		.wp-customizer button:focus .toggle-indicator:after {
			-webkit-box-shadow: 0 0 0 1px #0085ba, 0 0 2px 1px <?php echo Agama_Helper::hex2rgba( '#ac32e4', 0.8 ); ?>;
			box-shadow: 0 0 0 1px #0085ba, 0 0 2px 1px <?php echo Agama_Helper::hex2rgba( '#ac32e4', 0.8 ); ?>;
		}
		#customize-controls .control-section .accordion-section-title:focus, 
		#customize-controls .control-section .accordion-section-title:hover, 
		#customize-controls .control-section.open .accordion-section-title, 
		#customize-controls .control-section:hover>.accordion-section-title {
			border-left-color: #0085ba;
			color: #0085ba;
		}
		.customize-panel-back:focus, 
		.customize-panel-back:hover, 
		.customize-section-back:focus, 
		.customize-section-back:hover {
			border-left-color: #0085ba;
			color: #0085ba;
		}
		#customize-theme-controls .control-section .accordion-section-title:focus:after, 
		#customize-theme-controls .control-section .accordion-section-title:hover:after, 
		#customize-theme-controls .control-section.open .accordion-section-title:after, 
		#customize-theme-controls .control-section:hover > .accordion-section-title:after {
			color: #0085ba;
		}
		.customize-controls-close:focus, 
		.customize-controls-close:hover, 
		.customize-controls-preview-toggle:focus, 
		.customize-controls-preview-toggle:hover {
			border-top-color: #0085ba;
			color: #0085ba;
		}
		/* Override Kirki Default Colors */
		.kirki-reset-section:hover, 
		.kirki-reset-section:active {
			background: #ac32e4 !important;
		}
		/* Theme Info */
		ul.theme-info li {
			background: #dedede;
			padding: 5px 10px;
			margin-bottom: 1px;
		}
		ul.theme-info li:hover {
			background: #eee;
		}
		ul.theme-info li a {
			font-weight: 500;
			color: #555d66;
		}
        .dd-options li {
            margin-bottom: 0;
        }
        #input_agama_media_logo {
            display: block;
            text-align: center;
        }
        #input_agama_media_logo label {
            padding-right: 20px;
        }
        #input_agama_media_logo label:last-child {
            padding-right: 0;
        }
        #input_agama_media_logo label img {
            padding: 5px;
        }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'customize_styles_agama_support');
