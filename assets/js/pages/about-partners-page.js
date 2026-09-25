( function ( $ ) {
	'use strict';

	var SPEED = 350;

	function initPartnerAccordion() {
		var labels = ( window.iecPartners && window.iecPartners.labels ) || {
			downloadBrochure: 'Download brochure',
			viewCoverageMap: 'View Coverage Map',
		};

		$( '.iec_partner_accordian_trigger' ).on( 'click', function () {
			var $trigger = $( this );
			var $item    = $trigger.closest( '.iec_partner_accordian_box_warpper' );
			var group    = $trigger.data( 'group' );
			var $panel   = $( '.iec_partner_accordian_below_content[data-group="' + group + '"]' );
			var tpl      = $item.find( 'template.iec-partner-content-source' )[0];

			if ( $item.hasClass( 'active' ) || ! $panel.length ) {
				return;
			}

			$( '.iec_partner_accordian_box_warpper[data-group="' + group + '"]' )
				.removeClass( 'active' )
				.find( '.iec_partner_accordian_trigger' )
				.attr( 'aria-expanded', 'false' );

			$item.addClass( 'active' );
			$trigger.attr( 'aria-expanded', 'true' );

			$panel.stop( true, true ).fadeOut( SPEED, function () {
				var $container = $( this );
				var $heading   = $container.find( 'h2, h3' ).first();
				var caption    = $trigger.data( 'caption' ) || '';
				var href       = $trigger.data( 'operator-href' ) || '';
				var brochure   = $trigger.data( 'brochure-url' ) || '';
				var mapUrl     = $trigger.data( 'map-url' ) || '';

				$heading.empty();
				if ( href ) {
					$heading.append( $( '<a>', { class: 'js-operator-link', href: href, text: $trigger.data( 'operator-label' ) || caption } ) );
				} else {
					$heading.text( caption );
				}

				$container.find( '.iec_para_content' ).html( tpl ? tpl.innerHTML : '' );
				$container.find( '.iec_partner_accordian_button_list' ).remove();

				if ( brochure || mapUrl ) {
					var $list = $( '<div>', { class: 'iec_partner_accordian_button_list' } );
					if ( brochure ) {
						$list.append( $( '<div>' ).append( $( '<a>', {
							href: brochure,
							class: 'download-brochure',
							target: '_blank',
							rel: 'noopener noreferrer',
							text: labels.downloadBrochure,
						} ) ) );
					}
					if ( mapUrl ) {
						$list.append( $( '<div>' ).append( $( '<button>', {
							type: 'button',
							class: 'iec-partner-view-map view-map',
							text: labels.viewCoverageMap,
							'data-map-url': mapUrl,
						} ) ) );
					}
					$container.append( $list );
				}

				$container.addClass( 'active' ).fadeIn( SPEED );
			} );
		} );
	}

	function initCoverageMap() {
		var $dialog = $( '#partner-coverage-map' );
		if ( ! $dialog.length || ! $dialog[0].showModal ) {
			return;
		}

		var $img = $dialog.find( 'img' );

		$( document ).on( 'click', '.iec-partner-view-map', function ( e ) {
			e.preventDefault();
			var mapUrl = $( this ).data( 'map-url' ) || '';
			if ( ! mapUrl || ! $img.length ) {
				return;
			}
			$img.off( 'load' ).on( 'load', function () {
				$img.css( 'visibility', 'visible' );
			} );
			$img.css( 'visibility', 'hidden' ).attr( 'src', mapUrl );
			$dialog[0].showModal();
		} );

		$dialog.find( '.close' ).on( 'click', function () {
			if ( $dialog[0].open ) {
				$dialog[0].close();
			}
		} );
	}

	$( function () {
		initPartnerAccordion();
		initCoverageMap();
	} );

} )( jQuery );
