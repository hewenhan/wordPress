/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */

( function( $ ) {
    
    // Site Title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
    
    // Site Description
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
    
    // Body background colors.
    wp.customize( 'agama_body_background_colors', function( value ) {
        value.bind( function( color ) {
            $('body').css({
                'background': 'linear-gradient(to right, '
                    .concat( color.left ).concat( ' 0, ' )
                    .concat( color.right ).concat( ' 100%)' )
            });
        } );
    } );
    
    // Navbar Buttons Shadow
    wp.customize( 'agama_navbar_buttons_shadow', function( value ) {
        value.bind( function( disabled ) {
            if ( disabled ) {
                if ( ! $('#masthead ul.navbar-buttons').hasClass( 'shadow-none' ) ) {
                    $('#masthead ul.navbar-buttons').addClass( 'shadow-none' );
                }
            } else {
                if ( $('#masthead ul.navbar-buttons').hasClass( 'shadow-none' ) ) {
                    $('#masthead ul.navbar-buttons').removeClass( 'shadow-none' );
                }
            }
        } );
    } );
    
    // Header image background overlay.
    wp.customize( 'agama_header_image_background', function( value ) {
        value.bind( function( color ) {
            var header_image = wp.customize.get().header_image;
            $('#agama-header-image .header-image').css({
                'background': 'linear-gradient(to right, '
                    .concat( color.left ).concat( ' 0, ' )
                    .concat( color.right ).concat( ' 100%), url('+ header_image +')' )
            });
        } );
    } );
    
    // Layout Style
    wp.customize( 'agama_layout_style', function( value ) {
        value.bind( function( to ) {
            if( 'fullwidth' === to ) {
                $('#agama-main-wrapper').removeClass( 'tv-container tv-p-0' ).addClass( 'is-full-width' );
            } else if( 'boxed' === to ) {
                $('#agama-main-wrapper').removeClass( 'is-full-width' ).addClass( 'tv-container tv-p-0' );
            }
        } );
    } );
    
    // Sidebar Position
    wp.customize( 'agama_sidebar_position', function( value ) {
        value.bind( function( position ) {
            if ( 'left' == position ) {
                if ( $('#primary').hasClass( 'tv-order-1' ) ) {
                    $('#primary').removeClass( 'tv-order-1' ).addClass( 'tv-order-2' );
                }
                if ( $('#secondary').hasClass( 'tv-order-2' ) ) {
                    $('#secondary').removeClass( 'tv-order-2' ).addClass( 'tv-order-1' );
                }
            } else if ( 'right' == position ) {
                if ( $('#primary').hasClass( 'tv-order-2' ) ) {
                    $('#primary').removeClass( 'tv-order-2' ).addClass( 'tv-order-1' );
                }
                if ( $('#secondary').hasClass( 'tv-order-1' ) ) {
                    $('#secondary').removeClass( 'tv-order-1' ).addClass( 'tv-order-2' );
                }
            }
        } );
    } );
    
    // Footer widgets background colors.
    wp.customize( 'agama_footer_widgets_background_colors', function( value ) {
        value.bind( function( color ) {
            $('.footer-widgets').css({
                'background': 'linear-gradient(to right, '
                    .concat( color.left ).concat( ' 0, ' )
                    .concat( color.right ).concat( ' 100%)' )
            });
        } );
    } );
    
    // Footer background colors.
    wp.customize( 'agama_footer_background_colors', function( value ) {
        value.bind( function( color ) {
            $('#agama-footer').css({
                'background': 'linear-gradient(to right, '
                    .concat( color.left ).concat( ' 0, ' )
                    .concat( color.right ).concat( ' 100%)' )
            });
        } );
    } );
})( jQuery );
