( function ( $ ) {
	'use strict';

	$( function () {
		if ( ! $( '#member-popup' ).length ) {
			return;
		}

		function fillPopup( $el ) {
			var $card    = $el.closest( '.iec_management_member_box' );
			var $dialog  = $( '#member-popup' );
			var imageUrl = $card.attr( 'data-member-image' ) || '';
			var $tpl     = $card.find( '.iec-member-bio-source' );
			var name     = $card.attr( 'data-member-name' ) || '';

			$dialog.find( '.img' ).css( 'background-image', imageUrl ? 'url(' + imageUrl + ')' : '' );
			$dialog.find( '.name' ).text( name );
			$dialog.find( '.position' ).text( $card.attr( 'data-member-role' ) || '' );
			$dialog.find( '.company' ).text( $card.attr( 'data-member-company' ) || '' );
			$dialog.find( '.bio' ).html( $tpl.length ? $tpl.html() : '' );
		}

		IEC.bindDialog( {
			dialog: '#member-popup',
			trigger: '.iec_management_member_box--bio, .iec-member-bio-trigger',
			onOpen: fillPopup,
		} );

		$( document ).on( 'keydown', '.iec_management_member_box--bio', function ( e ) {
			if ( e.key === 'Enter' || e.key === ' ' ) {
				e.preventDefault();
				$( this ).trigger( 'click' );
			}
		} );

		$( document ).on( 'click', '.iec_management_member_box .linkedin', function ( e ) {
			e.stopPropagation();
		} );
	} );

} )( jQuery );