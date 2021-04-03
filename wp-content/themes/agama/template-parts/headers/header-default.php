<?php

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

    <hgroup id="agama-logo" class="tv-d-block">
        <div class="tv-container tv-d-flex tv-justify-content-between tv-align-items-center">
            <div class="tv-d-block">
                <?php agama_logo(); ?>
            </div>
            <?php get_template_part( 'template-parts/navbar', 'buttons' ); ?>
        </div>
    </hgroup><!-- #agama-logo -->

    <nav id="agama-primary-nav" class="tv-d-none tv-d-lg-block" role="navigation">
        <div class="tv-container">
            <div class="tv-row">
                <?php echo Agama::menu( 'primary', 'agama-navigation' ); ?>
            </div>
        </div>
    </nav><!-- #agama-primary-nav -->

    <nav id="agama-mobile-nav" class="mobile-menu tv-collapse" role="navigation">
        <?php echo Agama::menu( 'primary', 'menu' ); ?>
    </nav><!-- #agama-mobile-nav -->
    
</div><!-- .agama-header-overlay -->
