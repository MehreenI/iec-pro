<?php
/**
 * Flexible: image_with_text
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = $args['block'] ?? array();

$desktop_image = iec_resolve_media_to_url( $block['image'] ?? null );
if ( ! $desktop_image ) {
	return;
}

$mobile_image = iec_resolve_media_to_url( $block['image_mobile'] ?? null );
if ( ! $mobile_image ) {
	$mobile_image = $desktop_image;
}

$reverse_raw = $block['reverse'] ?? null;
if ( is_array( $reverse_raw ) ) {
	$is_reverse = in_array( 'yes', $reverse_raw, true ) || in_array( 'true', $reverse_raw, true );
} elseif ( is_string( $reverse_raw ) ) {
	$is_reverse = in_array( strtolower( $reverse_raw ), array( 'yes', 'true', '1' ), true );
} else {
	$is_reverse = (bool) $reverse_raw;
}

$link = array();
if ( ! empty( $block['url'] ) ) {
	$link = array(
		'url'   => $block['url'],
		'title' => ! empty( $block['button_text'] ) ? $block['button_text'] : __( 'Learn More', 'bbtheme' ),
	);
}

iec_module(
	'image-text-list',
	array(
		'reverse'       => ! $is_reverse,
		'desktop_image' => $desktop_image,
		'mobile_image'  => $mobile_image,
		'desktop_class' => 'text_white',
		'heading'       => $block['title'] ?? '',
		'subheading'    => $block['subtitle'] ?? '',
		'items'         => $block['items'] ?? array(),
		'link'          => $link,
	)
);
