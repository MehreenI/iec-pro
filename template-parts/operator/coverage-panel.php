<?php
/**
 * Operator — coverage copy with a map panel beside it.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['coverage_panel'];
$boxes = iec_rows_or_defaults(get_sub_field('boxes'), $defaults['boxes']);
$facts = iec_rows_or_defaults(get_sub_field('facts'), $defaults['facts']);
$button = iec_link_parts(get_sub_field('button'), $defaults['button']);
$image = iec_image_tag(get_sub_field('image'), $defaults['image_default'], 'iec_img_style');
?>

<section class="iec_defualt_position iec_starlink_inmarsat_coverage_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="iec_starlink_inmarsat_coverage_content">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>

                    <h2 class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>

                    <div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100"><?= iec_filled(get_sub_field('content'), $defaults['content']); ?></div>

                    <?php if ($boxes): ?>
                        <div class="iec_starlink_inmarsat_coverage_content_box_grid" data-fade="up" data-delay="150" data-stagger=".iec_starlink_inmarsat_coverage_content_box">
                            <?php foreach ($boxes as $box): ?>
                                <div class="iec_starlink_inmarsat_coverage_content_box">
                                    <h3><?= $box['title'] ?? ''; ?></h3>

                                    <p class="card_iec_text"><?= $box['text'] ?? ''; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($button['url']): ?>
                        <a class="btn secondary-btn" href="<?= $button['url']; ?>"<?= $button['target']; ?>><?= $button['title']; ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-7">
                <div class="iec_starlink_inmarsat_coverage_right_box" data-fade="up" data-delay="200">
                    <?php if ($image): ?>
                        <div class="iec_starlink_inmarsat_coverage_right_box_image"><?= $image; ?></div>
                    <?php endif; ?>

                    <?php if ($facts): ?>
                        <ul>
                            <?php foreach ($facts as $fact): ?>
                                <li>
                                    <strong><?= $fact['label'] ?? ''; ?></strong>

                                    <span><?= $fact['value'] ?? ''; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="iec_starlink_inmarsat_coverage_disclaimer_box">
                        <p><strong><?= iec_filled(get_sub_field('note_heading'), $defaults['note_heading']); ?></strong></p>

                        <p class="card_iec_text"><?= iec_filled(get_sub_field('note_content'), $defaults['note_content']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
