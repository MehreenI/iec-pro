( function ( $ ) {
	'use strict';

	window.initOptiviewPage = function () {
		if ( $( '[data-optiview-banner]' ).length ) {
			initBannerCarousel();
		}
		if ( typeof window.useCaseSwiper === 'function' ) {
			window.useCaseSwiper();
		}
		initMoreLinks();
		initComingSoonModal();
	};

	function initMoreLinks() {
		$( '.more' ).on( 'click', function ( e ) {
			e.preventDefault();
			var href = $( this ).attr( 'href' );
			if ( ! href || href.charAt( 0 ) !== '#' ) {
				return;
			}
			var $target = $( href );
			if ( ! $target.length ) {
				return;
			}
			var offset = $( window ).width() > 1024 ? 70 : 25;
			$( 'html, body' ).animate( { scrollTop: $target.offset().top - offset }, 'smooth' );
			$target.closest( '.acordion__item' ).addClass( 'active' )
				.find( '.acordion__item__trigger' ).attr( 'aria-expanded', 'true' )
				.find( 'svg' ).addClass( 'rotate' );
		} );
	}

	function initBannerCarousel() {
		var $banners = $( '.banner__main' );
		if ( ! $banners.length ) {
			return;
		}

		var $bgs      = $( '.banner__bg' );
		var $buttons  = $( '.banner__wrapper__info__download' );
		var $progress = $( '.banner-progress__item' );
		var current   = 0;
		var busy      = false;
		var total     = $banners.length;
		var timer     = null;

		function setSlide( index, on ) {
			$banners.eq( index ).toggleClass( 'banner__active', on );
			$bgs.eq( index ).toggleClass( 'banner__active', on );
			$buttons.eq( index ).toggleClass( 'banner__active', on );
			$progress.eq( index ).toggleClass( 'progress-active', on ).attr( 'aria-selected', on ? 'true' : 'false' );
			if ( on ) {
				$banners.eq( index ).removeAttr( 'hidden' );
			} else {
				$banners.eq( index ).attr( 'hidden', 'hidden' );
			}
		}

		function goTo( index ) {
			if ( busy || index === current ) {
				return;
			}
			busy = true;
			setSlide( current, false );
			current = index;
			setSlide( current, true );
			setTimeout( function () { busy = false; }, 1000 );
		}

		function next() {
			goTo( ( current + 1 ) % total );
		}

		function startTimer() {
			clearInterval( timer );
			timer = setInterval( next, 5000 );
		}

		setSlide( current, true );

		$progress.each( function ( i ) {
			$( this ).on( 'click keydown', function ( e ) {
				if ( e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ' ) {
					return;
				}
				if ( e.type === 'keydown' ) {
					e.preventDefault();
				}
				goTo( i );
				startTimer();
			} );
		} );

		startTimer();
	}

	function initComingSoonModal() {
		var overlay = document.getElementById( 'iec-optiview-modal' );
		var closeButton = overlay && overlay.querySelector( '.close-button' );
		var notifyForm = overlay && overlay.querySelector( '.notify-form' );
		var emailInput = overlay && overlay.querySelector( '#iec-optiview-notify-email' );

		if ( ! overlay || ! closeButton ) {
			return;
		}

		function isOpen() {
			return ! overlay.hasAttribute( 'hidden' );
		}

		function setMainHidden( hidden ) {
			var main = document.getElementById( 'main' );
			if ( ! main ) {
				return;
			}
			if ( hidden ) {
				main.setAttribute( 'aria-hidden', 'true' );
				main.setAttribute( 'inert', '' );
			} else {
				main.removeAttribute( 'aria-hidden' );
				main.removeAttribute( 'inert' );
			}
		}

		function openModal() {
			if ( isOpen() ) {
				return;
			}

			overlay.hidden = false;
			overlay.classList.remove( 'is-closing' );
			overlay.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'iec_optiview_modal_open' );
			setMainHidden( true );

			if ( dialog ) {
				dialog.focus( { preventScroll: true } );
			}
		}

		function hideOverlay() {
			overlay.hidden = true;
			overlay.classList.remove( 'is-closing' );
			overlay.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'iec_optiview_modal_open' );
			setMainHidden( false );
		}

		function onCloseAnimationEnd( event ) {
			if ( event.target !== overlay ) {
				return;
			}
			overlay.removeEventListener( 'animationend', onCloseAnimationEnd );
			hideOverlay();
		}

		function closeModal() {
			if ( ! isOpen() || overlay.classList.contains( 'is-closing' ) ) {
				return;
			}

			if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
				hideOverlay();
				return;
			}

			overlay.classList.add( 'is-closing' );
			overlay.addEventListener( 'animationend', onCloseAnimationEnd );
		}

		var dialog = overlay.querySelector( '.iec_optiview_modal' );

		closeButton.addEventListener( 'click', closeModal );

		$( document ).on( 'click', '[data-optiview-modal-open]', function ( event ) {
			event.preventDefault();
			openModal();
		} );

		if ( window.location.hash === '#iec-optiview-modal' ) {
			openModal();
		}

		overlay.addEventListener( 'click', function ( event ) {
			if ( event.target === overlay ) {
				closeModal();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' ) {
				closeModal();
			}
		} );

		if ( notifyForm && emailInput ) {
			var submitBtn = notifyForm.querySelector( '.notify-button' );
			var label = notifyForm.querySelector( '.notify-button span' );
			var statusEl = notifyForm.querySelector( '#iec-optiview-notify-status' );
			var consentInput = notifyForm.querySelector( '#iec-optiview-notify-consent' );

			function notifyConfig() {
				var page = window.iecOptiview || {};
				var global = window.iecConfig || {};
				return {
					ajaxUrl: page.ajaxUrl || global.ajaxUrl || '',
					nonce: page.nonce || global.nonce || '',
					action: page.action || 'iec_optiview_notify',
					strings: page.strings || {}
				};
			}

			function setStatus( message, state ) {
				notifyForm.classList.remove( 'is-invalid', 'is-loading', 'is-success', 'is-consent-invalid' );
				if ( state ) {
					notifyForm.classList.add( state );
				}
				emailInput.setAttribute( 'aria-invalid', state === 'is-invalid' ? 'true' : 'false' );
				if ( consentInput ) {
					consentInput.setAttribute( 'aria-invalid', state === 'is-consent-invalid' ? 'true' : 'false' );
				}
				if ( statusEl ) {
					statusEl.textContent = message || '';
				}
			}

			function failSubmit( message, focusEl, state ) {
				setStatus( message, state || 'is-invalid' );
				if ( submitBtn ) {
					submitBtn.disabled = false;
				}
				( focusEl || emailInput ).focus();
			}

			$( notifyForm ).on( 'submit', function ( event ) {
				event.preventDefault();

				var email = String( emailInput.value || '' ).trim();
				var cfg = notifyConfig();
				var strings = cfg.strings;

				if ( notifyForm.classList.contains( 'is-loading' ) || notifyForm.classList.contains( 'is-success' ) ) {
					return;
				}

				if ( ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( email ) ) {
					failSubmit( strings.invalidEmail || 'Please enter a valid email address' );
					return;
				}

				if ( consentInput && ! consentInput.checked ) {
					failSubmit(
						strings.consentRequired || 'Please accept the privacy policy to continue.',
						consentInput,
						'is-consent-invalid'
					);
					return;
				}

				if ( ! cfg.ajaxUrl || ! cfg.nonce ) {
					failSubmit( strings.requestError || 'Something went wrong. Please try again.' );
					return;
				}

				setStatus( '', 'is-loading' );
				if ( submitBtn ) {
					submitBtn.disabled = true;
				}

				$.ajax( {
					url: cfg.ajaxUrl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: cfg.action,
						nonce: cfg.nonce,
						email: email,
						gdpr_consent: 1,
						page_url: window.location.href
					}
				} )
					.done( function ( payload ) {
						if ( ! payload || payload.success !== true ) {
							failSubmit( strings.requestError || 'Something went wrong. Please try again.' );
							return;
						}

						setStatus( '', 'is-success' );
						emailInput.disabled = true;
						if ( consentInput ) {
							consentInput.disabled = true;
						}
						if ( label ) {
							label.textContent = ( submitBtn && submitBtn.getAttribute( 'data-success-label' ) ) || 'Thanks';
						}
						if ( payload.data && payload.data.mail === false && statusEl ) {
							statusEl.textContent = payload.data.mail_error || 'Confirmation email was not sent.';
						}
						window.setTimeout( closeModal, 1200 );
					} )
					.fail( function ( xhr ) {
						var code = xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.code;
						var message = strings.requestError || 'Something went wrong. Please try again.';
						var state = 'is-invalid';
						var focusEl = emailInput;
						if ( code === 'invalid_email' ) {
							message = strings.invalidEmail || message;
						} else if ( code === 'rate_limited' ) {
							message = strings.rateLimited || message;
						} else if ( code === 'consent_required' ) {
							message = strings.consentRequired || message;
							state = 'is-consent-invalid';
							focusEl = consentInput || emailInput;
						}
						failSubmit( message, focusEl, state );
					} );
			} );
		}

	}

	$( function () {
		if ( $( '[data-optiview-banner], .iec_optiview_directions, #iec-optiview-modal' ).length ) {
			initOptiviewPage();
		}
	} );

} )( jQuery );
