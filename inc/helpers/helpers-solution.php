<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_solution_single_context( array $fields ): array {
	$product_images  = is_array( $fields['product_images'] ?? null ) ? $fields['product_images'] : array();
	$coverage_images = is_array( $fields['coverage_images'] ?? null ) ? $fields['coverage_images'] : array();
	$key_points      = is_array( $fields['key_points'] ?? null ) ? $fields['key_points'] : array();
	$banner          = is_array( $fields['banner'] ?? null ) ? $fields['banner'] : array();
	$custom_button   = is_array( $fields['custom_button'] ?? null ) ? $fields['custom_button'] : array();
	$brochure        = is_array( $fields['brochure'] ?? null ) ? $fields['brochure'] : array();
	$section_boxes   = is_array( $fields['section_boxes'] ?? null ) ? $fields['section_boxes'] : array();
	$video_section   = is_array( $fields['video_section'] ?? null ) ? $fields['video_section'] : array();
	$tabs_section    = is_array( $fields['tabs_section'] ?? null ) ? $fields['tabs_section'] : array();
	$recommended     = is_array( $fields['recommended_solutions'] ?? null ) ? $fields['recommended_solutions'] : array();

	$iec_ps_page      = get_config( 'iec_ps_page' );
	$iec_enquire_page = get_config( 'iec_enquire_page' );

	return array(
		'fields'                  => $fields,
		'product_images'          => $product_images,
		'coverage_images'         => $coverage_images,
		'total_product_image'     => count( $product_images ),
		'total_cover_image'       => count( $coverage_images ),
		'caption'                 => $fields['caption'] ?? '',
		'content'                 => $fields['content'] ?? '',
		'interest'                => $fields['interest'] ?? '',
		'key_points'              => $key_points,
		'banner'                  => $banner,
		'custom_button'           => $custom_button,
		'brochure'                => $brochure,
		'section_form'            => ! empty( $fields['section_form'] ),
		'section_boxes'           => $section_boxes,
		'video_section'           => $video_section,
		'tabs_section'            => $tabs_section,
		'recommended_solutions'   => $recommended,
		'ps_page_link'            => $iec_ps_page ? get_permalink( $iec_ps_page ) : home_url(),
		'enquire_link'            => $iec_enquire_page ? get_permalink( $iec_enquire_page ) : home_url(),
		'current_page_id'         => get_the_ID(),
		'has_banner'              => ! empty( $banner['image']['url'] ),
		'has_boxes'               => ! empty( $section_boxes['boxes_block'] ),
		'has_video'               => ! empty( $video_section['video_preview']['url'] ),
		'has_tabs'                => ! empty( $tabs_section['tabs'] ),
		'has_recommended'         => ! empty( $recommended ),
	);
}
