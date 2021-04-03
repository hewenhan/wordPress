<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Agama_Partial_Refresh {
    
    /**
     * Top Navigation Enable / Disable
     *
     * @since 1.3.1
     */
    function preview_top_navigation() {
        if( get_theme_mod( 'agama_top_navigation', true ) ) {
            return Agama::menu( 'top', 'agama-navigation' );
        }
    }
    
    /**
     * Top Navigation Social Icons Enable / Disable
     *
     * @since 1.3.1
     */
    function preview_top_nav_social_icons() {
        if( get_theme_mod( 'agama_top_nav_social', true ) ) {
            Agama::social_icons( false, 'animated' );
        }
    }
    
    /**
     * Logo Desktop Preview
     *
     * @since 1.3.1
     * @return mixed
     */
    function preview_logo() {
        $desktop = esc_url( get_theme_mod( 'agama_logo' ) );
        
        if( $desktop ) {
            agama_logo();
        } else {
            echo '<h1 class="site-title">';
                echo '<a href="'. esc_url( home_url( '/' ) ) .'" ';
                echo 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">';    
                    echo get_bloginfo( 'name' );
                echo '</a>';
            echo '</h1>';
        }
    }
    
    /**
     * Logo Tablet Preview
     *
     * @since 1.3.9
     * @return mixed
     */
    function preview_logo_tablet() {
        $tablet = esc_url( get_theme_mod( 'agama_tablet_logo' ) );
        
        if( $tablet ) {
            agama_logo();
        } else {
            echo '<h1 class="site-title">';
                echo '<a href="'. esc_url( home_url( '/' ) ) .'" ';
                echo 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">';    
                    echo get_bloginfo( 'name' );
                echo '</a>';
            echo '</h1>';
        }
    }
    
    /**
     * Logo Mobile Preview
     *
     * @since 1.3.9
     * @return mixed
     */
    function preview_logo_mobile() {
        $mobile = esc_url( get_theme_mod( 'agama_mobilelogo' ) );
        
        if( $mobile ) {
            agama_logo();
        } else {
            echo '<h1 class="site-title">';
                echo '<a href="'. esc_url( home_url( '/' ) ) .'" ';
                echo 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">';    
                    echo get_bloginfo( 'name' );
                echo '</a>';
            echo '</h1>';
        }
    }
    
    /**
     * Header Image
     *
     * The Agama theme header image partial.
     *
     * @since 1.5.3
     * @access public
     * @return mixed
     */
    public function header_image() { ?>
        <?php if( get_theme_mod( 'agama_header_image_overlay', true ) ) : ?>
        <div class="header-image" 
             style="background-image: linear-gradient(to right, rgba(69,104,220,0.8), rgba(176,106,179,0.8)), url(<?php echo esc_url( get_header_image() ); ?>);"></div>
        <?php else : ?>
        <div class="header-image" 
             style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);"></div>
        <?php endif; ?>
    <?php
    }
    
    /**
     * Enable Footer Social Icons
     *
     * @since 1.3.1
     */
    function preview_footer_social_icons() {
        if( get_theme_mod( 'agama_footer_social', true ) ) {
            Agama::social_icons('top');
        }
    }
    
    /**
     * Footer Copyright Text
     *
     * @since 1.3.1
     */
    function preview_footer_copyright() {
        do_action('agama_credits');
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
