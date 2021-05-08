(function ($) {
  "use strict";

	$(document).ready(function () {
 
		$('#location').on('change', function() {
			$.cookie("location", $(this).val());
			location.reload(true); 
		});
	
	});

})(jQuery);
