<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_news' );

if ( empty( $section['enabled'] ) ) {
	return;
}

$manual = ! empty( $section['news_and_events'] ) && is_array( $section['news_and_events'] ) ? $section['news_and_events'] : array();

$query_args = array(
	'post_type'              => 'news',
	'post_status'            => 'publish',
	'posts_per_page'         => 3,
	'no_found_rows'          => true,
	'update_post_meta_cache' => true,
	'update_post_term_cache' => true,
	'orderby'                => 'date',
	'order'                  => 'DESC',
);

if ( $manual !== array() ) {
	$post_ids = array();

	foreach ( $manual as $item ) {
		$post_id = is_object( $item ) ? (int) $item->ID : (int) $item;

		if ( $post_id > 0 ) {
			$post_ids[] = $post_id;
		}
	}

	$query_args['post__in'] = $post_ids;
	$query_args['orderby']  = 'post__in';
	unset( $query_args['order'] );
}

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) {
	wp_reset_postdata();
	return;
}

get_template_part(
	'template-parts/modules/featured-news',
	null,
	array(
		'heading'       => $section['heading'] ?? '',
		'heading_class' => 'iec_section_heading iec-section-heading',
		'query'         => $query,
		'spacing'       => 'iec-offshore-news-section',
		'heading_attrs' => 'data-aos="fade-up"',
		'card_attrs'    => 'data-aos="fade-up"',
	)
);

wp_reset_postdata();
