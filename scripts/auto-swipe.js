
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 3,
          slidesPerGroup: 3,
          autoplay: {
            delay: 5000,
            disableOnInteraction: false,
          },
          breakpoints: {
            100:{
              slidesPerView: 1,
              spaceBetween: 0,
              slidesPerGroup: 1,
              spaceBetween: 5,
            },
            768: {
              slidesPerView: 2,
              spaceBetween: 20,
              slidesPerGroup: 2,
            },
            1024: {
              slidesPerView: 3,
              slidesPerGroup: 3,
              spaceBetween: 50,
            },
          },
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
        });
