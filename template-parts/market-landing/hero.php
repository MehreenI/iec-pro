<?php
/**
 * Market Landing — hero.
 *
 * Args: section (ACF group `hero`: background_image, mobile_image, breadcrumb_label, heading, sub_heading, button).
 * Empty fields fall back to iec_market_landing_defaults().
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$section = is_array($args['section'] ?? null) ? $args['section'] : [];
$defaults = iec_market_landing_defaults()['hero'];
$background = iec_resolve_media_to_url($section['background_image'] ?? '') ?: $defaults['background_image_default'];
$mobile_background = iec_resolve_media_to_url($section['mobile_image'] ?? '');
$button = is_array($section['button'] ?? null) ? $section['button'] : [];
?>

<section class="iec-industries-hero iec_defualt_position iec_bg_repeat<?= $mobile_background ? ' has-mobile-image' : ''; ?>" style="--heroImage: url('<?= $background; ?>');<?= $mobile_background ? ' --heroImageMobile: url(\'' . $mobile_background . '\');' : ''; ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="iec-industries-hero__content text-md-center">
                    <div class="iec-industries-hero__breadcrumb text-white">
                        <a href="<?= iec_wpml_localize_url(home_url('/')); ?>"><?= __('Home', 'iec'); ?></a>
                        <span class="iec-industries-hero__breadcrumb-sep" aria-hidden="true">
                            <svg viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="currentColor"></path></svg>
                        </span>
                        <span><?= iec_filled($section['breadcrumb_label'] ?? '', $defaults['breadcrumb_label']); ?></span>
                    </div>

                    <h1 class="iec-primary-heading text-white" data-split="word" data-fade="up"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?></h1>

                    <p class="iec_hero_desc wysiwyg-content" data-fade="up" data-delay="100"><?= iec_filled($section['sub_heading'] ?? '', $defaults['sub_heading']); ?></p>

                    <a href="<?= iec_resolve_wpml_url($button) ?: $defaults['button']['url']; ?>" class="btn secondary-btn"<?= iec_link_target_attr($button); ?>>
                        <?= iec_filled($button['title'] ?? '', $defaults['button']['title']); ?>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="iec-industries-hero__visual"></div>
            </div>
        </div>
    </div>
</section>
