jQuery( function ( $ ) {
	'use strict';

	$( '.t-market-landing .iec-industry-type-card[href^="#"]' ).on( 'click', function ( event ) {
		var targetId = $( this ).attr( 'href' );
		var $target = $( targetId );

		if ( ! $target.length ) {
			return;
		}

		event.preventDefault();

		$( 'html, body' ).animate( {
			scrollTop: $target.offset().top - 80
		}, 600 );
	} );
} );
