var acc = document.getElementsByClassName("acordion-item");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        var svg = this.querySelector("svg");
        if (svg) {
            svg.classList.toggle("rotate");
        }
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}
document.querySelectorAll('.hover-section').forEach(function (section) {

    section.addEventListener('click', function () {
        if (window.innerWidth < 1024) {
            if (this.style.transform === 'translateY(600px)') {
                this.style.transform = 'translateY(0)';
            } else {
                this.style.transform = 'translateY(600px)';
            }
        }
    });
});

document.querySelectorAll('.directions-wrapper .item').forEach(function (section) {
    console.log(true)
    section.addEventListener('click', function (event) {
        if (window.innerWidth < 1024) {
            const hoverSection = section.querySelector('.hover-section');

            if (hoverSection) {
                if (hoverSection.style.transform === 'translateY(600px)') {
                    hoverSection.style.transform = 'translateY(0)';
                    console.log(hoverSection);

                } else {
                    hoverSection.style.transform = 'translateY(600px)';
                }
            }
        }
    });
});

document.querySelectorAll('.menu-items').forEach(item => {
    item.addEventListener('click', function () {
        document.querySelector('.big_menu_block').classList.toggle('active');
        document.querySelector('.header').classList.toggle('header-2');
        document.querySelector('.header-wrapper .right').classList.toggle('header-2');
    });
});
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {

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
                        document.body.classList.add('no-scroll');

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


document.querySelector('.lang').addEventListener('click', function () {
    const menu = document.querySelector('.language-menu');
    menu.classList.toggle('visible');

    this.classList.toggle('open');
});

document.querySelectorAll('.language-menu a').forEach(function (link) {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        const selectedLang = this.textContent.trim();
        document.querySelector('.current-lang').textContent = selectedLang;

        window.location.href = this.href;
    });
});
