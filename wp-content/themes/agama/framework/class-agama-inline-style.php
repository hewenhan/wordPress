<?php
/**
 * Inline Style
 *
 * The Agama theme inline style.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.5.3
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit; 
}

class Inline_Style {
    
    /**
     * Init
     * 
     * Initialize the Agama theme inline style.
     *
     * @since 1.5.3
     * @access public
     * @return string
     */
    public static function init() {
        $css  = '';
        $css .= self::body();
        $css .= self::header_image();
        $css .= self::footer_widgets();
        $css .= self::footer();
        
        return apply_filters( 'agama/inline_css', $css );
    }
    
    /**
     * Body
     *
     * The Agama theme body background colors.
     *
     * @since 1.6.0
     * @access private
     * @return mixed
     */
    private static function body() {
        $background = get_theme_mod( 
            'agama_body_background_colors', 
            [
                'left'  => '#e6e6e6',
                'right' => '#e6e6e6'
            ]
        );
        
        // Sanitize colors.
        $background = array_map( 'esc_attr', $background );
        
        $css  = 'body {';
        $css .= 'background: linear-gradient( to right, ';
        $css .= $background['left'] . ' 0, ';
        $css .= $background['right'] . ' 100%)';
        $css .= '}';
        
        return ! empty( $css ) ? $css : '';
    }
    
    /**
     * Header Image
     *
     * The Agama theme header image inline style.
     *
     * @since 1.5.3
     * @access private
     * @return mixed
     */
    private static function header_image() {
        $overlay = get_theme_mod( 'agama_header_image_overlay', true );
        $background = get_theme_mod( 'agama_header_image_background', [
            'left'  => 'rgba(160,47,212,0.8)',
            'right' => 'rgba(69,104,220,0.8)'
        ] );
        
        $header_image = esc_url( get_header_image() );
        
        if( $overlay && $header_image ) {
            $css = "#agama-header-image .header-image {
                background-image: linear-gradient(to right, {$background['left']}, {$background['right']}), url({$header_image});
            }";
        }
        else
        if( ! $overlay && $header_image ) {
            $css = "#agama-header-image .header-image {
                background-image: url({$header_image});
            }";
        }
        
        return ! empty( $css ) ? $css : '';
    }
    
    /**
     * Footer Widgets
     *
     * The Agama theme footer widgets area inline style.
     *
     * @since 1.6.0
     * @access private
     * @return mixed
     */
    private static function footer_widgets() {
        $background = get_theme_mod( 
            'agama_footer_widgets_background_colors', 
            [
                'left'  => '#314150',
                'right' => '#314150'
            ]
        );
        
        // Sanitize colors.
        $background = array_map( 'esc_attr', $background );
        
        $css  = '.footer-widgets {';
        $css .= 'background: linear-gradient( to right, ';
        $css .= $background['left'] . ' 0, ';
        $css .= $background['right'] . ' 100%)';
        $css .= '}';
        
        return ! empty( $css ) ? $css : '';
    }
    
    /**
     * Footer
     *
     * The Agama theme footer inline style.
     *
     * @since 1.6.0
     * @access private
     * @return mixed
     */
    private static function footer() {
        $background = get_theme_mod( 
            'agama_footer_background_colors', 
            [
                'left'  => '#293744',
                'right' => '#293744'
            ]
        );
        
        // Sanitize colors.
        $background = array_map( 'esc_attr', $background );
        
        $css  = '#agama-footer {';
        $css .= 'background: linear-gradient( to right, ';
        $css .= $background['left'] . ' 0, ';
        $css .= $background['right'] . ' 100%)';
        $css .= '}';
        
        return ! empty( $css ) ? $css : '';
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
