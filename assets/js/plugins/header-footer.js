( function ( $ ) {
	'use strict';

	function headerChrome() {
		return $( '#header-v2, .iec_main_header, .iec_mobile_menu_warpper' );
	}

	function initSearch() {
		var $chrome = headerChrome();
		$chrome.find( '.search .search-icon' ).on( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();
			var $wrap = $( this ).closest( '.search' );
			$wrap.toggleClass( 'searching' );
			if ( $wrap.hasClass( 'searching' ) ) {
				$wrap.find( 'input' ).trigger( 'focus' );
			}
		} );

		$( document ).on( 'click.iecHeaderSearch', function ( e ) {
			if ( ! $( e.target ).closest( '.search' ).length ) {
				$chrome.find( '.search' ).removeClass( 'searching' );
			}
		} );
	}

	function initLanguage() {
		headerChrome().find( '.lang-container' ).on( 'click', function () {
			$( this ).find( '.lang' ).toggleClass( 'open' );
			$( this ).find( '.language-menu' ).toggleClass( 'visible' );
		} );
	}

	function initMobileMenu() {
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
			} else {
				$( '.iec_mobile_dropdown' ).removeClass( 'active' );
				$( '.iec_mobile_submenu' ).stop( true, true ).slideUp( 300 );
				$parent.addClass( 'active' );
				$parent.find( '> .iec_mobile_submenu' ).stop( true, true ).slideDown( 300 );
			}
		} );

		$( '.iec_mobile_card_toggle' ).on( 'click', function () {
			var $card = $( this ).closest( '.iec_mobile_card' );
			if ( $card.hasClass( 'active' ) ) {
				$card.removeClass( 'active' );
				$card.find( '> .iec_mobile_links' ).stop( true, true ).slideUp( 250 );
			} else {
				$card.siblings( '.iec_mobile_card' ).removeClass( 'active' ).find( '.iec_mobile_links' ).stop( true, true ).slideUp( 250 );
				$card.addClass( 'active' );
				$card.find( '> .iec_mobile_links' ).stop( true, true ).slideDown( 250 );
			}
		} );
	}

	$( function () {
		initSearch();
		initLanguage();
		initMobileMenu();
	} );
} )( jQuery );
