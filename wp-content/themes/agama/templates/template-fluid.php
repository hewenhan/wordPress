<?php
/**
 * Template Name: Template Fluid
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.3.8
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php get_header(); ?>

<div id="primary" class="site-content tv-container-fluid">
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template-parts/content', 'page' ); ?>

            <?php if( comments_open() ) : ?>
                <?php comments_template( '', true ); ?>
            <?php endif; ?>

        <?php endwhile; // end of the loop. ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
