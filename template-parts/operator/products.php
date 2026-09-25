<?php
/**
 * Operator — featured Starlink products (live CPT).
 *
 * Args: fields (ACF group `products`: heading). Empty heading falls back to the built-in one.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$section = is_array($args['fields']['products'] ?? null) ? $args['fields']['products'] : [];

iec_module('products', [
    'heading' => iec_filled($section['heading'] ?? '', __('Starlink Products', 'iec')),
    'query' => new WP_Query([
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
        'meta_query' => [
            [
                'key' => 'ps_filter_operator',
                'value' => 'Starlink',
                'compare' => 'LIKE',
            ],
            [
                'key' => 'ps_filter_type',
                'value' => '"product"',
                'compare' => 'LIKE',
            ],
        ],
    ]),
]);
