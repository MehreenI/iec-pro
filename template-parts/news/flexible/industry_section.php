<?php
/**
 * Flexible: industry slider.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = $args['block'] ?? array();

$heading = $block['heading'] ?? '';
$content = is_string( $block['content'] ?? null ) ? trim( $block['content'] ) : '';
$button  = $block['button'] ?? array();
$rows    = $block['industries'] ?? array();

$slider = array();

foreach ( $rows as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$title = $row['title'] ?? '';
	$image = iec_resolve_media_to_url( $row['image'] ?? null );
	$link  = iec_resolve_wpml_url( $row['link'] ?? '' );
	if ( $title === '' && $image === '' ) {
		continue;
	}
	$slider[] = array(
		'title' => $title,
		'image' => array(
			'url' => $image,
		),
		'link'  => $link !== '' ? $link : '#',
	);
}

if ( $heading === '' && $content === '' && empty( $slider ) ) {
	return;
}

get_template_part(
	'template-parts/modules/vertical-market-slider',
	null,
	array(
		'heading'              => $heading,
		'content'              => $content,
		'button_url'           => $button['url'] ?? '',
		'button_title'         => $button['title'] ?? 'Learn More',
		'slider'               => $slider,
		'id'                   => 'iec-insights-industry-' . wp_unique_id(),
		'button_id'            => '',
		'section_class'        => 'iec_single_news_main_section iec-single-news-industry-section',
		'content_class'        => 'wysiwyg-content',
		'use_heading_section'  => true,
	)
);
