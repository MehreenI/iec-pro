<?php
/**
 * Market detail needs accordion — delegates to shared module.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

iec_module(
	'accordion',
	array(
		'items'  => $args['needs'] ?? array(),
		'type'   => 'toggle',
		'layout' => 'columns',
	)
);
