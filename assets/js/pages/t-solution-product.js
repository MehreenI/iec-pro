( function ( $ ) {
    'use strict';

    var config = window.iecSpLanding || {};
    var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    /* ── Hero word-split reveal ─────────────────────────────── */

    function splitIntoWords( el ) {
        var text = el.textContent.trim();
        var words = text.split( /\s+/ );

        el.innerHTML = '';

        words.forEach( function ( word, index ) {
            var wrap = document.createElement( 'span' );
            wrap.className = 'word-wrap';

            var span = document.createElement( 'span' );
            span.className = 'word';
            span.style.animationDelay = ( index * 0.05 ) + 's';
            span.textContent = word;

            wrap.appendChild( span );
            el.appendChild( wrap );

            if ( index < words.length - 1 ) {
                el.appendChild( document.createTextNode( '\u00A0' ) );
            }
        } );
    }

    function initHeroReveal() {
        var hero = document.querySelector( '.iec_hero_banner' );
        if ( ! hero ) {
            return;
        }

        var splitEls = hero.querySelectorAll( '.js-split-reveal' );
        var fadeEls = hero.querySelectorAll( '.js-fade-up' );

        if ( ! reduceMotion ) {
            splitEls.forEach( splitIntoWords );
        }

        requestAnimationFrame( function () {
            hero.classList.add( 'is-revealed' );

            setTimeout(
                function () {
                    splitEls.forEach( function ( el ) {
                        el.classList.add( 'is-revealed' );
                    } );
                    fadeEls.forEach( function ( el ) {
                        el.classList.add( 'is-revealed' );
                    } );
                },
                reduceMotion ? 0 : 500
            );
        } );
    }

    /* ── Scroll reveal ──────────────────────────────────────── */

    function observeReveal( elements ) {
        if ( ! elements.length ) {
            return;
        }

        if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
            elements.forEach( function ( el ) {
                el.classList.add( 'is-inview' );
            } );
            return;
        }

        var observer = new IntersectionObserver(
            function ( entries ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        entry.target.classList.add( 'is-inview' );
                        observer.unobserve( entry.target );
                    }
                } );
            },
            {
                threshold: 0.15,
                rootMargin: '0px 0px -40px 0px',
            }
        );

        elements.forEach( function ( el ) {
            observer.observe( el );
        } );
    }

    function initScrollReveal() {
        observeReveal(
            document.querySelectorAll(
                '.iec_product_post_filter_forms, .iec-product-solution-wrapper, section.btn, .intro .wyswig-content p'
            )
        );
    }

    /* ── Product listing (filters + load more) ───────────────── */

    function parseProductCards( html ) {
        return $( '<div>' ).html( $.trim( html ) ).children( '.iec-product-solution-wrapper' );
    }

    function initProductListing() {
        var $form = $( '[data-sp-landing-filters]' );
        var $section = $( '[data-sp-landing-grid]' );
        var $grid = $( '[data-sp-landing-products]' );
        var $gridLoader = $( '[data-sp-landing-grid-loader]' );
        var $loadMoreWrap = $( '[data-sp-landing-actions] .load-more' );
        var $loadMoreBtn = $( '[data-sp-landing-load-more]' );
        var $loadMoreLabel = $loadMoreBtn.find( '.load-more__label' );
        var $noResults = $( '[data-sp-landing-no-results]' );

        if ( ! $section.length || ! $grid.length || ! config.ajaxUrl || ! config.action ) {
            return;
        }

        var currentPage = parseInt( $section.attr( 'data-page' ), 10 ) || 1;
        var isLoading = false;
        var filterTimer = null;
        var searchTimer = null;
        var searchDebounce = 1000;
        var activeRequest = null;
        var defaultLabel = $loadMoreLabel.text() || 'View More';
        var loadingLabel = config.loadingText || 'Loading..';
        var $keyword = $( '#keyword' );
        var $searchField = $keyword.closest( '.iec_search_field' );
        var $gridWrap = $section.find( '.iec-grid-wrap' );

        function syncKeywordState() {
            $searchField.toggleClass( 'has-keyword', $.trim( $keyword.val() ) !== '' );
        }

        function setNoResultsState( showNoResults ) {
            $gridWrap.prop( 'hidden', showNoResults );
            $noResults.prop( 'hidden', ! showNoResults );
        }

        function setGridLoading( loading ) {
            if ( loading ) {
                setNoResultsState( false );
            }

            $section.toggleClass( 'is-filter-loading', loading );
            $gridLoader.prop( 'hidden', ! loading );
            $gridLoader.attr( 'aria-hidden', loading ? 'false' : 'true' );

            if ( loading ) {
                $grid.empty();
            }
        }

        function setLoadMoreLoading( loading ) {
            $loadMoreWrap.toggleClass( 'is-loading', loading );
            $loadMoreBtn.attr( 'aria-busy', loading ? 'true' : 'false' );
            $loadMoreBtn.prop( 'disabled', loading );
            $loadMoreLabel.text( loading ? loadingLabel : defaultLabel );
        }

        function updateResults( data, append ) {
            var $cards = parseProductCards( data.html || '' );

            if ( append ) {
                $grid.append( $cards );
            } else {
                $grid.html( $cards );
            }

            if ( $cards.length ) {
                observeReveal( $cards.toArray() );
                setNoResultsState( false );
                $loadMoreWrap.prop( 'hidden', ! data.has_more );
            } else if ( ! append ) {
                setNoResultsState( true );
                $loadMoreWrap.prop( 'hidden', true );
            }

            currentPage = parseInt( data.page, 10 ) || 1;
            $section.attr( 'data-page', String( currentPage ) );
        }

        function buildRequestData( page ) {
            var parts = [];
            var pageId = parseInt( $section.attr( 'data-page-id' ), 10 ) || parseInt( config.pageId, 10 ) || 0;

            if ( $form.length ) {
                var formQuery = $form.serialize();
                if ( formQuery ) {
                    parts.push( formQuery );
                }
            }

            parts.push(
                $.param( {
                    action: config.action,
                    sp_page: page,
                    page: page,
                    page_id: pageId,
                    lang: config.lang || '',
                    keyword: $.trim( $keyword.val() ),
                } )
            );

            return parts.join( '&' );
        }

        function fetchProducts( page, append ) {
            if ( ! config.ajaxUrl || ! config.action ) {
                window.alert( config.requestErrorText || 'Error: Could not load results' );
                return;
            }

            if ( activeRequest && activeRequest.readyState !== 4 ) {
                activeRequest.abort();
            }

            isLoading = true;

            if ( append ) {
                setLoadMoreLoading( true );
            } else {
                setGridLoading( true );
            }

            activeRequest = $.ajax( {
                url: config.ajaxUrl,
                method: 'GET',
                dataType: 'json',
                data: buildRequestData( page ),
                cache: false,
            } )
                .done( function ( response ) {
                    if ( ! response || ! response.success || ! response.data ) {
                        throw new Error( 'Invalid response' );
                    }

                    updateResults( response.data, append );
                } )
                .fail( function ( _xhr, status ) {
                    if ( 'abort' === status ) {
                        return;
                    }

                    window.alert( config.requestErrorText || 'Error: Could not load results' );
                } )
                .always( function () {
                    isLoading = false;
                    setGridLoading( false );
                    setLoadMoreLoading( false );
                    activeRequest = null;
                } );
        }

        if ( $form.length ) {
            $form.on( 'submit', function ( event ) {
                event.preventDefault();
            } );

            $form.on( 'change', 'input[name^="ps_filter"]', function () {
                if ( filterTimer ) {
                    window.clearTimeout( filterTimer );
                }

                filterTimer = window.setTimeout( function () {
                    fetchProducts( 1, false );
                }, 250 );
            } );
        }

        $keyword.on( 'keydown', function ( event ) {
            if ( 'Enter' === event.key ) {
                event.preventDefault();
            }
        } );

        $keyword.on( 'input', function () {
            syncKeywordState();

            if ( searchTimer ) {
                window.clearTimeout( searchTimer );
            }

            searchTimer = window.setTimeout( function () {
                fetchProducts( 1, false );
            }, searchDebounce );
        } );

        $searchField.on( 'click', '.close', function ( event ) {
            event.preventDefault();

            if ( searchTimer ) {
                window.clearTimeout( searchTimer );
            }

            $keyword.val( '' );
            syncKeywordState();
            fetchProducts( 1, false );
        } );

        if ( $loadMoreBtn.length ) {
            $loadMoreBtn.on( 'click', function () {
                if ( isLoading ) {
                    return;
                }

                fetchProducts( currentPage + 1, true );
            } );
        }

        syncKeywordState();

        $( document ).on( 'click', '[data-sp-landing-reset-filters]', function ( e ) {
            e.preventDefault();

            if ( isLoading || ! $form.length ) {
                return;
            }

            $form.find( 'input[name^="ps_filter"]' ).prop( 'checked', false );
            if ( searchTimer ) {
                window.clearTimeout( searchTimer );
            }
            $keyword.val( '' );
            syncKeywordState();
            fetchProducts( 1, false );
        } );
    }

    /* ── Mobile filter accordion ─────────────────────────────── */

    function initMobileFilterAccordion() {
        var $filterSection = $( '.iec_product_post_filter_forms' );

        if ( ! $filterSection.length ) {
            return;
        }

        var mobileMq = window.matchMedia( '(max-width: 768px)' );

        function isMobile() {
            return mobileMq.matches;
        }

        function resetDesktopState() {
            if ( isMobile() ) {
                return;
            }

            $filterSection.find( '.filters-group' ).removeClass( 'expand' );
            $filterSection.find( '.filters-group h6' ).attr( 'aria-expanded', 'false' );
        }

        $filterSection.find( '.filters-group h6' ).attr( {
            role: 'button',
            tabindex: '0',
            'aria-expanded': 'false',
        } );

        $filterSection.on( 'click', '.filters-group h6', function ( e ) {
            if ( ! isMobile() ) {
                return;
            }

            e.preventDefault();

            var $heading = $( this );
            var $group   = $heading.closest( '.filters-group' );
            var isOpen   = $group.hasClass( 'expand' );

            $filterSection.find( '.filters-group' ).removeClass( 'expand' );
            $filterSection.find( '.filters-group h6' ).attr( 'aria-expanded', 'false' );

            if ( ! isOpen ) {
                $group.addClass( 'expand' );
                $heading.attr( 'aria-expanded', 'true' );
            }
        } );

        $filterSection.on( 'keydown', '.filters-group h6', function ( e ) {
            if ( ! isMobile() ) {
                return;
            }

            if ( 'Enter' === e.key || ' ' === e.key ) {
                e.preventDefault();
                $( this ).trigger( 'click' );
            }
        } );

        if ( mobileMq.addEventListener ) {
            mobileMq.addEventListener( 'change', resetDesktopState );
        } else if ( mobileMq.addListener ) {
            mobileMq.addListener( resetDesktopState );
        }

        resetDesktopState();
    }

    /* ── Boot ─────────────────────────────────────────────────── */

    $( function () {
        initHeroReveal();
        initScrollReveal();
        initProductListing();
        initMobileFilterAccordion();
    } );
}( jQuery ) );
