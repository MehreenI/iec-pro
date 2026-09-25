<?php
/**
 * Operator — Beyond Connectivity managed services.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['managed'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$services = iec_rows_or_defaults(get_sub_field('services'), $defaults['services']);
?>

<section class="iec-manage-services p-3" id="managed" aria-labelledby="managed-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="managed-heading" class="iec-section-heading text-white text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>
        <?php if ($services): ?>
            <div class="grid-3">
                <?php foreach ($services as $service): ?>
                    <article>
                        <span aria-hidden="true"><?= $service['badge'] ?? ''; ?></span>
                        <h3 class="iec-heading text-white"><?= $service['title'] ?? ''; ?></h3>
                        <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100">
                            <p class="card_iec_text"><?= $service['text'] ?? ''; ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
