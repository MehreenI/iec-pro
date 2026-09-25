/**
 * Operator page — scroll reveal + availability tabs.
 *
 * @package iec
 */
( function ( window, document ) {
	'use strict';

	function initReveal() {
		var nodes = document.querySelectorAll( '.iec-operator-main .slo-reveal' );
		if ( ! nodes.length ) {
			return;
		}

		if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches || ! ( 'IntersectionObserver' in window ) ) {
			nodes.forEach( function ( el ) {
				el.classList.add( 'is-visible' );
			} );
			return;
		}

		var io = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					entry.target.classList.add( 'is-visible' );
					io.unobserve( entry.target );
				} );
			},
			{
				threshold: 0.14,
				rootMargin: '0px 0px -6% 0px',
			}
		);

		nodes.forEach( function ( el ) {
			io.observe( el );
		} );
	}

	function initTabs() {
		var roots = document.querySelectorAll( '[data-slo-tabs]' );
		if ( ! roots.length ) {
			return;
		}

		roots.forEach( function ( root ) {
			var tabs = root.querySelectorAll( '[data-slo-tab]' );
			var panels = root.querySelectorAll( '[role="tabpanel"]' );

			tabs.forEach( function ( tab ) {
				tab.addEventListener( 'click', function () {
					var key = tab.getAttribute( 'data-slo-tab' );

					tabs.forEach( function ( t ) {
						var active = t === tab;
						t.classList.toggle( 'is-active', active );
						t.setAttribute( 'aria-selected', active ? 'true' : 'false' );
					} );

					panels.forEach( function ( panel ) {
						var match = panel.id === 'slo-panel-' + key;
						panel.classList.toggle( 'is-active', match );
						if ( match ) {
							panel.removeAttribute( 'hidden' );
						} else {
							panel.setAttribute( 'hidden', '' );
						}
					} );
				} );
			} );
		} );
	}

	jQuery( function () {
		initReveal();
		initTabs();
	} );
}( window, document ) );
