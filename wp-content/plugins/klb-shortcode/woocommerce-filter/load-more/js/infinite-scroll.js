
jQuery(document).ready(function ($) {
   var count = 2;
   var total = loadmore.max_page;
   
	$(window).data('ajaxready', true).scroll(function(e) {
		if ($(window).data('ajaxready') == false) return;
		
		if($(window).scrollTop() >= $('.klb-shop').offset().top + $('.klb-shop').outerHeight() - window.innerHeight) {
			$(window).data('ajaxready', false);

			if (count > total) {
				return false;
			} else {
				klb_infinite_pagination(count);
			}
			
			count++;
		 }
		
	});

   function klb_infinite_pagination() {
        var data = {
			cache: false,
            action: 'load_more',
			beforeSend: function() {
				$('.klb-shop > div:last-child').append('<svg class="loader-image preloader" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>');
			},
			'current_page': loadmore.current_page,
			'per_page': loadmore.per_page,
			'cat_id': loadmore.cat_id,
			'filter_cat': loadmore.filter_cat,
			'layered_nav': loadmore.layered_nav,
			'on_sale': loadmore.on_sale,
			'orderby': loadmore.orderby,
			'shop_view': loadmore.shop_view,

        };
		
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(loadmore.ajaxurl, data, function(response) {
            $('.klb-shop').append(response);
			loadmore.current_page++;
			
			if ( loadmore.current_page == loadmore.max_page ){
				$('.klb-load-more').remove();
			}
			
			$(".loader-image").remove();
			$(window).data('ajaxready', true);
        });

     return false;
   }
 });