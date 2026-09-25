<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();

if ( empty( $section ) ) {
	return;
}

$heading     = $section['heading'] ?? '';
$tab_title_1 = $section['tab_title'] ?? '';
$tab_title_2 = $section['tab_title_2'] ?? '';
$items_1     = $section['industries'] ?? array();
$items_2 = $section['industries_2'] ?? array();

if ( empty( $items_1 ) && empty( $items_2 ) ) {
	return;
}

$tab_1_id = 'land';
$tab_2_id = 'maritime';

$chevron = '<svg xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none" aria-hidden="true"><path d="M0.695312 0.695182L4.86659 4.51886L0.695312 8.34253" stroke="white" stroke-width="1.39043" stroke-linecap="round"/></svg>';

$render_cards = static function ( $items ) use ( $chevron ) {

	if ( empty( $items ) ) {
		return;
	}
    ?>
    <div class="iec_home_industries_swiper_warpper">
        <div class="swiper iec_home_industries_swiper">
            <div class="swiper-wrapper">
                <?php foreach ( $items as $item ) : ?>
                    <?php
                    $link  = $item['link'] ?? array();
                    $title = $link['title'] ?? '';
                    $url   = ! empty( $link['url'] ) && function_exists( 'iec_resolve_wpml_url' )
                        ? iec_resolve_wpml_url( $link )
                        : ( $link['url'] ?? '' );
                    $target = $link['target'] ?? '';
                    $image     = $item['image'] ?? null;
                    $image_id  = 0;
                    $image_url = '';

                    if ( is_numeric( $image ) ) {
                        $image_id = (int) $image;

                    } elseif ( is_array( $image ) ) {
                        $image_id  = ! empty( $image['ID'] ) ? (int) $image['ID'] : 0;
                        $image_url = $image['url'] ?? '';
                    }

                    if ( $image_id < 1 && $image_url ) {
                        $image_id = (int) attachment_url_to_postid( $image_url );
                    }

                    if ( ! $title ) {
                        continue;
                    }
                    ?>
                    <div class="swiper-slide">
                        <a href="<?= esc_url( $url ?: '#' ); ?>"
                           class="iec_industry_card"
                            <?= $target ? ' target="' . esc_attr( $target ) . '"' : ''; ?>
                        >
                            <?php if ( $image_id ) : ?>

                                <?= wp_get_attachment_image( $image_id, 'medium_large', false, array( 'alt' => $title ) ); ?>

                            <?php endif; ?>
                            <div class="iec_overlay"></div>
                            <h3>
                                <?= $title; ?>
                                <?= $chevron; ?>
                            </h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination iec_home_industires_swiper_pagination"></div>
                <div class="swiper-button-next iec_home_industires_swiper_next"></div>
                <div class="swiper-button-prev iec_home_industires_swiper_prev"></div>
            <div class="iec_swiper_arrow_warpper">
                <div class="swiper-button-next iec_home_industires_swiper_next"></div>
                <div class="swiper-button-prev iec_home_industires_swiper_prev"></div>
            </div>
        </div>
    </div>
    <?php
};?>
<section class="iec_defualt_position iec_section_home_industries">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <?php if ( $heading ) : ?>

                    <h2 class="iec_section_heading iec-section-heading" data-aos="fade-up"><?= esc_html( $heading ); ?></h2>

                <?php endif; ?>

            </div>
            <div class="col-md-7">
                <div class="iec_industry_tabs" data-aos="fade-up" data-aos-delay="100">
                    
                    <?php if ( $tab_title_1 ) : ?>

                        <button class="iec_tab_btn active" data-tab="<?= esc_attr( $tab_1_id ); ?>" type="button"><?= $tab_title_1; ?></button>

                    <?php endif; ?>

                    <?php if ( $tab_title_2 ) : ?>

                        <button class="iec_tab_btn" data-tab="<?= esc_attr( $tab_2_id ); ?>" type="button"><?= $tab_title_2; ?></button>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="iec_industries_panels" data-aos="fade-up" data-aos-delay="150">
                    <div class="iec_industries_panels_track">
                        <?php if ( ! empty( $items_1 ) ) : ?>

                            <div class="iec_tab_content active" id="<?= esc_attr( $tab_1_id ); ?>" data-tab-index="0">
                                <?php $render_cards( $items_1 ); ?>
                            </div>

                        <?php endif; ?>

                        <?php if ( ! empty( $items_2 ) ) : ?>

                            <div class="iec_tab_content" id="<?= esc_attr( $tab_2_id ); ?>" data-tab-index="1">
                                <?php $render_cards( $items_2 ); ?>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
