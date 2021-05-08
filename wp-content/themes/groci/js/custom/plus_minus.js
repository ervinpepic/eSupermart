(function ($) {
  "use strict";

	$(document).ready(function () {
 
		$('.qty-archive').on('input', function() {
			$(this).closest('.product-footer').find('a.btn').attr('data-quantity', $(this).val());
		});

		$('.inc').on('click', function () {
			if ($(this).prev().val() < 100) {
				$(this).prev().val(+$(this).prev().val() + 1);
			}
			
			$(this).closest('.product-footer').find('a.btn').attr('data-quantity', $(this).closest('.product-footer').find('.qty-archive').val());

			$('button.button').removeAttr("disabled");
		});
		

		$('.dec').on('click', function () {
			if ($(this).next().val() > 1) {
				if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
			}
			
			$(this).closest('.product-footer').find('a.btn').attr('data-quantity', $(this).closest('.product-footer').find('.qty-archive').val());
			
			$('button.button').removeAttr("disabled");
		});

 
 
	});

})(jQuery);
