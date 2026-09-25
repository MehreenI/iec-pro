<?php
/**
 * Single solution post template.
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

	$ctx = iec_solution_single_context( $fields );
	?>

	<main id="main" class="iec-single-solution-main">
		<?php
		get_template_part( 'template-parts/solution/hero', null, array( 'ctx' => $ctx ) );
		get_template_part( 'template-parts/solution/anchor-nav', null, array( 'ctx' => $ctx ) );

		if ( ! empty( $ctx['has_overview'] ) ) {
			get_template_part(
				'template-parts/solution/overview',
				null,
				array(
					'overview' => $ctx['overview'],
					'images'   => $ctx['overview_images'],
				)
			);
			get_template_part( 'template-parts/solution/image-modal' );
		}

		if ( ! empty( $ctx['has_use_cases'] ) ) {
			get_template_part(
				'template-parts/solution/use-cases',
				null,
				array(
					'use_cases' => $ctx['use_cases'],
					'list'      => $ctx['use_cases_list'],
				)
			);
		}

		if ( ! empty( $ctx['has_industries'] ) ) {
			get_template_part(
				'template-parts/solution/industries',
				null,
				array( 'items' => $ctx['industry_items'] )
			);
		} elseif ( ! empty( $ctx['has_markets'] ) ) {
			get_template_part(
				'template-parts/product/markets',
				null,
				array( 'filter' => $ctx['filter'] )
			);
		}

		if ( ! empty( $ctx['has_specs'] ) ) {
			get_template_part(
				'template-parts/product/specifications',
				null,
				array( 'specifications' => $ctx['specs'] )
			);
		}

		if ( ! empty( $ctx['has_features'] ) ) {
			get_template_part(
				'template-parts/solution/features',
				null,
				array( 'list' => $ctx['features_list'] )
			);
		}

		if ( ! empty( $ctx['has_materials'] ) ) {
			get_template_part(
				'template-parts/solution/materials',
				null,
				array(
					'materials'       => $ctx['materials'],
					'valid_materials' => $ctx['valid_materials'],
				)
			);
		}

		if ( ! empty( $ctx['has_faqs'] ) ) {
			get_template_part(
				'template-parts/solution/faq',
				null,
				array(
					'faqs' => $ctx['faqs'],
					'list' => $ctx['faq_list'],
				)
			);
		}

		iec_module(
			'contact-form',
			array(
				'form_heading' => __( 'Enquiry Now', 'bbtheme' ),
				'form_type'    => 'solution-enquiry',
			)
		);
		?>
	</main>

	<?php
endwhile;

get_footer();
