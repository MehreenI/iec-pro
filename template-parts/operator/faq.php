<?php
/**
 * Operator — FAQ through the shared FAQ module.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

if (!function_exists('iec_module')) {
    return;
}

$defaults = iec_operator_defaults();

$faq = [];
foreach (iec_flex_rows(get_sub_field('questions_and_answers')) as $item) {
    if (empty($item['question'])) {
        continue;
    }

    $faq[] = [
        'question' => $item['question'],
        'answer' => $item['answer'] ?? '',
    ];
}

if (empty($faq)) {
    $faq = $defaults['questions_and_answers'];
}

$heading = iec_filled(get_sub_field('faq_title'), $defaults['faq_title']);
$style = get_sub_field('faq_style');
$class_name = $style == 1 ? 'p-3 split-content' : 'p-3';

iec_module('faq', [
    'col_class' => 'text-md-center',
    'eyebrow' => __('FAQ', 'iec'),
    'eyebrow_class' => 'iec-eyebrow text-md-center',
    'heading' => $heading,
    'heading_class' => 'text-md-center',
    'content' => get_sub_field('content'),
    'content_class' => 'fixed',
    'faq' => $faq,
    'section_id' => 'faq',
    'section_class' => $class_name,
]);
