/**
 * File customize-controls.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function( $ ) {
    
    // Media Devices Logo
    wp.customize( 'agama_media_logo', function( value ) {
        value.bind( function( device ) {
            if( device == 'desktop' ) {
                $('.devices .preview-desktop').click();
            }
            if( device == 'tablet' ) {
                $('.devices .preview-tablet').click();
            }
            if( device == 'mobile' ) {
                $('.devices .preview-mobile').click();
            }
        });
    });
    
})( jQuery );
