<?php
/**
 * The template for displaying footer.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) || is_active_sidebar( 'footer-widget-4' ) ): ?>
<div class="footer-widgets">
    <div class="tv-container">
        <div class="tv-row">

            <?php if( is_active_sidebar( 'footer-widget-1' ) ): ?>
            <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                <?php dynamic_sidebar( 'footer-widget-1' ); ?>
            </div>
            <?php endif; ?>

            <?php if( is_active_sidebar( 'footer-widget-2' ) ): ?>
            <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                <?php dynamic_sidebar( 'footer-widget-2' ); ?>
            </div>
            <?php endif; ?>

            <?php if( is_active_sidebar( 'footer-widget-3' ) ): ?>
            <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                <?php dynamic_sidebar( 'footer-widget-3' ); ?>
            </div>
            <?php endif; ?>

            <?php if( is_active_sidebar( 'footer-widget-4' ) ): ?>
            <div class="<?php Agama_Helper::get_fwidgets_bs_class(); ?>">
                <?php dynamic_sidebar( 'footer-widget-4' ); ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div><!-- .footer-widgets -->
<?php endif; ?>

<footer id="agama-footer" class="tv-d-block" role="contentinfo">
    <div class="tv-container tv-p-0 tv-d-flex tv-justify-content-between tv-align-items-center">

        <div class="site-info">
            <?php do_action('agama_credits'); ?>
        </div>

        <?php if( get_theme_mod('agama_footer_social', true) ): ?>
        <div class="social">
            <?php Agama::social_icons('top'); ?>
        </div>
        <?php endif; ?>

    </div>
</footer><!-- #agama-footer -->
