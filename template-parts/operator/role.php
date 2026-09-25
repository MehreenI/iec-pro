<?php
/**
 * Operator — what Starlink is and IEC's role.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['role'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$button = iec_link_parts(get_sub_field('button'), $defaults['button']);
$logo = iec_image_tag(get_sub_field('logo'), $defaults['logo_default'], '', false);
$positions = ['top', 'left', 'right', 'bottom'];
$points = array_slice(iec_rows_or_defaults(get_sub_field('points'), $defaults['points']), 0, 4);
?>

<section class="iec_defualt_position p-3" id="role" aria-labelledby="role-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="iec_content_box">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="role-heading" class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2 text-md-center"><?= $content; ?></div>
                    <?php if ($button['url']): ?>
                        <nav class="navigation-buttons">
                            <a href="<?= $button['url']; ?>" class="btn secondary-btn"<?= $button['target']; ?>><?= $button['title']; ?></a>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="iec_image_wrapper" aria-label="<?= __('IEC Telecom Starlink role', 'iec'); ?>">
                    <span aria-hidden="true"></span>
                    <div>
                        <?= $logo; ?>
                    </div>
                    <?php foreach ($points as $index => $point): ?>
                        <div data-position="<?= $positions[$index]; ?>">
                            <div aria-hidden="true">
                                <?= $point['icon'] ?>
                            </div>
                            <h3 class="iec-secondary-heading"><?= $point['title'] ?? ''; ?></h3>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
