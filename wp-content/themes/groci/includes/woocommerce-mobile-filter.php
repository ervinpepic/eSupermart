<div class="mobile-filter">
	<div class="mobile-filter-header">
		<h5><?php esc_html_e('Product Filters','groci'); ?> <a data-toggle="offcanvasmobile" class="float-right" href="#"><i class="mdi mdi-close"></i></a></h5>
	</div>
	<div class="klb-sidebar sidebar">
		<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
			<?php dynamic_sidebar( 'shop-sidebar' ); ?>
		<?php } ?> 
	</div>
</div>