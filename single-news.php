<?php
/**
 * Single news post router.
 *
 * @package iec
 */

get_header();

$type_slug = iec_news_single_type_slug();
$template  = 'template-parts/news/types/' . $type_slug;

if ( locate_template( $template . '.php' ) ) {
	get_template_part( 'template-parts/news/types/' . $type_slug );
} else {
	get_template_part( 'template-parts/news/types/default' );
}

get_footer();
