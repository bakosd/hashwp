
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 3,
          slidesPerGroup: 3,
          autoplay: {
            delay: 25000,
            disableOnInteraction: false,
          },
          breakpoints: {
            100:{
              slidesPerView: 1,
              spaceBetween: 0,
              slidesPerGroup: 1,
              spaceBetween: 25,
            },
            768: {
              slidesPerView: 2,
              spaceBetween: 20,
              slidesPerGroup: 2,
            },
            1024: {
              slidesPerView: 3,
              slidesPerGroup: 3,
              spaceBetween: 25,
            },
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
        });
