<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blocks = $args['blocks'] ?? array();
if ( ! is_array( $blocks ) || ! $blocks ) {
	return;
}

foreach ( $blocks as $block ) {
	if ( ! is_array( $block ) || empty( $block['acf_fc_layout'] ) ) {
		continue;
	}

	$layout = $block['acf_fc_layout'];

	if ( 'spacer' === $layout ) {
		$space = $block['space'] ?? 0;
		if ( $space > 0 ) {
			echo '<div style="margin-top: ' . esc_attr( (string) $space ) . 'px" aria-hidden="true"></div>';
		}
		continue;
	}

	if ( 'image_with_text' === $layout ) {
		$desktop_image = iec_resolve_media_to_url( $block['image'] ?? null );
		if ( ! $desktop_image ) {
			continue;
		}
		$mobile_image = iec_resolve_media_to_url( $block['image_mobile'] ?? null );
		if ( ! $mobile_image ) {
			$mobile_image = $desktop_image;
		}
		$reverse_raw = $block['reverse'] ?? array();
		iec_module(
			'image-text-list',
			array(
				'reverse'       => is_array( $reverse_raw ) && in_array( 'yes', $reverse_raw, true ),
				'desktop_image' => $desktop_image,
				'mobile_image'  => $mobile_image,
				'desktop_class' => ( 'font_blue' === ( $block['section_text_color'] ?? '' ) ) ? 'text_blue' : 'text_white',
				'top_space'     => $block['top_space'] ?? '0px',
				'bottom_space'  => $block['bottom_space'] ?? '0px',
				'heading'       => $block['title'] ?? '',
				'subheading'    => $block['subtitle'] ?? '',
				'items'         => $block['items'] ?? array(),
				'link'          => $block['link'] ?? '',
			)
		);
		continue;
	}

	if ( 'add_solution' === $layout && ! empty( $block['add_solutions'] ) ) {
		iec_module( 'solutions-grid', array( 'block' => $block ) );
		continue;
	}

	if ( 'products' === $layout && ! empty( $block['product_section'] ) ) {
		iec_module(
			'products',
			array(
				'heading'       => $block['section_heading'] ?? '',
				'products'      => $block['product_section'],
				'block'         => $block,
				'layout'        => 'office',
				'show_btn'      => true,
				'section_class' => 'iec_products_posts_sec iec_defualt_position',
			)
		);
	}
}
