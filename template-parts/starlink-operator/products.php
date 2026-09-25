<?php
/**
 * Starlink Operator — featured Starlink products (live CPT).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$operator_key = 'Starlink';

$products = get_posts(
	array(
		'post_type'              => 'product',
		'post_status'            => 'publish',
		'posts_per_page'         => 8,
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'suppress_filters'       => false,
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => false,
		'meta_query'             => array(
			array(
				'key'     => 'ps_filter_operator',
				'value'   => $operator_key,
				'compare' => 'LIKE',
			),
		),
	)
);

if ( empty( $products ) ) {
	return;
}

$view_all_url = '';
if ( function_exists( 'iec_ps_product_solution_base_url' ) && function_exists( 'iec_ps_operator_listing_url' ) ) {
	$view_all_url = iec_ps_operator_listing_url( iec_ps_product_solution_base_url(), $operator_key );
}
if ( ! $view_all_url && function_exists( 'iec_config_permalink' ) ) {
	$view_all_url = iec_config_permalink( 'iec_ps_page' );
}
if ( ! $view_all_url ) {
	$view_all_url = home_url( '/satellite-terminals/' );
}
if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$view_all_url = iec_resolve_wpml_url( $view_all_url );
}
?>
<section class="slo-sec slo-sec--surface" id="products" aria-labelledby="slo-products-heading">
	<div class="container">
		<div class="slo-section-head slo-section-head--center slo-reveal">
			<span class="iec_home_eyebrow">Starlink Products</span>
			<h2 class="slo-h2" id="slo-products-heading">Hardware Built for Performance</h2>
			<div class="wyswig-content">
				<p>Starlink terminals and kits available through IEC Telecom — from fixed sites to maritime deployments.</p>
			</div>
		</div>
	</div>

	<?php
	if ( function_exists( 'iec_module' ) ) {
		iec_module(
			'products',
			array(
				'heading'        => '',
				'products'       => $products,
				'show_btn'       => false,
				'section_class'  => 'iec-products-section iec-product-solution-section slo-products-module',
				'stagger_target' => '.iec-product-solution-wrapper',
			)
		);
	}
	?>

	<div class="container">
		<div class="slo-actions slo-actions--center slo-reveal">
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $view_all_url ); ?>">View all Starlink products</a>
		</div>
	</div>
</section>
