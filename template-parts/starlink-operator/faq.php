<?php
/**
 * Starlink Operator — FAQ from page ACF (questions_and_answers).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$raw    = isset( $fields['questions_and_answers'] ) && is_array( $fields['questions_and_answers'] )
	? $fields['questions_and_answers']
	: array();

if ( empty( $raw ) ) {
	return;
}

$faq = array();
foreach ( $raw as $item ) {
	if ( empty( $item['question'] ) ) {
		continue;
	}
	$faq[] = array(
		'question' => $item['question'],
		'answer'   => $item['answer'] ?? '',
	);
}

if ( empty( $faq ) ) {
	return;
}

$heading = ! empty( $fields['faq_title'] ) ? (string) $fields['faq_title'] : 'Everything You Need to Know';

if ( function_exists( 'iec_module' ) ) {
	iec_module(
		'faq',
		array(
			'eyebrow'       => 'FAQ',
			'heading'       => $heading,
			'faq'           => $faq,
			'section_id'    => 'faq',
			'section_class' => 'slo-faq-section',
		)
	);
}
