<?php
/**
 * Market Landing — specialized connectivity: intro and four features.
 *
 * Args: section (ACF group `specialized_connectivity`: show_section, eyebrow, heading, content, features[icon, title, description]).
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

$defaults = iec_market_landing_defaults()['specialized_connectivity'];
$features = iec_rows_or_defaults($section['features'] ?? [], $defaults['features']);
?>

<section class="iec-specialized-connectivity iec_defualt_position">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-md-center">
                <span class="iec-eyebrow text-md-center"><?= iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']); ?></span>
                <h2 class="iec-section-heading mb-1"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?></h2>
                <div class="wysiwyg-content"><?= iec_filled($section['content'] ?? '', $defaults['content']); ?></div>
            </div>
        </div>

        <?php if ($features): ?>
            <div class="grid-4">
                <?php foreach ($features as $feature): ?>
                    <div class="iec-connectivity-feature text-center">
                        <div class="iec-connectivity-feature__icon">
                            <?= iec_icon_tag($feature['icon'] ?? null, $feature['icon_svg'] ?? ''); ?>
                        </div>

                        <?php if (!empty($feature['title'])): ?>
                            <h3><?= $feature['title']; ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($feature['description'])): ?>
                            <div class="wysiwyg-content">
                                <p><?= $feature['description']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
