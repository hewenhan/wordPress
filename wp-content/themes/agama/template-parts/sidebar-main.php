<?php
/**
 * The template for displaying sidebar.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} 

if ( is_active_sidebar( 'sidebar-1' ) ) {
    
    dynamic_sidebar( 'sidebar-1' );
    
}
