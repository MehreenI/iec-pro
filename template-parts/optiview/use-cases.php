<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$items  = $fields['use_cases'] ?? array();

if ( empty( $items ) ) {
	return;
}

get_template_part(
	'template-parts/modules/use-case-slider',
	null,
	array(
		'items'   => $items,
		'heading' => __( 'USE CASES', 'bbtheme' ),
		'attr'    => 'data-optiview-use-cases',
	)
);
