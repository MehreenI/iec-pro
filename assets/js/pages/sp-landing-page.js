( function ( $ ) {
	'use strict';

	var cfg = window.iecSpLandingFilter || {};
	var adminUrl = cfg.adminUrl || '';
	var noResultsText = cfg.noResultsText || 'No results found.';
	var requestErrorText = cfg.requestErrorText || 'Error: Could not load results';

	function escapeHtml( value ) {
		return String( value == null ? '' : value )
			.replace( /&/g, '&amp;' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' )
			.replace( /"/g, '&quot;' )
			.replace( /'/g, '&#39;' );
	}

	function escapeAttr( value ) {
		return escapeHtml( value ).replace( /`/g, '&#96;' );
	}

	jQuery( function ( $ ) {
		if ( ! adminUrl ) {
			return;
		}

		var urlParams = new URLSearchParams( window.location.search );
		var initialKeyword = urlParams.get( 'keyword' ) || '';

		function getOperatorSlugFromPath() {
			var path = ( window.location.pathname || '' ).replace( /\/+$/, '' );
			var segments = path.split( '/' ).filter( function ( s ) {
				return s.length > 0;
			} );
			var ix = -1;
			for ( var i = 0; i < segments.length; i++ ) {
				if ( String( segments[ i ] ).toLowerCase() === 'product-solution' ) {
					ix = i;
					break;
				}
			}
			if ( ix === -1 || ix + 1 >= segments.length ) {
				return '';
			}
			try {
				return decodeURIComponent( String( segments[ ix + 1 ] ).replace( /\+/g, ' ' ) );
			} catch ( e ) {
				return segments[ ix + 1 ];
			}
		}

		var initialOperator = getOperatorSlugFromPath()
			|| urlParams.get( 'operator' )
			|| urlParams.get( 'Operator' )
			|| '';
		var debounceDelay = 500;
		var searchTimeout = null;
		var activeRequest = null;
		var lastRequestToken = 0;

		var $form = $( '#filters-form' );
		var $keywordInput = $( '#keyword' );
		var $resultsContainer = $( '.iec_product_posts_margin' );
		var $loadingOverlay = $( '.loading-overlay' );
		var $loadMore = $( '.load-more' );
		var $loadMoreLoader = $loadMore.find( '.loader' );
		var $noResults = $( '.no-results' );

		function normalizeFilterValue( value ) {
			return String( value || '' )
				.toLowerCase()
				.trim()
				.replace( /&/g, 'and' )
				.replace( /[^a-z0-9\s-]/g, '' )
				.replace( /\s+/g, '-' )
				.replace( /-+/g, '-' )
				.replace( /^-+|-+$/g, '' );
		}

		function preselectOperatorFromUrl() {
			if ( ! initialOperator ) {
				return;
			}

			var normalizedOperator = normalizeFilterValue( initialOperator );
			var $operatorToggles = $( 'input[name="ps_filter[operator][]"]' );

			if ( ! $operatorToggles.length ) {
				return;
			}

			var $targetToggle = $operatorToggles.filter( function () {
				var value = $( this ).val();
				var dataKey = $( this ).data( 'key' );
				var normVal = normalizeFilterValue( value );
				var normKey = normalizeFilterValue( dataKey );
				return value === initialOperator
					|| dataKey === initialOperator
					|| normVal === normalizedOperator
					|| normKey === normalizedOperator;
			} ).first();

			if ( $targetToggle.length ) {
				$targetToggle.prop( 'checked', true );
			}
		}

		function buildRequestData( startAt ) {
			var data = {
				keyword: $.trim( $keywordInput.val() ),
				'start-at': startAt
			};

			$.each( $form.serializeArray(), function ( _, field ) {
				if ( field.name.indexOf( 'ps_filter' ) === -1 ) {
					return;
				}

				if ( ! data[ field.name ] ) {
					data[ field.name ] = [];
				}

				data[ field.name ].push( field.value );
			} );

			return data;
		}

		function createItemHTML( item ) {
			var catsHTML = '';

			if ( item.cats && item.cats.length ) {
				catsHTML = '<div class="cats">' + item.cats.map( function ( cat ) {
					return '<div class="' + escapeAttr( cat.cat ) + '"><div>' + escapeHtml( cat.label ) + '</div></div>';
				} ).join( '' ) + '</div>';
			}

			return (
				'<div class="col-md-6 col-lg-4 iec_product_post_box_warpper">' +
					'<a href="' + escapeAttr( item.href ) + '" class="iec_product_post_box">' +
						'<div class="iec_product_box_image" style="background-image: url(\'' + escapeAttr( item.thumb ) + '\');">' +
							catsHTML +
						'</div>' +
						'<h3 class="iec_product_post_title">' + escapeHtml( item.title ) + '</h3>' +
					'</a>' +
				'</div>'
			);
		}

		function showNoResults( message ) {
			$noResults.text( message || noResultsText ).show();
		}

		function toggleLoader( show, isAppend ) {
			if ( isAppend ) {
				$loadMoreLoader.toggle( show );
				return;
			}

			$loadingOverlay.toggle( show );
		}

		function handleResponse( response, append ) {
			var items = response && Array.isArray( response.items ) ? response.items : [];

			if ( ! items.length ) {
				if ( ! append ) {
					$resultsContainer.empty();
					showNoResults();
				}
				$loadMore.hide();
				return;
			}

			var html = items.map( createItemHTML ).join( '' );

			if ( append ) {
				$resultsContainer.append( html );
			} else {
				$resultsContainer.html( html );
			}

			$loadMore.toggle( response.hasMore === true );
			$noResults.hide();
		}

		function fetchFilteredResults( startAt, append ) {
			var offset = typeof startAt === 'number' ? startAt : 0;
			var shouldAppend = append === true;
			var requestToken = ++lastRequestToken;

			if ( activeRequest && activeRequest.readyState !== 4 ) {
				activeRequest.abort();
			}

			activeRequest = $.ajax( {
				url: adminUrl,
				type: 'POST',
				dataType: 'json',
				data: buildRequestData( offset ),
				beforeSend: function () {
					toggleLoader( true, shouldAppend );
				}
			} )
				.done( function ( response ) {
					if ( requestToken !== lastRequestToken ) {
						return;
					}
					handleResponse( response, shouldAppend );
				} )
				.fail( function ( xhr, status ) {
					if ( status === 'abort' || requestToken !== lastRequestToken ) {
						return;
					}
					if ( ! shouldAppend ) {
						showNoResults( requestErrorText );
					}
				} )
				.always( function () {
					if ( requestToken === lastRequestToken ) {
						toggleLoader( false, shouldAppend );
					}
				} );
		}

		function resetAndFetch() {
			fetchFilteredResults( 0, false );
		}

		function handleKeywordInput() {
			clearTimeout( searchTimeout );
			searchTimeout = setTimeout( resetAndFetch, debounceDelay );
		}

		preselectOperatorFromUrl();
		if ( initialKeyword ) {
			$keywordInput.val( initialKeyword );
		}
		fetchFilteredResults( 0, false );

		$keywordInput.on( 'input', handleKeywordInput );

		$form.on( 'change', '.toggle-fields-row input[type="checkbox"]', resetAndFetch );

		$loadMore.on( 'click', 'a', function ( event ) {
			event.preventDefault();
			fetchFilteredResults( $( '.iec_product_post_box_warpper' ).length, true );
		} );

		$( '.search-field' ).on( 'click', '.close', function ( event ) {
			event.preventDefault();
			$keywordInput.val( '' );
			resetAndFetch();
		} );

		$( '.filters-group' ).on( 'click', function () {
			$( this ).toggleClass( 'expand' );
		} );
	} );
}( jQuery ) );
