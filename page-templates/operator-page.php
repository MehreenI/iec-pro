<?php
/**
 * Template Name: Operator
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

get_header();

while (have_posts()):
    the_post();

    $defaults = iec_operator_defaults();
    $fallback = have_rows('page_sections') ? [] : array_column($defaults['page_sections'], 'acf_fc_layout');
    $contact_style = iec_filled(get_field('contact_style'), $defaults['contact_style']);
    $show_contact = get_field('show_contact');
    ?>

	<main id="main" class="iec-operator-main">
		<?php get_template_part('template-parts/operator/hero', null, ['fields' => iec_page_fields()]); ?>

		<?php while (have_rows('page_sections')): ?>
			<?php the_row(); ?>

			<?php get_template_part('template-parts/operator/' . str_replace('_', '-', get_row_layout())); ?>
		<?php endwhile; ?>

		<?php foreach ($fallback as $layout): ?>
			<?php get_template_part('template-parts/operator/' . str_replace('_', '-', $layout)); ?>
		<?php endforeach; ?>

		<?php if (null === $show_contact || $show_contact): ?>
			<?php iec_module( 'contact-form', array( 'style' => $contact_style ) ); ?>
		<?php endif; ?>
	</main>

<?php
endwhile;

get_footer();
