<?php

/*************************************************
## Groci Get options
*************************************************/
function groci_ft(){	
	$getft  = isset( $_GET['ft'] ) ? $_GET['ft'] : '';

	return esc_html($getft);
}

/* Load More */
require_once( __DIR__ . '/load-more/load-more.php' );
