( function ( $ ) {
    'use strict';

    window.IEC = window.IEC || {};

    if ( typeof Swiper === 'undefined' ) {
        return;
    }

    /* ------------------------------------------------------------------ */
    /* 1. HELPERS                                                         */
    /* ------------------------------------------------------------------ */

    /* already initialized check: */
    function isReady( el ) {
        return el && ! el.swiper;
    }

    /* swiper wrapper check: */
    function hasWrapper( el ) {
        if ( ! el || ! el.children ) {
            return false;
        }
        for ( var i = 0; i < el.children.length; i++ ) {
            if ( el.children[ i ].classList && el.children[ i ].classList.contains( 'swiper-wrapper' ) ) {
                return true;
            }
        }
        return false;
    }

    /* unready elements: */
    function $ready( selector, context ) {
        return $( selector, context ).filter( function () {
            return isReady( this );
        } );
    }

    function swiperConfig( config ) {
        return Object.assign( {
            touchStartPreventDefault: false,
            preventClicks: false,
            preventClicksPropagation: false,
        }, config || {} );
    }

    /* create swiper instance: */
    function create( el, config ) {
        if ( ! isReady( el ) ) {
            return el.swiper || null;
        }
        if ( ! hasWrapper( el ) ) {
            return null;
        }
        return new Swiper( el, swiperConfig( config ) );
    }

    IEC.swiperConfig = swiperConfig;

    IEC.initMobileOnlySwiper = function ( selector, options ) {
        var el = document.querySelector( selector );
        var mobile = window.matchMedia( '(max-width: 767px)' );

        if ( ! el ) {
            return;
        }

        function sync() {
            if ( mobile.matches ) {
                if ( ! el.swiper ) {
                    create( el, options );
                }
                return;
            }

            if ( el.swiper ) {
                el.swiper.destroy( true, true );
            }
        }

        sync();
        mobile.addEventListener( 'change', sync );
    };

    /* slide count: */
    function slideCount( el ) {
        return $( el ).find( '.swiper-slide' ).length;
    }

    /* ------------------------------------------------------------------ */
    /* 2. CONFIGS                                                         */
    /* ------------------------------------------------------------------ */

    /* office hero defaults: */
    function officeHeroConfig( $el ) {
        return {
            loop: true,
            speed: 600,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: {
                el: $el.find( '.swiper-pagination' )[0] || null,
                clickable: true,
            },
        };
    }

    /* portfolio slider settings: */
    function starlinkPortfolioConfig( pagination, next, prev ) {
        return {
            slidesPerView: 'auto',
            spaceBetween: 24,
            loop: true,
            pauseOnMouseEnter: true,
            pagination: { el: pagination, clickable: true },
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: { nextEl: next, prevEl: prev },
            breakpoints: {
                0: { spaceBetween: 15 },
                768: { spaceBetween: 25 },
                1024: { spaceBetween: 30 },
            },
        };
    }

    /* market desktop / mobile settings: */
    function marketConfig( next, prev, pagination ) {
        return {
            desktop: {
                slidesPerView: 'auto',
                spaceBetween: 44,
                loop: false,
                watchOverflow: true,
                autoplay: { delay: 2500, disableOnInteraction: false },
                navigation: { nextEl: next, prevEl: prev },
                pagination: { el: pagination, clickable: true },
            },
            mobile: {
                slidesPerView: 1,
                loop: false,
                watchOverflow: true,
                autoplay: { delay: 2500, disableOnInteraction: false },
                spaceBetween: 23,
                navigation: { nextEl: next, prevEl: prev },
            },
        };
    }

    /* ------------------------------------------------------------------ */
    /* 3. HOME                                                            */
    /* ------------------------------------------------------------------ */

    /* home hero stack: */
    function initHomeHeroStack() {
        if ( document.querySelector( '[data-iec-hero-cycle]' ) ) {
            return;
        }

        $( '[data-iec-hero-stack="1"]' ).each( function () {
            var $root = $( this );
            if ( $root.data( 'iecHeroStackBound' ) ) {
                return;
            }
            $root.data( 'iecHeroStackBound', true );

            var $cards = $root.find( '.iec_home_hero_card' );
            var total  = $cards.length;
            var active = 0;
            var timer  = null;
            var delay  = 5500;
            var fading = false;
            var animMs = 3000;

            if ( total < 1 ) {
                return;
            }

            function applyDepths( index ) {
                $cards.each( function () {
                    var $card = $( this );
                    var i     = parseInt( $card.attr( 'data-index' ), 10 ) || 0;
                    var depth = ( i - index + total ) % total;
                    var label = 0 === depth ? '0' : 'hide';

                    $card
                        .attr( 'data-depth', label )
                        .toggleClass( 'is-active', 0 === depth )
                        .toggleClass( 'is-hidden-stack', 0 !== depth );
                } );
            }

            function updateCopyFromSlide( index ) {
                var $section = $root.closest( '.iec_section_home_hero' );
                var $heading = $section.find( '.iec_home_hero_heading' );
                var $text    = $section.find( '.iec_home_hero_text' );
                var $card    = $cards.filter( '[data-index="' + index + '"]' );
                var heading  = $card.attr( 'data-heading' ) || '';
                var content  = $card.attr( 'data-content' ) || '';
                var $targets = $heading.add( $text );

                if ( heading && $heading.length ) {
                    $heading.text( heading );
                }

                if ( content && $text.length ) {
                    $text.html( '<p></p>' ).find( 'p' ).text( content );
                }

                if ( ! $targets.length ) {
                    return;
                }

                $targets.removeClass( 'iec_home_hero_copy_fade' );
                $targets.each( function () {
                    void this.offsetWidth;
                } );
                $targets.addClass( 'iec_home_hero_copy_fade' );
            }

            function setActive( index ) {
                if ( index < 0 || index >= total || index === active || fading ) {
                    return;
                }

                var $outgoing = $cards.filter( '[data-index="' + active + '"]' );
                var $incoming = $cards.filter( '[data-index="' + index + '"]' );

                fading = true;
                $root.addClass( 'is-fading' );
                $outgoing.addClass( 'is-fade-out' );
                $incoming.addClass( 'is-fade-in' );
                updateCopyFromSlide( index );

                window.setTimeout( function () {
                    active = index;
                    applyDepths( active );
                    $cards.removeClass( 'is-fade-out is-fade-in' );
                    $root.removeClass( 'is-fading' );
                    fading = false;
                }, animMs );
            }

            function next() {
                setActive( ( active + 1 ) % total );
            }

            function startAutoplay() {
                stopAutoplay();
                if ( total < 2 ) {
                    return;
                }
                timer = window.setInterval( next, delay );
            }

            function stopAutoplay() {
                if ( timer ) {
                    window.clearInterval( timer );
                    timer = null;
                }
            }

            $root.on( 'mouseenter.iecHeroStack focusin.iecHeroStack', stopAutoplay );
            $root.on( 'mouseleave.iecHeroStack focusout.iecHeroStack', startAutoplay );

            applyDepths( 0 );
            startAutoplay();
        } );
    }

    /* home hero swiper: */
    function initHomeHeroSwiper() {
        var $heroes = $( '[data-iec-hero-swiper]' );
        if ( ! $heroes.length ) {
            return;
        }

        var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

        $heroes.each( function () {
            var $hero = $( this );
            var $tracks = $hero.find( '.iec-home-hero-swiper' );

            $tracks.each( function () {
                var el = this;
                if ( ! isReady( el ) || ! hasWrapper( el ) ) {
                    return;
                }

                var slides = slideCount( el );
                var trackKey = el.getAttribute( 'data-iec-hero-track' ) || 'desktop';
                var $dots = $hero.find( '[data-iec-hero-dots="' + trackKey + '"] .iec_home_hero_dots' );
                var bloom = $hero.find( '.iec_home_hero_bloom' )[0];

                var swiper = create( el, {
                    slidesPerView: 1,
                    speed: reduceMotion ? 0 : 1600,
                    loop: slides > 1,
                    allowTouchMove: slides > 1,
                    followFinger: true,
                    resistanceRatio: 0.65,
                    watchOverflow: true,
                    observer: true,
                    observeParents: true,
                    autoplay: slides > 1 && ! reduceMotion
                        ? { delay: 7000, disableOnInteraction: false, pauseOnMouseEnter: true }
                        : false,
                    pagination: $dots.length && slides > 1
                        ? {
                            el: $dots[0],
                            clickable: true,
                            renderBullet: function ( index, className ) {
                                return '<button type="button" class="' + className + ' iec_home_hero_dot" aria-label="Go to slide ' + ( index + 1 ) + '"><span class="iec_home_hero_dot_fill" aria-hidden="true"></span></button>';
                            },
                        }
                        : undefined,
                    on: {
                        slideChangeTransitionStart: function () {
                            if ( reduceMotion || ! bloom ) {
                                return;
                            }
                            bloom.classList.remove( 'is-blooming' );
                            void bloom.offsetWidth;
                            bloom.classList.add( 'is-blooming' );
                        },
                    },
                } );

                if ( swiper && swiper.autoplay && $hero.hasClass( 'iec-anim-hero-curtain' ) ) {
                    swiper.autoplay.stop();
                    window.setTimeout( function () {
                        if ( swiper.autoplay ) {
                            swiper.autoplay.start();
                        }
                    }, 1100 );
                }
            } );
        } );
    }

    /* home hero: */
    function initHomeHero() {
        initHomeHeroStack();
        initHomeHeroSwiper();

        var $el = $ready( '.iec_home_page_banner_section .iec_single_office_swiper' );
        if ( ! $el.length ) {
            return;
        }

        var $wrap = $el.closest( '.iec_single_office_banner_swiper_warpper' );

        create( $el[0], {
            spaceBetween: 30,
            centeredSlides: true,
            loop: false,
            initialSlide: 0,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: {
                el: $wrap.find( '.swiper-pagination' )[0] || '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.iec_home_page_banner_section .iec_single_office_swiper_next',
                prevEl: '.iec_home_page_banner_section .iec_single_office_swiper_prev',
            },
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 4. HERO BANNERS                                                    */
    /* ------------------------------------------------------------------ */

    /* office hero: */
    function initOfficeHero() {
        var $el = $ready( '.iec_banner_section .iec_single_office_swiper' );
        if ( ! $el.length ) {
            return;
        }

        create( $el[0], $.extend( true, officeHeroConfig( $el ), {
            navigation: {
                nextEl: '.iec_banner_section .iec_single_office_swiper_next',
                prevEl: '.iec_banner_section .iec_single_office_swiper_prev',
            },
        } ) );
    }

    /* iot hero: */
    function initIotHero() {
        var $el = $ready( '.iec-iot-hero-swiper' );
        if ( ! $el.length ) {
            return;
        }

        create( $el[0], {
            loop: true,
            speed: 600,
            navigation: {
                nextEl: '.iec_iot_slider_section .slider-button-next',
                prevEl: '.iec_iot_slider_section .slider-button-prev',
            },
        } );
    }

    /* tab-landing hero: */
    function initTunisianHero() {
        var $root = $( '.iec-tab-landing' );
        if ( ! $root.length ) {
            return;
        }

        var $el = $ready( '.iec_single_office_swiper', $root );
        if ( ! $el.length ) {
            return;
        }

        create( $el[0], {
            spaceBetween: 30,
            centeredSlides: true,
            loop: false,
            initialSlide: 0,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: {
                el: $el.find( '.swiper-pagination' )[0],
                clickable: true,
            },
            navigation: {
                nextEl: $root.find( '.iec_single_office_swiper_next' )[0],
                prevEl: $root.find( '.iec_single_office_swiper_prev' )[0],
            },
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 5. NEWS                                                            */
    /* ------------------------------------------------------------------ */

    /* news gallery: */
    function initNewsGallery() {
        var $sliders = $ready( '.iec_single_news_slider_warpper .swiper[class*="iec_single_news_detail_swiper"]' );
        if ( ! $sliders.length ) {
            return;
        }

        $sliders.each( function () {
            var $el = $( this );
            var $wrap = $el.closest( '.iec_single_news_slider_warpper' );
            var nextEl = $wrap.find( '.iec_single_news_next' )[0] || null;
            var prevEl = $wrap.find( '.iec_single_news_prev' )[0] || null;
            var pagEl = $wrap.find( '.iec_single_news_pagination' )[0] || null;
            var slides = slideCount( this );

            create( this, {
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 20,
                loop: slides > 2,
                grabCursor: true,
                navigation: {
                    nextEl: nextEl,
                    prevEl: prevEl,
                },
                pagination: pagEl
                    ? {
                        el: pagEl,
                        clickable: true,
                    }
                    : undefined,
                breakpoints: {
                    768: { spaceBetween: 120 },
                    1025: { spaceBetween: 170 },
                },
            } );
        } );
    }

    function featuredNewsIsMobile() {
        return window.matchMedia( '(max-width: 767px)' ).matches;
    }

    function muteFeaturedNewsClones( root ) {
        $( root ).find( '.swiper-slide-duplicate' ).each( function () {
            var slide = this;
            slide.setAttribute( 'aria-hidden', 'true' );
            slide.setAttribute( 'data-nosnippet', '' );

            $( slide ).find( 'a' ).each( function () {
                var span = document.createElement( 'span' );
                span.className = this.className;
                span.innerHTML = this.innerHTML;
                this.replaceWith( span );
            } );

            $( slide ).find( 'img' ).each( function () {
                this.alt = '';
                this.removeAttribute( 'srcset' );
                this.removeAttribute( 'sizes' );
            } );
        } );
    }

    function placeFeaturedNewsCards() {
        $( '.bd_do_featured_news' ).each( function () {
            var section = this;
            var grid = section.querySelector( '.iec_single_office_featured_news_margin' );
            var swiperEl = section.querySelector( '.iec_featured_news_swiper' );

            if ( ! grid || ! swiperEl || swiperEl.closest( '[data-office-tabs]' ) ) {
                return;
            }

            var wrapper = swiperEl.querySelector( '.swiper-wrapper' );

            if ( ! wrapper ) {
                return;
            }

            if ( swiperEl.swiper ) {
                swiperEl.swiper.destroy( true, true );
            }

            $( wrapper ).children( '.swiper-slide-duplicate' ).remove();

            $( wrapper ).children( '.swiper-slide' ).each( function () {
                var card = this.querySelector( '.iec_news_post_box_warpper' );

                if ( card ) {
                    grid.appendChild( card );
                }
            } );

            wrapper.innerHTML = '';

            if ( ! featuredNewsIsMobile() ) {
                return;
            }

            $( grid ).children( '.iec_news_post_box_warpper' ).each( function () {
                var slide = document.createElement( 'div' );
                slide.className = 'swiper-slide';
                slide.appendChild( this );
                wrapper.appendChild( slide );
            } );
        } );
    }

    /* featured news (legacy): */
    function initNewsFeatured() {
        var $el = $ready( '.iec_single_office_featured_news_swiper' );
        if ( ! $el.length ) {
            return;
        }

        create( $el[0], {
            spaceBetween: 30,
            centeredSlides: true,
            navigation: {
                nextEl: '.iec_featured_news_swiper_next',
                prevEl: '.iec_featured_news_swiper_prev',
            },
        } );
    }

    /* featured news cards: */
    function initFeaturedNewsSwipers() {
        $ready( '.iec-featured-news-swiper, .iec-news-featured-swiper' ).each( function () {
            var $el = $( this );

            if ( $el.closest( '.iec_office_tabs_swiper' ).length || $el.hasClass( 'iec_featured_news_swiper' ) ) {
                return;
            }

            if ( slideCount( this ) < 2 ) {
                return;
            }

            var $parent = $el.closest( '.iec_single_office_featured_news_margin' ).length
                ? $el.closest( '.iec_single_office_featured_news_margin' )
                : $el.parent();

            create( this, {
                slidesPerView: 1.05,
                spaceBetween: 16,
                watchOverflow: true,
                navigation: {
                    nextEl: $parent.find( '.iec-featured-news-swiper-next, .iec-news-featured-swiper-next' )[0],
                    prevEl: $parent.find( '.iec-featured-news-swiper-prev, .iec-news-featured-swiper-prev' )[0],
                },
            } );
        } );
    }

    /* office tab featured news: */
    function initOfficeTabFeaturedNews() {
        var $root = $( '[data-office-tabs]' );
        if ( ! $root.length ) {
            return;
        }

        $ready( '.iec_featured_news_swiper', $root ).each( function () {
            if ( slideCount( this ) < 2 ) {
                return;
            }

            var $el   = $( this );
            var $wrap = $el.closest( '.iec_single_office_featured_news_swiper' ).length
                ? $el.closest( '.iec_single_office_featured_news_swiper' )
                : $el.parent();

            create( this, {
                slidesPerView: 1.05,
                spaceBetween: 16,
                watchOverflow: true,
                nested: true,
                navigation: {
                    nextEl: $wrap.find( '.iec_featured_news_swiper_next' )[0] || null,
                    prevEl: $wrap.find( '.iec_featured_news_swiper_prev' )[0] || null,
                },
            } );
        } );
    }

    /* global featured news: */
    function initGlobalFeaturedNews() {
        placeFeaturedNewsCards();

        if ( ! featuredNewsIsMobile() ) {
            return;
        }

        $ready( '.iec_featured_news_swiper' ).each( function () {
            var $el = $( this );

            if ( $el.closest( '[data-office-tabs]' ).length || slideCount( this ) < 1 ) {
                return;
            }

            var $wrap = $el.closest( '.iec_single_office_featured_news_swiper' ).length
                ? $el.closest( '.iec_single_office_featured_news_swiper' )
                : $el.parent();

            var instance = create( this, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: slideCount( this ) > 1,
                centeredSlides: true,
                navigation: {
                    nextEl: $wrap.find( '.iec_featured_news_swiper_next' )[ 0 ] || null,
                    prevEl: $wrap.find( '.iec_featured_news_swiper_prev' )[ 0 ] || null,
                },
                on: {
                    init: function () {
                        muteFeaturedNewsClones( this.el );
                    },
                },
            } );

            if ( instance ) {
                muteFeaturedNewsClones( instance.el );
            }
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 6. OFFICE + TABS                                                   */
    /* ------------------------------------------------------------------ */

    var OFFICE_TAB_HASH = {
        '#about_us': 0,
        '#regional_news': 1,
        '#contact_us': 2,
        '#contat_us': 2,
    };

    /* office solutions: */
    function initOfficeSolutionSwipers() {
        $ready( '.solution_swiper, .iec_solution_swiper' ).each( function () {
            var $el       = $( this );
            var $section  = $el.closest( '.iec_solution_section' );
            var $wrapper  = $el.closest( '.iec_solution_swiper_warpper' );
            var $pag      = $section.find( '.iec_solution_pagination, .swiper-pagination' ).first();
            var inTabs    = $el.closest( '.iec_office_tabs_swiper' ).length > 0;

            create( this, {
                slidesPerView: 'auto',
                spaceBetween: $section.length ? 8 : 24,
                watchOverflow: true,
                nested: inTabs,
                pagination: $pag.length ? { el: $pag[0], clickable: true } : undefined,
                navigation: {
                    nextEl: $wrapper.find( '.swiper-button-next' )[0] || null,
                    prevEl: $wrapper.find( '.swiper-button-prev' )[0] || null,
                },
            } );
        } );
    }

    /* office tab active state: */
    function syncTabButtons( $root, activeIndex ) {
        $root.find( '.custom-tab-btn' ).each( function () {
            var idx      = parseInt( $( this ).attr( 'data-tab' ), 10 );
            var isActive = idx === activeIndex;
            $( this ).toggleClass( 'active', isActive ).attr( 'aria-selected', isActive ? 'true' : 'false' ).attr( 'tabindex', isActive ? '0' : '-1' );
        } );
    }

    /* office tabs: */
    function initOfficeTabs() {
        var $root = $( '[data-office-tabs]' );
        if ( ! $root.length ) {
            return;
        }

        var $swiperEl = $ready( '.iec_office_tabs_swiper', $root );
        if ( ! $swiperEl.length ) {
            return;
        }

        var tabsSwiper = create( $swiperEl[0], {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 600,
            autoHeight: true,
            allowTouchMove: false,
            simulateTouch: false,
            preventClicks: false,
            preventClicksPropagation: false,
            touchStartPreventDefault: false,
            resistanceRatio: 0.85,
            preventInteractionOnTransition: true,
            watchOverflow: true,
            on: {
                slideChange: function () {
                    syncTabButtons( $root, this.activeIndex );
                },
                resize: function () {
                    this.updateAutoHeight( 600 );
                },
            },
        } );

        if ( ! tabsSwiper ) {
            return;
        }

        syncTabButtons( $root, tabsSwiper.activeIndex );

        $root.find( '.custom-tab-btn' ).off( 'click.iecTabs' ).on( 'click.iecTabs', function () {
            var idx = parseInt( $( this ).attr( 'data-tab' ), 10 );
            if ( isNaN( idx ) || $( this ).hasClass( 'active' ) ) {
                return;
            }
            tabsSwiper.slideTo( idx, 600 );
            IEC.scrollTo( $root );
        } );

        function goToHashTab() {
            var hash = window.location.hash;
            if ( ! hash || OFFICE_TAB_HASH[ hash ] === undefined ) {
                return;
            }
            var index = OFFICE_TAB_HASH[ hash ];
            if ( index !== tabsSwiper.activeIndex ) {
                tabsSwiper.slideTo( index, 600 );
            }
        }

        goToHashTab();
        $( window ).off( 'hashchange.iecTabs' ).on( 'hashchange.iecTabs', goToHashTab );

        initOfficeTabFeaturedNews();
    }

    /* tab-landing button state: */
    function setLandingTabActive( $buttons, activeIndex ) {
        $buttons.each( function ( i ) {
            var isActive = i === activeIndex;
            $( this ).toggleClass( 'active', isActive ).attr( 'aria-selected', isActive ? 'true' : 'false' ).attr( 'tabindex', isActive ? '0' : '-1' );
        } );
    }

    /* tab-landing content: */
    function initTabLandingSwiper() {
        var $root = $( '.iec-tab-landing' );
        if ( ! $root.length ) {
            return;
        }

        var $swiperEl = $ready( '[data-tab-landing-swiper]', $root );
        var $buttons  = $root.find( '[data-tab-landing-tabs] .custom-tab-btn' );

        if ( ! $swiperEl.length || ! $buttons.length ) {
            return;
        }

        var swiper = create( $swiperEl[0], {
            slidesPerView: 1,
            speed: 600,
            autoHeight: true,
            allowTouchMove: true,
            on: {
                slideChange: function () {
                    setLandingTabActive( $buttons, swiper.activeIndex );
                },
            },
        } );

        if ( ! swiper ) {
            return;
        }

        $buttons.off( 'click.iecLandingTab' ).on( 'click.iecLandingTab', function () {
            var index = parseInt( $( this ).attr( 'data-tab-index' ), 10 );
            if ( isNaN( index ) || index === swiper.activeIndex ) {
                return;
            }
            swiper.slideTo( index );
            setLandingTabActive( $buttons, index );
            IEC.scrollTo( $root.find( '.iec_tab_landing_tab_section' ) );
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 7. PRODUCT                                                         */
    /* ------------------------------------------------------------------ */

    /* product thumbs + main: */
    function initProductHero() {
        var thumbEl = document.querySelector( '.iec_single_porduct_swiper_thumb_hero' );
        var mainEl  = document.querySelector( '.iec_single_porduct_swiper_main_hero' );
        var desktop = window.matchMedia( '(min-width: 992px)' );

        if ( ! thumbEl || ! mainEl ) {
            return;
        }

        function sync() {
            if ( thumbEl.swiper ) {
                thumbEl.swiper.destroy( true, true );
            }
            if ( mainEl.swiper ) {
                mainEl.swiper.destroy( true, true );
            }

            var thumbSwiper = create( thumbEl, {
                spaceBetween: 30,
                slidesPerView: 3,
                watchSlidesProgress: true,
                watchOverflow: true,
                direction: desktop.matches ? 'vertical' : 'horizontal',
                navigation: {
                    nextEl: '.hero-swiper-button-next',
                    prevEl: '.hero-swiper-button-prev',
                },
            } );

            create( mainEl, {
                spaceBetween: 10,
                watchOverflow: true,
                thumbs: { swiper: thumbSwiper },
            } );
        }

        sync();
        desktop.addEventListener( 'change', sync );
    }

    /* market sliders: */
    function initMarketSwipers() {
        [
            {
                selector: '.market_swiper_0',
                next: '.swiper-button-next-0',
                prev: '.swiper-button-prev-0',
                pag: '.swiper-pagination-0',
            },
            {
                selector: '.market_swiper_1',
                next: '.swiper-button-next-1',
                prev: '.swiper-button-prev-1',
                pag: '.swiper-pagination-1',
            },
        ].forEach( function ( item ) {
            var $el = $ready( item.selector );
            if ( ! $el.length ) {
                return;
            }
            var cfg = marketConfig( item.next, item.prev, item.pag );
            var wide = window.matchMedia( '(min-width: 637px)' );

            function sync() {
                if ( $el[0].swiper ) {
                    $el[0].swiper.destroy( true, true );
                }
                create( $el[0], wide.matches ? cfg.desktop : cfg.mobile );
            }

            sync();
            wide.addEventListener( 'change', sync );
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 8. STARLINK + OFFSHORE                                             */
    /* ------------------------------------------------------------------ */

    /* starlink portfolio: */
    function initStarlinkPortfolioSwipers() {
        $ready( '.starlink_portfolio_maritime_swiper, .starlink_portfolio_land_swiper' ).each( function () {
            var $el    = $( this );
            var $scope = $el.closest( '.iec_starlink_portfolio_swiper_warpper' );

            if ( ! $scope.length ) {
                $scope = $el.parent();
            }

            create( this, starlinkPortfolioConfig(
                $scope.find( '.swiper-pagination' )[0] || null,
                $scope.find( '.swiper-button-next' )[0] || null,
                $scope.find( '.swiper-button-prev' )[0] || null
            ) );
        } );
    }

    /* offshore portfolio: */
    function initOffshorePortfolio() {
        var $section = $( '.offshore .iec_starlink_portfolio_maritime_swiper_section' );
        if ( ! $section.length ) {
            return;
        }

        var $el = $ready( '.starlink_portfolio_maritime_swiper', $section );
        if ( ! $el.length ) {
            return;
        }

        create( $el[0], {
            slidesPerView: 'auto',
            spaceBetween: 24,
            loop: true,
            pagination: {
                el: $section.find( '.starlink_portfolio_maritime_pagination' )[0],
                clickable: true,
            },
            navigation: {
                nextEl: $section.find( '.starlink_portfolio_maritime_next' )[0],
                prevEl: $section.find( '.starlink_portfolio_maritime_prev' )[0],
            },
        } );
    }

    /* offshore vas tabs: */
    function initOffshoreVasSwiper() {
        var $swiperEl = $ready( '[data-offshore-vas-swiper]' );
        if ( ! $swiperEl.length ) {
            return;
        }

        var $tabs = $( '.block-7 .custom-tab' );

        var swiper = create( $swiperEl[0], {
            slidesPerView: 1,
            speed: 700,
            autoHeight: true,
            allowTouchMove: true,
        } );

        if ( ! swiper ) {
            return;
        }

        $tabs.off( 'click.iecVas' ).on( 'click.iecVas', function () {
            var index = parseInt( $( this ).attr( 'data-index' ), 10 );
            if ( isNaN( index ) ) {
                return;
            }
            swiper.slideTo( index );
            $tabs.removeClass( 'active' );
            $( this ).addClass( 'active' );
        } );

        swiper.on( 'slideChange', function () {
            $tabs.removeClass( 'active' ).eq( swiper.activeIndex ).addClass( 'active' );

            var activeSlide = swiper.slides[ swiper.activeIndex ];

            if ( activeSlide ) {
                document.dispatchEvent(
                    new CustomEvent( 'iec:offshore-vas-slide', {
                        detail: { slide: activeSlide },
                    } )
                );
            }
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 9. DIRECTIONS                                                      */
    /* ------------------------------------------------------------------ */

    /* synced left / right sliders: */
    function initSyncedDirections( opts ) {
        var $section = $( opts.section );
        if ( ! $section.length ) {
            return;
        }

        var $right = $section.find( opts.right );
        var $left  = $section.find( opts.left );

        if ( ! $right.length || ! $left.length ) {
            return;
        }

        if ( opts.destroyFirst ) {
            [ $right[0], $left[0] ].forEach( function ( el ) {
                if ( el.swiper ) {
                    el.swiper.destroy( true, true );
                }
            } );
        }

        if ( ! isReady( $right[0] ) && ! opts.destroyFirst ) {
            return;
        }

        var $bg = opts.bg ? $section.find( opts.bg ) : $();

        var leftSwiper = create( $left[0], {
            slidesPerView: 1,
            effect: opts.fadeLeft ? 'fade' : undefined,
            fadeEffect: opts.fadeLeft ? { crossFade: true } : undefined,
            loop: true,
            allowTouchMove: false,
            speed: 600,
        } );

        var rightSwiper = create( $right[0], $.extend( true, {
            slidesPerView: 1,
            spaceBetween: 0,
            centeredSlides: true,
            loop: true,
            speed: 600,
            pagination: opts.pagination ? { el: opts.pagination, clickable: true } : undefined,
            navigation: opts.navigation || undefined,
            breakpoints: opts.breakpoints || {
                1024: { slidesPerView: 3, centeredSlides: false, spaceBetween: 20 },
            },
        }, opts.rightExtra || {} ) );

        if ( ! rightSwiper ) {
            return;
        }

        function syncBg( idx ) {
            if ( $bg.length ) {
                $bg.removeClass( 'active-bg' ).eq( idx ).addClass( 'active-bg' );
            }
        }

        rightSwiper.on( 'slideChange', function () {
            var idx = rightSwiper.realIndex;
            if ( leftSwiper ) {
                leftSwiper.slideToLoop( idx, 600, false );
            }
            syncBg( idx );
        } );

        syncBg( rightSwiper.realIndex );
        if ( leftSwiper ) {
            leftSwiper.slideToLoop( rightSwiper.realIndex, 0, false );
        }
    }

    /* optiview directions: */
    function initOptiviewDirections() {
        if ( ! $( '.vms__directions-right, .vms__directions-left' ).length ) {
            return;
        }

        initSyncedDirections( {
            section: '.iec_optiview_directions',
            right: '.vms__directions-right',
            left: '.vms__directions-left',
            bg: '.directions__bg img',
            pagination: '.vms-swiper-pagination',
            navigation: {
                nextEl: '.vms-swiper-button-next',
                prevEl: '.vms-swiper-button-prev',
            },
            fadeLeft: true,
            destroyFirst: true,
        } );
    }

    /* voucher directions: */
    function initVoucherDirections() {
        var $section = $( '.iec_optiview_directions' );
        if ( ! $section.length || $section.find( '.vms__directions-right' ).length ) {
            return;
        }

        initSyncedDirections( {
            section: $section,
            right: '.swiper__directions-right',
            left: '.swiper__directions-left',
            bg: '.directions__bg img',
            pagination: $section.find( '.swiper-pagination' )[0],
            navigation: {
                nextEl: $section.find( '.swiper-button-next' )[0],
                prevEl: $section.find( '.swiper-button-prev' )[0],
            },
            fadeLeft: false,
            destroyFirst: false,
        } );
    }

    /* ------------------------------------------------------------------ */
    /* 10. BOOT                                                           */
    /* ------------------------------------------------------------------ */

    /* start all sliders: */
    function initAll() {
        initHomeHero();
        initOfficeHero();
        initIotHero();
        initTunisianHero();
        initNewsGallery();
        initNewsFeatured();
        initFeaturedNewsSwipers();
        initGlobalFeaturedNews();
        initOfficeTabs();
        initOfficeSolutionSwipers();
        initTabLandingSwiper();
        initProductHero();
        initMarketSwipers();
        initStarlinkPortfolioSwipers();
        initOffshorePortfolio();
        initOffshoreVasSwiper();
        initOptiviewDirections();
        initVoucherDirections();
    }

    IEC.initSwipers             = initAll;
    IEC.initFeaturedNewsSwipers = initFeaturedNewsSwipers;
    IEC.placeFeaturedNewsCards  = placeFeaturedNewsCards;

    window.matchMedia( '(max-width: 767px)' ).addEventListener( 'change', function () {
        $( '.bd_do_featured_news .iec_featured_news_swiper' ).each( function () {
            if ( this.swiper ) {
                this.swiper.destroy( true, true );
            }
        } );
        initGlobalFeaturedNews();
    } );

    window.useCaseSwiper = function () {
        initOptiviewDirections();
        initVoucherDirections();
    };

} )( jQuery );
