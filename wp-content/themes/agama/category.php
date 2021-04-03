<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<section id="primary" class="site-content <?php echo esc_attr( Agama::bs_class() ); ?>">

    <div id="content" role="main"<?php Agama_Helper::get_blog_isotope_class(); ?>>

    <?php if ( have_posts() ) :

        /* Start the Loop */
        while ( have_posts() ) : the_post();

            /* Include the post format-specific template for the content. If you want to
             * this in a child theme then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'template-parts/content', get_post_format() );

        endwhile;

    else: 

        get_template_part( 'template-parts/content', 'none' );

    endif; ?>

    </div><!-- #content -->

    <?php agama_content_nav( 'nav-below' ); ?>
    <?php Agama_Helper::get_infinite_scroll_load_more_btn(); ?>

</section><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
