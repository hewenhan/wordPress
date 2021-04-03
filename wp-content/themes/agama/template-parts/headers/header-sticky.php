<?php
/**
 * Header V3
 *
 * Display header v3.
 *
 * @author Theme Vision <support@theme-vision.com>
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

global $top_nav, $social_icons; ?>

<div class="agama-header-overlay">

    <div class="agama-top-nav-wrapper">
        <div class="tv-container tv-d-flex tv-justify-content-between tv-align-items-center">

            <?php if( $top_nav ): ?>
            <nav id="agama-top-nav" class="tv-d-none tv-d-lg-block" role="navigation">
                <?php echo Agama::menu( 'top', 'agama-navigation' ); ?>
            </nav>
            <?php endif; ?>

            <?php if( $social_icons ): ?>
            <div id="agama-top-social">
                <?php if( get_theme_mod( 'agama_top_nav_social', true ) ): ?>
                    <?php Agama::social_icons( false, 'animated' ); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div><!-- .agama-top-nav-wrapper -->

    <div class="tv-container tv-d-flex tv-justify-content-between tv-align-items-center">

        <div id="agama-logo">
            <?php agama_logo(); ?>
        </div><!-- #agama-logo -->

        <nav id="agama-primary-nav" class="tv-navbar tv-justify-content-end tv-justify-content-lg-between" role="navigation">
            <?php echo Agama::menu( 'primary', 'agama-navigation tv-navbar-nav tv-d-none tv-d-lg-block' ); ?>
        </nav><!-- #agama-primary-nav -->

    </div>

    <nav id="agama-mobile-nav" class="mobile-menu tv-collapse" role="navigaiton">
        <?php echo Agama::menu( 'mobile', 'menu' ); ?>
    </nav><!-- #agama-mobile-nav -->
    
</div><!-- .agama-header-overlay -->
