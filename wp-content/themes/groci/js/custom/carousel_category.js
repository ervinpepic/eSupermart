(function ($) {
  "use strict";

	$(document).ready(function () {
 
	// ===========Category Owl Carousel============
    var objowlcarousel = $(".owl-carousel-category");
    if (objowlcarousel.length > 0) {
        objowlcarousel.owlCarousel({
            items: productcategory.displayitem,
	        itemsDesktop: [1199, productcategory.displayitem],
	        itemsDesktopSmall: [979, productcategory.mobileitem],
	        itemsTablet: [768, productcategory.mobileitem],
	        itemsMobile: [479, productcategory.mobileitem],
            lazyLoad: true,
            pagination: false,
			 loop: true,
            autoPlay: productcategory.autoplay,
            navigation: true,
            stopOnHover: true,
			navigationText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"]
        });
    }

	});

})(jQuery);
