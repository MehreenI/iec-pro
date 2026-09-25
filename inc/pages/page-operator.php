<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'iec_filled' ) ) {
	function iec_filled( $value, $fallback = '' ) {
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			return $value;
		}
		if ( is_array( $value ) && ! empty( $value ) ) {
			return $value;
		}
		return $fallback;
	}
}

if ( ! function_exists( 'iec_link_parts' ) ) {
	function iec_link_parts( $link, $fallback = array() ) {
		$link     = is_array( $link ) ? $link : array();
		$fallback = is_array( $fallback ) ? $fallback : array();
		$url      = (string) ( $link['url'] ?? $fallback['url'] ?? '#' );
		$title    = (string) ( $link['title'] ?? $fallback['title'] ?? '' );
		$target   = (string) ( $link['target'] ?? $fallback['target'] ?? '' );

		return array(
			'url'    => $url,
			'title'  => $title,
			'target' => $target ? ' target="' . esc_attr( $target ) . '"' : '',
		);
	}
}

if ( ! function_exists( 'iec_rows_or_defaults' ) ) {
	function iec_rows_or_defaults( $rows, $defaults = array() ) {
		$rows = is_array( $rows ) ? $rows : array();
		return $rows ? $rows : ( is_array( $defaults ) ? $defaults : array() );
	}
}

if ( ! function_exists( 'iec_flex_rows' ) ) {
	function iec_flex_rows( $rows ) {
		return is_array( $rows ) ? $rows : array();
	}
}

if ( ! function_exists( 'iec_section_hidden' ) ) {
	function iec_section_hidden( $section ) {
		return is_array( $section ) && array_key_exists( 'show_section', $section ) && ! $section['show_section'];
	}
}

if ( ! function_exists( 'iec_image_tag' ) ) {
	function iec_image_tag( $image, $fallback = array() ) {
		$url = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $image ) : '';
		if ( ! $url && is_array( $fallback ) ) {
			$url = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $fallback ) : '';
		}
		if ( ! $url ) {
			return '';
		}
		return '<img src="' . esc_url( $url ) . '" alt="" loading="lazy" decoding="async">';
	}
}

if ( ! function_exists( 'iec_operator_defaults' ) ) {
	function iec_operator_defaults() {
		$link    = array(
			'url'    => '#',
			'title'  => '',
			'target' => '',
		);
		$section = array(
			'eyebrow'               => '',
			'heading'               => '',
			'intro'                 => '',
			'content'               => '',
			'button'                => $link,
			'cards'                 => array(),
			'sections'              => array(),
			'status_heading'        => '',
			'note_heading'          => '',
			'note_content'          => '',
			'note_primary_button'   => $link,
			'note_secondary_button' => $link,
			'image_default'         => '',
			'overlay_title'         => '',
			'sub_heading'           => '',
			'primary_button'        => $link,
			'secondary_button'      => $link,
			'stats'                 => array(),
			'boxes'                 => array(),
			'stats_style'           => 'compact',
		);

		return array(
			'contact_style'  => '',
			'page_sections'  => array(),
			'banner'         => $section,
			'how_it_works'   => $section,
			'why_iec'        => $section,
			'solutions'      => $section,
			'iridium_intro'  => $section,
			'buying_guide'   => $section,
			'fits_grid'      => $section,
			'why_leo'        => $section,
			'coverage'       => $section,
			'cta'            => $section,
			'coverage_panel' => $section,
			'patterns'       => array( 'sections' => array( $section ) ),
			'country_guides' => $section,
			'role'           => $section,
			'availability'   => $section,
			'service_finder' => $section,
			'managed'        => $section,
			'faq'            => $section,
		);
	}
}

if ( ! function_exists( 'iec_market_landing_defaults' ) ) {
	function iec_market_landing_defaults() {
		$section = array(
			'heading'            => '',
			'sub_heading'        => '',
			'eyebrow'            => '',
			'video_file_default' => '',
			'show_section'       => true,
		);

		return array(
			'hero'                     => $section,
			'industry_types'           => $section,
			'specialized_connectivity' => $section,
			'land_industries'          => $section,
			'maritime_industries'      => $section,
			'global_coverage'          => $section,
			'video'                    => $section,
			'our_solutions'            => $section,
			'faq'                      => $section,
		);
	}
}
