(function ($) {
  "use strict";

	$(document).ready(function () {
		$('.more_slide_open').slideUp();	
		$('.more_categories').on('click', function (){
			$(this).toggleClass('show');
			$('.more_slide_open').slideToggle();
		});
		
		$(".category-list-sidebar-body > :nth-child(1n+"+ categorylist.displayitem +")" ).wrapAll( "<div class='more_slide_open' style='display: none;'></div>" );
	});

})(jQuery);