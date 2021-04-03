<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<div class="agama-header-overlay">
    
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
    
</div>
