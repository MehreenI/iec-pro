<?php
/**
 * Operator — country guide cards.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['country_guides'];
$guides = iec_rows_or_defaults(get_sub_field('guides'), $defaults['guides']);

if (!$guides) {
    return;
}

$guide_icon = '<svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><path d="M12 40H53L47 49H20L12 40Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/><path d="M22 40V25H40V40" stroke="currentColor" stroke-width="2.2"/><path d="M28 25V15H35V25" stroke="currentColor" stroke-width="2.2"/><path d="M35 17L43 23" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/><path d="M17 53C20 55 23 55 26 53C29 51 32 51 35 53C38 55 41 55 44 53C47 51 50 51 53 53" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/><path d="M10 34H22" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>';
?>

<section class="country-guides p-3" id="country-guides" aria-labelledby="country-guides-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>
                    <h2 id="country-guides-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>

                    <div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100"><?= iec_filled(get_sub_field('content'), $defaults['content']); ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="iec_country_guides_warpper" data-fade="up" data-delay="150">
                    <div class="swiper iec_country_guides_swiper" data-country-guides>
                        <div class="swiper-wrapper">
                            <?php foreach ($guides as $guide): ?>
                                <?php $link = iec_link_parts($guide['link'] ?? null, $defaults['link_default']); ?>
                                <div class="swiper-slide">
                                    <a href="<?= $link['url']; ?>" class="iec-industry-card iec_h_100"<?= $link['target']; ?>>
                                        <div class="iec-industry-card__image">
                                            <?= iec_image_tag($guide['image'] ?? null, (array) ($guide['image_default'] ?? []) + ['alt' => $guide['title'] ?? '']); ?>
                                        </div>

                                        <div class="iec-industry-card__body">
                                            <div class="iec-industry-card__icon industry-svg"><?= $guide_icon; ?></div>
                                            <h3 class="iec-heading"><?= $guide['title'] ?? ''; ?></h3>

                                            <div class="wysiwyg-content">
                                                <p class="card_iec_text"><?= $guide['description'] ?? ''; ?></p>
                                            </div>

                                            <span class="iec-industry-card__link">
                                                <?= $link['title']; ?>
                                                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev" aria-label="<?= __('Previous slide', 'iec'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
                            <path d="M30.7271 31L15.4934 31L0.000180604 15.978L15.3636 -1.34311e-06L30.7271 0L15.3636 15.5L30.7271 31Z" fill="#727DA4" fill-opacity="0.5"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_swiper_mobile_icon" aria-hidden="true">
                            <path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#727DA3"/>
                        </svg>
                    </div>

                    <div class="swiper-button-next" aria-label="<?= __('Next slide', 'iec'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
                            <path d="M0.5 0L12.8944 0L25.5 15.022L13 31H0.5L13 15.5L0.5 0Z" fill="#727DA4" fill-opacity="0.5"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_swiper_mobile_icon" aria-hidden="true">
                            <path d="M4.11062 13.42L5.29729 14.6L11.8906 7.99998L5.29063 1.39998L4.11063 2.57998L9.53063 7.99998L4.11062 13.42Z" fill="#727DA3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
