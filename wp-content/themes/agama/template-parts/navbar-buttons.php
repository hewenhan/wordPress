<?php
/**
 * Navbar Buttons
 *
 * The header navbar buttons.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.6.1
 */

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $woocommerce;

$mobile_menu_label = get_theme_mod( 'agama_nav_mobile_icon_title', '' ); 

if ( class_exists( 'woocommerce' ) ) {
    $default = [ 'search', 'cart', 'mobile' ];
    $cart_link = wc_get_cart_url();
} else {
    $default = [ 'search', 'mobile' ];
    $cart_link = '#';
}

$navbar_buttons = get_theme_mod( 'agama_navbar_buttons', $default );
$navbar_buttons = array_map( 'esc_attr', $navbar_buttons );

if ( get_theme_mod( 'agama_navbar_buttons_shadow', false ) ) {
    $class = 'shadow-none';
} else {
    $class = '';
} ?>

<?php if ( ! empty( $navbar_buttons ) ) : ?>

<div>

    <?php
    if ( has_action( 'agama_before_navbar_buttons' ) ) {
        /**
         * Hook: agama_before_navbar_buttons
         *
         * @hooked none
         *
         * @since 1.6.1
         */
        do_action( 'agama_before_navbar_buttons' );
    } ?>
    
    <ul class="navbar-buttons tv-d-inline-block tv-align-middle <?php echo esc_attr( $class ); ?>">
        <?php foreach ( $navbar_buttons as $navbar_button ) : ?>
        
            <?php if ( 'search' == $navbar_button ) : ?>
            <li class="navbar-button navbar-button-search">
                <a href="#fs-search" class="search-trigger" data-toggle="fullscreen-overlay"><i class="fa fa-search"></i></a>
            </li>
            <?php endif; ?>
        
            <?php if ( 'cart' == $navbar_button && class_exists( 'woocommerce' ) ) : ?>
            <li class="navbar-button navbar-button-cart">
                <a href="<?php echo esc_url( $cart_link ); ?>" data-toggle="offcanvas"><i class="fa fa-shopping-basket"></i></a>
                <span class="badge badge-danger"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
            </li>
            <?php endif; ?>
            
            <?php if ( 'mobile' == $navbar_button ) : ?>
            <li class="navbar-button navbar-button-mobile tv-d-block tv-d-lg-none">
                <a href="#mobile-menu" class="mobile-menu-toggle toggle--elastic">
                    <span class="mobile-menu-toggle-box"><span class="mobile-menu-toggle-inner"></span></span>
                    <span class="mobile-menu-toggle-label"><?php echo esc_html( $mobile_menu_label ); ?></span>
                </a>
            </li>
            <?php endif; ?>
        
        <?php endforeach; ?>
    </ul><!-- .navbar-buttons -->
    
    <?php

    if ( has_action( 'agama_after_navbar_buttons' ) ) {
        /**
         * Hook: agama_after_navbar_buttons
         *
         * @hooked none
         *
         * @since 1.6.1
         */
        do_action( 'agama_after_navbar_buttons' );
    } ?>
    
</div>

<?php endif; ?>
    