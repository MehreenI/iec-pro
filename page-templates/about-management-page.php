<?php
/**
 * Template Name: About Management Page
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

	<main id="main" class="iec-about-management-main">

		<?php get_template_part( 'template-parts/about/hero', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/heading', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/management-members', null, array( 'profile_sections' => $fields['profile_sections'] ?? array() ) ); ?>

	</main>

	<?php
endwhile;

get_footer();
