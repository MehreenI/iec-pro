<?php
/**
 * Market Landing — our solutions band.
 *
 * Args: section (ACF group `our_solutions`: show_section, background_image, eyebrow, heading, content,
 *       items[icon, title, description]).
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

$defaults = iec_market_landing_defaults()['our_solutions'];
$background = iec_resolve_media_to_url($section['background_image'] ?? null);
$items = iec_rows_or_defaults($section['items'] ?? [], $defaults['items']);
?>

<section class="iec-our-solutions pos-rel text-white"<?= $background ? ' style="background-image: url(\'' . $background . '\');"' : ''; ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-md-center">
                <span class="iec-eyebrow text-md-center"><?= iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']); ?></span>
                <h2 class="iec-section-heading mb-1 text-white"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?></h2>
                <div class="wysiwyg-content"><?= iec_filled($section['content'] ?? '', $defaults['content']); ?></div>
            </div>
        </div>

        <?php if ($items): ?>
            <div class="grid-3">
                <?php foreach ($items as $item): ?>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><?= iec_icon_tag($item['icon'] ?? null, $item['icon_svg'] ?? ''); ?></div>

                        <?php if (!empty($item['title'])): ?>
                            <h3><?= $item['title']; ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['description'])): ?>
                            <div class="wysiwyg-content">
                                <p><?= $item['description']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
