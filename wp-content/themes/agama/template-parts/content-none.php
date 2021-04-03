<?php
/**
 * The template used for displaying page content in page.php
 *
 * @author      Theme Vision <support@theme-vision.com>
 * @package     Agama
 * @since       1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<article id="post-0" class="post no-results not-found">
    <?php if ( current_user_can( 'edit_posts' ) ) : // Show a different message to a logged-in user who can add posts. ?>
    
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'No posts to display', 'agama' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'agama' ), admin_url( 'post-new.php' ) ); ?></p>
        </div>

    <?php else : // Show the default message to everyone else. ?>
    
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'agama' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'agama' ); ?></p>
            <?php get_search_form(); ?>
        </div>
    
    <?php endif; ?>
</article>
