<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_products' );

if ( empty( $section['enabled'] ) ) {
	return;
}

$related  = ! empty( $section['related_products'] ) && is_array( $section['related_products'] ) ? $section['related_products'] : array();
$products = function_exists( 'iec_module_product_posts' ) ? iec_module_product_posts( $related, 0, 'product' ) : array();

$heading = ! empty( $section['heading'] ) ? $section['heading'] : 'Recommended Products';
$cta     = is_array( $section['cta'] ?? null ) ? $section['cta'] : array();
$has_cta = ! empty( $cta['url'] );

$module_args = array(
	'heading_class' => 'iec_section_heading',
	'min_products'  => 0,
	'post_type'     => 'product',
	'heading_attrs' => 'data-aos="fade-up"',
	'card_attrs'    => 'data-aos="fade-up"',
);

iec_module(
	'products',
	array_merge(
		$module_args,
		array(
			'heading'       => $heading,
			'products'      => $products,
			'show_btn'      => ! $has_cta,
			'block'         => array( 'link' => $has_cta ? $cta : false ),
			'section_class' => 'products iec-offshore-products-section iec-products-section iec-product-solution-section',
		)
	)
);

$second_products = ( ! empty( $section['other_product_section'] ) && ! empty( $section['second_products'] ) && is_array( $section['second_products'] ) )
	? $section['second_products']
	: array();

if ( $second_products === array() ) {
	return;
}

iec_module(
	'products',
	array_merge(
		$module_args,
		array(
			'heading'       => $section['second_heading'] ?? '',
			'products'      => $second_products,
			'show_btn'      => false,
			'block'         => array( 'link' => false ),
			'section_class' => 'products iec-offshore-products-section iec-products-section iec-product-solution-section second-product-section',
		)
	)
);
