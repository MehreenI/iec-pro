<?php
/**
 * Template Name: VAS Detail Page
 *
 * Value-added service detail (OptiSIM / GTS / similar).
 *
 * @package iec
 */

get_header();

while ( have_posts() ) :
	the_post();

	$fields = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$banner = is_array( $fields['banner'] ?? null ) ? $fields['banner'] : array();
	$part_args = array(
		'fields' => $fields,
		'banner' => $banner,
	);
	?>

	<main id="main" data-vas-detail-page>

		<?php get_template_part( 'template-parts/vas/detail-hero', null, $part_args ); ?>
		<?php get_template_part( 'template-parts/vas/detail-content', null, $part_args ); ?>

	</main>

	<?php
endwhile;

get_footer();
