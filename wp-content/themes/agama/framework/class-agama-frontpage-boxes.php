<?php
/**
 * Frontpage Boxes
 *
 * The Agama front page boxes class.
 *
 * @author      Theme Vision <support@theme-vision.com>
 * @package     Theme Vision
 * @subpackage  Agama
 * @since       1.1.6
 * @since       1.5.8 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Front_Page_Boxes {
    
    /**
     * Label
     *
     * The boxes heading holder.
     *
     * @since 1.5.8
     * @return string
     */
    protected $label;
    
    /**
     * Visibility
     *
     * The boxes visibility.
     *
     * @since 1.6.0
     * @return string
     */
    protected $visibility;
    
    /**
     * Boxes
     *
     * The boxes arguments holder.
     *
     * @since 1.5.8
     * @return array
     */
    protected $boxes;
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.5.8
     * @access public
     * @return null|object
     */
    public static $instance = null;
    
    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.5.8
     * @access public
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Class Constructor
     */
    function __construct() {
        
        $this->label = get_theme_mod( 'agama_frontpage_boxes_heading',  __( 'Front Page Boxes', 'agama' ) );
        $this->visibility = get_theme_mod( 'agama_frontpage_boxes_visibility', 'homepage' );
        $this->boxes = get_theme_mod( 'agama_frontpage_boxes_repeater', [] );
        
        /**
         * Render the content.
         */
        $this->render_content();
        
    }
    
    /**
     * Visibility
     *
     * Check where the front page should be shown.
     *
     * @since 1.6.0
     * @access private
     * @return bool
     */
    private function visibility() {
        if ( 
            'homepage' == $this->visibility && is_home() || 
            'frontpage' == $this->visibility && is_front_page() ||
            'allpages' == $this->visibility 
        ) {
            return true;
        }
        return false;
    }
    
    /**
     * Attributes
     *
     * Return the box wrapper attributes.
     *
     * @param array $box (required) The box settings.
     *
     * @since 1.5.8
     * @access private
     * @return string
     */
    private function attributes( $box ) {
        switch( count( $this->boxes ) ) {
            case '1' :
                $class = 'tv-col-md-12';
                break;
            case '2' : 
                $class = 'tv-col-md-6';
                break;
            case '3' : 
            case '6' :
                $class = 'tv-col-md-4';
                break;
            case '4' :
            case '8' :
                $class = 'tv-col-md-6 tv-col-lg-3';
                break;
            case '5' :
                $class = 'tv-col-md';
                break;
            case '7' :
                $class = 'tv-col-lg tv-col-md-4';
                break;
        }
        
        $attributes['class'] = 'class="agama-frontpage-box ' . esc_attr( $class ) . '"';
        
        if ( $box['animated'] ) {
            $attributes['animation'] = 'data-animate="' . esc_attr( $box['animation'] ) . '"';
            $attributes['delay'] = 'data-delay="' . esc_attr( $box['animation_delay'] ) . '"';
        }
        
        echo implode( ' ', $attributes );
    }
    
    /**
     * Image
     *
     * Format the image properly for use in img src attribute.
     *
     * @param int|string (required) The image ID or URL.
     *
     * @since 1.5.8
     * @access private
     * @return string
     */
    private function image( $image ) {
        if ( is_numeric( $image ) ) {
            $URL = wp_get_attachment_image_src( $image );
            $URL = $URL[0]; // Return the attachment URL.
        } else {
            $URL = $image;
        }
        return $URL;
    }
    
    /**
     * Icon Attributes
     *
     * Format the FontAwesome icon attributes.
     *
     * @param array $box (required) The box details.
     *
     * @since 1.5.8
     * @access private
     * @return string
     */
    private function icon_attributes( $box ) {
        $class = 'fa ' . $box['icon'];
        $attributes['class'] = 'class="' . esc_attr( $class ) . '"';
        
        if ( ! empty( $box['icon_color'] ) ) {
            $attributes['style'] = 'style="color:' . esc_attr( $box['icon_color'] ) .';"';
        }
        
        echo implode( ' ', $attributes );
    }
    
    /**
     * Render Content
     *
     * Render the front page boxes content.
     *
     * @since 1.5.8
     * @access private
     * @return mixed
     */
    private function render_content() {
        if ( ! empty( $this->boxes ) && $this->visibility() ) : ?>
            <div id="frontpage-boxes" class="tv-row">
                <?php if ( ! empty( $this->label ) ) : ?>
                    <div class="tv-col-md-12">
                        <h1><?php echo esc_html( $this->label ); ?></h1>
                    </div>
                <?php endif; ?>
                <?php foreach ( $this->boxes as $box ) : ?>
                    <div <?php $this->attributes( $box ); ?>>

                        <?php if ( $box['url'] ) : ?>
                        <a href="<?php echo esc_url( $box['url'] ); ?>">
                        <?php endif; ?>

                            <?php if ( ! empty( $box['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $this->image( $box['image'] ) ); ?>" 
                                 alt="<?php echo esc_attr( $box['title'] ); ?>">
                            <?php endif; ?>

                            <?php if ( ! empty( $box['icon'] ) ) : ?>
                            <i <?php $this->icon_attributes( $box ); ?>></i>
                            <?php endif; ?>

                        <?php if ( $box['url'] ) : ?>
                        </a>
                        <?php endif; ?>

                        <?php if ( ! empty( $box['title'] ) ) : ?>
                        <h2><?php echo esc_html( $box['title'] ); ?></h2>
                        <?php endif; ?>

                        <?php if ( ! empty( $box['text'] ) ) : ?>
                        <p><?php echo esc_html( $box['text'] ); ?></p>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div><!-- #frontpage-boxes -->
        <?php
        endif;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
