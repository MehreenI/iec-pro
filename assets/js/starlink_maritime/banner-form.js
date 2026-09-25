document.addEventListener('DOMContentLoaded', function() {
    const bannerForm = document.querySelector('.banner-form');
    const bannerText = document.querySelector('.header-btn');
    const bannerBtn = document.querySelector('.banner-pop');
    const bannerFormSvg = document.querySelector('.banner-form form svg');
    const body = document.body;

    function closePopup() {
        bannerForm.classList.add('hide-popup');
        body.style.overflow = ''; 
    }

    bannerText.addEventListener('click', function() {
        bannerForm.classList.remove('hide-popup');
        body.style.overflow = 'hidden'; 
    });
    bannerBtn.addEventListener('click', function() {
        bannerForm.classList.remove('hide-popup');
        body.style.overflow = 'hidden';
    });

    bannerFormSvg.addEventListener('click', function() {
        closePopup();
    });

    bannerForm.addEventListener('click', function(event) {
        if (!event.target.closest('form')) {
            closePopup();
        }
    });
});

// const swiperEl = document.querySelector(".main-swiper");
// console.log(swiperEl)
// let swiperInstance = null;

// function initSwiper() {
//     console.log(window.innerWidth)
//     if (window.innerWidth < 1024 ) {
//         swiperInstance = new Swiper(swiperEl, {
//             slidesPerView: 1,
//             spaceBetween: 30,
//             navigation: {
//                 nextEl: '.swiper-button-next-news',
//                 prevEl: '.swiper-button-prev-news',
//             },
//         });
//     }
//     else if (window.innerWidth >= 1024 && swiperInstance) {
//         swiperInstance.destroy(true, true);
//         swiperInstance = null;
//     }
// }

// window.addEventListener("resize", initSwiper);
// window.addEventListener("load", initSwiper);