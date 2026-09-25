var swiper = new Swiper(".swiper-fun", {
    autoHeight: true,
});

function setActiveTab(index) {
    document.querySelectorAll('.tabs .item').forEach(function(tab, i) {
        if (i === index) {
            tab.classList.add('active-tab');
        } else {
            tab.classList.remove('active-tab');
        }
    });
    swiper.slideTo(index);
}

setActiveTab(0);

document.querySelectorAll('.tabs .item').forEach(function (tab, index) {
    tab.addEventListener('click', function () {
        setActiveTab(index);
    });
});


document.addEventListener('scroll', function() {
    const rightElement = document.querySelector('.iec_header_wrapper .iec_header_right');
    const bigMenuBlock = document.querySelector('.big_menu_block');

    if (window.scrollY > 0) {
        rightElement.classList.add('transforms');
        bigMenuBlock.classList.add('big_menu_block_tops');
    } else {
        rightElement.classList.remove('transforms');
        bigMenuBlock.classList.remove('big_menu_block_tops');
    }
});
console.log('true')

if(window.innerWidth <=1024) {
    console.log('true')
    var swiperDir = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next2",
            prevEl: ".swiper-button-prev2",
        },

    });
}