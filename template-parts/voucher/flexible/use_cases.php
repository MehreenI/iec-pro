<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'heading' ) ?: __( 'USE CASES', 'bbtheme' );
$items   = get_sub_field( 'use_cases_copy' ) ?: array();

if ( empty( $items ) ) {
	return;
}

get_template_part(
	'template-parts/modules/use-case-slider',
	null,
	array(
		'items'         => $items,
		'heading'       => $heading,
		'heading_class' => 'directions__main iec_section_heading',
	)
);
