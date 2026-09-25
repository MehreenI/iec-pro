( function ( $ ) {
	'use strict';

	function initImageModal() {
		var overlay  = document.getElementById( 'iecModalOverlay' );
		var modalImg = document.getElementById( 'iecModalImg' );
		var closeBtn = document.getElementById( 'iecModalClose' );

		if ( ! overlay || ! modalImg || ! closeBtn ) {
			return;
		}

		function openModal( trigger ) {
			modalImg.src = trigger.getAttribute( 'data-img' ) || '';
			modalImg.alt = trigger.getAttribute( 'aria-label' ) || '';
			overlay.classList.add( 'is-open' );
			document.body.style.overflow = 'hidden';
		}

		function closeModal() {
			overlay.classList.remove( 'is-open' );
			modalImg.src = '';
			modalImg.alt = '';
			document.body.style.overflow = '';
		}

		document.querySelectorAll( '.iec_single_solution_product_image_post' ).forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				openModal( this );
			} );
		} );

		closeBtn.addEventListener( 'click', closeModal );
		overlay.addEventListener( 'click', function ( e ) {
			if ( e.target === overlay ) {
				closeModal();
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && overlay.classList.contains( 'is-open' ) ) {
				closeModal();
			}
		} );
	}

	function initAccordion() {
		$( '.iec_single_solution_acordion_body' ).hide();

		$( '.iec_single_solution_acordion_header' ).on( 'click', function () {
			var $header = $( this );
			var $item   = $header.closest( '.iec_single_solution_acordion_item' );
			var $body   = $item.find( '.iec_single_solution_acordion_body' );
			var open    = $item.hasClass( 'active' );

			$( '.iec_single_solution_acordion_item' ).removeClass( 'active' )
				.find( '.iec_single_solution_acordion_header' ).attr( 'aria-expanded', 'false' );
			$( '.iec_single_solution_acordion_body' ).stop( true, true ).slideUp( 300 );

			if ( ! open ) {
				$item.addClass( 'active' );
				$header.attr( 'aria-expanded', 'true' );
				$body.stop( true, true ).slideDown( 300 );
			}
		} );
	}

	function initSwipers() {
		if ( typeof IEC.initMobileOnlySwiper !== 'function' ) {
			return;
		}

		IEC.initMobileOnlySwiper( '.image-modal-swiper', {
			slidesPerView: 1,
			spaceBetween: 15,
			speed: 600,
			loop: false,
			watchOverflow: true,
			navigation: {
				nextEl: '.image_modal_swiper_next',
				prevEl: '.image_modal_swiper_prev'
			}
		} );

		IEC.initMobileOnlySwiper( '.use_cases_swiper', {
			slidesPerView: 1,
			spaceBetween: 15,
			speed: 600,
			loop: false,
			watchOverflow: true,
			navigation: {
				nextEl: '.use_cases_swiper_next',
				prevEl: '.use_cases_swiper_prev'
			}
		} );
	}

	$( function () {
		initImageModal();
		initAccordion();
		initSwipers();
	} );
} )( jQuery );
