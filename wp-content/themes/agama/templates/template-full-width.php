<?php
/**
 * Template Name: Template Full Width
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

get_header(); ?>
	
<div id="primary" class="site-content tv-container tv-p-0">
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
