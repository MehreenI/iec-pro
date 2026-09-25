document.querySelectorAll('.menu-items').forEach(item => {
	item.addEventListener('click', function () {
		var body = document.querySelector('body');
		var bigMenu = document.querySelector('.big_menu_block');
		var header = document.querySelector('.header');
		var right = document.querySelector('.iec_header_wrapper .iec_header_right');
		if ( body ) {
			body.classList.toggle('not_scroll');
		}
		if ( bigMenu ) {
			bigMenu.classList.toggle('active');
		}
		if ( header ) {
			header.classList.toggle('header-2');
		}
		if ( right ) {
			right.classList.toggle('header-2');
		}
	});
});

document.addEventListener('scroll', function() {
    const rightElement = document.querySelector('.iec_header_wrapper .iec_header_right');
    const bigMenuBlock = document.querySelector('.big_menu_block');
    if ( ! rightElement || ! bigMenuBlock ) {
        return;
    }

    if (window.scrollY > 0) {
        rightElement.classList.add('transforms');
        bigMenuBlock.classList.add('big_menu_block_tops');
    } else {
        rightElement.classList.remove('transforms');
        bigMenuBlock.classList.remove('big_menu_block_tops');
    }
});

document.querySelectorAll('.iec_header_wrapper .search-icon').forEach(icon => {
    icon.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const wrap = this.closest('.search');

        // Close all other search boxes
        document.querySelectorAll('.search').forEach(search => {
            if (search !== wrap) {
                search.classList.remove('searching');
            }
        });

        // Toggle current search box
        wrap.classList.toggle('searching');

        // Focus input when opened
        if (wrap.classList.contains('searching')) {
            const input = wrap.querySelector(
                'input[type="text"], input[type="search"]'
            );

            if (input) {
                input.focus();
            }
        }
    });
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.iec_header_wrapper .search')) {
        document.querySelectorAll('.iec_header_wrapper .search').forEach(search => {
            search.classList.remove('searching');
        });
    }
});

document.querySelector('.iec_header_wrapper .lang')?.addEventListener('click', function () {
	const menu = document.querySelector('.iec_header_wrapper .language-menu');
	if ( ! menu ) {
		return;
	}
	menu.classList.toggle('visible');
	this.classList.toggle('open');
});

document.querySelectorAll('.iec_header_wrapper .language-menu a').forEach(function (link) {
	link.addEventListener('click', function (event) {
		event.preventDefault();
		const selectedLang = this.textContent.trim();
		const current = document.querySelector('.iec_header_wrapper .current-lang');
		if ( current ) {
			current.textContent = selectedLang;
		}
		window.location.href = this.href;
	});
});

document.addEventListener('DOMContentLoaded', function() {
    const bannerForm = document.querySelector('.banner-form');
    const bannerText = document.querySelector('.header-btn');
    const bannerBtn = document.querySelector('.banner-pop');
    const bannerFormSvg = document.querySelector('.banner-form form svg');
    const body = document.body;

    if ( ! bannerForm ) {
        return;
    }

    function openPopup() {
        bannerForm.classList.remove('hide-popup');
        body.style.overflow = 'hidden';
        if ( window.jQuery ) {
            window.jQuery( bannerForm ).trigger( 'iec:popup:open' );
        }
    }

    function closePopup() {
        bannerForm.classList.add('hide-popup');
        body.style.overflow = '';
    }

    if ( bannerText ) {
        bannerText.addEventListener('click', openPopup);
    }
    if ( bannerBtn ) {
        bannerBtn.addEventListener('click', openPopup);
    }

    if ( bannerFormSvg ) {
        bannerFormSvg.addEventListener('click', function() {
            closePopup();
        });
    }

    bannerForm.addEventListener('click', function(event) {
        if (!event.target.closest('form')) {
            closePopup();
        }
    });
});



document.addEventListener("DOMContentLoaded", () => {
    function setupAnimations(selector, delay = 500) {
        const paths = document.querySelectorAll(selector);
        const observerOptions = { root: null, rootMargin: '0px', threshold: 0.3 };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const index = Array.from(paths).indexOf(target);
                    setTimeout(() => {
                        target.classList.add("animate");
                    }, index * delay);
                    observer.unobserve(target);
                }
            });
        }, observerOptions);

        paths.forEach(path => {
            observer.observe(path);
        });
    }

    function initAnimations() {
        if (window.innerWidth > 768) {
            setupAnimations(".starlink-wrapper .right .items svg path");
            setupAnimations(".benefits-content .left .benefits-items .item .left .bottom svg path");
            setupAnimations(".benefits-content .right .benefits-items .item .bottom svg path", 600);
            setupAnimations(".iec_benefits_box .left .iec_benefits_item_warpper .bottom svg path");
            setupAnimations(".iec_benefits_box .right .iec_benefits_item_warpper .bottom svg path", 600);
            setupAnimations(".standart .left .image-with-item svg path", 600);
        }
    }

    // Initial check
    initAnimations();

    // Optional: Add an event listener to handle window resize
    window.addEventListener("resize", () => {
        if (window.innerWidth > 1024) {
            initAnimations();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
	if ( typeof Swiper === 'undefined' || ! document.querySelector('.product_swiper') ) {
		return;
	}
	new Swiper(".product_swiper", {
		slidesPerView: "auto",
		spaceBetween: 20,
		loop: true,
		pagination: {
			el: ".iec_starlink_product_swiper_pagination",
			clickable: true,
		},
		navigation: {
			nextEl: ".iec_starlink_product_swiper_next",
			prevEl: ".iec_starlink_product_swiper_prev",
		},
	});
});

document.addEventListener("DOMContentLoaded", () => {
	setTimeout(() => {

		if (window.innerWidth > 1024) {
			document.addEventListener('click', function (event) {
				if (event.target.id && event.target.id.startsWith('ant-')) {
					const number = event.target.id.split('-')[1];
					const appContainer = document.querySelector('.iec_starlink_product_collapse_container');
					const parentElement = event.target.parentElement;
					document.querySelectorAll('.active-bg').forEach(item => {
						item.classList.remove('active-bg');
					});
					if (parentElement) {
						parentElement.classList.add('active-bg')
					}
					document.querySelectorAll('.iec_starlink_product_collapse_warpper').forEach(item => {
						item.classList.remove('open-options');
					});

					setTimeout(() => {
						const targetWrapper = document.querySelector(`.ant-item-${number}`);
						if (targetWrapper) {
							targetWrapper.classList.add('open-options');
							if (appContainer) {
								appContainer.classList.add('open-height');
								document.body.classList.add('no-scroll');

								if (window.innerWidth > 1024) {
									const targetElement = document.querySelector('.iec_starlink_product_collapse_item_warpper');
									const offset = 80;

									if (targetElement) {
										const elementPosition = targetElement.getBoundingClientRect().top;
										const offsetPosition = elementPosition + window.pageYOffset - offset;

										setTimeout(() => {
											window.scrollTo({
												top: offsetPosition,
												behavior: 'smooth'
											});
										}, 600);
									}
								}

							}
						}
					}, 500);

				}

				if (event.target.closest('.iec_starlink_product_collapse_item_content_top')) {
					const parentWrapper = event.target.closest('.iec_starlink_product_collapse_warpper');
					const appContainer = document.querySelector('.iec_starlink_product_collapse_container');
					document.querySelectorAll('.active-bg').forEach(item => {
						item.classList.remove('active-bg');
					});
					if (parentWrapper) {
						const scrollDuration = 500;

						setTimeout(() => {
							if (appContainer && window.innerWidth > 1024) {
								const targetElement = document.querySelector('.product_swiper .swiper-wrapper');
								if (targetElement) {
									const elementPosition = targetElement.getBoundingClientRect().top;
									const offsetPosition = elementPosition + window.pageYOffset - 200;

									window.scrollTo({
										top: offsetPosition,
										behavior: 'smooth'
									});

									setTimeout(() => {
										parentWrapper.classList.remove('open-options');
										appContainer.classList.remove('open-height');
										document.body.classList.remove('no-scroll');

									}, scrollDuration);
								}
							}
						}, 100);
					}
				}

			});
		}
		if (window.innerWidth <= 1024) {
			document.addEventListener('click', function (event) {
				if (event.target.id && event.target.id.startsWith('ant-')) {
					const number = event.target.id.split('-')[1];
					const optionsWrapper = document.querySelector('.iec_starlink_product_collapse_sec');
					const targetWrapper = document.querySelector(`.ant-item-${number}`);

					if (optionsWrapper) {
						optionsWrapper.classList.add('show-popup');
						document.body.classList.add('hide-over');
						document.body.classList.add('no-scroll');

					}

					if (targetWrapper) {
						targetWrapper.classList.add('show-item');
					}
				}
				if (event.target.classList.contains('close-popup')) {
					const optionsWrapper = document.querySelector('.iec_starlink_product_collapse_sec');
					const allItems = document.querySelectorAll('.show-item');

					if (optionsWrapper) {
						optionsWrapper.classList.remove('show-popup');
						document.body.classList.remove('hide-over');
						document.body.classList.remove('no-scroll');

					}

					allItems.forEach(item => {
						item.classList.remove('show-item');
					});
				}
			});
		}
	}, 500);

});


document.addEventListener("DOMContentLoaded", () => {
	var swiper = new Swiper(".iec_swiper_tabs_slide", {
		autoHeight: true,
	});

	function setActiveTab(index) {
		document.querySelectorAll('.iec_tabs_list .iec_tab_item').forEach(function(tab, i) {
			if (i === index) {
				tab.classList.add('active-tab');
			} else {
				tab.classList.remove('active-tab');
			}
		});
		swiper.slideTo(index);
	}

	setActiveTab(0);

	document.querySelectorAll('.iec_tabs_list .iec_tab_item').forEach(function (tab, index) {
		tab.addEventListener('click', function () {
			setActiveTab(index);
		});
	});

});

document.addEventListener("DOMContentLoaded", () => {
	if ( typeof Swiper === 'undefined' || ! document.querySelector('.iec_starlink_swiper_direction_right') ) {
		return;
	}
	var swiperDir = new Swiper(".iec_starlink_swiper_direction_right", {
		slidesPerView: 1,
		spaceBetween: 0,
		centeredSlides: true,
		loop: true,
		direction: "horizontal",
		pagination: {
			el: ".iec_starlink_swiper_direction_pagination",
			clickable: true
		},
		navigation: {
			nextEl: ".iec_starlink_swiper_direction_next",
			prevEl: ".iec_starlink_swiper_direction_prev",
		},
		breakpoints: {
			1024: {
				slidesPerView: 3,
				spaceBetween: 20,
				centeredSlides: false,
			}
		}
	});

	var swiperDir1 = new Swiper(".iec_starlink_swiper_direction_left", {
		slidesPerView: 1,
		effect: "fade",
		loop: true,
		allowTouchMove: false,
	});

	function updateActiveBackground(index) {
		const bgImages = document.querySelectorAll('.iec_starlink_directions_bg img');

		bgImages.forEach(img => img.classList.remove('active-bg'));

		if (bgImages[index]) {
			bgImages[index].classList.add('active-bg');
		}
	}

	swiperDir.on('slideChange', function () {
		swiperDir1.slideToLoop(swiperDir.realIndex);
		updateActiveBackground(swiperDir.realIndex);
	});

	updateActiveBackground(0);
});

document.addEventListener("DOMContentLoaded", () => {
	if ( typeof Swiper === 'undefined' || ! document.querySelector('.iec_starlink_swiper_direction_bot_right') ) {
		return;
	}
	var swiperDir__bot = new Swiper(".iec_starlink_swiper_direction_bot_right", {
		slidesPerView: 1,
		spaceBetween: 0,
		centeredSlides: true,
		loop: true,
		direction: "horizontal",
		pagination: {
			el: ".iec_starlink_swiper_direction_bot_pagination",
			clickable: true,
		},
		navigation: {
			nextEl: ".iec_starlink_swiper_direction_bot_next",
			prevEl: ".iec_starlink_swiper_direction_bot_prev",
		},
		breakpoints: {
			1024: {
				slidesPerView: 3,
				centeredSlides: false,
            	centeredSlidesBounds: false,
				spaceBetween: 20,
			}
		}
	});

	var swiperDir1__bot = new Swiper(".iec_starlink_swiper_direction_bot_left", {
		slidesPerView: 1,
		effect: "fade",
		loop: true,
		allowTouchMove: false,
	});

	function updateActiveBackgroundBot(index) {
		const bgImages = document.querySelectorAll('.iec_starlink_directions_bot_bg img');
		bgImages.forEach((img, i) => {
			img.classList.toggle('active-bg', i === index);
		});
	}

	swiperDir__bot.on('slideChange', function () {
		swiperDir1__bot.slideToLoop(swiperDir__bot.realIndex);
		updateActiveBackgroundBot(swiperDir__bot.realIndex);
	});

	updateActiveBackgroundBot(0);

	function reinitSliders() {
		const swiperElement = document.querySelector('.iec_starlink_swiper_direction_bot_right');
		if ( ! swiperElement ) {
			return;
		}
		swiperElement.removeAttribute('dir');

		swiperDir1__bot.destroy(true, true);
		swiperDir__bot.destroy(true, true);

		swiperDir1__bot = new Swiper(".iec_starlink_swiper_direction_bot_left", {
			slidesPerView: 1,
			effect: "fade",
			loop: true,
			allowTouchMove: false,
		});

		swiperDir__bot = new Swiper(".iec_starlink_swiper_direction_bot_right", {
			slidesPerView: 1,
			spaceBetween: 0,
		    centeredSlides: true,
		    centeredSlidesBounds: true,
			loop: true,
			direction: "horizontal",
			pagination: {
				el: ".iec_starlink_swiper_direction_bot_pagination",
				clickable: true,
			},
			navigation: {
				nextEl: ".iec_starlink_swiper_direction_bot_next",
				prevEl: ".iec_starlink_swiper_direction_bot_prev",
			},
			breakpoints: {
				1024: {
					slidesPerView: 3,
					centeredSlides: false,
	            	centeredSlidesBounds: false,
					spaceBetween: 20,
				}
			}
		});

		swiperDir__bot.on('slideChange', function () {
			swiperDir1__bot.slideToLoop(swiperDir__bot.realIndex);
			updateActiveBackgroundBot(swiperDir__bot.realIndex);
		});
	}

	if (window.innerWidth < 1024) {
		reinitSliders();
	}
});

document.addEventListener("DOMContentLoaded", () => {
	jQuery(document).ready(function ($) {

	    // Hide all accordion bodies
	    $('.iec_starlink_acordion_body').hide();

	    $('.iec_starlink_acordion_header').on('click', function () {

	        const parent = $(this).closest('.iec_starlink_acordion_item');

	        if (parent.hasClass('active')) {
	            parent.removeClass('active');
	            parent.find('.iec_starlink_acordion_body').stop(true, true).slideUp(300);
	        } else {
	            $('.iec_starlink_acordion_item').removeClass('active');
	            $('.iec_starlink_acordion_body').stop(true, true).slideUp(300);

	            parent.addClass('active');
	            parent.find('.iec_starlink_acordion_body').stop(true, true).slideDown(300);
	        }

	    });

	});
});

document.addEventListener("DOMContentLoaded", () => {
	jQuery(document).ready(function (){
        if ( window.IEC && typeof IEC.placeFeaturedNewsCards === 'function' ) {
            return;
        }

        document.querySelectorAll( '.iec_featured_news_swiper' ).forEach( function ( el ) {
            if ( el.swiper || ! el.querySelector( '.swiper-slide' ) ) {
                return;
            }

            new Swiper( el, {
                slidesPerView : "auto",
                spaceBetween  : 30,
                loop          : el.querySelectorAll( '.swiper-slide' ).length > 1,
                centeredSlides: true,
                navigation    : {
                    nextEl: '.iec_featured_news_swiper_next',
                    prevEl: '.iec_featured_news_swiper_prev',
                },
            } );
        } );

    });
});