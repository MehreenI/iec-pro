<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_sp_landing_per_page() {
	return 8;
}

function iec_sp_landing_filter_groups() {
	return array(
		'application',
		'setup',
		'type',
		'operator',
		'market',
	);
}

function iec_sp_landing_product_category_keys() {
	return array(
		'land',
		'maritime',
		'satellite-phones',
	);
}

function iec_sp_landing_normalize_post_type( $post_type ) {
	return in_array( $post_type, array( 'product', 'solution' ), true ) ? $post_type : 'product';
}

function iec_sp_landing_lang_aliases( $lang ) {
	$lang  = is_string( $lang ) && '' !== $lang ? $lang : 'en';
	$codes = array( $lang );

	if ( 'zh-hans' === $lang ) {
		$codes[] = 'zh';
	} elseif ( 'zh' === $lang ) {
		$codes[] = 'zh-hans';
	}

	return array_values( array_unique( $codes ) );
}

function iec_sp_landing_current_lang() {
	$lang = function_exists( 'iec_wpml_current_language' ) ? iec_wpml_current_language() : '';

	return '' !== $lang ? $lang : 'en';
}

function iec_sp_landing_default_lang() {
	return function_exists( 'iec_wpml_default_language' ) ? iec_wpml_default_language() : 'en';
}

function iec_sp_landing_source_page_id( $page_id ) {
	$page_id = (int) $page_id;
	if ( $page_id < 1 || ! has_filter( 'wpml_object_id' ) ) {
		return $page_id;
	}

	$source_id = apply_filters( 'wpml_object_id', $page_id, 'page', true, iec_sp_landing_default_lang() );

	return $source_id ? (int) $source_id : $page_id;
}

function iec_sp_landing_page_field( $field, $page_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	$page_id = (int) $page_id;
	$value   = $page_id > 0 ? get_field( $field, $page_id ) : null;

	if ( ! iec_sp_landing_field_is_empty( $value ) ) {
		return $value;
	}

	$source_id = iec_sp_landing_source_page_id( $page_id );
	if ( $source_id > 0 && $source_id !== $page_id ) {
		return get_field( $field, $source_id );
	}

	return $value;
}

function iec_sp_landing_field_is_empty( $value ) {
	if ( null === $value || false === $value || '' === $value ) {
		return true;
	}

	return is_array( $value ) && $value === array();
}

function iec_sp_landing_map_ids_to_language( $ids, $lang, $post_type ) {
	$ids       = is_array( $ids ) ? $ids : array();
	$lang      = is_string( $lang ) && '' !== $lang ? $lang : iec_sp_landing_current_lang();
	$post_type = iec_sp_landing_normalize_post_type( $post_type );
	$mapped    = array();

	foreach ( $ids as $id ) {
		$id = (int) $id;
		if ( $id < 1 ) {
			continue;
		}

		if ( has_filter( 'wpml_object_id' ) ) {
			$translated = apply_filters( 'wpml_object_id', $id, $post_type, false, $lang );
			if ( ! $translated ) {
				continue;
			}
			$id = (int) $translated;
		}

		if ( 'publish' === get_post_status( $id ) && $post_type === get_post_type( $id ) ) {
			$mapped[] = $id;
		}
	}

	return array_values( array_unique( $mapped ) );
}

function iec_sp_landing_product_category( $page_id ) {
	$page_id = (int) $page_id;
	if ( $page_id < 1 || ! function_exists( 'get_field' ) ) {
		return '';
	}

	$raw = iec_sp_landing_page_field( 'product_category', $page_id );
	if ( empty( $raw ) ) {
		return '';
	}

	$allowed = iec_sp_landing_product_category_keys();
	$values  = is_array( $raw ) ? $raw : array( $raw );

	foreach ( $values as $value ) {
		$key = sanitize_title_for_query( (string) $value );
		if ( in_array( $key, $allowed, true ) ) {
			return $key;
		}
	}

	return '';
}

function iec_sp_landing_apply_locked_category( $filters, $category ) {
	$filters  = is_array( $filters ) ? $filters : array();
	$category = sanitize_title_for_query( (string) $category );

	if ( ! in_array( $category, iec_sp_landing_product_category_keys(), true ) ) {
		return $filters;
	}

	$filters['application'] = array( $category );

	return $filters;
}

function iec_sp_landing_normalize_filters( $raw ) {
	$normalized = array();

	if ( ! is_array( $raw ) ) {
		return $normalized;
	}

	foreach ( iec_sp_landing_filter_groups() as $group ) {
		if ( empty( $raw[ $group ] ) ) {
			continue;
		}

		$values = is_array( $raw[ $group ] ) ? $raw[ $group ] : array( $raw[ $group ] );
		$keys   = array();

		foreach ( $values as $value ) {
			$key = sanitize_title_for_query( (string) $value );
			if ( '' !== $key ) {
				$keys[] = $key;
			}
		}

		$keys = array_values( array_unique( $keys ) );
		if ( $keys !== array() ) {
			$normalized[ $group ] = $keys;
		}
	}

	return $normalized;
}

function iec_sp_landing_filter_names( $filters ) {
	$filter_names = array();

	foreach ( $filters as $group => $keys ) {
		foreach ( $keys as $key ) {
			$filter_names[] = sanitize_key( $group ) . '_' . $key;
		}
	}

	return array_values( array_unique( $filter_names ) );
}

function iec_sp_landing_ids_for_langs( $filter_names, $langs ) {
	global $wpdb;

	$filter_names = array_values( array_filter( array_map( 'strval', (array) $filter_names ) ) );
	$langs        = array_values( array_unique( array_filter( array_map( 'strval', (array) $langs ) ) ) );

	if ( $filter_names === array() || $langs === array() ) {
		return array();
	}

	$table = $wpdb->prefix . 'custom_ps_filter';

	$count              = count( $filter_names );
	$name_placeholders  = implode( ', ', array_fill( 0, $count, '%s' ) );
	$lang_placeholders  = implode( ', ', array_fill( 0, count( $langs ), '%s' ) );

	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT post_id FROM {$table} WHERE lang_code IN ({$lang_placeholders}) AND filter_value = '1' AND filter_name IN ({$name_placeholders}) GROUP BY post_id HAVING COUNT(DISTINCT filter_name) = %d",
			array_merge( $langs, $filter_names, array( $count ) )
		)
	);

	if ( ! is_array( $ids ) ) {
		return array();
	}

	return array_values( array_map( 'intval', $ids ) );
}

function iec_sp_landing_ids_for_all_filters( $filter_names, $lang, $post_type = 'product' ) {
	global $wpdb;

	if ( $filter_names === array() ) {
		return array();
	}

	$table = $wpdb->prefix . 'custom_ps_filter';

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) !== $table ) {
		return null;
	}

	$lang    = is_string( $lang ) && '' !== $lang ? $lang : iec_sp_landing_current_lang();
	$default = iec_sp_landing_default_lang();
	$ids     = iec_sp_landing_ids_for_langs( $filter_names, iec_sp_landing_lang_aliases( $lang ) );

	if ( $ids === array() && $default !== $lang ) {
		$ids = iec_sp_landing_ids_for_langs( $filter_names, iec_sp_landing_lang_aliases( $default ) );
	}

	if ( $ids === array() ) {
		return array();
	}

	return iec_sp_landing_map_ids_to_language( $ids, $lang, $post_type );
}

function iec_sp_landing_filter_post_ids( $filters, $post_type = 'product' ) {
	if ( empty( $filters ) ) {
		return null;
	}

	$filter_names = iec_sp_landing_filter_names( $filters );
	if ( $filter_names === array() ) {
		return null;
	}

	$ids = iec_sp_landing_ids_for_all_filters( $filter_names, iec_sp_landing_current_lang(), $post_type );

	if ( null === $ids || $ids === array() ) {
		return null;
	}

	return $ids;
}

function iec_sp_landing_filters_meta_query( $filters ) {
	if ( empty( $filters ) ) {
		return array();
	}

	$meta_query = array( 'relation' => 'AND' );

	foreach ( $filters as $group => $keys ) {
		foreach ( $keys as $key ) {
			$meta_query[] = array(
				'key'     => 'ps_filter_' . sanitize_key( $group ),
				'value'   => '"' . $key . '"',
				'compare' => 'LIKE',
			);
		}
	}

	return $meta_query;
}

function iec_sp_landing_sanitize_search( $raw ) {
	$search = trim( sanitize_text_field( (string) $raw ) );

	if ( function_exists( 'mb_substr' ) ) {
		return mb_substr( $search, 0, 80 );
	}

	return substr( $search, 0, 80 );
}

function iec_sp_landing_search_posts_where( $where, $query ) {
	if ( ! $query instanceof WP_Query ) {
		return $where;
	}

	$search = $query->get( 'iec_sp_landing_search' );
	if ( ! is_string( $search ) || '' === $search ) {
		return $where;
	}

	global $wpdb;
	$like   = '%' . $wpdb->esc_like( $search ) . '%';
	$where .= $wpdb->prepare(
		" AND ( {$wpdb->posts}.post_title LIKE %s OR {$wpdb->posts}.post_excerpt LIKE %s OR {$wpdb->posts}.post_content LIKE %s OR EXISTS (
			SELECT 1 FROM {$wpdb->postmeta} AS iec_sp_cap
			WHERE iec_sp_cap.post_id = {$wpdb->posts}.ID
			AND iec_sp_cap.meta_key = 'caption'
			AND iec_sp_cap.meta_value LIKE %s
		) ) ",
		$like,
		$like,
		$like,
		$like
	);

	return $where;
}

function iec_sp_landing_query_args( $page, $per_page, $filters = array(), $post_type = 'product', $search = '' ) {
	$post_type = iec_sp_landing_normalize_post_type( $post_type );
	$search    = iec_sp_landing_sanitize_search( $search );
	$args      = array(
		'post_type'              => $post_type,
		'post_status'            => 'publish',
		'posts_per_page'         => max( 1, (int) $per_page ),
		'paged'                  => max( 1, (int) $page ),
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'no_found_rows'          => false,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => false,
		'suppress_filters'       => false,
	);

	if ( '' !== $search ) {
		$args['iec_sp_landing_search'] = $search;
	}

	$filter_ids = iec_sp_landing_filter_post_ids( $filters, $post_type );

	if ( is_array( $filter_ids ) && $filter_ids !== array() ) {
		$args['post__in'] = $filter_ids;
	} elseif ( ! empty( $filters ) ) {
		$args['meta_query'] = iec_sp_landing_filters_meta_query( $filters );
	}

	return $args;
}

function iec_sp_landing_get_products( $page, $per_page = null, $filters = array(), $post_type = 'product', $search = '' ) {
	$per_page   = null !== $per_page ? max( 1, (int) $per_page ) : iec_sp_landing_per_page();
	$page       = max( 1, (int) $page );
	$filters    = is_array( $filters ) ? $filters : array();
	$post_type  = iec_sp_landing_normalize_post_type( $post_type );
	$search     = iec_sp_landing_sanitize_search( $search );
	$use_search = '' !== $search;

	if ( $use_search ) {
		add_filter( 'posts_where', 'iec_sp_landing_search_posts_where', 10, 2 );
	}

	try {
		$query = new WP_Query( iec_sp_landing_query_args( $page, $per_page, $filters, $post_type, $search ) );
		$posts = is_array( $query->posts ) ? $query->posts : array();
	} finally {
		if ( $use_search ) {
			remove_filter( 'posts_where', 'iec_sp_landing_search_posts_where', 10 );
		}
	}

	wp_reset_postdata();

	return array(
		'posts'     => $posts,
		'total'     => (int) $query->found_posts,
		'has_more'  => $page < (int) $query->max_num_pages,
		'page'      => $page,
		'per_page'  => $per_page,
		'post_type' => $post_type,
	);
}

function iec_sp_landing_page_context( $page_id = 0 ) {
	$page_id   = $page_id > 0 ? (int) $page_id : (int) get_queried_object_id();
	$post_type = iec_sp_landing_page_field( 'show_solution', $page_id ) ? 'solution' : 'product';
	$category  = iec_sp_landing_product_category( $page_id );
	$filters   = iec_sp_landing_apply_locked_category( array(), $category );
	$search    = isset( $_GET['keyword'] ) ? iec_sp_landing_sanitize_search( wp_unslash( $_GET['keyword'] ) ) : '';
	$query     = iec_sp_landing_get_products( 1, null, $filters, $post_type, $search );
	$is_inner  = '' !== $category;

	return array(
		'page_id'                 => $page_id,
		'post_type'               => $post_type,
		'per_page'                => $query['per_page'],
		'products'                => $query['posts'],
		'has_more'                => $query['has_more'],
		'total'                   => $query['total'],
		'current_page'            => 1,
		'product_category'        => $category,
		'search'                  => $search,
		'is_inner_products'       => $is_inner,
		'hide_application_filter' => $is_inner,
		'hide_card_category'      => 'satellite-phones' === $category,
	);
}

function iec_sp_landing_render_products_html( $posts, $args = array() ) {
	if ( empty( $posts ) || ! is_array( $posts ) ) {
		return '';
	}

	$args               = is_array( $args ) ? $args : array();
	$hide_card_category = ! empty( $args['hide_card_category'] );
	$search             = isset( $args['search'] ) ? iec_sp_landing_sanitize_search( $args['search'] ) : '';

	ob_start();

	foreach ( $posts as $post ) {
		get_template_part(
			'template-parts/sp-landing/product',
			'card',
			array(
				'post'               => $post,
				'hide_card_category' => $hide_card_category,
				'search'             => $search,
			)
		);
	}

	return (string) ob_get_clean();
}

function iec_sp_landing_products_payload( $page, $filters = array(), $post_type = 'product', $args = array() ) {
	$page      = max( 1, (int) $page );
	$post_type = iec_sp_landing_normalize_post_type( $post_type );
	$args      = is_array( $args ) ? $args : array();
	$search    = isset( $args['search'] ) ? iec_sp_landing_sanitize_search( $args['search'] ) : '';
	$query     = iec_sp_landing_get_products( $page, null, $filters, $post_type, $search );

	return array(
		'html'      => iec_sp_landing_render_products_html( $query['posts'], $args ),
		'count'     => count( $query['posts'] ),
		'has_more'  => (bool) $query['has_more'],
		'page'      => (int) $query['page'],
		'total'     => (int) $query['total'],
		'post_type' => $post_type,
	);
}

function iec_sp_landing_ajax_param( $key ) {
	if ( isset( $_GET[ $key ] ) ) {
		return wp_unslash( $_GET[ $key ] );
	}

	if ( isset( $_POST[ $key ] ) ) {
		return wp_unslash( $_POST[ $key ] );
	}

	return null;
}

function iec_sp_landing_ajax_page() {
	$sp_page = iec_sp_landing_ajax_param( 'sp_page' );
	$page    = ( null !== $sp_page && '' !== $sp_page )
		? absint( $sp_page )
		: absint( iec_sp_landing_ajax_param( 'page' ) );

	return max( 1, $page );
}

function iec_sp_landing_ajax_products() {
	$page    = iec_sp_landing_ajax_page();
	$page_id = absint( iec_sp_landing_ajax_param( 'page_id' ) );
	$lang    = sanitize_text_field( (string) ( iec_sp_landing_ajax_param( 'lang' ) ?? '' ) );
	$search  = iec_sp_landing_sanitize_search( iec_sp_landing_ajax_param( 'keyword' ) );
	$filters = iec_sp_landing_normalize_filters( iec_sp_landing_ajax_param( 'ps_filter' ) );

	if ( '' !== $lang && function_exists( 'iec_sanitize_wpml_lang' ) ) {
		$lang = iec_sanitize_wpml_lang( $lang );
	}

	if ( '' !== $lang && has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $lang );
	}

	$post_type = iec_sp_landing_page_field( 'show_solution', $page_id ) ? 'solution' : 'product';
	$category  = iec_sp_landing_product_category( $page_id );
	$filters   = iec_sp_landing_apply_locked_category( $filters, $category );

	wp_send_json_success(
		iec_sp_landing_products_payload(
			$page,
			$filters,
			$post_type,
			array(
				'hide_card_category' => 'satellite-phones' === $category,
				'search'             => $search,
			)
		)
	);
}
add_action( 'wp_ajax_iec_sp_landing_get_products', 'iec_sp_landing_ajax_products' );
add_action( 'wp_ajax_nopriv_iec_sp_landing_get_products', 'iec_sp_landing_ajax_products' );
add_action( 'wp_ajax_iec_sp_landing_load_more', 'iec_sp_landing_ajax_products' );
add_action( 'wp_ajax_nopriv_iec_sp_landing_load_more', 'iec_sp_landing_ajax_products' );
