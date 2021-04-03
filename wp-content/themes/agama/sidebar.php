<?php
/**
 * The Sidebar
 *
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$class[] = 'widget-area tv-col-md-3';

if ( 'right' == agama_sidebar_position() ) {
    $class[] = 'tv-order-2';
} else if ( 'left' == agama_sidebar_position() ) {
    $class[] = 'tv-order-1';
} ?>

<div id="secondary" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" role="complementary"><?php 
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'main-sidebar' ) ) {
        get_template_part( 'template-parts/sidebar', 'main' );
    }
    ?>
</div>
