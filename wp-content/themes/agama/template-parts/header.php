<?php
/**
 * The template for displaying header.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} 

global $top_nav, $social_icons; 

$header       = esc_attr( get_theme_mod( 'agama_header_style', 'transparent' ) );
$top_nav      = esc_attr( get_theme_mod( 'agama_top_navigation', true ) );
$social_icons = esc_attr( get_theme_mod( 'agama_top_nav_social', true ) ); ?>

<header id="masthead" class="site-header <?php Agama::header_class(); ?>" itemscope itemtype="http://schema.org/WPHeader" role="banner">
<?php
    if ( 'transparent' == $header ) {
        get_template_part( 'template-parts/headers/header', 'transparent' );
    } else if ( 'sticky' == $header ) {
        get_template_part( 'template-parts/headers/header', 'sticky' );
    } else if ( 'default' == $header ) {
        get_template_part( 'template-parts/headers/header', 'default' );
    } 
?>
</header><!-- #masthead -->
