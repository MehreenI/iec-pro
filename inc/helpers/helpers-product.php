<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function iec_product_normalize_application_filter( $filter ): array {
	if ( ! is_array( $filter ) ) {
		$filter = ! empty( $filter ) ? array( $filter ) : array();
	}

	return array_values(
		array_filter(
			array_map( 'strtolower', $filter ),
			function ( $value ) {
				return in_array( $value, array( 'maritime', 'land' ), true );
			}
		)
	);
}

function iec_product_material_download_svg(): string {
	return '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20 38.75C30.3553 38.75 38.75 30.3553 38.75 20C38.75 9.64466 30.3553 1.25 20 1.25C9.64466 1.25 1.25 9.64466 1.25 20C1.25 30.3553 9.64466 38.75 20 38.75Z" fill="#727DA3" class="at_circle"/><path d="M20 23.575C19.8667 23.575 19.7417 23.5543 19.625 23.513C19.5083 23.4717 19.4 23.4007 19.3 23.3L15.7 19.7C15.5 19.5 15.404 19.2667 15.412 19C15.42 18.7333 15.516 18.5 15.7 18.3C15.9 18.1 16.1377 17.996 16.413 17.988C16.6883 17.98 16.9257 18.0757 17.125 18.275L19 20.15V13C19 12.7167 19.096 12.4793 19.288 12.288C19.48 12.0967 19.7173 12.0007 20 12C20.2827 11.9993 20.5203 12.0953 20.713 12.288C20.9057 12.4807 21.0013 12.718 21 13V20.15L22.875 18.275C23.075 18.075 23.3127 17.979 23.588 17.987C23.8633 17.995 24.1007 18.0993 24.3 18.3C24.4833 18.5 24.5793 18.7333 24.588 19C24.5967 19.2667 24.5007 19.5 24.3 19.7L20.7 23.3C20.6 23.4 20.4917 23.471 20.375 23.513C20.2583 23.555 20.1333 23.5757 20 23.575ZM14 28C13.45 28 12.9793 27.8043 12.588 27.413C12.1967 27.0217 12.0007 26.5507 12 26V24C12 23.7167 12.096 23.4793 12.288 23.288C12.48 23.0967 12.7173 23.0007 13 23C13.2827 22.9993 13.5203 23.0953 13.713 23.288C13.9057 23.4807 14.0013 23.718 14 24V26H26V24C26 23.7167 26.096 23.4793 26.288 23.288C26.48 23.0967 26.7173 23.0007 27 23C27.2827 22.9993 27.5203 23.0953 27.713 23.288C27.9057 23.4807 28.0013 23.718 28 24V26C28 26.55 27.8043 27.021 27.413 27.413C27.0217 27.805 26.5507 28.0007 26 28H14Z" fill="white"/></svg>';
}

function iec_product_check_icon_svg(): string {
    return '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M26.2996 7.89829C26.4266 8.02492 26.5273 8.17535 26.596 8.34097C26.6647 8.50658 26.7001 8.68413 26.7001 8.86343C26.7001 9.04274 26.6647 9.22029 26.596 9.3859C26.5273 9.55152 26.4266 9.70195 26.2996 9.82857L14.0309 22.0973C13.9042 22.2243 13.7538 22.325 13.5882 22.3937C13.4226 22.4624 13.245 22.4978 13.0657 22.4978C12.8864 22.4978 12.7089 22.4624 12.5433 22.3937C12.3777 22.325 12.2272 22.2243 12.1006 22.0973L6.64782 16.6445C6.39185 16.3886 6.24805 16.0414 6.24805 15.6794C6.24805 15.3174 6.39185 14.9702 6.64782 14.7143C6.90379 14.4583 7.25096 14.3145 7.61296 14.3145C7.97496 14.3145 8.32213 14.4583 8.5781 14.7143L13.0657 19.2046L24.3693 7.89829C24.496 7.77134 24.6464 7.67062 24.812 7.6019C24.9776 7.53318 25.1552 7.4978 25.3345 7.4978C25.5138 7.4978 25.6913 7.53318 25.8569 7.6019C26.0226 7.67062 26.173 7.77134 26.2996 7.89829Z" fill="#727DA3"/></svg>';
}

function iec_product_valid_materials( $product_materials ): array {
    $list = array();

    if ( ! is_array( $product_materials ) || empty( $product_materials['product_material_list'] ) ) {
        return $list;
    }

    if ( ! is_array( $product_materials['product_material_list'] ) ) {
        return $list;
    }

    foreach ( $product_materials['product_material_list'] as $row ) {
        if ( ! is_array( $row ) ) {
            continue;
        }
        $file = $row['file'] ?? null;
        if ( is_array( $file ) && ! empty( $file['url'] ) ) {
            $list[] = $row;
        }
    }

    return $list;
}

function iec_product_single_context( array $fields ): array {
    $filter = iec_product_normalize_application_filter( $fields['ps_filter_application'] ?? array() );

    $operator = $fields['ps_filter_operator'] ?? array();
    if ( ! is_array( $operator ) ) {
        $operator = ! empty( $operator ) ? array( $operator ) : array();
    }

    $overview               = is_array( $fields['overview'] ?? null ) ? $fields['overview'] : array();
    $key_features           = is_array( $fields['key_features'] ?? null ) ? $fields['key_features'] : array();
    $specifications_section = is_array( $fields['specifications_section'] ?? null ) ? $fields['specifications_section'] : array();
    $coverage_map           = is_array( $fields['coverage_map'] ?? null ) ? $fields['coverage_map'] : array();
    $product_materials      = is_array( $fields['product_materials'] ?? null ) ? $fields['product_materials'] : array();

    $has_starlink_map   = ! empty( $operator ) && in_array( 'starlink', $operator, true ) && ! empty( $coverage_map['starlink_map'] );
    $has_coverage_image = ! empty( $coverage_map['coverage_map_img']['url'] );
    $valid_materials    = iec_product_valid_materials( $product_materials );

    return array(
        'filter'                => $filter,
        'operator'              => $operator,
        'overview'              => $overview,
        'key_features'          => $key_features,
        'specifications'        => $specifications_section,
        'coverage_map'          => $coverage_map,
        'product_materials'     => $product_materials,
        'valid_materials'       => $valid_materials,
        'has_overview'          => ! empty( $overview['heading'] ) || ! empty( $overview['contant'] ),
        'has_key_features'      => ! empty( $key_features['core_features'] ),
        'has_markets'           => in_array( 'maritime', $filter, true ) || in_array( 'land', $filter, true ),
        'has_specifications'    => ! empty( $specifications_section['heading'] ) || ! empty( $specifications_section['specification_content'] ),
        'has_starlink_map'      => $has_starlink_map,
        'has_coverage_image'    => $has_coverage_image,
        'has_coverage'          => $has_starlink_map || $has_coverage_image,
        'has_product_materials' => ! empty( $valid_materials ),
    );
}

function iec_product_related_posts( int $post_id ): array {
    $args = array(
        'post_type'        => 'product',
        'posts_per_page'   => 8,
        'post_status'      => 'publish',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post__not_in'     => array( $post_id ),
        'suppress_filters' => false,
        'meta_query'       => array(
            array(
                'key'     => 'ps_filter_type',
                'value'   => '"product"',
                'compare' => 'LIKE',
            ),
        ),
    );

    $operators = function_exists( 'get_field' ) ? get_field( 'ps_filter_operator', $post_id ) : array();
    if ( ! empty( $operators ) ) {
        if ( ! is_array( $operators ) ) {
            $operators = array( $operators );
        }
        $operator_query = array( 'relation' => 'OR' );
        foreach ( $operators as $op ) {
            $operator_query[] = array(
                'key'     => 'ps_filter_operator',
                'value'   => '"' . $op . '"',
                'compare' => 'LIKE',
            );
        }
        $args['meta_query'] = $operator_query;
    }

    $posts = get_posts( $args );
    return is_array( $posts ) ? $posts : array();
}

function iec_solution_card_image_url( int $post_id, string $fallback = '' ): string {
    if ( $post_id < 1 || ! function_exists( 'get_field' ) ) {
        return $fallback;
    }

    $url = iec_resolve_media_to_url( get_field( 'landing_image', $post_id ) );

    return $url !== '' ? $url : $fallback;
}

function iec_product_hero_lcp_url( array $fields ): string {
    $hero   = is_array( $fields['hero_section'] ?? null ) ? $fields['hero_section'] : array();
    $right  = is_array( $hero['product_images'] ?? null ) ? $hero['product_images'] : array();
    $slides = is_array( $right['products'] ?? null ) ? $right['products'] : array();

    if ( empty( $slides[0] ) ) {
        return '';
    }

    return iec_resolve_media_to_url( $slides[0] );
}

function iec_product_single_preload_hero(): void {
    if ( ! is_singular( 'product' ) || ! function_exists( 'get_fields' ) ) {
        return;
    }

    $fields = get_fields();
    if ( ! is_array( $fields ) ) {
        return;
    }

    $url = iec_product_hero_lcp_url( $fields );
    if ( $url === '' ) {
        return;
    }

    printf(
        '<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
        esc_url( $url )
    );
}
add_action( 'wp_head', 'iec_product_single_preload_hero', 2 );

function iec_module_product_posts( array $products, int $min = 0, string $post_type = 'product' ): array {
    $posts = array();
    $seen  = array();

    foreach ( $products as $product ) {
        $post = $product instanceof WP_Post ? $product : get_post( (int) $product );

        if ( ! $post instanceof WP_Post || 'publish' !== $post->post_status || isset( $seen[ $post->ID ] ) ) {
            continue;
        }

        $posts[]            = $post;
        $seen[ $post->ID ]  = true;
    }

    if ( $min < 1 || count( $posts ) >= $min ) {
        return $posts;
    }

    $extra = get_posts(
        array(
            'post_type'              => $post_type,
            'post_status'            => 'publish',
            'posts_per_page'         => $min - count( $posts ),
            'post__not_in'           => array_keys( $seen ),
            'orderby'                => array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ),
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        )
    );

    foreach ( (array) $extra as $post ) {
        if ( ! $post instanceof WP_Post || isset( $seen[ $post->ID ] ) ) {
            continue;
        }

        $posts[]           = $post;
        $seen[ $post->ID ] = true;
    }

    return $posts;
}

function iec_product_enquiry_error_messages(): array {
    return array(
        100 => __( 'Invalid method', 'bbtheme' ),
        101 => __( 'Invalid data', 'bbtheme' ),
        102 => __( 'Invalid email', 'bbtheme' ),
        103 => __( 'Captcha not validated', 'bbtheme' ),
    );
}
