<?php
/**
 * Market Landing — global coverage band.
 *
 * Args: section (ACF group `global_coverage`: show_section, background_image, eyebrow, heading, highlight,
 *       content, features[icon, title, sub_title]).
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

$defaults = iec_market_landing_defaults()['global_coverage'];
$background = iec_resolve_media_to_url($section['background_image'] ?? null);
$highlight = iec_filled($section['highlight'] ?? '', $defaults['highlight']);
$features = iec_rows_or_defaults($section['features'] ?? [], $defaults['features']);
?>

<section class="iec-global-coverage iec_defualt_position"<?= $background ? ' style="background-image: url(\'' . $background . '\');"' : ''; ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec-global-coverage__content text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']); ?></span>
                    <h2 class="iec-section-heading mb-1"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?><?= $highlight ? ' <span class="highlight">' . $highlight . '</span>' : ''; ?></h2>
                    <div class="wysiwyg-content half_wysiwyg-content "><?= iec_filled($section['content'] ?? '', $defaults['content']); ?></div>

                    <?php if ($features): ?>
                        <div class="grid-3">
                            <?php foreach ($features as $feature): ?>
                                <div class="iec-global-feature text-center">
                                    <div class="iec-global-feature__icon">
                                        <?= iec_icon_tag($feature['icon'] ?? null, $feature['icon_svg'] ?? ''); ?>
                                    </div>
                                    <div class="iec-global-feature__text">
                                        <strong><?= $feature['title'] ?? ''; ?></strong>
                                        <span><?= $feature['sub_title'] ?? ''; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
