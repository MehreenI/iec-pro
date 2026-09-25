( function ( $ ) {
	'use strict';

	function initOperatorsSwiper() {
		var el = document.querySelector( '.iec_vsat_operators_swiper' );

		if ( ! el || typeof Swiper === 'undefined' || el.swiper ) {
			return;
		}

		new Swiper( el, {
			slidesPerView: 1,
			spaceBetween: 16,
			watchOverflow: true,
			touchStartPreventDefault: false,
			preventClicks: false,
			preventClicksPropagation: false,
			pagination: {
				el: '.iec_vsat_operators_pagination',
				clickable: true
			},
			navigation: {
				nextEl: '.iec_vsat_operators_next',
				prevEl: '.iec_vsat_operators_prev'
			},
			breakpoints: {
				576: { slidesPerView: 2, spaceBetween: 20 },
				768: { slidesPerView: 3, spaceBetween: 24 },
				992: { slidesPerView: 4, spaceBetween: 24 }
			}
		} );
	}

	function sizeStrokeButton( btn, svg, rect ) {
		var width  = btn.offsetWidth;
		var height = btn.offsetHeight;

		if ( ! width || ! height ) {
			return;
		}

		var radius = parseFloat( window.getComputedStyle( btn ).borderRadius ) || 8;
		var stroke = 2;
		var perimeter = 2 * ( width + height );

		svg.setAttribute( 'viewBox', '0 0 ' + width + ' ' + height );
		rect.setAttribute( 'x', stroke / 2 );
		rect.setAttribute( 'y', stroke / 2 );
		rect.setAttribute( 'width', Math.max( width - stroke, 0 ) );
		rect.setAttribute( 'height', Math.max( height - stroke, 0 ) );
		rect.setAttribute( 'rx', Math.max( radius - 1, 0 ) );
		rect.setAttribute( 'ry', Math.max( radius - 1, 0 ) );
		rect.style.strokeDasharray = String( perimeter );
		rect.style.strokeDashoffset = String( perimeter );
	}

	function initStrokeButtons( page ) {
		if ( ! page ) {
			return;
		}

		page.querySelectorAll( '.learn_more_btn' ).forEach( function ( btn ) {
			if (
				btn.closest( '.recommended_solutions_section' ) ||
				btn.closest( '.iec_vsat_hero_button_list' ) ||
				btn.classList.contains( 'iec_band_link' ) ||
				btn.classList.contains( 'iec_vsat_stroke_btn' )
			) {
				return;
			}

			btn.classList.add( 'iec_vsat_stroke_btn' );

			var svg = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
			svg.setAttribute( 'class', 'iec_vsat_btn_stroke' );
			svg.setAttribute( 'aria-hidden', 'true' );

			var rect = document.createElementNS( 'http://www.w3.org/2000/svg', 'rect' );
			svg.appendChild( rect );
			btn.insertBefore( svg, btn.firstChild );

			var resize = function () {
				sizeStrokeButton( btn, svg, rect );
			};

			resize();
			window.addEventListener( 'resize', resize );
			window.addEventListener( 'load', resize );
		} );
	}

	function refreshStrokeButtons( page ) {
		if ( ! page ) {
			return;
		}

		page.querySelectorAll( '.iec_vsat_stroke_btn' ).forEach( function ( btn ) {
			var svg  = btn.querySelector( '.iec_vsat_btn_stroke' );
			var rect = svg ? svg.querySelector( 'rect' ) : null;

			if ( svg && rect ) {
				sizeStrokeButton( btn, svg, rect );
			}
		} );
	}

	function splitWords( el ) {
		var words = el.textContent.trim().split( /\s+/ );

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

	function splitChars( el ) {
		var text  = el.textContent;
		var chars = [];

		el.textContent = '';
		el.setAttribute( 'aria-label', text.trim() );

		text.split( '' ).forEach( function ( character ) {
			if ( ' ' === character ) {
				el.appendChild( document.createTextNode( '\u00A0' ) );
				return;
			}

			var span = document.createElement( 'span' );
			span.className = 'vsat-char';
			span.textContent = character;
			span.setAttribute( 'aria-hidden', 'true' );
			el.appendChild( span );
			chars.push( span );
		} );

		return chars;
	}

	function initHeroReveal() {
		var hero = document.querySelector( '.t-vsat-portfolio .iec_vsat_hero_reveal' );

		if ( ! hero ) {
			return;
		}

		var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var heading      = hero.querySelector( '.js-vsat-hero-heading' );
		var subtitle     = hero.querySelector( '.js-vsat-split-reveal' );
		var buttonItems  = hero.querySelectorAll( '.iec_vsat_hero_button_list li' );
		var heroBg       = hero.querySelector( '.iec_vsat_hero_bg' );
		var headingChars = [];
		var hasGsap      = typeof gsap !== 'undefined';

		function revealHeroContent() {
			hero.classList.add( 'is-content-ready' );

			if ( reduceMotion || ! hasGsap ) {
				headingChars.forEach( function ( charEl ) {
					charEl.style.opacity = '1';
					charEl.style.transform = 'none';
				} );

				if ( subtitle ) {
					subtitle.classList.add( 'is-revealed' );
				}

				buttonItems.forEach( function ( item ) {
					item.style.opacity = '1';
					item.style.transform = 'none';
				} );
				return;
			}

			if ( headingChars.length ) {
				gsap.to( headingChars, {
					opacity: 1,
					y: 0,
					duration: 0.5,
					stagger: 0.03,
					ease: 'back.out(1.7)'
				} );
			}

			if ( subtitle ) {
				subtitle.classList.add( 'is-revealed' );
			}

			if ( buttonItems.length ) {
				gsap.set( buttonItems, { opacity: 0, y: 48 } );
				gsap.to( buttonItems, {
					opacity: 1,
					y: 0,
					duration: 0.55,
					stagger: 0.12,
					ease: 'power2.out',
					delay: 0.15
				} );
			}
		}

		if ( ! reduceMotion && heading ) {
			headingChars = splitChars( heading );
		}

		if ( ! reduceMotion && subtitle ) {
			splitWords( subtitle );
		}

		if ( hasGsap && typeof ScrollTrigger !== 'undefined' ) {
			gsap.registerPlugin( ScrollTrigger );

			ScrollTrigger.matchMedia( {
				'(min-width: 768px)': function () {
					if ( ! heroBg ) {
						return;
					}

					gsap.to( heroBg, {
						yPercent: 20,
						ease: 'none',
						scrollTrigger: {
							trigger: hero,
							start: 'top top',
							end: 'bottom top',
							scrub: 0.6,
							invalidateOnRefresh: true
						}
					} );
				}
			} );
		}

		requestAnimationFrame( function () {
			hero.classList.add( 'is-revealed' );

			if ( reduceMotion ) {
				hero.classList.add( 'is-content-ready' );
				revealHeroContent();
				return;
			}

			window.setTimeout( revealHeroContent, 900 );
		} );
	}

	function initGsapFallback( page ) {
		if ( ! page ) {
			return;
		}

		if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
			page.classList.add( 'iec-vsat-gsap-fallback' );
			if ( page.querySelector( '.iec_vsat_hero_reveal' ) ) {
				page.querySelector( '.iec_vsat_hero_reveal' ).classList.add( 'is-content-ready' );
			}
			return;
		}

		window.setTimeout( function () {
			if ( ! page.classList.contains( 'iec-vsat-gsap-ready' ) ) {
				page.classList.add( 'iec-vsat-gsap-fallback' );
			}
		}, 2500 );
	}

	function initMobileSwipers() {
		if ( typeof IEC.initMobileOnlySwiper !== 'function' ) {
			return;
		}

		IEC.initMobileOnlySwiper( '.iec_advantage_slider', {
			slidesPerView: 1,
			spaceBetween: 16,
			speed: 600,
			loop: false,
			watchOverflow: true,
			navigation: {
				nextEl: '.iec_advantage_next',
				prevEl: '.iec_advantage_prev'
			}
		} );

		IEC.initMobileOnlySwiper( '.iec_band_slider', {
			slidesPerView: 1,
			spaceBetween: 16,
			speed: 600,
			loop: false,
			watchOverflow: true,
			navigation: {
				nextEl: '.iec_band_next',
				prevEl: '.iec_band_prev'
			}
		} );
	}

	function initSolutions() {
		var section = document.querySelector( '.recommended_solutions_section' );
		var buttons = section ? section.querySelectorAll( '.solution_btn' ) : [];
		var panes   = section ? section.querySelectorAll( '.solution_pane' ) : [];
		var images  = section ? section.querySelectorAll( '.recommended_solution_image .reveal-box.solution_image' ) : [];
		var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function playReveal( box ) {
			if ( ! box ) {
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

		function playText( pane ) {
			if ( ! pane ) {
				return;
			}

			if ( reduced ) {
				pane.classList.add( 'is-text-visible' );
				return;
			}

			pane.classList.remove( 'is-text-visible' );
			void pane.offsetWidth;
			pane.classList.add( 'is-text-visible' );
		}

		if ( images.length && ! reduced && 'IntersectionObserver' in window ) {
			var observer = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						playReveal( entry.target );
						observer.unobserve( entry.target );
					}
				} );
			}, { threshold: 0.3 } );

			images.forEach( function ( box ) {
				if ( box.classList.contains( 'active' ) ) {
					observer.observe( box );
				}
			} );
		} else {
			images.forEach( function ( box ) {
				box.classList.add( 'is-visible' );
			} );
		}

		buttons.forEach( function ( btn, index ) {
			btn.addEventListener( 'click', function () {
				var target = this.getAttribute( 'data-target' );
				var pane   = document.getElementById( target );

				buttons.forEach( function ( item ) {
					item.classList.remove( 'active' );
				} );
				panes.forEach( function ( item ) {
					item.classList.remove( 'active', 'is-text-visible' );
				} );
				images.forEach( function ( item ) {
					item.classList.remove( 'active' );
				} );

				this.classList.add( 'active' );

				if ( pane ) {
					pane.classList.add( 'active' );
					playText( pane );
				}

				if ( images[ index ] ) {
					images[ index ].classList.add( 'active' );
					playReveal( images[ index ] );
				}
			} );
		} );
	}

	function fadeUpOnScroll( targets, options ) {
		var elements = gsap.utils.toArray( targets );
		var config   = options || {};
		var trigger  = config.trigger || elements[0];

		if ( ! elements.length || ! trigger ) {
			return;
		}

		gsap.fromTo(
			elements,
			{
				autoAlpha: 0,
				x: typeof config.x === 'number' ? config.x : 0,
				y: typeof config.y === 'number' ? config.y : 40,
				scale: typeof config.scale === 'number' ? config.scale : 1,
				rotation: typeof config.rotation === 'number' ? config.rotation : 0
			},
			{
				autoAlpha: 1,
				x: 0,
				y: 0,
				scale: 1,
				rotation: 0,
				duration: config.duration || 0.7,
				ease: config.ease || 'power2.out',
				stagger: config.stagger || 0,
				delay: config.delay || 0,
				immediateRender: true,
				scrollTrigger: {
					trigger: trigger,
					start: config.start || 'top 88%',
					toggleActions: 'play none none none',
					invalidateOnRefresh: true
				}
			}
		);
	}

	function splitTitleWords( el ) {
		var parts = el.textContent.trim().split( /\s+/ );
		var words = [];

		el.innerHTML = '';

		parts.forEach( function ( word, index ) {
			var span = document.createElement( 'span' );
			span.className = 'vsat-title-word';
			span.textContent = word;
			el.appendChild( span );
			words.push( span );

			if ( index < parts.length - 1 ) {
				el.appendChild( document.createTextNode( '\u00A0' ) );
			}
		} );

		return words;
	}

	function initGsap( page ) {
		if ( ! page || typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) {
			return;
		}

		if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
			page.classList.add( 'iec-vsat-gsap-fallback' );
			return;
		}

		gsap.registerPlugin( ScrollTrigger );
		page.classList.add( 'iec-vsat-gsap-ready' );

		gsap.utils.toArray( page.querySelectorAll( '.js-vsat-section-title' ) ).forEach( function ( titleEl ) {
			var words   = splitTitleWords( titleEl );
			var trigger = titleEl.closest( '.iec_section_heading' ) || titleEl;

			if ( ! words.length ) {
				return;
			}

			gsap.fromTo(
				words,
				{ autoAlpha: 0, y: 40, rotation: 5 },
				{
					autoAlpha: 1,
					y: 0,
					rotation: 0,
					duration: 0.6,
					stagger: 0.1,
					ease: 'power3.out',
					immediateRender: true,
					scrollTrigger: {
						trigger: trigger,
						start: 'top 88%',
						toggleActions: 'play none none none',
						invalidateOnRefresh: true
					}
				}
			);
		} );

		fadeUpOnScroll( page.querySelector( '.iec_partner_bar .iec_partner_label' ), {
			trigger: page.querySelector( '.iec_partner_bar' ),
			y: 16,
			duration: 0.5
		} );

		fadeUpOnScroll( page.querySelectorAll( '.iec_partner_logo' ), {
			trigger: page.querySelector( '.iec_partner_bar' ),
			y: 28,
			scale: 0.82,
			duration: 0.65,
			ease: 'back.out(1.5)',
			stagger: 0.07
		} );

		gsap.utils.toArray( page.querySelectorAll( '.iec-eyebrow' ) ).forEach( function ( eyebrow ) {
			fadeUpOnScroll( eyebrow, {
				trigger: eyebrow.closest( '.iec_section_heading' ) || eyebrow,
				y: 20,
				duration: 0.5
			} );
		} );

		gsap.utils.toArray( page.querySelectorAll( '.iec_section_heading .iec_section_description, .iec_section_heading > p' ) ).forEach( function ( description ) {
			fadeUpOnScroll( description, {
				trigger: description.closest( '.iec_section_heading' ) || description,
				y: 24,
				duration: 0.6,
				delay: 0.15
			} );
		} );

		var advantageGrid = page.querySelector( '.iec_advantage_grid' );
		if ( advantageGrid ) {
			gsap.utils.toArray( page.querySelectorAll( '.iec_advantage_grid .iec_advantage_card_wrapper' ) ).forEach( function ( card, index ) {
				fadeUpOnScroll( card, {
					trigger: advantageGrid,
					x: index % 2 === 0 ? -55 : 55,
					y: 36,
					scale: 0.92,
					rotation: index % 2 === 0 ? -2 : 2,
					duration: 0.8,
					ease: 'power3.out',
					delay: index * 0.1
				} );
			} );
		}

		var bandGrid = page.querySelector( '.iec_band_grid_desktop' );
		if ( bandGrid ) {
			fadeUpOnScroll( page.querySelectorAll( '.iec_band_grid_desktop .iec_band_card' ), {
				trigger: bandGrid,
				y: 50,
				scale: 0.9,
				duration: 0.85,
				ease: 'back.out(1.4)',
				stagger: 0.14
			} );
		}

		var freqSection = page.querySelector( '.iec_frequency_section' );
		if ( freqSection ) {
			gsap.utils.toArray( page.querySelectorAll( '.iec_band_marquee_track' ) ).forEach( function ( track, index ) {
				gsap.to( track, {
					x: 0 === index % 2 ? -100 : 100,
					ease: 'none',
					scrollTrigger: {
						trigger: freqSection,
						start: 'top bottom',
						end: 'bottom top',
						scrub: 0.8,
						invalidateOnRefresh: true
					}
				} );
			} );
		}

		var serviceGrid = page.querySelector( '.iec_service_grid' );
		if ( serviceGrid ) {
			gsap.utils.toArray( page.querySelectorAll( '.iec_service_grid .iec_service_card_wrapper' ) ).forEach( function ( card, index ) {
				fadeUpOnScroll( card, {
					trigger: serviceGrid,
					x: index % 2 === 0 ? -80 : 80,
					y: 0,
					duration: 0.8,
					ease: 'power3.out',
					delay: index * 0.12
				} );
			} );

			gsap.utils.toArray( page.querySelectorAll( '.iec_service_card .bd_model_img_wrapper img' ) ).forEach( function ( img ) {
				var cardWrap = img.closest( '.iec_service_card_wrapper' );
				if ( ! cardWrap ) {
					return;
				}

				gsap.fromTo(
					img,
					{ yPercent: -8 },
					{
						yPercent: 8,
						ease: 'none',
						scrollTrigger: {
							trigger: cardWrap,
							start: 'top bottom',
							end: 'bottom top',
							scrub: 0.5,
							invalidateOnRefresh: true
						}
					}
				);
			} );
		}

		var solutionsRow = page.querySelector( '.recommended_solutions_section .container > .row:nth-child(2)' );
		if ( solutionsRow ) {
			fadeUpOnScroll( page.querySelector( '.recommended_solutions_section .col-md-3' ), {
				trigger: solutionsRow,
				x: -40,
				y: 0
			} );
			fadeUpOnScroll( page.querySelector( '.recommended_solutions_section .col-md-5' ), {
				trigger: solutionsRow,
				y: 30,
				duration: 0.75
			} );
			fadeUpOnScroll( page.querySelector( '.recommended_solutions_section .recommeded_image' ), {
				trigger: solutionsRow,
				x: 50,
				y: 0,
				scale: 0.94,
				duration: 0.85,
				ease: 'power3.out'
			} );

			var recImageWrap = page.querySelector( '.recommended_solution_image' );
			if ( recImageWrap ) {
				gsap.to( recImageWrap, {
					y: -30,
					ease: 'none',
					scrollTrigger: {
						trigger: solutionsRow,
						start: 'top bottom',
						end: 'bottom top',
						scrub: 0.6,
						invalidateOnRefresh: true
					}
				} );
			}
		}

		var faqGrid = page.querySelector( '.iec_faq_grid' );
		if ( faqGrid ) {
			fadeUpOnScroll( page.querySelectorAll( '.iec_faq_item' ), {
				trigger: faqGrid,
				x: -24,
				y: 24,
				scale: 0.98,
				duration: 0.65,
				ease: 'power2.out',
				stagger: 0.08
			} );
		}

		ScrollTrigger.refresh();
	}

	$( function () {
		var page = document.querySelector( '.t-vsat-portfolio' );

		initOperatorsSwiper();
		initStrokeButtons( page );
		initHeroReveal();
		initGsapFallback( page );
		initMobileSwipers();
		initSolutions();
		initGsap( page );

		window.addEventListener( 'load', function () {
			refreshStrokeButtons( page );
			if ( typeof ScrollTrigger !== 'undefined' ) {
				ScrollTrigger.refresh();
			}
		} );

		window.setTimeout( function () {
			refreshStrokeButtons( page );
		}, 1000 );
	} );
} )( jQuery );
