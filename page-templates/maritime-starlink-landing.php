<?php
/**
 * Template Name: Starlink Maritime Landing
 * Template Post Type: page, product, solution
 *
 * Thin wrapper — all markup lives in template-parts/starlink/* and is shared
 * with the "Starlink New Landing" template. Data comes from
 * iec_starlink_landing_context() in inc/page-starlink.php.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$ctx = iec_starlink_landing_context();
	?>

	<main id="main" class="content starlink-landing">
		<?php if ( empty( $ctx['fields']['banner_title'] ) && empty( $ctx['fields']['background_image'] ) ) : ?>
			<h1 class="screen-reader-text"><?= get_the_title(); ?></h1>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/starlink/banner', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/featured-news', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/benefits', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/products', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/discover', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/video', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/info', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/functionality-tabs', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/directions', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/directions-bottom', null, $ctx ); ?>
		<?php get_template_part( 'template-parts/starlink/faq', null, $ctx ); ?>
	</main>

	<?php
endwhile;

get_footer();
