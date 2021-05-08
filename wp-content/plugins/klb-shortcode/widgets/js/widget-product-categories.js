(function ($) {
  "use strict";

	$(document).ready(function () {
		
		$('.widget_klb_product_categories ul.children').closest('li').addClass("cat-parent");
		$(".widget_klb_product_categories ul > li.cat-parent").append('<span class="subDropdown plus"></span>');

		$(".subDropdown")[0] && $(".subDropdown").on("click", function() {
			$(this).toggleClass("plus"), $(this).toggleClass("minus"), $(this).parent().find("ul").slideToggle()
		});
	
	});

})(jQuery);
