( function ( $ ) {
	'use strict';

	function initRegionalMap() {
		var tooltip = document.getElementById( 'mapTooltip' );
		if ( ! tooltip ) {
			return;
		}

		var isMobile = function () {
			return window.innerWidth <= 991;
		};

		function openTooltip() {
			if ( isMobile() ) {
				$( tooltip )
					.stop( true, true )
					.css( {
						display: 'block',
						opacity: 0,
						transform: 'translate(50%, 50%)',
					} )
					.animate(
						{ dummy: 0 },
						{
							duration: 400,
							step: function ( now, fx ) {
								$( this ).css( 'opacity', fx.pos );
							},
						}
					);
			} else {
				$( tooltip )
					.stop( true, true )
					.css( {
						display: 'block',
						opacity: 0,
						transform: 'translateX(60px)',
					} )
					.animate(
						{ dummy: 0 },
						{
							duration: 600,
							step: function ( now, fx ) {
								var progress = fx.pos;
								var move     = 60 - 60 * progress;
								$( this ).css( {
									transform: 'translateX(' + move + 'px)',
									opacity: progress,
								} );
							},
						}
					);
			}
		}

		function closeTooltip() {
			if ( isMobile() ) {
				$( tooltip )
					.stop( true, true )
					.animate(
						{ dummy: 0 },
						{
							duration: 300,
							step: function ( now, fx ) {
								$( this ).css( 'opacity', 1 - fx.pos );
							},
							complete: function () {
								$( this ).css( 'display', 'none' );
							},
						}
					);
			} else {
				$( tooltip )
					.stop( true, true )
					.animate(
						{ dummy: 0 },
						{
							duration: 450,
							step: function ( now, fx ) {
								var progress = fx.pos;
								var move     = 60 * progress;
								$( this ).css( {
									transform: 'translateX(' + move + 'px)',
									opacity: 1 - progress,
								} );
							},
							complete: function () {
								$( this ).css( 'display', 'none' );
							},
						}
					);
			}
		}

		function createContact( phone, email ) {
			var contactHTML = '';
			if ( phone ) {
				var cleanPhone = String( phone ).replace( /\s+/g, '' );
				contactHTML   += '<a href="tel:' + cleanPhone + '">' + phone + '</a>';
			}
			if ( phone && email ) {
				contactHTML += '&nbsp; | &nbsp;';
			}
			if ( email ) {
				contactHTML += '<a href="mailto:' + email + '">' + email + '</a>';
			}
			return contactHTML;
		}

		function escapeAttr( value ) {
			return String( value )
				.replace( /&/g, '&amp;' )
				.replace( /"/g, '&quot;' )
				.replace( /</g, '&lt;' )
				.replace( />/g, '&gt;' );
		}

		function pinData( $pin ) {
			return {
				className: $pin.attr( 'data-class' ) || '',
				image: $pin.attr( 'data-image' ) || '',
				name: $pin.attr( 'data-name' ) || '',
				title: $pin.attr( 'data-title' ) || '',
				address: $pin.attr( 'data-address' ) || '',
				phone: $pin.attr( 'data-phone' ) || '',
				email: $pin.attr( 'data-email' ) || '',
				address2: $pin.attr( 'data-address2' ) || '',
				phone2: $pin.attr( 'data-phone2' ) || '',
				email2: $pin.attr( 'data-email2' ) || '',
				link: $pin.attr( 'data-link' ) || '',
			};
		}

		function fillTooltip( data ) {
			var secondBlock = '';
			if ( data.address2 || data.phone2 || data.email2 ) {
				secondBlock =
					'<div class="iec_map_card_info">' +
					'<p class="iec_map_card_address">' + data.address2 + '</p>' +
					'<p class="iec_map_card_contact">' + createContact( data.phone2, data.email2 ) + '</p>' +
					'</div>';
			}

			tooltip.className = 'iec_map_card';
			if ( data.className ) {
				tooltip.classList.add( data.className );
			}

			tooltip.innerHTML =
				'<div class="iec_map_card_header">' +
				'<img src="' + data.image + '" alt="' + escapeAttr( data.name || '' ) + '">' +
				'<div><p class="iec_map_card_title"><strong>' + data.title + '</strong></p></div>' +
				'<a href="' + data.link + '" class="iec_desktop_icon">' +
				'<svg xmlns="http://www.w3.org/2000/svg" width="13" height="19" viewBox="0 0 13 19" fill="none" aria-hidden="true">' +
				'<path d="M1.01367 1.10574L10.0137 9.35574L1.01367 17.6057" stroke="#727DA3" stroke-width="3"/>' +
				'</svg></a>' +
				'<span class="iec_map_card_arrow iec_mobile_icon" role="button" tabindex="0" aria-label="Close">' +
				'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">' +
				'<path d="M15.5353 2.61723C15.8126 2.33013 15.966 1.9456 15.9625 1.54646C15.9591 1.14732 15.799 0.765519 15.5167 0.483276C15.2345 0.201034 14.8527 0.0409376 14.4535 0.0374692C14.0544 0.0340008 13.6699 0.187438 13.3828 0.464733L8 5.8475L2.61723 0.464733C2.47681 0.31934 2.30883 0.20337 2.12311 0.123589C1.93738 0.0438078 1.73763 0.0018139 1.5355 5.74767e-05C1.33338 -0.00169895 1.13292 0.0368169 0.945842 0.113358C0.75876 0.1899 0.588795 0.302933 0.445864 0.445864C0.302933 0.588795 0.1899 0.75876 0.113358 0.945842C0.0368169 1.13292 -0.00169895 1.33338 5.74767e-05 1.5355C0.0018139 1.73763 0.0438078 1.93738 0.123589 2.12311C0.20337 2.30883 0.31934 2.47681 0.464733 2.61723L5.8475 8L0.464733 13.3828C0.31934 13.5232 0.20337 13.6912 0.123589 13.8769C0.0438078 14.0626 0.0018139 14.2624 5.74767e-05 14.4645C-0.00169895 14.6666 0.0368169 14.8671 0.113358 15.0542C0.1899 15.2412 0.302933 15.4112 0.445864 15.5541C0.588795 15.6971 0.75876 15.8101 0.945842 15.8866C1.13292 15.9632 1.33338 16.0017 1.5355 15.9999C1.73763 15.9982 1.93738 15.9562 2.12311 15.8764C2.30883 15.7966 2.47681 15.6807 2.61723 15.5353L8 10.1525L13.3828 15.5353C13.5232 15.6807 13.6912 15.7966 13.8769 15.8764C14.0626 15.9562 14.2624 15.9982 14.4645 15.9999C14.6666 16.0017 14.8671 15.9632 15.0542 15.8866C15.2412 15.8101 15.4112 15.6971 15.5541 15.5541C15.6971 15.4112 15.8101 15.2412 15.8866 15.0542C15.9632 14.8671 16.0017 14.6666 15.9999 14.4645C15.9982 14.2624 15.9562 14.0626 15.8764 13.8769C15.7966 13.6912 15.6807 13.5232 15.5353 13.3828L10.1525 8L15.5353 2.61723Z" fill="#727DA3"/>' +
				'</svg></span></div>' +
				'<div class="iec_map_card_info">' +
				'<p class="iec_map_card_address">' + ( data.address || '' ) + '</p>' +
				'<p class="iec_map_card_contact">' + createContact( data.phone, data.email ) + '</p>' +
				'</div>' +
				secondBlock +
				'<a href="' + data.link + '" class="gray_btn">Learn More</a>';

			openTooltip();
		}

		function deactivateAll() {
			$( '.iec_map_pointer' ).removeClass( 'active' );
			$( '.iec_regional_offices_button' ).removeClass( 'active' );
			closeTooltip();
		}

		$( '.iec_map_pointer' ).on( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();

			var $pin = $( this );

			if ( $pin.hasClass( 'active' ) ) {
				deactivateAll();
				return;
			}

			$( '.iec_map_pointer' ).removeClass( 'active' );
			$( '.iec_regional_offices_button' ).removeClass( 'active' );
			$pin.addClass( 'active' );

			fillTooltip( pinData( $pin ) );
		} );

		$( '.iec_regional_offices_button' ).on( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();

			var $btn         = $( this );
			var targetClass  = $btn.data( 'target' );
			var $matchedPin  = $( '.iec_map_pointer[data-class="' + targetClass + '"]' ).first();

			if ( ! $matchedPin.length ) {
				return;
			}

			$( '.iec_regional_offices_button' ).removeClass( 'active' );
			$btn.addClass( 'active' );

			$( '.iec_map_pointer' ).removeClass( 'active' );
			$matchedPin.addClass( 'active' );

			fillTooltip( pinData( $matchedPin ) );
		} );

		$( tooltip ).on( 'click', '.iec_map_card_arrow', function ( e ) {
			e.preventDefault();
			e.stopPropagation();
			deactivateAll();
		} );

		$( tooltip ).on( 'click', function ( e ) {
			e.stopPropagation();
		} );

		$( document ).on( 'click.officesMap', function ( e ) {
			if ( $( e.target ).closest( '.iec_map_pointer, .iec_regional_offices_button, #mapTooltip' ).length ) {
				return;
			}
			deactivateAll();
		} );
	}

	$( function () {
		initRegionalMap();
	} );
} )( jQuery );