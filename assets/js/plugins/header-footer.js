( function ( $ ) {
	'use strict';

	function initHeaderChrome() {
		$( '.menu_burger' ).on( 'click', function () {
			$( '#header-v2' ).toggleClass( 'menu_open' );
		} );

		$( '.search-icon' ).on( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();

			var $wrap = $( this ).closest( '.search' );

			$( '.search' ).not( $wrap ).removeClass( 'searching' );
			$wrap.toggleClass( 'searching' );

			if ( $wrap.hasClass( 'searching' ) ) {
				$wrap.find( 'input[type="text"], input[type="search"]' ).trigger( 'focus' );
			}
		} );

		$( document ).on( 'click', function ( e ) {
			if ( ! $( e.target ).closest( '.search' ).length ) {
				$( '.search' ).removeClass( 'searching' );
			}
		} );

		$( '.lang-container' ).on( 'click', function () {
			$( this ).find( '.lang' ).toggleClass( 'open' );
			$( this ).find( '.menu.language-menu' ).toggleClass( 'visible' );
		} );

		$( '.show-on-load' ).removeClass( 'show-on-load' );
	}

	function initMegaMenuHover() {
		$( '.iec_menu_dropdown' ).each( function () {
			var $dropdown = $( this );
			var $mega     = $dropdown.parent().children( '.iec_mega_menu_warpper' );

			if ( ! $mega.length ) {
				return;
			}

			$dropdown.on( 'mouseenter', function () {
				$mega.addClass( 'iec_menu_visible' );
			} );

			$dropdown.on( 'mouseleave', function () {
				setTimeout( function () {
					if ( ! $mega.is( ':hover' ) ) {
						$mega.removeClass( 'iec_menu_visible' );
					}
				}, 50 );
			} );
		} );

		$( '.iec_mega_menu_warpper' )
			.on( 'mouseenter', function () {
				$( this ).addClass( 'iec_menu_visible' );
			} )
			.on( 'mouseleave', function () {
				$( this ).removeClass( 'iec_menu_visible' );
			} );
	}

	function initMobileNav() {
		$( '.iec_mobile_menu_btn' ).on( 'click', function () {
			$( this ).toggleClass( 'active' );
			$( '.iec_mobile_navigation' ).toggleClass( 'active' );
			$( 'body' ).toggleClass( 'menu-open' );
		} );

		$( '.iec_mobile_toggle' ).on( 'click', function () {
			var $parent = $( this ).closest( '.iec_mobile_dropdown' );

			if ( $parent.hasClass( 'active' ) ) {
				$parent.removeClass( 'active' );
				$parent.find( '> .iec_mobile_submenu' ).stop( true, true ).slideUp( 300 );
				return;
			}

			$( '.iec_mobile_dropdown' ).removeClass( 'active' );
			$( '.iec_mobile_submenu' ).stop( true, true ).slideUp( 300 );
			$parent.addClass( 'active' );
			$parent.find( '> .iec_mobile_submenu' ).stop( true, true ).slideDown( 300 );
		} );

		$( '.iec_mobile_card_toggle' ).on( 'click', function () {
			var $card = $( this ).closest( '.iec_mobile_card' );

			if ( $card.hasClass( 'active' ) ) {
				$card.removeClass( 'active' );
				$card.find( '> .iec_mobile_links' ).stop( true, true ).slideUp( 250 );
				return;
			}

			$card.siblings( '.iec_mobile_card' )
				.removeClass( 'active' )
				.find( '.iec_mobile_links' )
				.stop( true, true )
				.slideUp( 250 );

			$card.addClass( 'active' );
			$card.find( '> .iec_mobile_links' ).stop( true, true ).slideDown( 250 );
		} );
	}

	$( function () {
		initHeaderChrome();
		initMegaMenuHover();
		initMobileNav();

		$( 'a[href]' ).each( function () {
			try {
				var link = new URL( this.href );
				if ( link.hostname && link.hostname !== window.location.hostname ) {
					this.target = '_blank';
					this.rel = 'noopener noreferrer';
				}
			} catch ( e ) {}
		} );
	} );
} )( jQuery );
