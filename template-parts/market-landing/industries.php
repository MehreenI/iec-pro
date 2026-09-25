<?php
/**
 * Market Landing — land or maritime industry cards.
 *
 * Args: type ('land' | 'maritime'),
 *       section (ACF group `land_industries` / `maritime_industries`: show_section, eyebrow, heading, content,
 *       cards[image, icon, title, description, link_label, link]).
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

$type = 'maritime' === ($args['type'] ?? '') ? 'maritime' : 'land';
$defaults = iec_market_landing_defaults()[$type . '_industries'];
$cards = iec_rows_or_defaults($section['cards'] ?? [], $defaults['cards']);
$grid = min(5, max(2, count($cards)));
?>

<section id="<?= $type; ?>-industries" class="iec-land-industries iec_defualt_position">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-md-center">
                <span class="iec-eyebrow text-md-center"><?= iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']); ?></span>
                <h2 class="iec-section-heading mb-1"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?></h2>
                <div class="wysiwyg-content"><?= iec_filled($section['content'] ?? '', $defaults['content']); ?></div>
            </div>
        </div>

        <?php if ($cards): ?>
            <div class="grid-<?= $grid; ?>">
                <?php foreach ($cards as $item): ?>
                    <?php
                    $link = is_array($item['link'] ?? null) ? $item['link'] : [];
                    $url = !empty($link['url']) ? iec_resolve_wpml_url($link) : '';
                    $tag = $url ? 'a' : 'div';
                    $link_label = iec_filled($item['link_label'] ?? '', $link['title'] ?? '');
                    ?>
                    <<?= $tag; ?><?= $url ? ' href="' . $url . '"' . iec_link_target_attr($link) : ''; ?> class="iec-industry-card iec_h_100">
                        <div class="iec-industry-card__image">
                            <?= iec_image_tag($item['image'] ?? null, $item['image_default'] ?? [], 'iec_img_style'); ?>
                        </div>
                        <div class="iec-industry-card__body text-md-center">
                            <div class="iec-industry-card__icon industry-svg">
                                <?= iec_icon_tag($item['icon'] ?? null, $item['icon_svg'] ?? ''); ?>
                            </div>

                            <?php if (!empty($item['title'])): ?>
                                <h3><?= $item['title']; ?></h3>
                            <?php endif; ?>

                            <?php if (!empty($item['description'])): ?>
                                <div class="wysiwyg-content">
                                    <p><?= $item['description']; ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($url && $link_label): ?>
                                <span class="iec-industry-card__link text-md-center"><?= $link_label; ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <?php endif; ?>
                        </div>
                    </<?= $tag; ?>>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
