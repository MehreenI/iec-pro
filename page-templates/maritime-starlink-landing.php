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

$ctx = iec_starlink_landing_context();

get_header();
?>

    <div class="content starlink-landing">
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
    </div>

<?php
get_footer();
