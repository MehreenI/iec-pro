document.addEventListener("DOMContentLoaded", function () {
  const paginationDir = document.querySelector('.swiper__directions-right .swiper-pagination');
  const paginationBot = document.querySelector('.swiper__bot__directions-right .swiper-pagination');
  const paginationAntennas = document.querySelector('.antennas-slider .swiper-pagination');

  var swiperDir = new Swiper(".swiper__directions-right", {
    slidesPerView: 1,
    spaceBetween: 0,
    centeredSlides: true,
    loop: true,
    direction: "horizontal",
    pagination: {
      el: paginationDir,
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      1024: {
        slidesPerView: 3,
        centeredSlides: false,
        spaceBetween: 20,
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
    bgImages.forEach((img, i) => {
      img.classList.toggle('active-bg', i === index);
    });
  }

  swiperDir.on('slideChange', function () {
    swiperDir1.slideToLoop(swiperDir.realIndex);
    updateActiveBackground(swiperDir.realIndex);
  });

  updateActiveBackground(0);

  var swiperDir__bot = new Swiper(".swiper__bot__directions-right", {
    slidesPerView: 1,
    spaceBetween: 0,
    centeredSlides: true,
    loop: true,
    direction: "horizontal",
    pagination: {
      el: paginationBot,
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next1",
      prevEl: ".swiper-button-prev1",
    },
    breakpoints: {
      1024: {
        slidesPerView: 3,
        centeredSlides: false,
        spaceBetween: 20,
      }
    }
  });

  var swiperDir1__bot = new Swiper(".swiper__bot__directions-left", {
    slidesPerView: 1,
    effect: "fade",
    loop: true,
    allowTouchMove: false,
  });

  function updateActiveBackgroundBot(index) {
    const bgImages = document.querySelectorAll('.directions__bot__bg img');
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
    const swiperElement = document.querySelector('.swiper__bot__directions-right');
    swiperElement.removeAttribute('dir');

    swiperDir1__bot.destroy(true, true);
    swiperDir__bot.destroy(true, true);

    swiperDir1__bot = new Swiper(".swiper__bot__directions-left", {
      slidesPerView: 1,
      effect: "fade",
      loop: true,
      allowTouchMove: false,
    });

    swiperDir__bot = new Swiper(".swiper__bot__directions-right", {
      slidesPerView: 1,
      spaceBetween: 0,
      centeredSlides: true,
      loop: true,
      direction: "horizontal",
      pagination: {
        el: paginationBot,
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next1",
        prevEl: ".swiper-button-prev1",
      },
      breakpoints: {
        1024: {
          slidesPerView: 3,
          centeredSlides: false,
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

  var swiperAntennas = new Swiper(".antennas-slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    pagination: {
      el: paginationAntennas,
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next2",
      prevEl: ".swiper-button-prev2",
    },
    breakpoints: {
      1024: {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
      }
    }
  });

  if (window.innerWidth <= 1024) {
    new Swiper(".swiper-1", {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      pagination: {
        el: ".swiper-pagination-1",
        clickable: true,
      },
    });
  }
});
