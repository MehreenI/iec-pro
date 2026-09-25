<?php
/**
 * Operator — service finder, one tab per requirement.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['service_finder'];
$tabs = iec_rows_or_defaults(get_sub_field('tabs'), $defaults['tabs']);
$footer_button = iec_link_parts(get_sub_field('footer_button'), $defaults['footer_button']);
$class= get_sub_field('background');

if ($tabs) {
    $all_services = [];

    foreach ($tabs as $i => $tab) {
        $tabs[$i]['rows'] = iec_flex_rows($tab['services'] ?? null);
        $all_services = array_merge($all_services, $tabs[$i]['rows']);
    }

    array_unshift($tabs, [
        'label' => __('All Services', 'iec'),
        'rows'  => $all_services,
    ]);
}

$arrow = '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
?>

<section class="iec_defualt_position iec_starlink_inmarsat_section <?= $class ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_starlink_inmarsat" data-iec-tabs>
                    <div class="iec_starlink_inmarsat_header">
                        <div class="iec_starlink_inmarsat_header_left">
                            <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>

                            <h2 class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>
                        </div>

                        <div class="wysiwyg-content iec_starlink_inmarsat_header_right text-md-center" data-fade="up" data-delay="100"><?= iec_filled(get_sub_field('intro'), $defaults['intro']); ?></div>
                    </div>

                    <?php if ($tabs): ?>
                        <div class="iec_starlink_inmarsat_filters">
                            <h3 class="iec_starlink_inmarsat_filter_title"><?= iec_filled(get_sub_field('filter_title'), $defaults['filter_title']); ?></h3>

                            <div class="iec_starlink_inmarsat_filter_buttons" role="tablist" aria-label="<?= __('Services by requirement', 'iec'); ?>">
                                <?php foreach ($tabs as $index => $tab): ?>
                                    <button
                                            type="button"
                                            class="iec_starlink_inmarsat_filter_btn<?= 0 === $index ? ' is-active' : ''; ?>"
                                            role="tab"
                                            id="iec-tab-service-<?= $index; ?>"
                                            aria-selected="<?= 0 === $index ? 'true' : 'false'; ?>"
                                            aria-controls="panel-service-<?= $index; ?>"
                                            data-iec-tab="service-<?= $index; ?>"
                                    ><?= $tab['label'] ?? ''; ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php foreach ($tabs as $index => $tab): ?>
                            <?php $services = $tab['rows']; ?>
                            <div
                                    class="iec_starlink_inmarsat_post_grid<?= 0 === $index ? ' is-active' : ''; ?><?= count($services) > 3 ? ' is-four' : ''; ?>"
                                    role="tabpanel"
                                    id="panel-service-<?= $index; ?>"
                                    aria-labelledby="iec-tab-service-<?= $index; ?>"
                                <?= 0 === $index ? '' : ' hidden'; ?>
                            >
                                <div class="inmarsat_post_swiper_warpper">
                                    <div class="swiper inmarsat_post_swiper">
                                        <div class="swiper-wrapper">

                                            <?php foreach ($services as $position => $service): ?>
                                                <?php
                                                $link = iec_link_parts($service['link'] ?? null, $defaults['link_default']);
                                                $meta = iec_flex_rows($service['meta'] ?? null);
                                                ?>

                                                <div class="swiper-slide">
                                                    <a href="<?= $link['url']; ?>" class="iec_starlink_inmarsat_post"<?= $link['target']; ?>>
                                                        <div class="iec_starlink_inmarsat_post_header">
                                                            <span><?= sprintf('%02d', $position + 1); ?></span>

                                                            <h4 class="iec_starlink_inmarsat_post_title"><?= $service['title'] ?? ''; ?></h4>
                                                        </div>

                                                        <div class="wysiwyg-content">
                                                            <p class="card_iec_text"><?= $service['content'] ?? ''; ?></p>
                                                        </div>

                                                        <?php if ($meta): ?>
                                                            <div class="iec_starlink_inmarsat_post_meta">
                                                                <?php foreach ($meta as $item): ?>
                                                                    <div class="iec_starlink_inmarsat_post_meta_item">
                                                                        <span><?= $item['label'] ?? ''; ?></span>

                                                                        <strong><?= $item['value'] ?? ''; ?></strong>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <span class="iec_starlink_inmarsat_post_link"><?= $link['title']; ?> <?= $arrow; ?></span>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next inmarsat_post_swiper_next">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
                                            <path d="M0.5 0L12.8944 0L25.5 15.022L13 31H0.5L13 15.5L0.5 0Z" fill="#727DA4" fill-opacity="0.5"></path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_swiper_mobile_icon" aria-hidden="true">
                                            <path d="M4.11062 13.42L5.29729 14.6L11.8906 7.99998L5.29063 1.39998L4.11063 2.57998L9.53063 7.99998L4.11062 13.42Z" fill="#727DA3"></path>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-prev inmarsat_post_swiper_prev">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
                                            <path d="M30.7271 31L15.4934 31L0.000180604 15.978L15.3636 -1.34311e-06L30.7271 0L15.3636 15.5L30.7271 31Z" fill="#727DA4" fill-opacity="0.5"></path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_swiper_mobile_icon" aria-hidden="true">
                                            <path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#727DA3"></path>
                                        </svg>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="iec_starlink_inmarsat_footer">
                        <div class="wysiwyg-content"><?= iec_filled(get_sub_field('footer_text'), $defaults['footer_text']); ?></div>

                        <?php if ($footer_button['url']): ?>
                            <a class="btn secondary-btn" href="<?= $footer_button['url']; ?>"<?= $footer_button['target']; ?>><?= $footer_button['title']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Initialize Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.inmarsat_post_swiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            navigation: {
                nextEl: '.inmarsat_post_swiper_next',
                prevEl: '.inmarsat_post_swiper_prev',
            },
        });
    });
</script>
