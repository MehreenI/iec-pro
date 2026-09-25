<?php
/**
 * Market Landing — land / maritime type cards linking to the sections below.
 *
 * Args: section (ACF group `industry_types`: show_section, cards[image, icon, label, title, description, link_label, anchor]).
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

$cards = iec_rows_or_defaults($section['cards'] ?? [], iec_market_landing_defaults()['industry_types']['cards']);

if (!$cards) {
    return;
}
?>

<section class="iec-industry-types pos-rel">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="grid-2">
                    <?php foreach ($cards as $card): ?>
                        <?php $anchor = sanitize_title((string) ($card['anchor'] ?? '')); ?>
                        <a href="#<?= $anchor; ?>" class="iec-industry-type-card iec_h_100">
                            <div class="iec-industry-type-image">
                                <?= iec_image_tag($card['image'] ?? null, $card['image_default'] ?? [], 'iec_img_style'); ?>
                            </div>
                            <div class="iec-industry-type-overlay"></div>
                            <div class="iec-industry-type-content">
                                <div class="iec-industry-type-icon">
                                    <?= iec_icon_tag($card['icon'] ?? null, $card['icon_svg'] ?? ''); ?>
                                </div>

                                <?php if (!empty($card['label'])): ?>
                                    <span class="iec-industry-type-label font-segoe"><?= $card['label']; ?></span>
                                <?php endif; ?>

                                <?php if (!empty($card['title'])): ?>
                                    <h2 class="text-white"><?= $card['title']; ?></h2>
                                <?php endif; ?>

                                <?php if (!empty($card['description'])): ?>
                                    <div class="wysiwyg-content">
                                        <p class="text-white"><?= $card['description']; ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($card['link_label'])): ?>
                                    <span class="iec-industry-type-link text-white">
                                        <?= $card['link_label']; ?>
                                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
