<?php
/**
 * Upsell Field
 *
 * The customizer upsell field control.
 *
 * @author Theme Vision <support@theme-vision.com>
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.5.8
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the upsell field control.
 *
 * @since 1.5.8
 */
add_action( 'customize_register', function( $wp_customize ) {
    class Kirki_Controls_Agama_Upsell_Field_Control extends WP_Customize_Control {
        public $type = 'agama-upsell';
        public function render_content() { ?>
            <div class="themevision-upsell themevision-boxed-section control-subsection">
                <ul class="themevision-upsell-features">
                    <?php if ( is_array( $this->value() ) ) : foreach ( $this->value() as $label ) : ?>
                    <li><span class="upsell-pro-label"></span> <?php echo esc_html( $label ); ?></li>
                    <?php endforeach; else : ?>
                    <li><span class="upsell-pro-label"></span> <?php echo esc_html( $this->value() ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php
        }
    }
    /**
     * Register our custom control with Kirki
     */
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['agama-upsell'] = 'Kirki_Controls_Agama_Upsell_Field_Control';
		return $controls;
	});
} );
