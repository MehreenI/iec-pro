<?php
/**
 * Insights flexible content blocks loop.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blocks = $args['blocks'] ?? array();

if ( ! is_array( $blocks ) || empty( $blocks ) ) {
	return;
}

foreach ( $blocks as $block ) {
	if ( ! is_array( $block ) || empty( $block['acf_fc_layout'] ) ) {
		continue;
	}

	iec_news_render_flexible_section( (string) $block['acf_fc_layout'], $block );
}
