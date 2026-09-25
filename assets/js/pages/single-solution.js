/**
 * Single solution — image modal, accordion, and Swipers.
 */
( function ( $ ) {
	'use strict';

	function initImageModal() {
		var overlay  = document.getElementById( 'iecModalOverlay' );
		var modalImg = document.getElementById( 'iecModalImg' );
		var closeBtn = document.getElementById( 'iecModalClose' );

		if ( ! overlay || ! modalImg || ! closeBtn ) {
			return;
		}

		document.querySelectorAll( '.iec_single_solution_product_image_post' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				modalImg.src = this.getAttribute( 'data-img' ) || '';
				modalImg.alt = this.getAttribute( 'aria-label' ) || '';
				overlay.classList.add( 'is-open' );
				document.body.style.overflow = 'hidden';
			} );
		} );

		function closeModal() {
			overlay.classList.remove( 'is-open' );
			modalImg.src = '';
			document.body.style.overflow = '';
		}

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
			var $item = $( this ).closest( '.iec_single_solution_acordion_item' );

			if ( $item.hasClass( 'active' ) ) {
				$item.removeClass( 'active' )
					.find( '.iec_single_solution_acordion_body' ).stop( true, true ).slideUp( 300 );
			} else {
				$( '.iec_single_solution_acordion_item' ).removeClass( 'active' )
					.find( '.iec_single_solution_acordion_body' ).stop( true, true ).slideUp( 300 );
				$item.addClass( 'active' )
					.find( '.iec_single_solution_acordion_body' ).stop( true, true ).slideDown( 300 );
			}
		} );
	}

	function initSwipers() {
		if ( typeof Swiper === 'undefined' ) {
			return;
		}

		if ( document.querySelector( '.image-modal-swiper' ) ) {
			new Swiper( '.image-modal-swiper', {
				slidesPerView: 1,
				spaceBetween: 15,
				grid: { rows: 2 },
				navigation: { nextEl: '.image_modal_swiper_next', prevEl: '.image_modal_swiper_prev' },
			} );
		}

		if ( document.querySelector( '.use_cases_swiper' ) ) {
			new Swiper( '.use_cases_swiper', {
				slidesPerView: 'auto',
				spaceBetween: 15,
				navigation: { nextEl: '.use_cases_swiper_next', prevEl: '.use_cases_swiper_prev' },
			} );
		}
	}

	$( function () {
		initImageModal();
		initAccordion();
		initSwipers();
	} );
} )( jQuery );
