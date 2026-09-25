<?php
/**
 * VAS landing hero with optional overlay title.
 *
 * @package iec
 *
 * @var array $args { banner: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$banner = $args['banner'] ?? array();
$image  = $banner['image'] ?? null;
$image_id = 0;
$image_url = '';

if ( is_array( $image ) ) {
	$image_id  = (int) ( $image['ID'] ?? $image['id'] ?? 0 );
	$image_url = (string) ( $image['url'] ?? '' );

} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;

} elseif ( is_string( $image ) ) {
	$image_url = trim( $image );
}

if ( $image_id < 1 && '' === $image_url ) {
	$image_url = iec_resolve_media_to_url( $image );
}

if ( $image_id < 1 && $image_url ) {
	$image_id = (int) attachment_url_to_postid( $image_url );
}

$title   = $banner['overlay_title'] ?? '';
$title   = is_string( $title ) ? $title : '';
$caption = $banner['caption'] ?? '';

iec_module(
	'hero-banner',
	array(
		'image_id'      => $image_id,
		'image_url'     => $image_id > 0 ? '' : $image_url,
		'title'         => $title,
		'title_tag'     => ! empty( $caption ) ? 'p' : 'h1',
		'section_class' => 'iec_optisim_hero_banner',
	)
);
