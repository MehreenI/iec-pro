<?php
/**
 * Template Name: Become Partner Page
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

	<main id="main" class="iec-become-partner-main" style="margin-bottom: 1rem">

		<?php get_template_part( 'template-parts/about/hero', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/heading', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/become-partner-enquiry', null, array( 'fields' => $fields ) ); ?>

	</main>

	<?php
endwhile;

get_footer();
