<?php
/**
 * Template Name: Market Landing
 *
 * Sections read the ACF group "Market Landing Page" (acf/acf-t-market-landing.json).
 * A field left empty falls back to the built-in content, so the page keeps its
 * current text until an editor replaces it.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

get_header();

while ( have_posts() ) :
	the_post();

	$iec_fields  = iec_page_fields();
	$iec_section = function ( string $key ) use ( $iec_fields ): array {
		return is_array( $iec_fields[ $key ] ?? null ) ? $iec_fields[ $key ] : array();
	};
	?>

	<main id="main" class="t-market-landing">
		<?php
		get_template_part( 'template-parts/market-landing/hero', null, array( 'section' => $iec_section( 'hero' ) ) );
		get_template_part( 'template-parts/market-landing/industry-types', null, array( 'section' => $iec_section( 'industry_types' ) ) );
		get_template_part( 'template-parts/market-landing/specialized-connectivity', null, array( 'section' => $iec_section( 'specialized_connectivity' ) ) );
		get_template_part( 'template-parts/market-landing/industries', null, array( 'type' => 'land', 'section' => $iec_section( 'land_industries' ) ) );
		get_template_part( 'template-parts/market-landing/industries', null, array( 'type' => 'maritime', 'section' => $iec_section( 'maritime_industries' ) ) );
		get_template_part( 'template-parts/market-landing/global-coverage', null, array( 'section' => $iec_section( 'global_coverage' ) ) );
		get_template_part( 'template-parts/market-landing/video', null, array( 'section' => $iec_section( 'video' ) ) );
		get_template_part( 'template-parts/market-landing/our-solutions', null, array( 'section' => $iec_section( 'our_solutions' ) ) );
		get_template_part( 'template-parts/market-landing/faq', null, array( 'section' => $iec_section( 'faq' ) ) );

		iec_module( 'contact-form' );
		?>
	</main>

	<?php
endwhile;

get_footer();
