<?php
/**
 * Operator — coverage points and the live coverage map.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['coverage'];
$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$points = iec_rows_or_defaults(get_sub_field('points'), $defaults['points']);
?>

<section class="iec_defualt_position p-3" id="coverage" aria-labelledby="coverage-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box iec-coverage-aside text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="coverage-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>
        <div class="row align-items-center iec-coverage-wrap">
            <div class="col-md-6">
                <?php if ($points): ?>
                    <ul class="iec-coverage-points">
                        <?php foreach ($points as $point): ?>
                            <li>
                                <strong><?= $point['title'] ?? ''; ?></strong>
                                <div class="iec-coverage-point-content wysiwyg-content">
                                    <p class="card_iec_text"><?= $point['text'] ?? ''; ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="iec_map_wrapper">
                    <?php if(get_sub_field('add_image')):?>
                    <?php $image = get_sub_field('image');?>
                        <?php echo wp_get_attachment_image( $image['ID'], 'full', false, array( 'alt' => 'coverage-map' ) ); ?>
                    <?php else:?>
                    <?php if (shortcode_exists('starlink_map')) {
                        echo do_shortcode('[starlink_map height="360px" search="false"]');
                    } ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
