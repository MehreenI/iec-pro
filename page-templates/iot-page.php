<?php
/**
 * Template Name: Iot Page
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

	<main id="main" class="iec-iot-main iot-page">

		<?php get_template_part( 'template-parts/iot/hero', 'slider', $part_args ); ?>

		<?php get_template_part( 'template-parts/iot/enquiry-section', null, $part_args ); ?>

		<?php if ( ! empty( $fields['section_services'] ) ) : ?>
			<?php get_template_part( 'template-parts/iot/services', null, array( 'section' => $fields['section_services'] ) ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['section_areas'] ) ) : ?>
			<?php get_template_part( 'template-parts/iot/areas', null, array( 'section' => $fields['section_areas'] ) ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['section_push-to-talk'] ) ) : ?>
			<?php get_template_part( 'template-parts/iot/push-to-talk', null, array( 'section' => $fields['section_push-to-talk'] ) ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['section_maritime'] ) ) : ?>
			<?php
			get_template_part(
				'template-parts/iot/accordion',
				null,
				array(
					'section'   => $fields['section_maritime'],
					'items_key' => 'accordion_maritime',
					'variant'   => 'maritime',
				)
			);
			?>
		<?php endif; ?>

		<?php if ( ! empty( $fields['section_in-land'] ) ) : ?>
			<?php
			get_template_part(
				'template-parts/iot/accordion',
				null,
				array(
					'section'     => $fields['section_in-land'],
					'items_key'   => 'accordion_in-land',
					'variant'     => 'in_land',
					'extra_class' => 'iec_iot_accordian_in_land pt-0',
				)
			);
			?>
		<?php endif; ?>

		<div class="background-bottom-block" aria-hidden="true"></div>

	</main>

	<?php
endwhile;

get_footer();
