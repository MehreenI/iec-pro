/**
 * IEC scroll / entrance animations (GSAP + ScrollTrigger).
 *
 * Stagger a list:
 *   <ul class="iec-anim-stagger">
 *     <li>...</li>
 *   </ul>
 *
 * Optional on the same ul:
 *   iec-anim-fade-left
 *   data-iec-anim-stagger="0.15"
 *   data-iec-anim-delay="0.2"
 *
 * @package iec
 */
( function ( window, document ) {
	'use strict';

	/* ------------------------------------------------------------------ */
	/* Config                                                              */
	/* ------------------------------------------------------------------ */

	var PRESETS = {
		'iec-anim-fade-up': { y: 48, x: 0, opacity: 0, scale: 1, rotation: 0, blur: 0 },
		'iec-anim-fade-down': { y: -48, x: 0, opacity: 0, scale: 1, rotation: 0, blur: 0 },
		'iec-anim-fade-left': { y: 0, x: -56, opacity: 0, scale: 1, rotation: 0, blur: 0 },
		'iec-anim-fade-right': { y: 0, x: 56, opacity: 0, scale: 1, rotation: 0, blur: 0 },
		'iec-anim-scale-in': { y: 24, x: 0, opacity: 0, scale: 1, rotation: 0, blur: 0 },
		'iec-anim-blur-in': { y: 20, x: 0, opacity: 0, scale: 1, rotation: 0, blur: 8 },
		'iec-anim-flip-up': { y: 40, x: 0, opacity: 0, scale: 1, rotation: 8, blur: 0 },
	};

	var CONFIG = {
		defaultStart: 'top 88%',
		defaultDuration: 0.75,
		defaultEase: 'power3.out',
		defaultStagger: 0.12,
		heroCurtainDelay: 900,
	};

	var STAGGER_SELECTOR = '.iec-anim-stagger, .iec-anim-stagger-group';

	var state = {
		reduced: false,
		gsapReady: false,
	};

	/* ------------------------------------------------------------------ */
	/* Helpers                                                             */
	/* ------------------------------------------------------------------ */

	function $$( selector, context ) {
		return Array.prototype.slice.call( ( context || document ).querySelectorAll( selector ) );
	}

	function hasGsap() {
		return typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined';
	}

	function parseFloatAttr( el, attr, fallback ) {
		var value = parseFloat( el.getAttribute( attr ) );
		return isNaN( value ) ? fallback : value;
	}

	function getPresetFromElement( el ) {
		var keys = Object.keys( PRESETS );
		for ( var i = 0; i < keys.length; i++ ) {
			if ( el.classList.contains( keys[ i ] ) ) {
				return keys[ i ];
			}
		}
		return 'iec-anim-fade-up';
	}

	function getPresetValues( presetKey ) {
		return PRESETS[ presetKey ] || PRESETS[ 'iec-anim-fade-up' ];
	}

	function closestStagger( el ) {
		return el.closest ? el.closest( STAGGER_SELECTOR ) : null;
	}

	function markPlayed( el ) {
		el.classList.add( 'iec-anim-play', 'is-inview' );
	}

	function restartCssAnimations( elements ) {
		if ( ! elements || ! elements.length ) {
			return;
		}

		elements.forEach( function ( el ) {
			el.style.animation = 'none';
		} );

		if ( elements[ 0 ] ) {
			void elements[ 0 ].offsetWidth;
		}

		elements.forEach( function ( el ) {
			el.style.animation = '';
		} );
	}

	function wakeGsap() {
		if ( ! hasGsap() ) {
			return;
		}

		gsap.ticker.lagSmoothing( 0 );

		if ( gsap.globalTimeline && typeof gsap.globalTimeline.paused === 'function' && gsap.globalTimeline.paused() ) {
			gsap.globalTimeline.resume();
		}

		gsap.ticker.tick();

		if ( typeof ScrollTrigger !== 'undefined' ) {
			ScrollTrigger.refresh();
		}
	}

	function revealAllStatic() {
		$$( '.iec-anim-init, .iec-anim-split-chars, .iec-anim-split-words, .iec-anim-stagger, .iec-anim-stagger-group, .iec-anim-stagger-item, .iec-anim-image-reveal' ).forEach( markPlayed );
		$$( '.iec-anim-stagger > li' ).forEach( markPlayed );
		$$( '.iec-anim-char, .iec-anim-word' ).forEach( function ( el ) {
			el.style.opacity = '1';
			el.style.transform = 'none';
		} );
		$$( '.iec-anim-hero-curtain' ).forEach( function ( el ) {
			el.classList.add( 'is-content-ready', 'is-curtain-revealed' );
		} );
		$$( '.iec-anim-image-reveal' ).forEach( function ( el ) {
			el.classList.add( 'is-revealed' );
		} );
	}

	function buildScrollTriggerConfig( el, triggerEl ) {
		var customTrigger = el.getAttribute( 'data-iec-anim-trigger' );
		var trigger = triggerEl || ( customTrigger ? document.querySelector( customTrigger ) : el );

		return {
			trigger: trigger || el,
			start: el.getAttribute( 'data-iec-anim-start' ) || CONFIG.defaultStart,
			toggleActions: 'play none none none',
			invalidateOnRefresh: true,
		};
	}

	function animateFromPreset( elements, presetKey, options ) {
		if ( ! elements.length || ! hasGsap() ) {
			return;
		}

		var preset = getPresetValues( presetKey );
		var config = options || {};
		var from = {
			autoAlpha: 0,
			x: preset.x,
			y: preset.y,
			scale: preset.scale,
			rotation: preset.rotation,
		};

		if ( preset.blur ) {
			from.filter = 'blur(' + preset.blur + 'px)';
		}

		gsap.fromTo(
			elements,
			from,
			{
				autoAlpha: 1,
				x: 0,
				y: 0,
				scale: 1,
				rotation: 0,
				filter: 'blur(0px)',
				duration: config.duration || CONFIG.defaultDuration,
				ease: config.ease || CONFIG.defaultEase,
				stagger: config.stagger || 0,
				delay: config.delay || 0,
				immediateRender: true,
				scrollTrigger: config.scrollTrigger,
				onComplete: function () {
					if ( elements.forEach ) {
						elements.forEach( markPlayed );
					} else {
						markPlayed( elements );
					}
				},
			}
		);
	}

	function runWhenReady( el, onLoad, callback ) {
		var inHero = !!( el.closest && el.closest( '.iec-anim-hero-curtain' ) );

		if ( onLoad && inHero ) {
			whenHeroContentReady( callback, el );
			return;
		}

		callback();
	}

	/* ------------------------------------------------------------------ */
	/* Split text                                                          */
	/* ------------------------------------------------------------------ */

	function splitChars( el ) {
		if ( el.dataset.iecAnimSplit === 'done' ) {
			return $$( '.iec-anim-char', el );
		}

		var text = el.textContent;
		el.textContent = '';
		el.setAttribute( 'aria-label', text.trim() );

		var chars = [];

		text.split( '' ).forEach( function ( character ) {
			if ( character === ' ' ) {
				el.appendChild( document.createTextNode( '\u00A0' ) );
				return;
			}

			var span = document.createElement( 'span' );
			span.className = 'iec-anim-char';
			span.textContent = character;
			span.setAttribute( 'aria-hidden', 'true' );
			el.appendChild( span );
			chars.push( span );
		} );

		el.dataset.iecAnimSplit = 'done';
		return chars;
	}

	function createWordSpan( word, spans ) {
		var wrap = document.createElement( 'span' );
		wrap.className = 'iec-anim-word-wrap';

		var span = document.createElement( 'span' );
		span.className = 'iec-anim-word';
		span.textContent = word;
		span.setAttribute( 'aria-hidden', 'true' );
		wrap.appendChild( span );
		spans.push( span );

		return wrap;
	}

	function appendTextWords( text, parent, spans ) {
		if ( ! text ) {
			return;
		}

		text.split( /(\s+)/ ).forEach( function ( part ) {
			if ( ! part ) {
				return;
			}

			if ( /^\s+$/.test( part ) ) {
				parent.appendChild( document.createTextNode( part.replace( / /g, '\u00A0' ) ) );
				return;
			}

			parent.appendChild( createWordSpan( part, spans ) );
		} );
	}

	function cloneElementShallow( el ) {
		var clone = el.cloneNode( false );

		if ( clone.removeAttribute ) {
			clone.removeAttribute( 'id' );
		}

		return clone;
	}

	function processWordNodes( sourceParent, targetParent, spans ) {
		Array.prototype.slice.call( sourceParent.childNodes ).forEach( function ( node ) {
			if ( node.nodeType === 3 ) {
				appendTextWords( node.nodeValue, targetParent, spans );
				return;
			}

			if ( node.nodeType !== 1 ) {
				return;
			}

			var clone = cloneElementShallow( node );
			targetParent.appendChild( clone );
			processWordNodes( node, clone, spans );
		} );
	}

	function splitWords( el ) {
		if ( el.dataset.iecAnimSplit === 'done' ) {
			return $$( '.iec-anim-word', el );
		}

		var label = ( el.textContent || '' ).replace( /\s+/g, ' ' ).trim();
		if ( label ) {
			el.setAttribute( 'aria-label', label );
		}

		var spans = [];
		var fragment = document.createDocumentFragment();

		processWordNodes( el, fragment, spans );

		el.innerHTML = '';
		el.appendChild( fragment );
		el.dataset.iecAnimSplit = 'done';

		return spans;
	}

	function revealSplitNodes( nodes ) {
		if ( ! nodes || ! nodes.length ) {
			return;
		}

		nodes.forEach( function ( node ) {
			node.style.opacity = '1';
			node.style.transform = 'none';
		} );
	}

	function playSplitNodes( el, nodes, isWords ) {
		if ( ! nodes.length ) {
			return;
		}

		if ( ! hasGsap() ) {
			revealSplitNodes( nodes );
			markPlayed( el );
			return;
		}

		gsap.killTweensOf( nodes );
		gsap.fromTo(
			nodes,
			{
				opacity: 0,
				y: isWords ? '110%' : 30,
			},
			{
				opacity: 1,
				y: 0,
				duration: isWords ? 0.65 : 0.5,
				stagger: isWords ? 0.05 : 0.03,
				ease: isWords ? 'power3.out' : 'back.out(1.7)',
				delay: parseFloatAttr( el, 'data-iec-anim-delay', isWords ? 0.1 : 0 ),
				onComplete: function () {
					markPlayed( el );
				},
			}
		);
	}

	function playSplitIn( context ) {
		if ( ! context ) {
			return;
		}

		$$( '.iec-anim-split-words, .iec-anim-split-chars', context ).forEach( function ( el ) {
			var isWords = el.classList.contains( 'iec-anim-split-words' );
			var nodes = isWords ? $$( '.iec-anim-word', el ) : $$( '.iec-anim-char', el );
			playSplitNodes( el, nodes, isWords );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Hero curtain                                                        */
	/* ------------------------------------------------------------------ */

	function whenHeroContentReady( callback, el ) {
		var hero = ( el && el.closest ) ? el.closest( '.iec-anim-hero-curtain' ) : document.querySelector( '.iec-anim-hero-curtain' );

		if ( ! hero || hero.classList.contains( 'is-content-ready' ) ) {
			callback();
			return;
		}

		var finished = false;
		var finish = function () {
			if ( finished ) {
				return;
			}
			finished = true;
			callback();
		};

		if ( typeof MutationObserver !== 'undefined' ) {
			var observer = new MutationObserver( function () {
				if ( hero.classList.contains( 'is-content-ready' ) ) {
					observer.disconnect();
					finish();
				}
			} );
			observer.observe( hero, { attributes: true, attributeFilter: [ 'class' ] } );
		}

		window.setTimeout( finish, CONFIG.heroCurtainDelay + 200 );
	}

	function startHeroCurtain( hero ) {
		var panels = $$( '.iec-anim-curtain-panel', hero );

		hero.classList.add( 'is-curtain-revealed' );
		restartCssAnimations( panels );

		window.setTimeout( function () {
			hero.classList.add( 'is-content-ready' );
		}, CONFIG.heroCurtainDelay );
	}

	function initHeroCurtains() {
		$$( '.iec-anim-hero-curtain' ).forEach( function ( hero ) {
			if ( ! $$( '.iec-anim-curtain', hero ).length ) {
				var curtain = document.createElement( 'div' );
				curtain.className = 'iec-anim-curtain';
				curtain.setAttribute( 'aria-hidden', 'true' );

				for ( var i = 0; i < 3; i++ ) {
					var panel = document.createElement( 'span' );
					panel.className = 'iec-anim-curtain-panel';
					curtain.appendChild( panel );
				}

				hero.insertBefore( curtain, hero.firstChild );
			}

			if ( state.reduced ) {
				hero.classList.add( 'is-content-ready', 'is-curtain-revealed' );
				return;
			}

			requestAnimationFrame( function () {
				requestAnimationFrame( function () {
					startHeroCurtain( hero );
				} );
			} );
		} );
	}

	function bindHeroSwiperSplits() {
		$$( '.iec-anim-hero-curtain .swiper' ).forEach( function ( root ) {
			var attached = false;
			var playActive = function () {
				var active = root.querySelector( '.swiper-slide-active' ) || root.querySelector( '.swiper-slide' );
				playSplitIn( active );
			};

			var attach = function () {
				if ( attached || ! root.swiper ) {
					return attached;
				}

				attached = true;
				root.swiper.on( 'slideChangeTransitionStart', playActive );
				whenHeroContentReady( playActive, root );
				return true;
			};

			if ( ! attach() ) {
				window.setTimeout( attach, 200 );
				window.setTimeout( attach, 800 );
			}
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Stagger                                                             */
	/* ------------------------------------------------------------------ */

	function getStaggerItems( group ) {
		var selector = group.getAttribute( 'data-iec-anim-target' );

		if ( selector ) {
			return $$( selector, group );
		}

		var tagged = $$( '.iec-anim-stagger-item', group );
		if ( tagged.length ) {
			return tagged;
		}

		if ( 'UL' === group.tagName || 'OL' === group.tagName ) {
			return Array.prototype.filter.call( group.children, function ( child ) {
				return 'LI' === child.tagName;
			} );
		}

		return Array.prototype.slice.call( group.children );
	}

	function staggerGroup( group ) {
		var items = getStaggerItems( group );

		if ( ! items.length ) {
			return;
		}

		var onLoad = group.getAttribute( 'data-iec-anim-on-load' ) === 'true';
		var presetKey = group.getAttribute( 'data-iec-anim-preset' ) || getPresetFromElement( group );

		runWhenReady( group, onLoad, function () {
			if ( ! hasGsap() ) {
				items.forEach( markPlayed );
				return;
			}

			var opts = {
				duration: parseFloatAttr( group, 'data-iec-anim-duration', CONFIG.defaultDuration ),
				stagger: parseFloatAttr( group, 'data-iec-anim-stagger', CONFIG.defaultStagger ),
				delay: parseFloatAttr( group, 'data-iec-anim-delay', 0 ),
			};

			if ( ! onLoad ) {
				opts.scrollTrigger = buildScrollTriggerConfig( group, group );
			}

			animateFromPreset( items, presetKey, opts );
		} );
	}

	function initStagger() {
		$$( STAGGER_SELECTOR ).forEach( staggerGroup );
	}

	/* ------------------------------------------------------------------ */
	/* Scroll reveals                                                      */
	/* ------------------------------------------------------------------ */

	function initScrollReveals() {
		$$( '.iec-anim-init' ).forEach( function ( el ) {
			if ( el.classList.contains( 'iec-offshore-vas__anim' ) ) {
				return;
			}

			if ( closestStagger( el ) ) {
				return;
			}

			if ( el.classList.contains( 'iec-anim-split-chars' ) || el.classList.contains( 'iec-anim-split-words' ) ) {
				return;
			}

			var onLoad = el.getAttribute( 'data-iec-anim-on-load' ) === 'true';
			var presetKey = getPresetFromElement( el );
			var duration = parseFloatAttr( el, 'data-iec-anim-duration', CONFIG.defaultDuration );
			var delay = parseFloatAttr( el, 'data-iec-anim-delay', 0 );

			if ( ! hasGsap() ) {
				return;
			}

			runWhenReady( el, onLoad, function () {
				var opts = {
					duration: duration,
					delay: delay,
				};

				if ( ! onLoad ) {
					opts.scrollTrigger = buildScrollTriggerConfig( el );
				}

				animateFromPreset( [ el ], presetKey, opts );
			} );
		} );
	}

	function initSplitKind( selector, splitFn, isWords ) {
		$$( selector ).forEach( function ( el ) {
			var nodes = splitFn( el );
			var onLoad = el.getAttribute( 'data-iec-anim-on-load' ) === 'true' || !! el.closest( '.iec-anim-hero-curtain' );
			var inHero = !! el.closest( '.iec-anim-hero-curtain' );
			var inSwiper = !! el.closest( '.swiper' );

			if ( ! nodes.length ) {
				return;
			}

			if ( ! hasGsap() ) {
				revealSplitNodes( nodes );
				markPlayed( el );
				return;
			}

			if ( inSwiper && inHero ) {
				return;
			}

			var from = {
				opacity: 0,
				y: isWords ? '110%' : 30,
			};
			var to = {
				opacity: 1,
				y: 0,
				duration: isWords ? ( onLoad ? 0.65 : 0.7 ) : 0.5,
				stagger: isWords ? 0.05 : 0.03,
				ease: isWords ? 'power3.out' : 'back.out(1.7)',
				delay: parseFloatAttr( el, 'data-iec-anim-delay', isWords && onLoad ? 0.1 : 0 ),
				onComplete: function () {
					markPlayed( el );
				},
			};

			runWhenReady( el, onLoad, function () {
				if ( onLoad ) {
					gsap.to( nodes, Object.assign( { opacity: 1, y: 0 }, to ) );
					return;
				}

				gsap.fromTo( nodes, from, Object.assign( { scrollTrigger: buildScrollTriggerConfig( el ) }, to ) );
			} );
		} );
	}

	function initSplitText() {
		initSplitKind( '.iec-anim-split-chars', splitChars, false );
		initSplitKind( '.iec-anim-split-words', splitWords, true );
	}

	function initParallax() {
		if ( ! hasGsap() || state.reduced ) {
			return;
		}

		$$( '.iec-anim-parallax' ).forEach( function ( el ) {
			var speed = parseFloatAttr( el, 'data-iec-anim-speed', 20 );
			var trigger = el.closest( '.iec_single_office_banner_box' ) || el.parentElement || el;

			gsap.to( el, {
				yPercent: speed,
				ease: 'none',
				scrollTrigger: {
					trigger: trigger,
					start: 'top top',
					end: 'bottom top',
					scrub: 0.6,
					invalidateOnRefresh: true,
				},
			} );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Image reveal                                                        */
	/* ------------------------------------------------------------------ */

	function wrapImageReveal( el ) {
		if ( el.dataset.iecAnimReveal === 'done' ) {
			return;
		}

		var img = el.querySelector( 'img' ) || el;

		if ( img.tagName !== 'IMG' ) {
			return;
		}

		var parent = img.parentElement;

		if ( parent && parent.classList.contains( 'iec-anim-image-reveal__inner' ) ) {
			el.dataset.iecAnimReveal = 'done';
			return;
		}

		var wrapper = document.createElement( 'div' );
		wrapper.className = 'iec-anim-image-reveal__inner';

		var strips = document.createElement( 'div' );
		strips.className = 'iec-anim-image-reveal__strips';
		strips.setAttribute( 'aria-hidden', 'true' );

		for ( var i = 0; i < 5; i++ ) {
			var strip = document.createElement( 'span' );
			strip.className = 'iec-anim-image-reveal__strip';
			strips.appendChild( strip );
		}

		img.parentNode.insertBefore( wrapper, img );
		wrapper.appendChild( img );
		wrapper.appendChild( strips );
		el.dataset.iecAnimReveal = 'done';
	}

	function initImageReveals() {
		$$( '.iec-anim-image-reveal' ).forEach( function ( el ) {
			wrapImageReveal( el );

			if ( state.reduced ) {
				el.classList.add( 'is-revealed' );
				markPlayed( el );
				return;
			}

			if ( el.getAttribute( 'data-iec-anim-on-load' ) === 'true' ) {
				window.setTimeout( function () {
					el.classList.add( 'is-revealed' );
					markPlayed( el );
				}, 300 );
				return;
			}

			if ( typeof IntersectionObserver !== 'undefined' ) {
				var observer = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							entry.target.classList.add( 'is-revealed' );
							markPlayed( entry.target );
							observer.unobserve( entry.target );
						}
					} );
				}, { threshold: 0.25 } );

				observer.observe( el );
			} else {
				el.classList.add( 'is-revealed' );
				markPlayed( el );
			}
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Decorative effects                                                  */
	/* ------------------------------------------------------------------ */

	function initScrollProgress() {
		var root = document.querySelector( '[data-iec-anim-progress="true"]' );

		if ( ! root || state.reduced ) {
			return;
		}

		var bar = document.querySelector( '.iec-anim-progress-bar' );

		if ( ! bar ) {
			bar = document.createElement( 'div' );
			bar.className = 'iec-anim-progress-bar';
			bar.setAttribute( 'aria-hidden', 'true' );
			document.body.appendChild( bar );
		}

		var update = function () {
			var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			var height = document.documentElement.scrollHeight - window.innerHeight;
			var progress = height > 0 ? ( scrollTop / height ) * 100 : 0;
			bar.style.width = progress + '%';
		};

		update();
		window.addEventListener( 'scroll', update, { passive: true } );
		window.addEventListener( 'resize', update );
	}

	function initSpotlight() {
		if ( state.reduced || ! window.matchMedia( '(min-width: 992px)' ).matches ) {
			return;
		}

		$$( '.iec-anim-spotlight' ).forEach( function ( section ) {
			section.addEventListener( 'mouseenter', function () {
				section.classList.add( 'is-spotlight-active' );
			} );
			section.addEventListener( 'mouseleave', function () {
				section.classList.remove( 'is-spotlight-active' );
			} );
			section.addEventListener( 'mousemove', function ( event ) {
				var rect = section.getBoundingClientRect();
				section.style.setProperty( '--iec-spotlight-x', ( event.clientX - rect.left ) + 'px' );
				section.style.setProperty( '--iec-spotlight-y', ( event.clientY - rect.top ) + 'px' );
			} );
		} );
	}

	function initParticles() {
		if ( state.reduced ) {
			return;
		}

		$$( '.iec-anim-particles' ).forEach( function ( section ) {
			if ( section.querySelector( '.iec-anim-particles__layer' ) ) {
				return;
			}

			var layer = document.createElement( 'div' );
			layer.className = 'iec-anim-particles__layer';
			layer.setAttribute( 'aria-hidden', 'true' );

			var isPortfolio = section.classList.contains( 'iec-anim-particles--portfolio' )
				|| section.getAttribute( 'data-iec-particle-variant' ) === 'portfolio';
			var count = parseInt( section.getAttribute( 'data-iec-particle-count' ) || ( isPortfolio ? '42' : '24' ), 10 );

			for ( var i = 0; i < count; i++ ) {
				var dot = document.createElement( 'span' );
				var isOrb = isPortfolio && Math.random() < 0.12;
				dot.className = 'iec-anim-particle' + ( isOrb ? ' iec-anim-particle--orb' : '' );
				dot.style.left = ( Math.random() * 100 ) + '%';
				dot.style.top = ( Math.random() * 100 ) + '%';

				if ( isOrb ) {
					var orbSize = 4 + Math.random() * 8;
					dot.style.width = orbSize + 'px';
					dot.style.height = orbSize + 'px';
					dot.style.setProperty( '--iec-particle-opacity', ( 0.04 + Math.random() * 0.08 ).toString() );
					dot.style.setProperty( '--iec-particle-duration', ( 16 + Math.random() * 14 ) + 's' );
				} else if ( isPortfolio ) {
					var dotSize = 1.5 + Math.random() * 2.5;
					dot.style.width = dotSize + 'px';
					dot.style.height = dotSize + 'px';
					dot.style.setProperty( '--iec-particle-opacity', ( 0.06 + Math.random() * 0.14 ).toString() );
					dot.style.setProperty( '--iec-particle-duration', ( 12 + Math.random() * 16 ) + 's' );
				} else {
					dot.style.width = ( Math.random() * 4 + 2 ) + 'px';
					dot.style.height = dot.style.width;
					dot.style.setProperty( '--iec-particle-opacity', ( 0.2 + Math.random() * 0.5 ).toString() );
					dot.style.setProperty( '--iec-particle-duration', ( 8 + Math.random() * 10 ) + 's' );
				}

				dot.style.setProperty( '--iec-particle-delay', ( Math.random() * 6 ) + 's' );
				dot.style.setProperty( '--iec-particle-shift-x', ( -20 + Math.random() * 40 ) + 'px' );
				layer.appendChild( dot );
			}

			section.insertBefore( layer, section.firstChild );
			restartCssAnimations( $$( '.iec-anim-particle', layer ) );
		} );
	}

	function initTiltCards() {
		if ( state.reduced || ! window.matchMedia( '(min-width: 992px)' ).matches ) {
			return;
		}

		$$( '.iec-anim-tilt' ).forEach( function ( card ) {
			var maxRotate = parseFloat( card.getAttribute( 'data-iec-tilt-max' ) || '10' );

			card.addEventListener( 'mouseenter', function () {
				card.classList.add( 'is-tilting' );
			} );

			card.addEventListener( 'mousemove', function ( event ) {
				var rect = card.getBoundingClientRect();
				var rotateY = ( ( ( event.clientX - rect.left ) / rect.width ) - 0.5 ) * maxRotate;
				var rotateX = ( ( 0.5 - ( ( event.clientY - rect.top ) / rect.height ) ) ) * maxRotate;
				card.style.transform = 'perspective(900px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-6px)';
			} );

			card.addEventListener( 'mouseleave', function () {
				card.classList.remove( 'is-tilting' );
				card.style.transform = '';
			} );
		} );
	}

	function initMagneticElements() {
		if ( state.reduced || ! window.matchMedia( '(min-width: 992px)' ).matches ) {
			return;
		}

		$$( '.iec-anim-magnetic' ).forEach( function ( el ) {
			var strength = parseFloat( el.getAttribute( 'data-iec-magnetic' ) || '0.35' );

			el.addEventListener( 'mousemove', function ( event ) {
				var rect = el.getBoundingClientRect();
				var x = event.clientX - rect.left - rect.width / 2;
				var y = event.clientY - rect.top - rect.height / 2;
				el.style.transform = 'translate(' + ( x * strength ) + 'px, ' + ( y * strength ) + 'px)';
			} );

			el.addEventListener( 'mouseleave', function () {
				el.style.transform = '';
			} );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Offshore VAS slides                                                 */
	/* ------------------------------------------------------------------ */

	function playOffshoreVasSlide( slideEl ) {
		if ( ! slideEl ) {
			return;
		}

		var items = $$( '.iec-offshore-vas__anim', slideEl );

		if ( ! items.length ) {
			return;
		}

		if ( state.reduced || ! hasGsap() ) {
			items.forEach( markPlayed );
			return;
		}

		items.forEach( function ( el ) {
			gsap.killTweensOf( el );
			el.classList.remove( 'iec-anim-play', 'is-inview' );
			gsap.set( el, { clearProps: 'all' } );
		} );

		items.forEach( function ( el ) {
			animateFromPreset( [ el ], getPresetFromElement( el ), {
				duration: parseFloatAttr( el, 'data-iec-anim-duration', 0.95 ),
				delay: parseFloatAttr( el, 'data-iec-anim-delay', 0 ),
			} );
		} );
	}

	function initOffshoreVasSection() {
		var swiperRoot = document.querySelector( '[data-offshore-vas-swiper]' );

		if ( ! swiperRoot ) {
			return;
		}

		var section = swiperRoot.closest( '.iec-offshore-vas-section' );

		function playActiveSlide() {
			var activeSlide = swiperRoot.querySelector( '.swiper-slide-active' );

			if ( activeSlide ) {
				playOffshoreVasSlide( activeSlide );
			}
		}

		document.addEventListener( 'iec:offshore-vas-slide', function ( event ) {
			if ( event.detail && event.detail.slide ) {
				playOffshoreVasSlide( event.detail.slide );
			}
		} );

		if ( state.reduced ) {
			playActiveSlide();
			return;
		}

		if ( typeof IntersectionObserver !== 'undefined' && section ) {
			var observer = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						playActiveSlide();
						observer.unobserve( section );
					}
				} );
			}, { threshold: 0.22 } );

			observer.observe( section );
		} else {
			playActiveSlide();
		}
	}

	/* ------------------------------------------------------------------ */
	/* Fallback + boot                                                     */
	/* ------------------------------------------------------------------ */

	function initFallbackObserver() {
		if ( state.reduced || hasGsap() ) {
			return;
		}

		document.documentElement.classList.add( 'iec-anim-fallback' );

		if ( typeof IntersectionObserver === 'undefined' ) {
			revealAllStatic();
			return;
		}

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					markPlayed( entry.target );
					observer.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' } );

		$$( '.iec-anim-init, .iec-anim-stagger > li, .iec-anim-stagger-item' ).forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	function init() {
		state.reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		document.documentElement.classList.add( 'iec-anim-ready' );

		if ( state.reduced ) {
			document.documentElement.classList.add( 'iec-anim-reduced' );
			revealAllStatic();
			initOffshoreVasSection();
			return;
		}

		initHeroCurtains();
		initSplitText();
		bindHeroSwiperSplits();

		if ( hasGsap() ) {
			state.gsapReady = true;
			gsap.registerPlugin( ScrollTrigger );
			gsap.ticker.lagSmoothing( 0 );
			initScrollReveals();
			initStagger();
			initParallax();
			wakeGsap();
			window.setTimeout( function () {
				gsap.ticker.lagSmoothing( 500, 33 );
			}, 2000 );
		} else {
			initFallbackObserver();
		}

		initImageReveals();
		initScrollProgress();
		initSpotlight();
		initParticles();
		initTiltCards();
		initMagneticElements();
		initOffshoreVasSection();
	}

	function refresh() {
		wakeGsap();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

	window.addEventListener( 'load', refresh );
	window.addEventListener( 'pageshow', refresh );
	window.setTimeout( refresh, 150 );
	window.setTimeout( refresh, 700 );

	if ( document.fonts && document.fonts.ready ) {
		document.fonts.ready.then( refresh );
	}

	window.IECAnimate = {
		refresh: refresh,
		reinit: init,
		wake: wakeGsap,
		stagger: staggerGroup,
		playOffshoreVasSlide: playOffshoreVasSlide,
	};

}( window, document ) );
