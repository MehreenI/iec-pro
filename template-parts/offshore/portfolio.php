<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_portfolio' );

if ( empty( $section['enabled'] ) ) {
	return;
}

if ( empty( $section['verticals'] ) && empty( $section['heading'] ) && empty( $section['description'] ) ) {
	return;
}

$cta = $section['cta'] ?? array();

get_template_part(
	'template-parts/modules/vertical-market-slider',
	null,
	array(
		'heading'       => $section['heading'] ?? '',
		'heading_class' => 'iec_section_heading',
		'content'       => $section['description'] ?? '',
		'button_url'    => $cta['url'] ?? '',
		'button_title'  => ! empty( $cta['title'] ) ? $cta['title'] : 'Learn More',
		'slider'        => $section['verticals'] ?? array(),
		'id'            => 'maritime',
		'button_id'     => 'iecEnquiryModalTrigger',
		'section_class' => 'iec-offshore-portfolio-section',
		'heading_attrs' => 'data-aos="fade-up"',
		'content_attrs' => 'data-aos="fade-up" data-aos-delay="100"',
		'cta_attrs'     => 'data-aos="fade-up" data-aos-delay="150"',
		'slider_attrs'  => 'data-aos="fade-up" data-aos-delay="200"',
	)
);
