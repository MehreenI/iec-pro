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
        if (window.innerWidth > 1024) {
            setupAnimations(".starlink-wrapper .right .items svg path");
            setupAnimations(".benefits-content .left .benefits-items .item .left .bottom svg path");
            setupAnimations(".benefits-content .right .benefits-items .item .bottom svg path", 600);
            setupAnimations(".standart .left .image-with-item svg path", 600);
        }
    }

    initAnimations();

    window.addEventListener("resize", () => {
        if (window.innerWidth > 1024) {
            initAnimations();
        }
    });
});





if (window.innerWidth > 1024) {
    document.addEventListener('click', function (event) {
        if (event.target.id && event.target.id.startsWith('ant-')) {
            const number = event.target.id.split('-')[1];
            const appContainer = document.querySelector('.app-container--mini');
            const parentElement = event.target.parentElement;
            document.querySelectorAll('.active-bg').forEach(item => {
                item.classList.remove('active-bg');
            });
            if (parentElement) {
                parentElement.classList.add('active-bg')
            }
            document.querySelectorAll('.option__item__wrapper').forEach(item => {
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
                            const targetElement = document.querySelector('.options__item');
                            const offset = 120;

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

        if (event.target.closest('.options__item__right__top')) {
            const parentWrapper = event.target.closest('.option__item__wrapper');
            const appContainer = document.querySelector('.app-container--mini');
            document.querySelectorAll('.active-bg').forEach(item => {
                item.classList.remove('active-bg');
            });
            if (parentWrapper) {
                const scrollDuration = 500;

                setTimeout(() => {
                    if (appContainer && window.innerWidth > 1024) {
                        const targetElement = document.querySelector('.antennas__items');
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
            const optionsWrapper = document.querySelector('.options__wrapper');
            const targetWrapper = document.querySelector(`.ant-item-${number}`);

            if (optionsWrapper) {
                optionsWrapper.classList.add('show-popup');
                document.body.classList.add('hide-over');
            }

            if (targetWrapper) {
                targetWrapper.classList.add('show-item');
            }
        }
        if (event.target.classList.contains('close-popup')) {
            const optionsWrapper = document.querySelector('.options__wrapper');
            const allItems = document.querySelectorAll('.show-item');

            if (optionsWrapper) {
                optionsWrapper.classList.remove('show-popup');
                document.body.classList.remove('hide-over');

            }

            allItems.forEach(item => {
                item.classList.remove('show-item');
            });
        }
    });
}

