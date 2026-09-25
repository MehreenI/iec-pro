( function ( $ ) {
	'use strict';

	function animateCounter( el, duration ) {
		var end     = parseFloat( el.getAttribute( 'data-count' ) || '0', 10 );
		var suffix  = el.getAttribute( 'data-suffix' ) || '';
		var reduce  = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		if ( isNaN( end ) ) {
			return;
		}

		if ( reduce ) {
			el.textContent = end + suffix;
			return;
		}

		var startTime = null;

		function step( timestamp ) {
			if ( ! startTime ) {
				startTime = timestamp;
			}

			var progress = Math.min( ( timestamp - startTime ) / duration, 1 );
			var eased    = 1 - Math.pow( 1 - progress, 3 );
			var current  = Math.round( eased * end );

			el.textContent = current + suffix;

			if ( progress < 1 ) {
				window.requestAnimationFrame( step );
			} else {
				el.textContent = end + suffix;
			}
		}

		window.requestAnimationFrame( step );
	}

	function initStatisticsCounters() {
		var $sections = $( '[data-iec-statistics-section]' );

		if ( ! $sections.length ) {
			return;
		}

		$sections.each( function () {
			var $section = $( this );
			var counters = $section.find( '[data-iec-stat-counter]' ).get();

			if ( ! counters.length ) {
				return;
			}

			var run = function () {
				counters.forEach( function ( el ) {
					if ( el.getAttribute( 'data-iec-stat-played' ) === '1' ) {
						return;
					}

					el.setAttribute( 'data-iec-stat-played', '1' );
					animateCounter( el, 2000 );
				} );
			};

			if ( typeof window.IntersectionObserver === 'undefined' ) {
				run();
				return;
			}

			var observer = new window.IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							run();
							observer.disconnect();
						}
					} );
				},
				{ threshold: 0.3 }
			);

			observer.observe( $section.get( 0 ) );
		} );
	}

	$( function () {
		initStatisticsCounters();
	} );

}( jQuery ) );
