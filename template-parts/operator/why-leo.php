<?php
/**
 * Operator — Starlink LEO versus traditional GEO, and the recommended approach.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['why_leo'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$one_title = iec_filled(get_sub_field('column_one_title'), $defaults['column_one_title']);
$one_text = iec_filled(get_sub_field('column_one_text'), $defaults['column_one_text']);
$two_title = iec_filled(get_sub_field('column_two_title'), $defaults['column_two_title']);
$two_text = iec_filled(get_sub_field('column_two_text'), $defaults['column_two_text']);
$rows = iec_rows_or_defaults(get_sub_field('rows'), $defaults['rows']);
$approach_eyebrow = iec_filled(get_sub_field('approach_eyebrow'), $defaults['approach_eyebrow']);
$approach_heading = iec_filled(get_sub_field('approach_heading'), $defaults['approach_heading']);
$approach_content = iec_filled(get_sub_field('approach_content'), $defaults['approach_content']);
$approach_items = iec_rows_or_defaults(get_sub_field('approach_items'), $defaults['approach_items']);
?>

<section class="iec_defualt_position p-3" id="why-leo" aria-labelledby="why-leo-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="why-leo-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>
        <?php if ($rows): ?>
            <div class="row">
                <div class="col-md-12">
                    <div role="table" aria-label="<?= wp_strip_all_tags($one_title . ' ' . __('versus', 'iec') . ' ' . $two_title); ?>">
                        <div role="row">
                            <div role="columnheader"></div>
                            <div role="columnheader">
                                <strong><?= $one_title; ?></strong>
                                <span><?= $one_text; ?></span>
                            </div>
                            <div role="columnheader">
                                <strong><?= $two_title; ?></strong>
                                <span><?= $two_text; ?></span>
                            </div>
                        </div>
                        <?php foreach ($rows as $row): ?>
                            <div role="row">
                                <div role="rowheader"><?= $row['label'] ?? ''; ?></div>
                                <div role="cell" data-col="<?= wp_strip_all_tags($one_title); ?>"><?= $row['column_one'] ?? ''; ?></div>
                                <div role="cell" data-col="<?= wp_strip_all_tags($two_title); ?>"><?= $row['column_two'] ?? ''; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row iec-recommended-approach">
            <div class="col-md-6">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $approach_eyebrow; ?></span>
                    <h3 id="recommended-heading" class="iec-secondary-heading text-md-center"><?= $approach_heading; ?></h3>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $approach_content; ?></div>
                </div>
            </div>
            <?php if ($approach_items): ?>
                <div class="col-md-6">
                    <div>
                        <?php foreach ($approach_items as $item): ?>
                            <div>
                                <strong><?= $item['label'] ?? ''; ?></strong>
                                <span><?= $item['text'] ?? ''; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
