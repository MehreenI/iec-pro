<?php
/**
 * FAQ accordion module — VSAT layout.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$heading       = $args['heading'] ?? 'Frequently asked questions';
$eyebrow       = $args['eyebrow'] ?? '';
$faq           = $args['faq'] ?? array();
$section_class = $args['section_class'] ?? '';
$section_id    = $args['section_id'] ?? '';
$heading_class = $args['heading_class'] ?? '';
$heading_attrs = $args['heading_attrs'] ?? '';

if ( empty( $faq ) ) {
    return;
}

$section_attr = $section_id !== '' ? ' id="' . esc_attr( $section_id ) . '"' : '';

?>
<section class="iec_faq_section <?= esc_attr( $section_class ); ?>"<?= $section_attr; ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ( $eyebrow || $heading ) : ?>
                    <div class="iec_section_heading">
                        <?php if ( $eyebrow ) : ?>
                            <span class="iec_home_eyebrow iec-eyebrow"><?= $eyebrow; ?></span>
                        <?php endif; ?>

                        <?php if ( $heading ) : ?>
                            <h2 class="iec-section-heading <?= esc_attr( $heading_class ); ?>" <?= $heading_attrs; ?>><?= $heading; ?></h2>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="iec_faq_grid">
                    <?php foreach ( $faq as $item ) :
                        if ( empty( $item['question'] ) ) {
                            continue;
                        }
                        ?>
                        <div class="iec_faq_item">
                            <div class="iec_faq_header" aria-expanded="false" role="button" tabindex="0">
                                <h3 class="iec_faq_title"><?= $item['question']; ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="iec_faq_icon" aria-hidden="true">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            <div class="iec_faq_answer">
                                <div class="iec_faq_answer_inner">
                                    <?= wp_kses_post( $item['answer'] ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
