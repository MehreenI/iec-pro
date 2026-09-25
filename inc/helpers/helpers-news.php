<?php
/**
 * Shared news helpers: archive URL, home insights, single news.
 * Landing helpers: inc/helpers/helpers-news-landing.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_news_archive_url(): string {
	if ( function_exists( 'iec_config_permalink' ) ) {
		$url = iec_config_permalink( 'iec_news_page' );
		if ( '' !== $url ) {
			return $url;
		}
	}

	return iec_news_landing_get_category_url();
}

function iec_home_insights_tabs(): array {
	return array(
		array(
			'slug'  => 'insights',
			'label' => __( 'Insights', 'bbtheme' ),
		),
		array(
			'slug'  => 'publications',
			'label' => __( 'Publications', 'bbtheme' ),
		),
		array(
			'slug'  => 'events',
			'label' => __( 'Events', 'bbtheme' ),
		),
		array(
			'slug'  => 'press-release',
			'label' => __( 'Press Releases', 'bbtheme' ),
		),
		array(
			'slug'  => 'latest-updates',
			'label' => __( 'Latest Updates', 'bbtheme' ),
		),
	);
}

function iec_home_insights_query( string $category ): WP_Query {
	if ( ! class_exists( 'IEC_News_Query' ) ) {
		return new WP_Query(
			array(
				'post_type'      => array( 'news', 'press-release' ),
				'posts_per_page' => 3,
				'post_status'    => 'publish',
			)
		);
	}

	return new WP_Query( IEC_News_Query::get_list_args( $category, '', '', 1, 3 ) );
}

function iec_home_insights_post_data( int $post_id ): array {
	$fields   = function_exists( 'get_fields' ) ? ( get_fields( $post_id ) ?: array() ) : array();
	$caption  = $fields['caption'] ?? '';
	$excerpt  = is_string( $caption ) ? wp_strip_all_tags( $caption ) : '';
	$image_id = 0;

	if ( function_exists( 'get_field' ) ) {
		$image = get_field( 'image', $post_id );
		if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
			$image_id = (int) $image['ID'];
		} elseif ( is_numeric( $image ) ) {
			$image_id = (int) $image;
		}
	}

	if ( $image_id < 1 ) {
		$image_id = (int) get_post_thumbnail_id( $post_id );
	}

	return array(
		'id'        => $post_id,
		'title'     => get_the_title( $post_id ),
		'permalink' => get_permalink( $post_id ) ?: '',
		'date'      => strtoupper( get_the_date( 'd M Y', $post_id ) ),
		'category'  => strtoupper( iec_news_landing_post_category_label( $post_id ) ),
		'excerpt'   => wp_trim_words( $excerpt, 24, ' >>' ),
		'image'     => iec_news_landing_post_image_url( $post_id ),
		'image_id'  => $image_id,
	);
}

function iec_news_single_type_slug( int $post_id = 0 ): string {
	$post_id = $post_id > 0 ? $post_id : (int) get_the_ID();

	if ( 'press-release' === get_post_type( $post_id ) ) {
		return 'press-release';
	}

	$known = array( 'insights', 'publications', 'events', 'press-release', 'latest-updates', 'latest-update' );
	$term  = iec_news_single_primary_term( $post_id );
	$slug  = $term ? (string) $term->slug : '';

	if ( 'latest-update' === $slug ) {
		return 'latest-updates';
	}

	return in_array( $slug, $known, true ) ? $slug : 'default';
}

function iec_news_single_primary_term( int $post_id = 0 ): ?WP_Term {
	$post_id = $post_id > 0 ? $post_id : (int) get_the_ID();
	$terms   = get_the_terms( $post_id, 'news_type' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	return $terms[0];
}

function iec_news_banner_image_from_fields( array $fields ): string {
	if ( empty( $fields['image'] ) ) {
		return '';
	}

	return iec_resolve_media_to_url( $fields['image'] );
}

function iec_news_single_related_query( int $post_id, ?WP_Term $term = null, array $manual_posts = array() ): ?WP_Query {
	if ( $manual_posts ) {
		$ids = array();
		foreach ( $manual_posts as $post ) {
			$ids[] = is_object( $post ) ? (int) $post->ID : (int) $post;
		}
		$ids = array_values( array_filter( array_unique( $ids ) ) );
		if ( $ids ) {
			return new WP_Query(
				array(
					'post_type'      => array( 'news', 'press-release' ),
					'post__in'       => $ids,
					'orderby'        => 'post__in',
					'posts_per_page' => count( $ids ),
				)
			);
		}
	}

	if ( ! $term ) {
		return null;
	}

	return new WP_Query(
		array(
			'post_type'      => 'news',
			'posts_per_page' => 3,
			'post__not_in'   => array( $post_id ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'news_type',
					'field'    => 'slug',
					'terms'    => $term->slug,
				),
			),
		)
	);
}

function iec_news_stat_number_parts( string $raw ): array {
	$display = trim( $raw );
	$empty   = array(
		'display' => $display,
		'count'   => '',
		'suffix'  => '',
		'animate' => false,
	);

	if ( '' === $display ) {
		$empty['display'] = '';
		return $empty;
	}

	if ( preg_match( '/^(\d+(?:\.\d+)?)(.*)$/u', $display, $matches ) ) {
		return array(
			'display' => $display,
			'count'   => $matches[1],
			'suffix'  => (string) $matches[2],
			'animate' => true,
		);
	}

	return $empty;
}

function iec_news_render_flexible_section( string $layout, array $block = array() ): void {
	$layout = trim( $layout );
	if ( '' === $layout ) {
		return;
	}

	$slug = 'template-parts/news/flexible/' . $layout;
	if ( ! file_exists( get_template_directory() . '/' . $slug . '.php' ) ) {
		return;
	}

	get_template_part( $slug, null, array( 'block' => $block ) );
}

function iec_news_event_gradient_style( array $fields ): string {
	if ( empty( $fields['add_custom_background_color'] ) ) {
		return '';
	}

	$gen = $fields['gradient_generator'] ?? array();
	if ( ! is_array( $gen ) || empty( $gen['gradient_colors'] ) ) {
		return '';
	}

	$stops = array();
	foreach ( $gen['gradient_colors'] as $color ) {
		if ( ! empty( $color['color'] ) && isset( $color['position'] ) ) {
			$stops[] = $color['color'] . ' ' . (int) $color['position'] . '%';
		}
	}

	if ( count( $stops ) < 2 ) {
		return '';
	}

	if ( 'radial' === ( $gen['gradient_type'] ?? '' ) ) {
		$position = $gen['radial_position'] ?? 'center';
		return 'background: radial-gradient(at ' . $position . ', ' . implode( ', ', $stops ) . ');';
	}

	$direction = ! empty( $gen['custom_angle'] )
		? ( (int) $gen['custom_angle'] ) . 'deg'
		: ( $gen['direction'] ?? 'to bottom' );

	return 'background: linear-gradient(' . $direction . ', ' . implode( ', ', $stops ) . ');';
}

function iec_news_single_preload_hero(): void {
	if ( ! is_singular( array( 'news', 'press-release' ) ) || ! function_exists( 'get_fields' ) ) {
		return;
	}

	$fields = get_fields();
	if ( ! is_array( $fields ) ) {
		return;
	}

	$url = iec_news_banner_image_from_fields( $fields );
	if ( '' === $url ) {
		return;
	}

	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'iec_news_single_preload_hero', 2 );
