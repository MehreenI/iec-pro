<?php
/**
 * Template Name: Optiview page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields    = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$part_args = array( 'fields' => $fields );
	?>
	<main id="main">

		<?php get_template_part( 'template-parts/optiview/banner', null, $part_args ); ?>

		<?php if ( ! empty( $fields['features'] ) ) : ?>
			<?php get_template_part( 'template-parts/optiview/solutions', null, $part_args ); ?>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/optiview/video', null, $part_args ); ?>

		<?php if ( ! empty( $fields['items'] ) ) : ?>
			<?php get_template_part( 'template-parts/optiview/accordion', null, $part_args ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['parts'] ) ) : ?>
			<?php get_template_part( 'template-parts/optiview/benefits', null, $part_args ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['use_cases'] ) ) : ?>
			<?php get_template_part( 'template-parts/optiview/use-cases', null, $part_args ); ?>
		<?php endif; ?>

	</main>

	<?php get_template_part( 'template-parts/optiview/coming-soon-modal', null, $part_args ); ?>
	<?php
endwhile;

get_footer();
