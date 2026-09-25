<?php
/**
 * Offshore — FAQ accordion.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faq = array(
	'heading' => 'Frequently asked questions',
	'fqas'    => get_field( 'faqs' ),
);

if ( get_field( 'show_faq' ) ) :
	iec_module(
		'faq',
		array(
			'heading' => $faq['heading'],
			'faq'     => $faq['fqas'],
		)
	);
endif;
