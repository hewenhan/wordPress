<?php 
/**
 * Slider
 *
 * The Agama slider class.
 *
 * @author      Theme Vision <support@theme-vision.com>
 * @package     Theme Vision
 * @subpackage  Agama
 * @since       1.2.9
 * @since       1.6.0 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Slider {
    
    /**
     * Visibility
     *
     * The slider visibility.
     *
     * @since 1.6.0
     * @return string
     */
    protected $visibility;
    
    /**
     * Particles
     *
     * Check if the slider particles are enabled.
     *
     * @since 1.6.0
     * @return bool
     */
    protected $particles;
    
    /**
     * Slides
     *
     * The slider array slides holder.
     *
     * @since 1.6.0
     * @return array
     */
    protected $slides;
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.6.0
     * @access public
     * @return null|object
     */
    public static $instance = null;
    
    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.6.0
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
        
        $this->visibility = get_theme_mod( 'agama_slider_visibility', 'homepage' );
        $this->particles = get_theme_mod( 'agama_slider_particles', true );
        $this->slides = get_theme_mod( 'agama_slider_slides_repeater', [] );
        
        /**
         * Render the content.
         */
        $this->render_content();
        
    }
    
    /**
     * Visibility
     *
     * Check where the slider should be shown.
     *
     * @since 1.6.0
     * @access private
     * @return bool
     */
    private function visibility() {
        if ( 'homepage' == $this->visibility && is_home() || 'frontpage' == $this->visibility && is_front_page() ) {
            return true;
        }
        return false;
    }
    
    /**
     * Image
     *
     * Format the image properly for use in img src attribute.
     *
     * @param int|string (required) The image ID or URL.
     *
     * @since 1.6.0
     * @access private
     * @return string
     */
    private function image( $image ) {
        if ( is_numeric( $image ) ) {
            $URL = wp_get_attachment_image_src( $image, 'full' );
            $URL = $URL[0]; // Return the attachment URL.
        } else {
            $URL = $image;
        }
        return $URL;
    }
    
    /**
     * Title Attributes
     *
     * Format the slider title attributes.
     *
     * @param array $slide (required) The slide arguments.
     *
     * @since 1.6.0
     * @access private
     * @return string
     */
    private function title_attributes( $slide ) {
        if ( ! empty( $slide['title_animation'] ) ) {
            $class = 'slide-title animated ' . $slide['title_animation'];
        } else {
            $class = 'slide-title';
        }
        
        $attributes['class'] = 'class="' . esc_attr( $class ) .'"';
        
        if ( ! empty( $slide['title_color'] ) ) {
            $attributes['color'] = 'style="color:' . esc_attr( $slide['title_color'] ) .';"';
        }
        
        echo implode( ' ', $attributes );
    }
    
    /**
     * Button Attributes
     *
     * Format the slider button attributes.
     *
     * @param array $slide (required) The slide arguments.
     *
     * @since 1.6.0
     * @access private
     * @return string
     */
    private function button_attributes( $slide ) {
        if ( ! empty( $slide['button_link'] ) ) {
            $attributes['href'] = 'href="' . esc_url( $slide['button_link'] ) .'"';
        } else {
            $attributes['href'] = 'href="#"';    
        }
        
        if ( ! empty( $slide['button_animation'] ) ) {
            $class = 'button button-3d button-rounded button-xlarge animated ' . $slide['button_animation'];
        } else {
            $class = 'button button-3d button-rounded button-xlarge';
        }
        
        $attributes['class'] = 'class="' . esc_attr( $class ) .'"';
        
        if ( ! empty( $slide['button_color'] ) ) {
            $attributes['color'] = 'style="color:'. esc_attr( $slide['button_color'] ) .';border-color:'. esc_attr( $slide['button_color'] ) .';"';
        }
        
        $attributes['onmouseover'] = "onmouseover=this.style.color='#fff';this.style.backgroundColor='{$slide['button_color']}'";
        $attributes['onmouseout'] = "onmouseout=this.style.color='{$slide['button_color']}';this.style.backgroundColor='transparent'";
        
        echo implode( ' ', $attributes );
    }
    
    /**
     * Render Content
     *
     * Render the front page boxes content.
     *
     * @since 1.6.0
     * @access private
     * @return mixed
     */
    private function render_content() {
        if ( ! empty( $this->slides ) && $this->visibility() ) : ?>
            <div id="agama-slider-wrapper">
                
                <?php if ( $this->particles ) : ?>
                    <div id="particles-js" class="agama-particles"></div>
                <?php endif; ?>
                
                <div id="agama_slider" class="camera_wrap">
                    <?php foreach ( $this->slides as $slide ) : ?>
                        
                        <div data-src="<?php echo esc_url( $this->image( $slide['image'] ) ); ?>" 
                             data-alt="<?php echo esc_attr( $slide['title'] ); ?>">
                            <div class="slide-content">
                                <div class="slide-content-cell">
                                    <div class="tv-container">
                                        <div class="tv-row">
                                            <div class="tv-col-md-12 tv-col-sm-12 tv-col-xs-12">
                                                
                                                <?php if ( ! empty( $slide['title'] ) ) : ?>
                                                    <h2 <?php $this->title_attributes( $slide ); ?>>
														<?php echo esc_html( $slide['title'] ); ?>
													</h2>
                                                <?php endif; ?>
                                                
                                                <?php if ( ! empty( $slide['button_title'] ) ) : ?>
                                                    <a <?php $this->button_attributes( $slide ); ?>>
                                                        <?php echo esc_html( $slide['button_title'] ); ?>
                                                    </a>
                                                <?php endif; ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <?php endforeach; ?>
                </div>
                
            </div>
        <?php
        endif;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
