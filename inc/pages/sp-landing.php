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

function iec_sp_landing_product_category( $page_id ) {
    $page_id = (int) $page_id;
    if ( $page_id < 1 || ! function_exists( 'get_field' ) ) {
        return '';
    }

    $raw = get_field( 'product_category', $page_id );
    if ( empty( $raw ) ) {
        return '';
    }

    $values = is_array( $raw ) ? $raw : array( $raw );
    $allowed = iec_sp_landing_product_category_keys();

    foreach ( $values as $value ) {
        $key = sanitize_title_for_query( (string) $value );
        if ( in_array( $key, $allowed, true ) ) {
            return $key;
        }
    }

    return '';
}

function iec_sp_landing_apply_locked_category( $filters, $category ) {
    $filters = is_array( $filters ) ? $filters : array();
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

function iec_sp_landing_ids_for_all_filters( $filter_names, $lang ) {
    global $wpdb;

    if ( $filter_names === array() ) {
        return array();
    }

    $table = $wpdb->prefix . 'custom_ps_filter';

    if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) !== $table ) {
        return null;
    }

    $count        = count( $filter_names );
    $placeholders = implode( ', ', array_fill( 0, $count, '%s' ) );

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT post_id FROM {$table} WHERE lang_code = %s AND filter_value = '1' AND filter_name IN ({$placeholders}) GROUP BY post_id HAVING COUNT(DISTINCT filter_name) = %d",
            array_merge( array( $lang ), $filter_names, array( $count ) )
        )
    );

    if ( ! is_array( $ids ) ) {
        return array();
    }

    return array_values( array_map( 'intval', $ids ) );
}

function iec_sp_landing_filter_post_ids( $filters ) {
    if ( empty( $filters ) ) {
        return null;
    }

    $filter_names = iec_sp_landing_filter_names( $filters );

    if ( $filter_names === array() ) {
        return null;
    }

    $lang = apply_filters( 'wpml_current_language', null );
    $lang = is_string( $lang ) && '' !== $lang ? $lang : 'en';

    $ids = iec_sp_landing_ids_for_all_filters( $filter_names, $lang );

    if ( null === $ids ) {
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

function iec_sp_landing_query_args( $page, $per_page, $filters = array(), $post_type = 'product' ) {
    $post_type = in_array( $post_type, array( 'product', 'solution' ), true ) ? $post_type : 'product';

    $args = array(
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

    $filter_ids = iec_sp_landing_filter_post_ids( $filters );

    if ( is_array( $filter_ids ) ) {
        if ( $filter_ids === array() ) {
            $args['post__in'] = array( 0 );
        } else {
            $args['post__in'] = $filter_ids;
        }
    } elseif ( ! empty( $filters ) ) {
        $args['meta_query'] = iec_sp_landing_filters_meta_query( $filters );
    }

    return $args;
}

function iec_sp_landing_get_products( $page, $per_page = null, $filters = array(), $post_type = 'product' ) {
    $per_page = null !== $per_page ? max( 1, (int) $per_page ) : iec_sp_landing_per_page();
    $page     = max( 1, (int) $page );
    $filters   = is_array( $filters ) ? $filters : array();
    $post_type = in_array( $post_type, array( 'product', 'solution' ), true ) ? $post_type : 'product';

    $query = new WP_Query( iec_sp_landing_query_args( $page, $per_page, $filters, $post_type ) );
    $posts = is_array( $query->posts ) ? $query->posts : array();

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
    $post_type = get_field( 'show_solution', $page_id ) ? 'solution' : 'product';
    $category  = iec_sp_landing_product_category( $page_id );
    $filters   = iec_sp_landing_apply_locked_category( array(), $category );
    $query     = iec_sp_landing_get_products( 1, null, $filters, $post_type );
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
        'is_inner_products'       => $is_inner,
        'hide_application_filter' => $is_inner,
        'hide_card_category'      => 'satellite-phones' === $category,
    );
}

function iec_sp_landing_render_products_html( $posts, $args = array() ) {
    if ( empty( $posts ) || ! is_array( $posts ) ) {
        return '';
    }

    $args = is_array( $args ) ? $args : array();
    $hide_card_category = ! empty( $args['hide_card_category'] );

    ob_start();

    foreach ( $posts as $post ) {
        get_template_part(
            'template-parts/sp-landing/product',
            'card',
            array(
                'post'               => $post,
                'hide_card_category' => $hide_card_category,
            )
        );
    }

    return (string) ob_get_clean();
}

function iec_sp_landing_products_payload( $page, $filters = array(), $post_type = 'product', $args = array() ) {
    $page      = max( 1, (int) $page );
    $post_type = in_array( $post_type, array( 'product', 'solution' ), true ) ? $post_type : 'product';
    $args      = is_array( $args ) ? $args : array();
    $query     = iec_sp_landing_get_products( $page, null, $filters, $post_type );

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

function iec_sp_landing_ajax_products() {

    $sp_page = iec_sp_landing_ajax_param( 'sp_page' );
    $page    = null !== $sp_page && '' !== $sp_page
        ? absint( $sp_page )
        : absint( iec_sp_landing_ajax_param( 'page' ) );
    $page_id = absint( iec_sp_landing_ajax_param( 'page_id' ) );
    $lang    = sanitize_text_field( (string) ( iec_sp_landing_ajax_param( 'lang' ) ?? '' ) );
    if ( '' !== $lang && function_exists( 'iec_sanitize_wpml_lang' ) ) {
        $lang = iec_sanitize_wpml_lang( $lang );
    }

    $filters = array();
    $raw_filters = iec_sp_landing_ajax_param( 'ps_filter' );
    if ( null !== $raw_filters ) {
        $filters = iec_sp_landing_normalize_filters( $raw_filters );
    }

    if ( $page < 1 ) {
        $page = 1;
    }

    if ( '' !== $lang && has_action( 'wpml_switch_language' ) ) {
        do_action( 'wpml_switch_language', $lang );
    }

    $post_type = get_field( 'show_solution', $page_id ) ? 'solution' : 'product';
    $category  = iec_sp_landing_product_category( $page_id );
    $filters   = iec_sp_landing_apply_locked_category( $filters, $category );

    wp_send_json_success(
        iec_sp_landing_products_payload(
            $page,
            $filters,
            $post_type,
            array(
                'hide_card_category' => 'satellite-phones' === $category,
            )
        )
    );
}
add_action( 'wp_ajax_iec_sp_landing_get_products', 'iec_sp_landing_ajax_products' );
add_action( 'wp_ajax_nopriv_iec_sp_landing_get_products', 'iec_sp_landing_ajax_products' );

add_action( 'wp_ajax_iec_sp_landing_load_more', 'iec_sp_landing_ajax_products' );
add_action( 'wp_ajax_nopriv_iec_sp_landing_load_more', 'iec_sp_landing_ajax_products' );
