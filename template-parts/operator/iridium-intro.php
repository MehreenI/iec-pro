<?php
/**
 * Operator — network intro with a numbered list beside it.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['iridium_intro'];
$points = iec_rows_or_defaults(get_sub_field('points'), $defaults['points']);
$class= get_sub_field('background');
?>

<section class="iec_defualt_position iec_starlink_connectivity_section <?= $class ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="iec_starlink_connectivity_content">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>

                    <h2 class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>

                    <div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100"><?= iec_filled(get_sub_field('content'), $defaults['content']); ?></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="iec_starlink_connectivity_box" data-fade="up" data-delay="150">
                    <h3><?= iec_filled(get_sub_field('box_heading'), $defaults['box_heading']); ?></h3>

                    <?php if ($points): ?>
                        <ol class="iec_starlink_number_list">
                            <?php foreach ($points as $point): ?>
                                <li><?= $point['text'] ?? ''; ?></li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
