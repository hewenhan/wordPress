<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #agama-main-wrapper and #page div elements.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Hook: agama/after_content
 *
 * @hooked none
 *
 * @since 1.5.8
 */
do_action( 'agama/after_content' ); ?>
</div><!-- .vision-row.tv-row -->
</div><!-- #main.wrapper -->
</div><!-- #page.site -->

    <?php
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
        get_template_part( 'template-parts/footer' );
    } ?>
	
</div><!-- #agama-main-wrapper -->

<?php if( get_theme_mod('agama_to_top', true) ): ?>
	<?php echo sprintf( '<a id="%s"><i class="%s"></i></a>', 'toTop', 'fa fa-angle-up' ); ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>