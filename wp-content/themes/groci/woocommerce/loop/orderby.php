<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="row">
	<?php if(ot_get_option('groci_grid_list_view') == 'on'){ ?>
		<div class="col-md-6 col-xs-6">
			<div class="filter-tabs">
				<ul id="filter-tabs">
					<?php if(groci_shop_view() == 'list_view') { ?>
						<li> <a href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>" class="button-grid"><i class="icon mdi mdi-view-grid"></i></a> </li>
						<li class="active"><a href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>" class="button-list" ><i class="icon mdi mdi-view-list"></i></a></li>
					<?php } else { ?>
						<li class="active"><a href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>" class="button-grid"><i class="icon mdi mdi-view-grid"></i></a> </li>
						<li><a href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>" class="button-list" ><i class="icon mdi mdi-view-list"></i></a></li>
					<?php } ?>
					<?php if(is_shop()){ ?>
						<?php wp_enqueue_script( 'dealsdot-filter-toggle'); ?>
						<li class="klb-mobile-filter active"><a class="button-filter" data-toggle="offcanvasmobile" href="#"><i class="icon mdi mdi-filter"></i></a></li>
					<?php } ?>
					
				</ul>
			</div>
		</div>
		<div class="col-md-6 col-xs-6">
	<?php } else { ?>
		<div class="col-md-12">
	<?php } ?>

		<form class="woocommerce-ordering" method="get">
			<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'groci' ); ?>">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
		</form>
	</div>
	<div class="col-md-12"><?php echo groci_remove_klb_filter(); ?></div>
</div>