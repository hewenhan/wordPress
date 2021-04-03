<?php
/**
 * The Header template
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */ 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
    
<a class="screen-reader-text skip-link" href="#page">
    <?php esc_html_e( 'Skip to content', 'agama' ); ?>
</a><!-- .screen-reader-text -->

<div id="agama-main-wrapper" class="<?php Agama::main_wrapper_class(); ?>">
    
    <?php
    /**
     * Hook: agama/before_header_wrapper
     *
     * @hooked none
     *
     * @since 1.4.4
     */
    do_action( 'agama/before_header_wrapper' );
    
    /**
     * The Header
     */
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
        get_template_part( 'template-parts/header' );
    }
    
    /**
     * Hook: agama/after_header_wrapper
     *
     * @hooked agama_header_image - 10
     * @hooked agama_slider - 20
     * @hooked agama_breadcrumb - 30
     *
     * @since 1.4.4
     */
    do_action( 'agama/after_header_wrapper' ); ?>

	<div id="page" class="hfeed site">
		<div id="main" class="wrapper"> 
			<div class="vision-row tv-row">
                <?php
                /**
                 * Hook: agama/before_content
                 *
                 * @hooked agama_frontpage_boxes - 10
                 *
                 * @since 1.5.8
                 */
                do_action( 'agama/before_content' ); ?>
				