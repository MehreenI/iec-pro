/**
 * News landing + news_type archive — AJAX list only.
 * Featured swiper stays in assets/js/plugins/swiper-init.js.
 */
( function ( $ ) {
	'use strict';

	var config = window.iecNewsLanding || {};

	var SELECTORS = {
		root: '[data-news-posts]',
		loader: '.iec_news_loader',
		list: '.iec_news_posts_list',
		pagination: '.iec_paginate',
		pageLink: 'a.iec_paginate_item',
	};

	var SVG = {
		prev: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7.89035 1.58002L6.70369 0.400024L0.110352 7.00002L6.71035 13.6L7.89035 12.42L2.47035 7.00002L7.89035 1.58002Z" fill="#727DA3"></path></svg>',
		next: '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="#27284A"></path></svg>',
	};

	function escapeHtml( text ) {
		return String( text )
			.replace( /&/g, '&amp;' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' )
			.replace( /"/g, '&quot;' );
	}

	function renderNewsPostCard( post ) {
		var imageMarkup = post.image
			? '<div class="iec_main_news_post_image"><img src="' + escapeHtml( post.image ) + '" alt="' + escapeHtml( post.title ) + '" loading="lazy" decoding="async"></div>'
			: '';

		var categoryMarkup = post.category
			? '<span class="category_pill">' + escapeHtml( post.category ) + '</span>'
			: '';

		var excerptMarkup = post.excerpt
			? '<p>' + escapeHtml( post.excerpt ) + '</p>'
			: '';

		return (
			'<a href="' + escapeHtml( post.permalink ) + '" class="iec_main_news_post_box">' +
				imageMarkup +
				'<div class="iec_main_news_post_content">' +
					'<div class="iec_main_news_post_meta">' +
						categoryMarkup +
						'<span class="date">' + escapeHtml( post.date ) + '</span>' +
					'</div>' +
					'<h3 class="iec_main_news_post_title">' + escapeHtml( post.title ) + '</h3>' +
					excerptMarkup +
				'</div>' +
			'</a>'
		);
	}

	function renderPaginationArrow( direction ) {
		var label = direction === 'prev' ? 'Previous page' : 'Next page';
		var icon  = direction === 'prev' ? SVG.prev : SVG.next;

		return (
			'<a href="#" class="iec_paginate_item arrow" data-direction="' + direction + '" aria-label="' + label + '">' +
				icon +
			'</a>'
		);
	}

	function buildPageNumbers( currentPage, totalPages ) {
		var pages = [];
		var i;

		for ( i = 1; i <= Math.min( 3, totalPages ); i++ ) {
			pages.push( i );
		}

		for ( i = currentPage - 1; i <= currentPage + 1; i++ ) {
			if ( i > 3 && i < totalPages - 3 ) {
				pages.push( i );
			}
		}

		for ( i = Math.max( totalPages - 3, 5 ); i <= totalPages; i++ ) {
			pages.push( i );
		}

		return pages
			.filter( function ( page, index, list ) {
				return list.indexOf( page ) === index;
			} )
			.sort( function ( a, b ) {
				return a - b;
			} );
	}

	function renderPaginationControls( currentPage, totalPages, $pagination ) {
		if ( totalPages < 2 ) {
			$pagination.empty();
			return;
		}

		var html = '';

		if ( currentPage > 1 ) {
			html += renderPaginationArrow( 'prev' );
		}

		var pageNumbers = buildPageNumbers( currentPage, totalPages );

		pageNumbers.forEach( function ( page, index ) {
			if ( index > 0 && page - pageNumbers[ index - 1 ] > 1 ) {
				html += '<span class="iec_paginate_item ellipsis">...</span>';
			}

			var activeClass = page === currentPage ? ' iec_paginate_item_active' : '';
			html += '<a href="#" class="iec_paginate_item' + activeClass + '" data-page="' + page + '">' + page + '</a>';
		} );

		if ( currentPage < totalPages ) {
			html += renderPaginationArrow( 'next' );
		}

		$pagination.html( html );
	}

	function fetchNewsPosts( pageNumber ) {
		var requestUrl = new URL( config.restUrl, window.location.origin );

		requestUrl.searchParams.set( 'page', String( pageNumber ) );
		requestUrl.searchParams.set( 'lang', config.lang || 'en' );

		if ( config.category ) {
			requestUrl.searchParams.set( 'category', config.category );
		}
		if ( config.industry ) {
			requestUrl.searchParams.set( 'industry', config.industry );
		}
		if ( config.location ) {
			requestUrl.searchParams.set( 'location', config.location );
		}

		return fetch( requestUrl.toString(), {
			credentials: 'same-origin',
			headers: { Accept: 'application/json' },
		} ).then( function ( response ) {
			if ( ! response.ok ) {
				throw new Error( 'News request failed' );
			}
			return response.json();
		} );
	}

	function initNewsLandingList() {
		var $root = $( SELECTORS.root );

		if ( ! $root.length || ! config.restUrl ) {
			return;
		}

		var $loader     = $root.find( SELECTORS.loader );
		var $postsList  = $root.find( SELECTORS.list );
		var $pagination = $root.find( SELECTORS.pagination );
		var currentPage = parseInt( config.page, 10 ) || 1;

		function setLoadingState( isLoading ) {
			$loader.attr( 'aria-hidden', isLoading ? 'false' : 'true' );
			$root.toggleClass( 'is-loading', isLoading );
		}

		function loadPage( pageNumber ) {
			setLoadingState( true );

			fetchNewsPosts( pageNumber )
				.then( function ( response ) {
					var posts = response.posts || [];

					if ( ! posts.length ) {
						$postsList.html(
							'<p class="iec_news_no_results">' + escapeHtml( config.noResults || 'No results found.' ) + '</p>'
						);
					} else {
						$postsList.html( posts.map( renderNewsPostCard ).join( '' ) );
					}

					currentPage = response.current || pageNumber;
					renderPaginationControls( currentPage, response.total_pages || 1, $pagination );
				} )
				.catch( function () {
					$postsList.html(
						'<p class="iec_news_no_results">' + escapeHtml( config.errorText || 'Unable to load news.' ) + '</p>'
					);
					$pagination.empty();
				} )
				.finally( function () {
					setLoadingState( false );
				} );
		}

		function getTargetPage( $link ) {
			var direction = $link.data( 'direction' );

			if ( direction === 'prev' ) {
				return currentPage - 1;
			}
			if ( direction === 'next' ) {
				return currentPage + 1;
			}

			return parseInt( $link.data( 'page' ), 10 );
		}

		$pagination.on( 'click', SELECTORS.pageLink, function ( event ) {
			event.preventDefault();

			var targetPage = getTargetPage( $( this ) );

			if ( targetPage > 0 && targetPage !== currentPage ) {
				loadPage( targetPage );
				$postsList[ 0 ].scrollIntoView( { behavior: 'smooth', block: 'start' } );
			}
		} );

		loadPage( currentPage );
	}

	$( function () {
		initNewsLandingList();
	} );

} )( jQuery );
