( function ( $ ) {
	'use strict';

	/* Solutions */
	function playSolutionReveal( box, reduced ) {
		if ( ! box || box.classList.contains( 'is-empty' ) ) {
			return;
		}

		if ( reduced ) {
			box.classList.add( 'is-visible' );
			return;
		}

		box.classList.remove( 'is-visible' );
		void box.offsetWidth;
		box.classList.add( 'is-visible' );
	}

	function initSolutions() {
		var $section = $( '.iec-offshore-solutions-section' );

		if ( ! $section.length ) {
			return;
		}

		var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var boxes = $section.find( '[data-offshore-solution-reveal].solution_image' ).toArray();

		$section.find( '.solution_pane.active' ).show();
		$section.find( '.solution_image.active' ).show();

		if ( boxes.length && ! reduced && typeof IntersectionObserver !== 'undefined' ) {
			var observer = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}

					playSolutionReveal( entry.target, reduced );
					observer.unobserve( entry.target );
				} );
			}, { threshold: 0.3 } );

			boxes.forEach( function ( box ) {
				if ( box.classList.contains( 'active' ) ) {
					observer.observe( box );
				}
			} );
		} else {
			boxes.forEach( function ( box ) {
				playSolutionReveal( box, reduced );
			} );
		}

		$section.on( 'click', '.solution_btn', function () {
			var $button = $( this );

			if ( $button.hasClass( 'active' ) ) {
				return;
			}

			var $scope = $button.closest( '.iec-offshore-solutions-section' );
			var targetId = $button.data( 'target' );
			var slideIndex = String( targetId ).replace( 'solution-pane-', '' );
			var $nextPane = $scope.find( '#' + targetId );
			var $nextImage = $scope.find( '.solution_image[data-slide="' + slideIndex + '"]' );
			var $activePane = $scope.find( '.solution_pane.active' );
			var $activeImage = $scope.find( '.solution_image.active' );

			$scope.find( '.solution_btn' ).removeClass( 'active' );
			$button.addClass( 'active' );

			$activePane.fadeOut( 200, function () {
				$( this ).removeClass( 'active' );
				$nextPane.addClass( 'active' ).fadeIn( 300 );
			} );

			$activeImage.removeClass( 'active' );

			if ( $nextImage.length && ! $nextImage.hasClass( 'is-empty' ) ) {
				$nextImage.addClass( 'active' );
				playSolutionReveal( $nextImage.get( 0 ), reduced );
			}
		} );
	}

	$( function () {
		initSolutions();
	} );
} )( jQuery );
