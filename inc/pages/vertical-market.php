<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'iec_vertical_market_page_market' ) ) {

    function iec_vertical_market_page_market() {
        static $market = null;

        if ( null !== $market ) {
            return $market;
        }

        $market = array(
            'key'   => 'offshore',
            'label' => 'Offshore',
        );

        $post = get_queried_object();

        if ( ! $post instanceof WP_Post ) {
            return $market;
        }

        $page_slug  = sanitize_title( $post->post_name );
        $page_title = sanitize_title( $post->post_title );
        $choices    = iec_ps_filter_items( 'market' );

        if ( empty( $choices['choices'] ) || ! is_array( $choices['choices'] ) ) {
            return $market;
        }

        foreach ( $choices['choices'] as $choice ) {
            $key = isset( $choice['key'] ) ? (string) $choice['key'] : '';

            if ( $key === '' ) {
                continue;
            }

            $match_slug = $page_slug === $key || str_contains( $page_slug, $key );

            if ( ! $match_slug ) {
                $match_slug = $page_title === $key || str_contains( $page_title, $key );
            }

            if ( $match_slug ) {
                $market = array(
                    'key'   => $key,
                    'label' => ucfirst( $key ),
                );
                break;
            }
        }

        return $market;
    }
}

if ( ! function_exists( 'iec_vertical_market_product_ids' ) ) {

    function iec_vertical_market_product_ids( $market_key, $market_label ) {
        global $wpdb;

        $table = $wpdb->prefix . 'custom_ps_filter';

        if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) !== $table ) {
            return array();
        }

        $lang = apply_filters( 'wpml_current_language', null );
        $lang = is_string( $lang ) && $lang !== '' ? $lang : 'en';

        $filter_names = array(
            'market_' . $market_key,
        );

        if ( $market_label !== '' && 'market_' . sanitize_title_for_query( $market_label ) !== 'market_' . $market_key ) {
            $filter_names[] = 'market_' . sanitize_title_for_query( $market_label );
        }

        if ( $market_label !== '' && 'market_' . $market_label !== $filter_names[0] ) {
            $filter_names[] = 'market_' . $market_label;
        }

        $filter_names = array_values( array_unique( array_filter( $filter_names ) ) );
        $placeholders = implode( ', ', array_fill( 0, count( $filter_names ), '%s' ) );

        $ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT post_id FROM {$table} WHERE lang_code = %s AND filter_name IN ({$placeholders}) AND filter_value = '1'",
                array_merge( array( $lang ), $filter_names )
            )
        );

        if ( ! is_array( $ids ) || $ids === array() ) {
            return array();
        }

        return array_values( array_map( 'intval', $ids ) );
    }
}

if ( ! function_exists( 'iec_vertical_market_product_posts' ) ) {

    function iec_vertical_market_product_posts() {
        $config = get_field( 'offshore_products' );

        if ( ! is_array( $config ) ) {
            $config = array();
        }

        $limit  = ! empty( $config['limit'] ) ? max( 1, min( 24, (int) $config['limit'] ) ) : 8;
        $manual = ! empty( $config['related_products'] ) && is_array( $config['related_products'] ) ? $config['related_products'] : array();

        if ( $manual !== array() ) {
            $posts = array();

            foreach ( $manual as $item ) {
                $post_id = is_object( $item ) ? (int) $item->ID : (int) $item;

                if ( $post_id < 1 || 'publish' !== get_post_status( $post_id ) ) {
                    continue;
                }

                $post = get_post( $post_id );

                if ( $post instanceof WP_Post ) {
                    $posts[] = $post;
                }
            }

            if ( $posts !== array() ) {
                return array_slice( $posts, 0, $limit );
            }
        }

        $market     = iec_vertical_market_page_market();
        $market_key = $market['key'];
        $meta_keys  = array( $market_key );

        if ( ! empty( $market['label'] ) && $market['label'] !== $market_key ) {
            $meta_keys[] = $market['label'];
        }

        $query_args = array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => $limit,
            'orderby'                => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
            'no_found_rows'          => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => true,
        );

        $market_ids = iec_vertical_market_product_ids( $market_key, $market['label'] ?? '' );

        if ( $market_ids !== array() ) {
            $query_args['post__in'] = $market_ids;
        } else {
            $meta_query = array( 'relation' => 'OR' );

            foreach ( array_unique( $meta_keys ) as $meta_key ) {
                $meta_query[] = array(
                    'key'     => 'ps_filter_market',
                    'value'   => '"' . $meta_key . '"',
                    'compare' => 'LIKE',
                );
            }

            $query_args['meta_query'] = $meta_query;
        }

        $query = new WP_Query( $query_args );
        $posts = $query->posts;
        wp_reset_postdata();

        return is_array( $posts ) ? $posts : array();
    }
}

if ( ! function_exists( 'iec_offshore_product_posts' ) ) {

    function iec_offshore_product_posts() {
        return iec_vertical_market_product_posts();
    }
}
