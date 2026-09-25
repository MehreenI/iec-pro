<?php
/**
 * Template Name: Job Landing Page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields = get_fields() ?: array();
	?>

	<main id="main" class="iec-job-landing-main job-landing-page">

		<?php get_template_part( 'template-parts/about/hero', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/heading', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/job-vacancies', null, array( 'fields' => $fields ) ); ?>

	</main>

	<?php
endwhile;

get_footer();
