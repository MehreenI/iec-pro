<?php
/**
 * Operator — connectivity flow step cards.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['how_it_works'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$steps = iec_rows_or_defaults(get_sub_field('steps'), $defaults['steps']);
?>

<section class="iec_defualt_position p-3 how-it-work" id="how-it-works" aria-labelledby="how-it-works-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="how-it-works-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>

                    <div class="wysiwyg-content mb-2 text-md-center" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>

        <?php if ($steps): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_flow_steps grid-4" data-flow data-delay="150">
                        <?php foreach ($steps as $index => $step): ?>
                            <article class="iec_flow_step" data-flow-step>
                                <span class="iec_flow_step_number"><?= sprintf('%02d', $index + 1); ?></span>

                                <span class="iec_flow_step_icon" aria-hidden="true">
                                    <?= iec_icon_tag($step['icon'] ?? null, $step['icon_svg'] ?? ''); ?>
                                </span>

                                <h3 class="iec-heading"><?= $step['title'] ?? ''; ?></h3>

                                <div class="wysiwyg-content">
                                    <p class="card_iec_text"><?= $step['text'] ?? ''; ?></p>
                                </div>

                                <?php if ($index < count($steps) - 1): ?>
                                    <span class="iec_flow_arrow" aria-hidden="true">
                                        <svg viewBox="0 0 32 12" fill="none" data-flow-arrow><path class="iec_flow_arrow_line" d="M1 6h26" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="m23 1.8 5 4.2-5 4.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
