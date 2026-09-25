<?php
/**
 * Market Landing — FAQ through the shared FAQ module.
 *
 * Args: section (ACF group `faq`: show_section, eyebrow, heading, items[question, answer]).
 * Empty fields fall back to iec_market_landing_defaults().
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$section = is_array($args['section'] ?? null) ? $args['section'] : [];

if (iec_section_hidden($section)) {
    return;
}

$defaults = iec_market_landing_defaults()['faq'];
$items = array_values(array_filter(iec_rows_or_defaults($section['items'] ?? [], $defaults['items']), function ($item) {
    return !empty($item['question']);
}));

if (!$items) {
    return;
}

iec_module('faq', [
    'col_class' => 'text-md-center',
    'eyebrow' => iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']),
    'heading' => iec_filled($section['heading'] ?? '', $defaults['heading']),
    'faq' => $items,
]);
