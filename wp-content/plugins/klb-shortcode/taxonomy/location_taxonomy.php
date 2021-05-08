<?php

/*************************************************
## Register Location Taxonomy
*************************************************/ 

function custom_taxonomy_location()  {
$labels = array(
    'name'                       => 'Locations',
    'singular_name'              => 'Location',
    'menu_name'                  => 'Locations',
    'all_items'                  => 'All Locations',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Location',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'location', array( 'product','shop_coupon' ), $args );
register_taxonomy_for_object_type( 'location', array( 'product','shop_coupon' ) );
}
add_action( 'init', 'custom_taxonomy_location' );



/*************************************************
## Groci Query Vars
*************************************************/ 
function groci_query_vars( $query_vars ){
    $query_vars[] = 'klb_special_query';
    return $query_vars;
}
add_filter( 'query_vars', 'groci_query_vars' );

/*************************************************
## Groci Product Query for Klb Shortcodes
*************************************************/ 
function groci_product_query( $query ){
    if( isset( $query->query_vars['klb_special_query'] ) && groci_location() != 'all'){
		$tax_query[] = array(
			'taxonomy' => 'location',
			'field'    => 'slug',
			'terms'    => groci_location(),
		);

		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'groci_product_query' );

/*************************************************
## Groci Location
*************************************************/ 
function groci_location(){	
	$location  = isset( $_COOKIE['location'] ) ? $_COOKIE['location'] : 'all';
	if($location){
		return $location;
	}
}

/*************************************************
## Groci Location Output
*************************************************/ 
function groci_location_output(){	
	
	wp_enqueue_script( 'jquery-cookie');
	wp_enqueue_script( 'klb-location-filter');

	$terms = get_terms( array(
		'taxonomy' => 'location',
		'hide_empty' => true,
		'parent'    => 0,
	) );

	$output = '';
	
	$output .= '<select id="location">';
	$output .= '<option value="all">Your Location</option>';
	foreach ( $terms as $term ) {
		if($term->slug == groci_location()){
			$select = 'selected';
		} else {
			$select = '';
		}
		$output .= '<option value="'.esc_attr($term->slug).'" '.esc_attr($select).'>'.esc_html($term->name).'</option>';
	}
	$output .= '</select>';
	
	return $output;
}