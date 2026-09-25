<?php
/**
 * Operator — buying guide table.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['buying_guide'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$question_label = iec_filled(get_sub_field('question_label'), $defaults['question_label']);
$condition_label = iec_filled(get_sub_field('condition_label'), $defaults['condition_label']);
$recommendation_label = iec_filled(get_sub_field('recommendation_label'), $defaults['recommendation_label']);
$column = function (string $label) {
    return ucfirst(trim(str_replace('…', '', wp_strip_all_tags($label))));
};
$rows = iec_rows_or_defaults(get_sub_field('rows'), $defaults['rows']);
$button = iec_link_parts(get_sub_field('button'), $defaults['button']);
?>

<section class="iec-buying-guide p-3" id="buying-guide" aria-labelledby="buying-guide-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="buying-guide-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>
        <?php if ($rows): ?>
            <div class="row">
                <div class="col-md-12">
                    <div role="table" aria-label="<?= wp_strip_all_tags($heading); ?>">
                        <div role="row">
                            <div role="columnheader"><?= $question_label; ?></div>
                            <div role="columnheader"><?= $condition_label; ?></div>
                            <div role="columnheader"><?= $recommendation_label; ?></div>
                        </div>
                        <?php foreach ($rows as $row): ?>
                            <div role="row">
                                <div role="rowheader"><?= $row['question'] ?? ''; ?></div>
                                <div role="cell" data-col="<?= $column($condition_label); ?>"><?= $row['condition'] ?? ''; ?></div>
                                <div role="cell" data-col="<?= $column($recommendation_label); ?>"><strong><?= $row['recommendation'] ?? ''; ?></strong></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($button['url']): ?>
            <div class="row">
                <div class="col-md-12">
                    <nav class="navigation-buttons justify-content-end">
                        <a class="btn secondary-btn" href="<?= $button['url']; ?>"<?= $button['target']; ?>><?= $button['title']; ?></a>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
