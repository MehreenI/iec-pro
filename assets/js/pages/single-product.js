( function ( $ ) {
	'use strict';

	$( function () {
		if ( ! $( '.iec_single_products_links_list, .easyzoom' ).length ) {
			return;
		}

		if ( $.fn.easyZoom ) {
			$( '.easyzoom' ).easyZoom();
		}

		$( '.iec_single_products_links_list a[href^="#"]' ).on( 'click', function ( e ) {
			var $target = $( $( this ).attr( 'href' ) );
			if ( ! $target.length ) {
				return;
			}
			e.preventDefault();
			$( 'html, body' ).animate( { scrollTop: $target.offset().top - 80 }, 'smooth' );
		} );
	} );

	window.initSingleProductPage = function () {};

} )( jQuery );
