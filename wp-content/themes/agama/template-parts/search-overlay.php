<?php
/**
 * Search Box
 *
 * The header search box.
 *
 * @author  Theme Vision <support@theme-vision.com>
 * @package Agama
 * @since   1.6.1
 */

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} 

$navbar_buttons = get_theme_mod( 'agama_navbar_buttons', [ 'search', 'cart', 'mobile' ] );

$placeholder = esc_attr__( 'Search site...', 'agama' );

if ( class_exists( 'woocommerce' ) ) {
    if ( is_shop() ) {
        $placeholder = esc_attr__( 'Search products...', 'agama' );
    }
} ?>

<?php if ( in_array( 'search', $navbar_buttons ) ) : ?>
<div class="fs-overlay-wrapper" id="fs-search">
    <span class="fs-overlay-close"><i class="fa fa-times"></i></span>
    <div class="fs-overlay-inner">
        <div class="fs-overlay-content">
            <div class="tv-container">
                <form role="search" method="get" class="tv-input-group" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="tv-input-group-prepend">
                        <div class="tv-input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'Search for', 'agama' ) ?>" class="form-control" />
                    <?php if ( class_exists( 'woocommerce' ) && is_shop() ) : ?>
                        <input type="hidden" name="post_type" value="product" />
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
