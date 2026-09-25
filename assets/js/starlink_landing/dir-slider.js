var swiperDir = new Swiper(".swiper__directions-right", {
    slidesPerView: 1,
    spaceBetween: 0,
    centeredSlides: true,
    loop: true,
    direction: "horizontal",
    pagination: {
        el: ".swiper-pagination",
        clickable: true
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
            centeredSlides: false,

        }
    }
});

var swiperDir1 = new Swiper(".swiper__directions-left", {
    slidesPerView: 1,
    effect: "fade",
    loop: true,
    allowTouchMove: false,
});

function updateActiveBackground(index) {
    const bgImages = document.querySelectorAll('.directions__bg img');

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

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        console.log(window.innerWidth)
        if (window.innerWidth <= 1024) {
            new Swiper(".swiper-1", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                pagination: {
                    el: ".swiper-pagination-1",
                    clickable: true,
                },
                // navigation: {
                //     nextEl: ".swiper-button-next2",
                //     prevEl: ".swiper-button-prev2",
                // },
            });
        }
    }, 1000);
});