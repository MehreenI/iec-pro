<?php
/**
 * Operator — why IEC Telecom, four numbered steps.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['why_iec'];
$steps = iec_rows_or_defaults(get_sub_field('steps'), $defaults['steps']);
$dark = 'dark' === iec_filled(get_sub_field('background'), $defaults['background']);
?>

<section class="iec_defualt_position iec_starlink_why<?= $dark ? ' is-dark' : ''; ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="iec_starlink_why_content">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>

                    <h2 class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>

                    <div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100"><?= iec_filled(get_sub_field('content'), $defaults['content']); ?></div>
                </div>
            </div>

            <?php if ($steps): ?>
                <div class="col-md-7">
                    <div class="iec_starlink_why_box_grid" data-fade="up" data-delay="150" data-stagger=".iec_starlink_why_box">
                        <?php foreach ($steps as $step): ?>
                            <div class="iec_starlink_why_box">
                                <div class="iec_starlink_why_box_label"><?= $step['label'] ?? ''; ?></div>

                                <h3><?= $step['title'] ?? ''; ?></h3>

                                <p class="card_iec_text"><?= $step['text'] ?? ''; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
