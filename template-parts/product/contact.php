<?php
/**
 * Single product — contact / enquiry form.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form_heading = $args['form_heading'] ?? __( 'Enquiry Now', 'bbtheme' );

iec_module(
	'contact-form',
	array(
		'form_heading' => $form_heading,
		'form_type'    => 'product-enquiry',
	)
);
