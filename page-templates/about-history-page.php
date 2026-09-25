<?php
/**
 * Template Name: About History Page
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

	<main id="main" class="iec-about-history-main">

		<?php get_template_part( 'template-parts/about/hero', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/heading', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/history-timeline', null, array( 'history' => $fields['history'] ?? array() ) ); ?>

	</main>

	<?php
endwhile;

get_footer();
