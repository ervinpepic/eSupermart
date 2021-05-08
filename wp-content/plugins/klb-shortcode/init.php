<?php
    /*
    Plugin Name: Klb Shortcode
    Plugin URI: http://themeforest.net/user/klbtheme/portfolio
    Description: Plugin for displaying theme shortcodes.
    Author: KlbTheme
    Version: 1.6.0
    Author URI: http://themeforest.net/user/klbtheme/portfolio
    */
	
/*************************************************
## Include the required files
*************************************************/ 

	require_once('inc/klb-shortcode.php');
	require_once('inc/style.php');	
	require_once('inc/aq_resizer.php');	
	require_once('inc/post_view.php');
	require_once('widgets/widget-product-categories.php');
	require_once('widgets/widget-product-status.php');

	if ( ! function_exists( 'klbshortcode' ) ) {
		function klbshortcode() {
		}
	}

/*************************************************
## Woocommerce Filter Load More
*************************************************/ 
if ( ! function_exists( 'klbwoofilter' )){
    function klbwoofilter (){
       require_once('woocommerce-filter/woocommerce-filter.php');
    }
}
add_action( 'after_setup_theme', 'klbwoofilter' );

/*************************************************
## Load Languages
*************************************************/ 
function klb_shortcode_load_plugin_textdomain() {
	load_plugin_textdomain( 'klb-shortcode', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'klb_shortcode_load_plugin_textdomain' );

/*************************************************
## Styles and Scripts
*************************************************/ 
define('KLB_INDEX_JS', plugin_dir_url( __FILE__ )  . '/js');
define('KLB_INDEX_CSS', plugin_dir_url( __FILE__ )  . '/css');

function klb_scripts() {
     wp_register_script( 'klb-location-filter', 	  	  plugins_url( 'js/location-filter.js', __FILE__ ), true );
     wp_register_script( 'klb-widget-product-categories', plugins_url( 'widgets/js/widget-product-categories.js', __FILE__ ), true );
}
add_action( 'wp_enqueue_scripts', 'klb_scripts' );


/*************************************************
## Location Filter Check
*************************************************/
function klb_location_filter_check()
{
	if(ot_get_option('groci_location_filter') == 'on'){
		require_once('taxonomy/location_taxonomy.php');	
	}

}
add_action( 'after_setup_theme', 'klb_location_filter_check' );
