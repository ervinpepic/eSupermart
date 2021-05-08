(function ($) {
  "use strict";

	$(document).ready(function () {
 
    // ===========Featured Owl Carousel============
    var objowlcarousel = $(".owl-carousel-featured");
    if (objowlcarousel.length > 0) {
        objowlcarousel.owlCarousel({
            items: productcarousel.displayitem,
	        itemsMobile: [479, productcarousel.mobileitem],
            lazyLoad: true,
            pagination: false,
			loop: true,
            autoPlay: false,
            navigation: true,
            stopOnHover: true,
			navigationText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"]
        });
    }

	});

})(jQuery);
