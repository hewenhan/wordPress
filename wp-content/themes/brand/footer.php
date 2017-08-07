<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Brand
 */

?>

    </div> <!-- #content -->
    <?php brand_get_footer_sidebars();
if( ! brand_is_hidden( 'footer' ) ) { ?>
    <div <?php brand_site_info_class('site-info') ?>>
      <div class="container">
		    <div class="row">
          <?php do_action( 'brand_site_info' ); ?>
		    </div>
      </div>
    </div> <!-- .site-info --> <?php
}
  wp_footer(); ?>

  </div> <!-- #wrapper -->

  </body>
</html>
