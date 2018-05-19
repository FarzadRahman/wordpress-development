/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	wp.customize( 'site_title', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).css('color', to );
		} );
	} );
	wp.customize( 'site_description', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css('color', to );
		} );
	} );
	wp.customize( 'body_text_color', function( value ) {
		value.bind( function( to ) {
			$( 'body, .widget, .widget a, .widget select' ).css('color', to );
		} );
	} );
	wp.customize( 'menu_bg', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation, .main-navigation ul ul' ).css('background-color', to );
		} );
	} );
	wp.customize( 'title_panels', function( value ) {
		value.bind( function( to ) {
			$( '.posts-wrapper .entry-header, .loop-ribbon' ).css('background-color', to );
		} );
	} );
	wp.customize( 'footer_bg', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer, .site-footer .container' ).css('background-color', to );
		} );
	} );
	wp.customize( 'header_bg', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css('background-color', to );
		} );
	} );
	wp.customize( 'site_title_size', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).css('font-size', to + 'px' );
		} );
	} );			
	wp.customize( 'site_desc_size', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css('font-size', to + 'px' );
		} );
	} );
	wp.customize('h1_size',function( value ) {
		value.bind( function( newval ) {
			$('h1').not('.site-title').css('font-size', newval + 'px' );
		} );
	});	
    wp.customize('h2_size',function( value ) {
        value.bind( function( newval ) {
            $('h2').css('font-size', newval + 'px' );
        } );
    });	
    wp.customize('h3_size',function( value ) {
        value.bind( function( newval ) {
            $('h3').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('h4_size',function( value ) {
        value.bind( function( newval ) {
            $('h4').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('h5_size',function( value ) {
        value.bind( function( newval ) {
            $('h5').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('h6_size',function( value ) {
        value.bind( function( newval ) {
            $('h6').css('font-size', newval + 'px' );
        } );
    });
    wp.customize('body_size',function( value ) {
        value.bind( function( newval ) {
            $('body').css('font-size', newval + 'px' );
        } );
    });


} )( jQuery );
