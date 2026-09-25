<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $args['show_faq'] ) ) {
	return;
}

iec_module(
	'faq',
	array(
		'heading'       => 'Frequently asked questions',
		'faq'           => $args['faq'] ?? array(),
		'section_class' => 'iec-offshore-faq-section',
		'heading_attrs' => 'data-aos="fade-up"',
		'item_attrs'    => 'data-aos="fade-up"',
	)
);
