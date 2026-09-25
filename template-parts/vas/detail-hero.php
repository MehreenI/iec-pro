<?php
/**
 * VAS detail hero with back link.
 *
 * @package iec
 *
 * @var array $args { banner: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$banner   = $args['banner'] ?? array();
$image    = $banner['image'] ?? array();
$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];

} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

iec_module(
	'hero-banner',
	array(
		'image_id'       => $image_id,
		'show_back_link' => true,
		'section_class'  => 'iec_optisim_hero_banner',
	)
);
