<?php
/**
 * Operator — where the service fits, image cards.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['fits_grid'];
$cards = iec_rows_or_defaults(get_sub_field('cards'), $defaults['cards']);
$class= get_sub_field('add_pading');
$class_name = $class ? 'p-3' : '';
?>

<section class="iec_defualt_position iec_starlink_inmarsat_fits_section <?= $class_name ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_starlink_inmart_fit_content">
                    <span class="iec-eyebrow text-md-center"><?= iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']); ?></span>

                    <h2 class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?= iec_filled(get_sub_field('heading'), $defaults['heading']); ?></h2>
                </div>

                <?php if ($cards): ?>
                    <div class="iec_starlink_inmarst_fit_box_gird" data-fade="up" data-delay="150" data-stagger=".iec_starlink_inmarsat_fit_box">
                        <?php foreach ($cards as $card): ?>
                            <?php
                            $link = iec_link_parts($card['link'] ?? null, $defaults['link_default']);
                            $image = iec_image_tag($card['image'] ?? null, ($card['image_default'] ?? []) + ['alt' => $card['title'] ?? ''], 'iec_img_style');
                            ?>
                            <a href="<?= $link['url']; ?>" class="iec_starlink_inmarsat_fit_box"<?= $link['target']; ?>>
                                <?php if ($image): ?>
                                    <div class="iec_starlink_inmarst_fit_box_image"><?= $image; ?></div>
                                <?php endif; ?>

                                <div class="iec_starlink_inmarsat_fit_box_content">
                                    <span class="iec-eyebrow"><?= $card['label'] ?? ''; ?></span>

                                    <h3><?= $card['title'] ?? ''; ?></h3>

                                    <p class="card_iec_text"><?= $card['text'] ?? ''; ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
