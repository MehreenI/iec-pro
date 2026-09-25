<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_office_check_icon_svg(): string {
	return '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M26.2996 7.89829C26.4266 8.02492 26.5273 8.17535 26.596 8.34097C26.6647 8.50658 26.7001 8.68413 26.7001 8.86343C26.7001 9.04274 26.6647 9.22029 26.596 9.3859C26.5273 9.55152 26.4266 9.70195 26.2996 9.82857L14.0309 22.0973C13.9042 22.2243 13.7538 22.325 13.5882 22.3937C13.4226 22.4624 13.245 22.4978 13.0657 22.4978C12.8864 22.4978 12.7089 22.4624 12.5433 22.3937C12.3777 22.325 12.2272 22.2243 12.1006 22.0973L6.64782 16.6445C6.39185 16.3886 6.24805 16.0414 6.24805 15.6794C6.24805 15.3174 6.39185 14.9702 6.64782 14.7143C6.90379 14.4583 7.25096 14.3145 7.61296 14.3145C7.97496 14.3145 8.32213 14.4583 8.5781 14.7143L13.0657 19.2046L24.3693 7.89829C24.496 7.77134 24.6464 7.67062 24.812 7.6019C24.9776 7.53318 25.1552 7.4978 25.3345 7.4978C25.5138 7.4978 25.6913 7.53318 25.8569 7.6019C26.0226 7.67062 26.173 7.77134 26.2996 7.89829Z" fill="#727DA3"/></svg>';
}

function iec_office_hero_is_new_design( array $hero ): bool {
	return ! empty( $hero['new_hero_design'] );
}

function iec_office_new_hero_bg_slides( array $hero ): array {
	$rows   = isset( $hero['bg_slides'] ) && is_array( $hero['bg_slides'] ) ? $hero['bg_slides'] : array();
	$slides = array();

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$desktop = iec_resolve_media_to_url( $row['desktop'] ?? null );
		if ( '' === $desktop ) {
			continue;
		}

		$mobile = iec_resolve_media_to_url( $row['mobile'] ?? null );

		$slides[] = array(
			'desktop' => $desktop,
			'mobile'  => '' !== $mobile ? $mobile : $desktop,
		);
	}

	return $slides;
}

function iec_office_hero_preload_urls( array $hero ): array {
	$urls = array();

	if ( iec_office_hero_is_new_design( $hero ) ) {
		foreach ( iec_office_new_hero_bg_slides( $hero ) as $bg ) {
			$urls[] = $bg['desktop'];
			if ( '' !== $bg['mobile'] && $bg['mobile'] !== $bg['desktop'] ) {
				$urls[] = $bg['mobile'];
			}

			if ( count( $urls ) >= 2 ) {
				break;
			}
		}

		return array_values( array_unique( $urls ) );
	}

	$slider = isset( $hero['slider'] ) && is_array( $hero['slider'] ) ? $hero['slider'] : array();

	foreach ( $slider as $banner ) {
		if ( ! is_array( $banner ) ) {
			continue;
		}

		$desktop = iec_resolve_media_to_url( $banner['banner'] ?? null );
		$mobile  = iec_resolve_media_to_url( $banner['mobile_image'] ?? null );

		if ( '' !== $desktop ) {
			$urls[] = $desktop;
		}

		if ( '' !== $mobile && $mobile !== $desktop ) {
			$urls[] = $mobile;
		}

		if ( count( $urls ) >= 2 ) {
			break;
		}
	}

	return array_values( array_unique( $urls ) );
}

function iec_office_regional_news_query( int $office_post_id ): WP_Query {
	$location = function_exists( 'get_field' ) ? get_field( 'office_location', $office_post_id ) : '';
	$location = is_string( $location ) ? strtolower( trim( $location ) ) : '';

	$base_args = array(
		'post_type'              => array( 'news', 'press-release' ),
		'post_status'            => 'publish',
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'posts_per_page'         => 3,
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	);

	$matching_term = null;

	if ( '' !== $location ) {
		$terms = get_terms(
			array(
				'taxonomy'   => 'news_location',
				'hide_empty' => false,
			)
		);

		if ( ! is_wp_error( $terms ) && is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( strtolower( $term->name ) === $location ) {
					$matching_term = $term;
					break;
				}
			}
		}
	}

	if ( $matching_term ) {
		$base_args['tax_query'] = array(
			array(
				'taxonomy' => 'news_location',
				'field'    => 'term_id',
				'terms'    => $matching_term->term_id,
			),
		);
	}

	return new WP_Query( $base_args );
}

function iec_office_preload_hero_images(): void {
	if ( ! is_singular( 'office' ) || ! function_exists( 'get_fields' ) ) {
		return;
	}

	$fields = get_fields();
	$hero   = isset( $fields['hero'] ) && is_array( $fields['hero'] ) ? $fields['hero'] : array();

	foreach ( array_slice( iec_office_hero_preload_urls( $hero ), 0, 2 ) as $url ) {
		if ( '' === $url ) {
			continue;
		}
		printf(
			'<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
			esc_url( $url )
		);
	}
}
add_action( 'wp_head', 'iec_office_preload_hero_images', 2 );
