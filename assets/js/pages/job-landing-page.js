( function ( $ ) {
	'use strict';

	function initLocationFilter() {
		var $filter = $( '#job-location-filter' );
		if ( ! $filter.length ) {
			return;
		}

		$filter.on( 'change', function () {
			var value = $filter.val();
			$( '.iec-job-item' ).each( function () {
				var office = $( this ).attr( 'data-office' ) || '';
				$( this ).prop( 'hidden', value !== 'all' && office !== value );
			} );
		} );
	}

	function initJobItems() {
		var $items = $( '.iec-job-item' );
		if ( ! $items.length ) {
			return;
		}

		$items.each( function () {
			var $item = $( this );

			$item.find( '.iec-job-item__close' ).on( 'click', function ( e ) {
				e.preventDefault();
				e.stopPropagation();
				$item.removeClass( 'expand' );
			} );

			$item.find( '.iec-job-item__header' ).on( 'click', function ( e ) {
				e.preventDefault();
				if ( $item.hasClass( 'expand' ) ) {
					return;
				}
				$items.removeClass( 'expand' );
				$item.addClass( 'expand' );
				IEC.scrollTo( $item, 100 );
			} );
		} );

		if ( window.location.hash && window.location.hash.indexOf( 'job-' ) === 1 ) {
			$( window.location.hash ).filter( '.iec-job-item' ).addClass( 'expand' );
		}
	}

	function initFileUploadLabels() {
		$( '.iec-job-apply-form input[type="file"]' ).each( function () {
			var $input = $( this );
			var $label = $( 'label[for="' + $input.attr( 'id' ) + '"]' );
			if ( ! $label.length ) {
				return;
			}
			var defaultLabel = $label.attr( 'data-default-label' ) || $label.text();
			$input.on( 'change', function () {
				$label.text( $input[0].files && $input[0].files.length ? $input[0].files[0].name : defaultLabel );
			} );
		} );
	}

	$( function () {
		initLocationFilter();
		initJobItems();
		initFileUploadLabels();
	} );

} )( jQuery );