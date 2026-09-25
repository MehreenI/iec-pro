<?php
/**
 * News landing + news_type archive helpers.
 *
 * iec_news_landing_current_category() lives here.
 * Page JS: assets/js/pages/news-landing-page.js (window.iecNewsLanding).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_news_landing_get_page_id(): int {
	if ( function_exists( 'get_config' ) ) {
		$id = get_config( 'iec_news_page' );
		if ( is_numeric( $id ) && (int) $id > 0 ) {
			return (int) $id;
		}
	}

	$qid = get_queried_object_id();
	if ( $qid > 0 && 'page' === get_post_type( $qid ) ) {
		return $qid;
	}

	return 0;
}

function iec_news_landing_get_category_url(): string {
	$page_id = iec_news_landing_get_page_id();
	if ( $page_id > 0 ) {
		$url = get_permalink( $page_id );
		if ( $url ) {
			return trailingslashit( $url );
		}
	}

	return trailingslashit( home_url( '/news/' ) );
}

function iec_news_landing_current_term(): ?WP_Term {
	if ( ! is_tax( 'news_type' ) ) {
		return null;
	}

	$term = get_queried_object();

	return $term instanceof WP_Term ? $term : null;
}

function iec_news_landing_current_category(): string {
	$term = iec_news_landing_current_term();
	if ( $term && ! empty( $term->slug ) ) {
		return $term->slug;
	}

	return iec_news_landing_query_param( 'category' );
}

function iec_news_landing_query_param( string $key ): string {
	return isset( $_GET[ $key ] ) ? sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) : '';
}

function iec_news_landing_current_base_url(): string {
	$term = iec_news_landing_current_term();
	if ( $term ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) && $link ) {
			return trailingslashit( $link );
		}
	}

	return iec_news_landing_get_category_url();
}

function iec_news_type_archive_url( WP_Term $term ): string {
	$link = get_term_link( $term );
	if ( ! is_wp_error( $link ) && $link ) {
		return trailingslashit( $link );
	}

	return add_query_arg( 'category', $term->slug, iec_news_landing_get_category_url() );
}

function iec_news_landing_cached( string $suffix, callable $loader ): array {
	$page_id   = iec_news_landing_get_page_id();
	$cache_key = 'iec_news_landing_' . $suffix . '_' . $page_id;
	$cached    = get_transient( $cache_key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$value = $loader();
	if ( ! is_array( $value ) ) {
		$value = array();
	}

	set_transient( $cache_key, $value, HOUR_IN_SECONDS );

	return $value;
}

function iec_news_landing_get_location_terms(): array {
	return iec_news_landing_cached(
		'locations',
		static function () {
			$terms = get_terms(
				array(
					'taxonomy'   => 'news_location',
					'hide_empty' => true,
				)
			);

			return ( is_wp_error( $terms ) || ! is_array( $terms ) ) ? array() : $terms;
		}
	);
}

function iec_news_landing_bust_static_cache(): void {
	$page_id = iec_news_landing_get_page_id();
	delete_transient( 'iec_news_landing_locations_' . $page_id );
}

function iec_news_landing_term_label( $term ): string {
	if ( is_string( $term ) ) {
		$term = get_term_by( 'slug', $term, 'news_type' );
	}

	if ( ! $term instanceof WP_Term ) {
		return '';
	}

	$label = $term->name;

	if ( function_exists( 'get_field' ) ) {
		$caption = get_field( 'caption', 'news_type_' . $term->term_id );
		if ( is_string( $caption ) && '' !== $caption ) {
			$label = $caption;
		}
	}

	return $label;
}

function iec_news_landing_post_category_label( int $post_id ): string {
	$terms = get_the_terms( $post_id, 'news_type' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		return iec_news_landing_term_label( $terms[0] );
	}

	if ( 'press-release' === get_post_type( $post_id ) ) {
		return __( 'Press Release', 'bbtheme' );
	}

	return '';
}

function iec_news_landing_featured_title( string $category ): string {
	if ( '' === $category ) {
		return __( 'FEATURED NEWS', 'bbtheme' );
	}

	$label = iec_news_landing_term_label( $category );
	if ( '' === $label ) {
		$label = $category;
	}

	return sprintf(
		/* translators: %s: news category label */
		__( 'FEATURED %s', 'bbtheme' ),
		strtoupper( $label )
	);
}

function iec_news_landing_post_image_url( int $post_id ): string {
	if ( $post_id < 1 ) {
		return '';
	}

	if ( function_exists( 'get_field' ) ) {
		$image = get_field( 'image', $post_id );
		if ( is_array( $image ) && ! empty( $image['url'] ) ) {
			return (string) $image['url'];
		}
	}

	$thumb = get_the_post_thumbnail_url( $post_id, 'large' );

	return $thumb ? (string) $thumb : '';
}

function iec_news_landing_script_data( string $lang = '' ): array {
	if ( '' === $lang ) {
		$lang = (string) apply_filters( 'wpml_current_language', 'en' );
	}

	return array(
		'restUrl'   => esc_url_raw( rest_url( 'iec-news/v1/data' ) ),
		'page'      => 1,
		'category'  => iec_news_landing_current_category(),
		'industry'  => iec_news_landing_query_param( 'industry' ),
		'location'  => iec_news_landing_query_param( 'location' ),
		'lang'      => $lang,
		'noResults' => __( 'No results found.', 'bbtheme' ),
		'errorText' => __( 'Unable to load news.', 'bbtheme' ),
	);
}

