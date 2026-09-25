<?php
/**
 * Single product post template.
 *
 * @package iec
 */

get_header();

while ( have_posts() ) :
	the_post();

	$fields = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	if ( ! is_array( $fields ) ) {
		$fields = array();
	}

	$ctx = iec_product_single_context( $fields );
	?>

	<main class="iec-single-product-main">
		<?php
		get_template_part(
			'template-parts/product/hero',
			null,
			array(
				'fields' => $fields,
				'filter' => $ctx['filter'],
			)
		);

		get_template_part(
			'template-parts/product/anchor-nav',
			null,
			array( 'ctx' => $ctx )
		);

		if ( ! empty( $ctx['has_overview'] ) ) {
			get_template_part(
				'template-parts/product/overview',
				null,
				array( 'overview' => $ctx['overview'] )
			);
		}

		if ( ! empty( $ctx['has_key_features'] ) ) {
			get_template_part(
				'template-parts/product/key-features',
				null,
				array( 'key_features' => $ctx['key_features'] )
			);
		}

		if ( ! empty( $ctx['has_markets'] ) ) {
			get_template_part(
				'template-parts/product/markets',
				null,
				array( 'filter' => $ctx['filter'] )
			);
		}

		if ( ! empty( $ctx['has_specifications'] ) ) {
			get_template_part(
				'template-parts/product/specifications',
				null,
				array( 'specifications' => $ctx['specifications'] )
			);
		}

		if ( ! empty( $ctx['has_coverage'] ) ) {
			get_template_part(
				'template-parts/product/coverage',
				null,
				array(
					'coverage_map'       => $ctx['coverage_map'],
					'has_starlink_map'   => $ctx['has_starlink_map'],
					'has_coverage_image' => $ctx['has_coverage_image'],
				)
			);
		}

		if ( ! empty( $ctx['has_product_materials'] ) ) {
			get_template_part(
				'template-parts/product/materials',
				null,
				array(
					'product_materials' => $ctx['product_materials'],
					'valid_materials'   => $ctx['valid_materials'],
				)
			);
		}

		get_template_part(
			'template-parts/product/related-products',
			null,
			array( 'post_id' => get_the_ID() )
		);

		get_template_part( 'template-parts/product/contact' );
		?>
	</main>

	<?php
endwhile;

get_footer();
