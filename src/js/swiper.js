new Swiper('#swiper-projects', {
  direction: 'horizontal',
  loop: false,
  speed: 500,
  slidesPerView: 3.2,
  grabCursor: true,
  keyboard: true,
  spaceBetween: 24,
  allowTouchMove: true,
  navigation: {
    nextEl: '#projects .swiper-next',
    prevEl: '#projects .swiper-prev',
  },
  breakpoints: {
    0: {
      slidesPerView: 1.1,
      spaceBetween: 24,
    },
    650: {
      slidesPerView: 2.2,
      spaceBetween: 16,
    },
    767: {
      slidesPerView: 2.2,
      spaceBetween: 16,
    },
    992: {
      slidesPerView: 3.2,
      spaceBetween: 24,
    }
  }
});