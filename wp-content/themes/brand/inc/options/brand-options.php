<?php
function brand_settings_page() {
    add_theme_page(
        'Brand',
        'Brand',
        'edit_theme_options',
        'brand_setting_page',
        'brand_render_settings_page'
      );
}

function brand_render_settings_page() {
  if( ! current_user_can( 'edit_theme_options' ) ) {
    return;
  }
  ?>
  <div class="wrap">
    <h2 class="plugin-title">Brand Theme <?php echo BRAND_VER // WPCS: XSS ok. ?> </h2>
    <div class="subscribe">
          <h2> GETTING STARTED </h2>
      <p class="description"> <?php esc_html_e( 'Start build your site with Brand theme using the Customizer.', 'brand' ) ?> </p>
      <p class="button-link">
        <a href="<?php echo esc_url( admin_url( 'customize.php' ) ) ?>" class="button button-primary"> Customize </a>
      </p>
      <div class="clearfix"></div>
    </div>
    <div class="support">
          <h2> SUPPORT </h2>
      <h4> Need help? Our team is here for you. </h4>
      <p class="description"> <?php esc_html_e( 'We offer free, full support for Brand Theme. We will answer you as soon as possible.', 'brand' ) ?> </p>
      <p>
        <a href="https://www.wp-brandtheme.com/documentation/" target="_blank">View Brand documentation </a>
        <a href="https://www.wp-brandtheme.com/forums/forum/brand-theme/" target="_blank"> Ask in the forum </a>
      </p>
    </div>
    <div class="subscribe">
          <h2> SUBSCRIBE </h2>
      <p class="description"> <?php esc_html_e( 'Get news and updates about your theme.', 'brand' ) ?> </p>
      <p class="button-link">
        <a href="https://www.wp-brandtheme.com/subscribe/" id="brand-subscribe-btn" target="_blank" class="button button-primary"> Subscribe Now </a>
      </p>
      <div class="clearfix"></div>
    </div>
  </div>
  <?php
}
add_action( 'admin_menu', 'brand_settings_page' );
