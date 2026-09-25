( function ( $ ) {
    'use strict';

    function initNetworkLayerParticles() {
        var el = document.getElementById( 'iec-home-network-particles' );
        if ( ! el || typeof window.particlesJS !== 'function' ) {
            return;
        }

        window.particlesJS( 'iec-home-network-particles', {
            particles: {
                number: {
                    value: 70,
                    density: {
                        enable: true,
                        value_area: 900,
                    },
                },
                color: {
                    value: '#ffffff',
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#000000',
                    },
                    polygon: {
                        nb_sides: 5,
                    },
                },
                opacity: {
                    value: 0.55,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 0.8,
                        opacity_min: 0.15,
                        sync: false,
                    },
                },
                size: {
                    value: 2.8,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 2.5,
                        size_min: 0.6,
                        sync: false,
                    },
                },
                line_linked: {
                    enable: false,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1,
                },
                move: {
                    enable: true,
                    speed: 1.4,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200,
                    },
                },
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'bubble',
                    },
                    onclick: {
                        enable: true,
                        mode: 'push',
                    },
                    resize: true,
                },
                modes: {
                    grab: {
                        distance: 400,
                        line_linked: {
                            opacity: 1,
                        },
                    },
                    bubble: {
                        distance: 180,
                        size: 5,
                        duration: 1.6,
                        opacity: 0.9,
                        speed: 2,
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4,
                    },
                    push: {
                        particles_nb: 3,
                    },
                    remove: {
                        particles_nb: 2,
                    },
                },
            },
            retina_detect: true,
        } );
    }

    function initHomeInsights() {
        var $section = $( '[data-iec-home-insights]' );
        if ( ! $section.length ) {
            return;
        }

        var $panels = $section.find( '[data-iec-insights-panel]' );
        var $tabs = $section.find( '.iec_post_category_btn' );
        var $tabList = $section.find( '[role="tablist"]' );

        if ( ! $panels.length || ! $tabs.length ) {
            return;
        }

        function setActiveTab( $button ) {
            $section.find( '.iec_home_news_post_category_list li' ).removeClass( 'is-active' );
            $tabs.removeClass( 'active' ).attr( 'aria-selected', 'false' ).attr( 'tabindex', '-1' );
            $button.closest( 'li' ).addClass( 'is-active' );
            $button.addClass( 'active' ).attr( 'aria-selected', 'true' ).removeAttr( 'tabindex' );
        }

        function showCategory( category, $button ) {
            var key = category || 'all';

            setActiveTab( $button );

            $panels.each( function () {
                var $panel = $( this );
                var isMatch = ( $panel.attr( 'data-iec-insights-panel' ) || 'all' ) === key;
                if ( isMatch ) {
                    $panel.removeAttr( 'hidden' );
                } else {
                    $panel.attr( 'hidden', 'hidden' );
                }
            } );

            refreshAos();
        }

        function focusTabByIndex( index ) {
            if ( ! $tabs.length ) {
                return;
            }
            var safeIndex = ( index + $tabs.length ) % $tabs.length;
            var $target = $tabs.eq( safeIndex );
            $target.trigger( 'focus' );
            if ( ! $target.hasClass( 'active' ) ) {
                showCategory( $target.attr( 'data-category' ) || 'all', $target );
            }
        }

        $tabs.on( 'click', function () {
            var $btn = $( this );
            if ( $btn.hasClass( 'active' ) ) {
                return;
            }
            showCategory( $btn.attr( 'data-category' ) || 'all', $btn );
        } );

        $tabList.on( 'keydown', function ( e ) {
            var $focused = $( document.activeElement );
            if ( ! $focused.hasClass( 'iec_post_category_btn' ) ) {
                return;
            }
            var currentIndex = $tabs.index( $focused );
            if ( e.key === 'ArrowRight' ) {
                e.preventDefault();
                focusTabByIndex( currentIndex + 1 );
            } else if ( e.key === 'ArrowLeft' ) {
                e.preventDefault();
                focusTabByIndex( currentIndex - 1 );
            } else if ( e.key === 'Home' ) {
                e.preventDefault();
                focusTabByIndex( 0 );
            } else if ( e.key === 'End' ) {
                e.preventDefault();
                focusTabByIndex( $tabs.length - 1 );
            }
        } );
    }

    function refreshAos() {
        if ( window.IEC && typeof IEC.kickAOS === 'function' ) {
            IEC.kickAOS();
        }
    }

    function initSpotlightTagsProgress() {
        var lists = document.querySelectorAll( '[data-iec-spotlight-tags]' );
        if ( ! lists.length ) {
            return;
        }

        var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
        var tagMs = 520;
        var arrowMs = 380;

        function revealAll( list, items ) {
            list.classList.add( 'is-animated' );
            items.forEach( function ( item ) {
                item.classList.add( 'is-revealed', 'is-arrow-revealed' );
            } );
        }

        function runListOnce( list ) {
            if ( list.classList.contains( 'is-animated' ) ) {
                return;
            }

            var items = Array.prototype.slice.call( list.querySelectorAll( 'li' ) );
            if ( ! items.length ) {
                return;
            }

            if ( reduced ) {
                revealAll( list, items );
                return;
            }

            list.classList.add( 'is-animated' );

            var index = 0;

            function revealTag() {
                if ( index >= items.length ) {
                    return;
                }

                items[ index ].classList.add( 'is-revealed' );

                if ( index < items.length - 1 ) {
                    window.setTimeout( function () {
                        items[ index ].classList.add( 'is-arrow-revealed' );
                        window.setTimeout( function () {
                            index += 1;
                            revealTag();
                        }, arrowMs );
                    }, tagMs );
                    return;
                }
            }

            revealTag();
        }

        lists.forEach( function ( list ) {
            if ( ! ( 'IntersectionObserver' in window ) ) {
                runListOnce( list );
                return;
            }

            var io = new IntersectionObserver( function ( entries ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        runListOnce( entry.target );
                        io.unobserve( entry.target );
                    }
                } );
            }, { threshold: 0.35 } );

            io.observe( list );
        } );
    }

    function isMobile() {
        return window.innerWidth <= 767;
    }

    function mountSwiper( selector, pagination, next, prev ) {
        var el = document.querySelector( selector );
        if ( ! el || typeof Swiper === 'undefined' ) {
            return;
        }

        new Swiper( el, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            touchStartPreventDefault: false,
            preventClicks: false,
            preventClicksPropagation: false,
            pagination: { el: pagination, clickable: true },
            navigation: { nextEl: next, prevEl: prev },
        } );
    }

    function initHomeSwipers() {
        if ( isMobile() ) {
            mountSwiper(
                '.iec_home_solution_swiper',
                '.iec_home_solution_swiper_pagination',
                '.iec_home_solution_swiper_next',
                '.iec_home_solution_swiper_prev'
            );
        }

        mountSwiper(
            '.iec_home_industries_swiper',
            '.iec_home_industires_swiper_pagination',
            '.iec_home_industires_swiper_next',
            '.iec_home_industires_swiper_prev'
        );
    }

    function initIndustryTabs() {
        var buttons = document.querySelectorAll( '.iec_tab_btn' );
        var panels = document.querySelectorAll( '.iec_tab_content' );
        var track = document.querySelector( '.iec_industries_panels_track' );

        buttons.forEach( function ( button, btnIndex ) {
            button.addEventListener( 'click', function () {
                var panel = document.getElementById( button.dataset.tab );
                var index = panel ? parseInt( panel.getAttribute( 'data-tab-index' ), 10 ) : btnIndex;

                buttons.forEach( function ( item ) {
                    item.classList.remove( 'active' );
                } );
                panels.forEach( function ( item ) {
                    item.classList.remove( 'active' );
                } );

                button.classList.add( 'active' );
                if ( panel ) {
                    panel.classList.add( 'active' );
                }
                if ( track && ! isNaN( index ) ) {
                    track.style.transform = 'translateX(-' + ( index * 100 ) + '%)';
                }
            } );
        } );
    }

    function linkEl( href, text ) {
        var link = document.createElement( 'a' );
        link.href = href;
        link.textContent = text;
        return link;
    }

    function setPopupTitle( head, title, href ) {
        var markup = '<strong></strong><span>›</span>';
        var anchor = head.querySelector( 'a' );

        if ( href ) {
            if ( ! anchor ) {
                head.querySelectorAll( 'strong, span' ).forEach( function ( node ) {
                    node.remove();
                } );
                anchor = document.createElement( 'a' );
                head.appendChild( anchor );
            }
            anchor.href = href;
            anchor.innerHTML = markup;
            anchor.querySelector( 'strong' ).textContent = title;
            return;
        }

        if ( anchor ) {
            anchor.remove();
        }
        if ( ! head.querySelector( 'strong' ) ) {
            head.insertAdjacentHTML( 'beforeend', markup );
        }
        head.querySelector( 'strong' ).textContent = title;
    }

    function officeKey( item ) {
        var key = ( item.dataset.office || '' ).toLowerCase().replace( /[^a-z0-9-]/g, '' );
        var aliases = { france: 'europe', sangapore: 'singapore' };
        return aliases[ key ] || key;
    }

    function placeOfficePopup( popup, key ) {
        popup.className = popup.className.replace( /(?:^|\s)is-pos-\S+/g, '' ).trim();
        popup.style.inset = '';
        popup.style.left = '';
        popup.style.right = '';
        popup.style.top = '';
        popup.style.bottom = '';
        popup.style.transform = '';

        if ( isMobile() ) {
            popup.classList.remove( 'is-anchored-right' );
            return;
        }

        if ( key ) {
            popup.classList.add( 'is-pos-' + key );
        }
        popup.classList.toggle( 'is-anchored-right', key === 'uae' );
    }

    function fillOfficePopup( item ) {
        var popup = document.querySelector( '.iec_home_global_office_popup' );
        if ( ! popup || ! item ) {
            return;
        }

        var data = item.dataset;
        var flag = popup.querySelector( '.iec_home_global_office_flag' );
        var head = popup.querySelector( '.iec_home_global_office_head' );
        var address = popup.querySelector( 'p' );
        var meta = popup.querySelector( '.iec_home_global_office_popup_meta' );
        var key = officeKey( item );

        if ( flag ) {
            flag.src = data.officeFlag || '';
            flag.removeAttribute( 'srcset' );
            flag.removeAttribute( 'sizes' );
            flag.alt = data.title || '';
            flag.style.visibility = data.officeFlag ? 'visible' : 'hidden';
        }

        if ( head ) {
            setPopupTitle( head, data.title || '', data.link || '' );
        }

        if ( address ) {
            address.innerHTML = data.address || '';
            address.hidden = ! data.address;
        }

        if ( meta ) {
            meta.textContent = '';
            if ( data.phone ) {
                meta.appendChild( linkEl( 'tel:' + data.phone.replace( /[^\d+]/g, '' ), data.phone ) );
            }
            if ( data.phone && data.email ) {
                meta.appendChild( document.createElement( 'b' ) );
            }
            if ( data.email ) {
                meta.appendChild( linkEl( 'mailto:' + data.email, data.email ) );
            }
        }

        placeOfficePopup( popup, key );

        if ( popup.animate && ! isMobile() ) {
            var fromX = popup.classList.contains( 'is-anchored-right' ) ? '6px' : '-6px';
            popup.animate(
                [
                    { transform: 'translateX(' + fromX + ')', opacity: 0.7 },
                    { transform: 'none', opacity: 1 },
                ],
                { duration: 260, easing: 'ease-out' }
            );
        }
    }

    function setActiveOffice( item ) {
        if ( ! item ) {
            return;
        }

        document.querySelectorAll( '.iec_home_global_office_item' ).forEach( function ( office ) {
            var active = office === item;
            var ring = office.querySelector( '.iec_home_global_office_ring' );
            office.classList.toggle( 'is-active', active );
            if ( ring ) {
                ring.src = active ? ( ring.dataset.activeSrc || ring.src ) : ( ring.dataset.inactiveSrc || ring.src );
            }
        } );

        document.querySelectorAll( '.iec_home_global_map_marker' ).forEach( function ( marker ) {
            var active = marker.dataset.officeIndex === item.dataset.officeIndex;
            var img = marker.querySelector( 'img' );
            marker.classList.toggle( 'is-active', active );
            if ( img ) {
                img.src = active ? ( img.dataset.activeSrc || img.src ) : ( img.dataset.inactiveSrc || img.src );
            }
        } );

        fillOfficePopup( item );
    }

    function initRegionalOffices() {
        var items = document.querySelectorAll( '.iec_home_global_office_item' );
        if ( ! items.length ) {
            return;
        }

        items.forEach( function ( item ) {
            item.addEventListener( 'click', function () {
                setActiveOffice( item );
            } );
        } );

        document.querySelectorAll( '.iec_home_global_map_marker' ).forEach( function ( marker ) {
            marker.addEventListener( 'click', function () {
                var item = document.querySelector( '.iec_home_global_office_item[data-office-index="' + marker.dataset.officeIndex + '"]' );
                if ( item ) {
                    setActiveOffice( item );
                }
            } );
        } );

        setActiveOffice( document.querySelector( '.iec_home_global_office_item.is-active' ) || items[ 0 ] );

        window.addEventListener( 'resize', function () {
            var active = document.querySelector( '.iec_home_global_office_item.is-active' );
            var popup = document.querySelector( '.iec_home_global_office_popup' );
            if ( active && popup ) {
                placeOfficePopup( popup, officeKey( active ) );
            }
        } );
    }

    function initNetworkLayers() {
        var boxes = document.querySelectorAll( '.iec_home_network_layer_icon_box' );
        if ( ! boxes.length ) {
            return;
        }

        function closeDetail( detail ) {
            if ( ! detail || ! detail.classList.contains( 'is-open' ) ) {
                return;
            }
            detail.classList.remove( 'is-visible' );
            window.clearTimeout( detail._timer );
            detail._timer = window.setTimeout( function () {
                detail.classList.remove( 'is-open' );
            }, 500 );
        }

        function openDetail( detail ) {
            if ( ! detail ) {
                return;
            }
            window.clearTimeout( detail._timer );
            detail.classList.add( 'is-open' );
            detail.offsetHeight;
            detail.classList.add( 'is-visible' );
        }

        function closeAll() {
            boxes.forEach( function ( box ) {
                box.classList.remove( 'active' );
                closeDetail( box.querySelector( '.iec_home_network_detail' ) );
            } );
        }

        boxes.forEach( function ( box ) {
            function toggleBox() {
                if ( isMobile() ) {
                    return;
                }
                var wasActive = box.classList.contains( 'active' );
                closeAll();
                if ( ! wasActive ) {
                    box.classList.add( 'active' );
                    openDetail( box.querySelector( '.iec_home_network_detail' ) );
                }
            }

            box.addEventListener( 'click', toggleBox );
            box.addEventListener( 'keydown', function ( event ) {
                if ( event.key !== 'Enter' && event.key !== ' ' ) {
                    return;
                }
                event.preventDefault();
                toggleBox();
            } );
        } );

        window.addEventListener( 'resize', function () {
            if ( isMobile() ) {
                closeAll();
            }
        } );
    }

    function initPartnerMarquee() {
        var tracks = document.querySelectorAll( '.iec_marquee_section .iec_partner_logos' );

        if ( ! tracks.length ) {
            return;
        }

        var desktop = window.matchMedia( '(min-width: 769px)' );

        function sync( track ) {
            var source = track.querySelector( '.iec_partner_logos_set:not([data-marquee-clone])' );
            var clone = track.querySelector( '.iec_partner_logos_set[data-marquee-clone]' );

            if ( ! desktop.matches ) {

                if ( clone ) {
                    clone.remove();
                }

                return;
            }

            if ( clone || ! source ) {
                return;
            }

            clone = source.cloneNode( true );
            clone.setAttribute( 'aria-hidden', 'true' );
            clone.setAttribute( 'data-marquee-clone', '1' );
            clone.setAttribute( 'data-nosnippet', '' );

            clone.querySelectorAll( 'a' ).forEach( function ( link ) {
                var span = document.createElement( 'span' );
                span.className = link.className;
                span.innerHTML = link.innerHTML;
                link.replaceWith( span );
            } );

            clone.querySelectorAll( 'img' ).forEach( function ( img ) {
                img.alt = '';
                img.removeAttribute( 'srcset' );
                img.removeAttribute( 'sizes' );
            } );

            track.appendChild( clone );
        }

        tracks.forEach( sync );
        desktop.addEventListener( 'change', function () {
            tracks.forEach( sync );
        } );
    }

    $( function () {
        initSpotlightTagsProgress();
        initNetworkLayerParticles();
        initHomeInsights();
        initHomeSwipers();
        initIndustryTabs();
        initRegionalOffices();
        initNetworkLayers();
        initPartnerMarquee();
    } );

} )( jQuery );
