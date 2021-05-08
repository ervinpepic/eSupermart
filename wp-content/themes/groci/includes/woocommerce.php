<?php

/*************************************************
## Woocommerce 
*************************************************/

function groci_product_image(){
	if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
		$att=get_post_thumbnail_id();
		$image_src = wp_get_attachment_image_src( $att, 'full' );
		$image_src = $image_src[0];

		$width =  ot_get_option('groci_product_image_width');
		$height =  ot_get_option('groci_product_image_height');


		if($width && $height){
			$image = groci_resize( $image_src, $width, $height, true, true, true );  
		} else {
			$image = $image_src;
		}

		return esc_url($image);
	} else {
		return wc_placeholder_img_src('');
	}
}

if ( class_exists( 'woocommerce' ) ) {
add_theme_support( 'woocommerce' );
add_image_size('groci-woo-product', 450, 450, true);

// Remove woocommerce defauly styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// hide default shop title anasayfadaki title gizlemek için
add_filter('woocommerce_show_page_title', 'groci_override_page_title');
function groci_override_page_title() {
return false;
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); /*remove result count above products*/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);


add_action( 'woocommerce_before_shop_loop_item', 'groci_shop_thumbnail', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15);


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);
add_action( 'woocommerce_after_single_product_summary', 'groci_related_products', 20);
function groci_related_products(){
    woocommerce_related_products( array('posts_per_page' => 4));
}


/*----------------------------
  Add my owns
 ----------------------------*/
function groci_shop_thumbnail () {
		$id = get_the_ID();
		global $product;
		global $woocommerce;
		$rating = wc_get_rating_html($product->get_average_rating()); //get rating
	    $cart_url = wc_get_cart_url();
		$price = $product->get_price_html();
		$sale_price_dates_to    = ( $date = get_post_meta( $id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';
		$stock_status = $product->get_stock_status();
		$stock_text = $product->get_availability();
		$weight = $product->get_weight();


		$output = '';

		$att=get_post_thumbnail_id();
		$image_src = wp_get_attachment_image_src( $att, 'full' );

		if($image_src && function_exists('groci_resize')){
			$image_src = $image_src[0]; 
			$imageresize = groci_resize( $image_src, 170, 185, true, true, true );  
		} else {
			$image_src = $image_src[0]; 
			$imageresize = $image_src;
		}

		$percentage = '';
		if( $product->get_sale_price() && $product->get_regular_price()){
			$percentage .= '<span class="badge badge-success">';			
			$percentage .= ceil(100 - ($product->get_sale_price() / $product->get_regular_price()) * 100);			
			$percentage .= '%</span>';			
		}

    ?>


	<?php


		if (groci_shop_view() == 'list_view') {
			$output .= '<div class="product">';
			
			$output .= '<div class="row product-list-row">';
			
			$output .= '<div class="col-md-4">';
			$output .= '<div class="product-header">';
			$output .= $percentage;

			$output .= '<a href="'.get_permalink().'">';
			$output .= '<img class="img-fluid" src="'.groci_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
			$output .= '</a>';

			if($stock_status == 'instock'){
			$output .= '<span class="veg text-success mdi mdi-circle"></span>';
			} else {
			$output .= '<span class="non-veg text-danger mdi mdi-circle"></span>';
			}
			$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="col-md-8">';
			$output .= '<div class="product-body">';
			$output .= '<a href="'.get_permalink().'"><h2>'.get_the_title().'</h2></a>';
			if($stock_status == 'instock'){
			$output .= '<h6><strong><span class="mdi mdi-check-circle text-success"></span> '.$stock_text['availability'].'</strong>';
			} else {
			$output .= '<h6><strong><span class="mdi mdi-check-circle"></span> '.$stock_text['availability'].'</strong>';
			}
			if($weight){
			$output .= '<span> - '.$weight.' '.get_option('woocommerce_weight_unit').'</span></h6>';
			}
			$output .= '</div>';
			$output .= '<div class="product-footer">';
			$output .= '<p class="offer-price mb-0">'.$price.'</p>';
			$output .= '<div class="description m-t-10">'.groci_limit_words(get_the_excerpt(), '25').'</div>';
			if(ot_get_option('groci_quantity_box') == 'on'){
				if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
				wp_enqueue_script( 'groci-plus-minus'); 
				$output .= '<div class="plus-minus">';
				$output .= '<div class="cart-plus-minus">';
				$output .= '<div class="dec qtybutton">-</div>';
				$output .= '<input type="text" class="qty-archive" step="1" min="1" name="quantity" value="1" title="Qty" size="4" inputmode="numeric">';
				$output .= '<div class="inc qtybutton">+</div>';
				$output .= '</div>';
				$output .= '</div>';
				}
			}
			$output .= groci_add_to_cart_button();
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

		} else {
			$output .= '<div class="product">';
	
			$output .= '<div class="product-header">';
			$output .= $percentage;
			
			$output .= '<a href="'.get_permalink().'">';
			$output .= '<img class="img-fluid" src="'.groci_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
			$output .= '</a>';
			
			if($stock_status == 'instock'){
			$output .= '<span class="veg text-success mdi mdi-circle"></span>';
			} else {
			$output .= '<span class="non-veg text-danger mdi mdi-circle"></span>';
			}
			$output .= '</div>';
			$output .= '<div class="product-body">';
			$output .= '<a href="'.get_permalink().'"><h2>'.get_the_title().'</h2></a>';
			if($stock_status == 'instock'){
			$output .= '<h6><strong><span class="mdi mdi-check-circle text-success"></span> '.$stock_text['availability'].'</strong>';
			} else {
			$output .= '<h6><strong><span class="mdi mdi-check-circle"></span> '.$stock_text['availability'].'</strong>';
			}
			if($weight){
			$output .= '<span> - '.$weight.' '.get_option('woocommerce_weight_unit').'</span></h6>';
			}
			$output .= '</div>';
			$output .= '<div class="product-footer">';
			$output .= '<p class="offer-price mb-0">'.$price.'</p>';
			if(ot_get_option('groci_quantity_box') == 'on'){
				if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
				wp_enqueue_script( 'groci-plus-minus'); 
				$output .= '<div class="plus-minus">';
				$output .= '<div class="cart-plus-minus">';
				$output .= '<div class="dec qtybutton">-</div>';
				$output .= '<input type="text" class="qty-archive" step="1" min="1" name="quantity" value="1" title="Qty" size="4" inputmode="numeric">';
				$output .= '<div class="inc qtybutton">+</div>';
				$output .= '</div>';
				$output .= '</div>';
				}
			}
			$output .= groci_add_to_cart_button();
			$output .= '</div>';
			$output .= '</div>';
		}
		$output_escaped = $output;
		
		echo $output_escaped;

}

/*************************************************
## Woocommerce Cart Text
*************************************************/

//add to cart button
function groci_add_to_cart_button(){
	global $product;
	$output = '';

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output .= ob_get_clean();

	if(!empty($output)){
		$pos = strpos($output, ">");
		
		if ($pos !== false) {
		    $output = substr_replace($output,">", $pos , strlen(1));
		}
	}
	
	if($product->get_type() == 'variable' && empty($output)){
		$output = "<a class='btn btn-primary add-to-cart cart-hover' href='".get_permalink($product->id)."'>".esc_html__('Select options','groci')."</a>";
	}

	if($product->get_type() == 'simple'){
		$output .= "";
	} else {
		$btclass  = "single_bt";
	}
	
	if($output) return "$output";
}



/*************************************************
## Woo Cart Ajax
*************************************************/ 

add_filter('woocommerce_add_to_cart_fragments', 'groci_header_add_to_cart_fragment');
function groci_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	
	 <small class="cart-value cart-contents"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'groci'), $woocommerce->cart->cart_contents_count);?></small>

	<?php
	$fragments['small.cart-contents'] = ob_get_clean();

	return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <div class="fl-mini-cart-content">
        <?php woocommerce_mini_cart(); ?>
    </div>

    <?php $fragments['div.fl-mini-cart-content'] = ob_get_clean();

    return $fragments;

} );


/*************************************************
## Woo Cart Content Ajax
*************************************************/ 

add_filter('woocommerce_add_to_cart_fragments', 'groci_cart_content_fragment');
function groci_cart_content_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	
<span class="text-success cart-content-count">(<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'groci'), $woocommerce->cart->cart_contents_count);?>)</span>

	<?php
	$fragments['span.cart-content-count'] = ob_get_clean();

	return $fragments;
}	

/*************************************************
## Groci Woo Search Form
*************************************************/ 

add_filter( 'get_product_search_form' , 'groci_custom_product_searchform' );

function groci_custom_product_searchform( $form ) {

	$form = '
	<form class="search-form woocommerce-product-search" role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div class="input-group">
			<input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Enter Keyword Here ...', 'groci' ) . '" autocomplete="off">
			<span class="input-group-btn">
				<button class="btn btn-secondary" type="submit"><i class="mdi mdi-file-find"></i>'.esc_html__('Search','groci').'</button>
				<input type="hidden" name="post_type" value="product" />
			</span>
		</div>
	</form>';

	return $form;
}


/*************************************************
## Groci Stock Availability Translation
*************************************************/ 

add_filter( 'woocommerce_get_availability', 'groci_custom_get_availability', 1, 2);
function groci_custom_get_availability( $availability, $_product ) {
    
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('In Stock', 'groci');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('Out of stock', 'groci');
    }
    return $availability;
}


} // is woocommerce activated

?>