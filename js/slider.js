// Sliders JS

// Slider logos

var sliderLogos = document.querySelector('.js-slider-logos');
	
if (sliderLogos) {

    var count = sliderLogos.dataset.count;

    // Slides perView
        var slidesPerView_1024 = 1;
        var slidesPerView_1280 = 1;
        var slidesPerView_1536 = 1;

        if ( count > 5 ) {
            slidesPerView_1024 = 3;
            slidesPerView_1280 = 3;
            slidesPerView_1536 = 5;
        }
        else if ( count == 5 ) {
            slidesPerView_1024 = 3;
            slidesPerView_1280 = 3;
            slidesPerView_1536 = 4;
        } 
        else if ( count == 4 ) {
            slidesPerView_1024 = 3;
            slidesPerView_1280 = 3;
            slidesPerView_1536 = 3;
        } 
        else if ( count == 3 ) {
            slidesPerView_1024 = 2;
            slidesPerView_1280 = 2;
            slidesPerView_1536 = 2;
        } 
    //

    var swiperLogos = new Swiper('.js-slider-logos', {

        loop: true,
        slidesPerView: 1,

        /*
        autoplay: {
            delay: 3000,
        },
        */

        breakpoints: {
            360: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: slidesPerView_1024,
            },
            1280: {
                slidesPerView: slidesPerView_1280,
            },
            1536: {
                slidesPerView: slidesPerView_1536,
            },
        },

    });

}

//