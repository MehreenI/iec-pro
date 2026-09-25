( function ( $ ) {
	'use strict';

	window.IEC = window.IEC || {};

	var SPEED = 350;

	function onClick( $el, handler ) {
		$el.off( 'click.iec keydown.iec' ).on( 'click.iec keydown.iec', function ( e ) {
			if ( e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ' ) {
				return;
			}
			if ( e.type === 'keydown' ) {
				e.preventDefault();
			}
			handler.call( this, e );
		} );
	}

	function closeSiblings( $current, $siblings, openClass ) {
		$siblings.not( $current ).removeClass( openClass );
	}

	function initUseCases() {
		onClick( $( '[data-iec-accordion="expand"] .item, [data-iot-accordion] .item' ), function () {
			var $item = $( this );
			closeSiblings( $item, $item.siblings( '.item' ), 'expand' );
			$item.toggleClass( 'expand' );
		} );

		var $useCases = $( '.use-cases-item' );
		if ( $useCases.length ) {
			$useCases.first().addClass( 'accordion-active' )
				.find( '.use-case-accordion-arrow' ).css( 'transform', 'rotate(180deg)' );

			onClick( $useCases, function () {
				var $item = $( this );

				closeSiblings( $item, $useCases, 'accordion-active' );
				$useCases.not( $item ).find( '.use-case-accordion-arrow' ).css( 'transform', 'rotate(0deg)' );

				$item.toggleClass( 'accordion-active' );
				$item.find( '.use-case-accordion-arrow' ).css(
					'transform',
					$item.hasClass( 'accordion-active' ) ? 'rotate(180deg)' : 'rotate(0deg)'
				);
			} );
		}

		var $offshore = $( '[data-offshore-accordion] .accordion-header' );
		$offshore.not( '.active' ).next().hide();

		onClick( $offshore, function () {
			var $header = $( this );

			$offshore.not( $header ).removeClass( 'active' ).next().slideUp( SPEED );
			$header.toggleClass( 'active' ).next().slideToggle( SPEED );
			$header.attr( 'aria-expanded', $header.hasClass( 'active' ) );
		} );
	}

	function initFaq() {
		var $faqHeaders = $( '.iec_faq_header' );
		$faqHeaders.next( '.iec_faq_answer' ).css( 'maxHeight', 'none' ).hide();

		onClick( $faqHeaders, function () {
			var $header = $( this );
			var $grid   = $header.closest( '.iec_faq_grid' );

			$grid.find( '.iec_faq_header' ).not( $header ).removeClass( 'active' )
				.next( '.iec_faq_answer' ).slideUp( SPEED );

			$header.toggleClass( 'active' ).next( '.iec_faq_answer' ).slideToggle( SPEED );
			$header.attr( 'aria-expanded', $header.hasClass( 'active' ) );
		} );

		onClick( $( '[data-iec-accordion="toggle"] .iec_vertical_market_accordion_box_warpper, [data-market-accordion] .iec_vertical_market_accordion_box_warpper' ), function ( e ) {
			if ( $( e.target ).closest( '.content' ).length ) {
				return;
			}

			var $box = $( this );
			$box.closest( '[data-iec-accordion="toggle"], [data-market-accordion]' )
				.find( '.iec_vertical_market_accordion_box_warpper' )
				.not( $box )
				.removeClass( 'expand' );
			$box.toggleClass( 'expand' );
		} );

		var $headers = $( '.iec_single_news_accordion_header, .iec-accordion-header, .acordion__item__trigger, .iec_starlink_acordion_header, .accordion .accordion-header' )
			.not( '[data-offshore-accordion] .accordion-header' );

		$headers.each( function () {
			var $item  = $( this ).closest( '.iec_single_news_accordion_item, .iec-accordion-item, .acordion__item, .iec_starlink_acordion_item, .accordion-item' );
			var $panel = $item.find( '.iec_single_news_accordion_content, .iec-accordion-content, .acordion__item__info, .iec_starlink_acordion_body, .accordion-collapse, .accordion-content' ).first();

			if ( ! $item.hasClass( 'active' ) && ! $item.hasClass( 'is-open' ) && ! $( this ).hasClass( 'active' ) ) {
				$panel.hide();
			}
		} );

		onClick( $headers, function () {
			var $header = $( this );
			var $item   = $header.closest( '.iec_single_news_accordion_item, .iec-accordion-item, .acordion__item, .iec_starlink_acordion_item, .accordion-item' );
			var $panel  = $item.find( '.iec_single_news_accordion_content, .iec-accordion-content, .acordion__item__info, .iec_starlink_acordion_body, .accordion-collapse, .accordion-content' ).first();
			var $group  = $item.parent();

			$group.children().not( $item ).removeClass( 'active is-open' )
				.find( '.iec_single_news_accordion_content, .iec-accordion-content, .acordion__item__info, .iec_starlink_acordion_body, .accordion-collapse, .accordion-content' )
				.slideUp( SPEED );

			$item.toggleClass( 'active is-open' );
			$header.toggleClass( 'active' ).attr( 'aria-expanded', $item.hasClass( 'active' ) || $item.hasClass( 'is-open' ) );
			$panel.slideToggle( SPEED );
		} );
	}

	function initAll() {
		initUseCases();
		initFaq();
	}

	IEC.initAccordions       = initAll;
	IEC.initExpandAccordions = initUseCases;
	IEC.initToggleAccordions = initFaq;

} )( jQuery );
