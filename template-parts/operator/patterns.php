<?php
/**
 * Operator — maritime and land pattern sliders.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['patterns']['sections'];
$pattern_sections = iec_rows_or_defaults(get_sub_field('sections'), $defaults);
?>

<?php foreach ($pattern_sections as $index => $pattern): ?>
    <?php
    $id = sanitize_title((string) ($pattern['section_id'] ?? '')) ?: 'pattern-' . ($index + 1);
    $button = iec_link_parts($pattern['button'] ?? null, $defaults[0]['button']);
    $cards = iec_flex_rows($pattern['cards'] ?? null);
    ?>
    <section class="iec_defualt_position iec_market_slider_section p-2 iec_starlink_patterns" id="<?= $id; ?>" aria-labelledby="<?= $id; ?>-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_market_slider_content">
                        <span class="iec-eyebrow text-md-center"><?= $pattern['eyebrow'] ?? ''; ?></span>
                        <div class="iec_starlink_patterns_heading_warpper">
                            <h2 id="<?= $id; ?>-heading" class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= $pattern['heading'] ?? ''; ?></h2>
                            <a href="<?= $button['url']; ?>" class="btn secondary-btn iec_patterns_heading_btn" data-fade="up" data-delay="150"<?= $button['target']; ?>><?= $button['title']; ?></a>
                        </div>

                        <div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100">
                            <?= $pattern['intro'] ?? ''; ?>
                        </div>

                    </div>

                    <div class="iec_market_slider_warpper" data-fade="up" data-delay="200">
                        <div class="swiper-pagination"></div>

                        <div class="swiper iec_starlink_patterns_swiper" data-starlink-patterns>
                            <div class="swiper-wrapper">
                                <?php foreach ($cards as $card_index => $card): ?>
                                    <?php $image = iec_image_tag($card['image'] ?? null, $card['image_default'] ?? []); ?>
                                    <div class="swiper-slide starlink-img-slide">
                                        <?php if ($image): ?>
                                            <div class="top-img"><?= $image; ?></div>
                                        <?php endif; ?>

                                        <article>
                                            <span aria-hidden="true"><?= sprintf('%02d', $card_index + 1); ?></span>
                                            <h3 class="iec-heading"><?= $card['title'] ?? ''; ?></h3>

                                            <div class="wysiwyg-content">
                                                <p class="card_iec_text"><?= $card['text'] ?? ''; ?></p>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

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
<?php endforeach; ?>
