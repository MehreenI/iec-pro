<?php

$heading = $args['heading'] ?? '';
$content = $args['content'] ?? '';
$button_url = $args['button_url'] ?? '';
$button_title = $args['button_title'] ?? '';
$slider = $args['slider'] ?? '';
$section_id = $args['id'] ?? '';
$button_id = $args['button_id'] ?? '';
$section_class = $args['section_class'] ?? '';
$heading_class = $args['heading_class'] ?? '';
$content_class = $args['content_class'] ?? '';
$cta_class = $args['cta_class'] ?? '';
$slider_class = $args['slider_class'] ?? '';
$slide_class = $args['slide_class'] ?? '';
$heading_attrs = $args['heading_attrs'] ?? '';
$content_attrs = $args['content_attrs'] ?? '';
$cta_attrs = $args['cta_attrs'] ?? '';
$slider_attrs = $args['slider_attrs'] ?? '';
?>

<section id="<?= $section_id; ?>" class="iec_defualt_position iec_starlink_portfolio_swiper_section iec_starlink_portfolio_land_swiper_section <?= esc_attr( $section_class ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_starlink_portfolio_swiper_content">
                    <?php if ( $heading ) : ?>
                        <?php if ( ! empty( $args['use_heading_section'] ) ) : ?>
                            <div class="iec_heading_section">
                                <h2 <?= $heading_attrs; ?>><?= $heading; ?></h2>
                            </div>
                        <?php else : ?>
                            <h2 class="<?= esc_attr( $heading_class ); ?>" <?= $heading_attrs; ?>><?= $heading; ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( $content ) : ?>
                        <div class="<?= esc_attr( $content_class ); ?>" <?= $content_attrs; ?>><?= $content; ?></div>
                    <?php endif; ?>
                    <?php
                    $vm_button_url = function_exists( 'iec_resolve_wpml_url' )
                        ? iec_resolve_wpml_url( $button_url )
                        : (string) $button_url;
                    ?>
                    <?php if ( ! empty( $vm_button_url ) ) : ?>
                        <a href="<?= esc_url( $vm_button_url ); ?>" class="gray_btn <?= esc_attr( $cta_class ); ?>" id="<?= $button_id; ?>" <?= $cta_attrs ?>><?= $button_title; ?></a>
                    <?php endif; ?>
                </div>
                <div class="iec_starlink_portfolio_swiper_warpper <?= esc_attr( $slider_class ); ?>" <?= $slider_attrs ?>>
                    <div class="swiper-pagination starlink_portfolio_land_pagination"></div>
                    <div class="swiper starlink_portfolio_land_swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $slider as $item ) :
                                $raw_url = $item['link'] ?? '';

                                if ( is_array( $raw_url ) ) {
                                    $raw_url = $raw_url['url'] ?? '';
                                }

                                $raw_url = (string) $raw_url;

                                if ( '#' === $raw_url ) {
                                    $raw_url = '';
                                }

                                $url = ( '' !== $raw_url && function_exists( 'iec_resolve_wpml_url' ) )
                                    ? iec_resolve_wpml_url( $raw_url )
                                    : $raw_url;

                                $media = array();

                                if ( ! empty( $item['headshot'] ) && is_array( $item['headshot'] ) ) {
                                    $media = $item['headshot'];
                                } elseif ( ! empty( $item['image'] ) && is_array( $item['image'] ) ) {
                                    $media = $item['image'];
                                }

                                $image_id  = (int) ( $media['ID'] ?? 0 );
                                $image_url = (string) ( $media['url'] ?? '' );
                                $image_alt = (string) ( $media['alt'] ?? '' );

                                if ( '' === $image_alt ) {
                                    $image_alt = (string) ( $item['title'] ?? '' );
                                }

                                if ( $image_id < 1 && '' !== $image_url ) {
                                    $image_id = (int) attachment_url_to_postid( $image_url );
                                }
                                ?>
                                <div class="swiper-slide">
                                    <?php if ( '' !== $url ) : ?>
                                    <a href="<?= esc_url( $url ); ?>" class="iec_starlink_portfolio_swiper_box <?= esc_attr( $slide_class ); ?>">
                                    <?php else : ?>
                                    <div class="iec_starlink_portfolio_swiper_box <?= esc_attr( $slide_class ); ?>">
                                    <?php endif; ?>
                                        <div class="iec_starlink_portfolio_swiper_image iec_bg_repeat"<?= ( $image_id < 1 && '' !== $image_url ) ? ' style="--boxImage: url(' . esc_url( $image_url ) . ');"' : ''; ?>>
                                            <?php if ( $image_id > 0 ) : ?>
                                                <?= wp_get_attachment_image( $image_id, 'medium_large', false, array( 'alt' => $image_alt, 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="iec_starlink_portfolio_swiper_box_content">
                                            <h3><?= $item['title']; ?></h3>
                                        </div>
                                    <?php if ( '' !== $url ) : ?>
                                    </a>
                                    <?php else : ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="swiper-button-next starlink_portfolio_land_next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                            <path d="M0 0L15.2337 0L30.7269 15.022L15.3634 31L0 31L15.3634 15.5L0 0Z" fill="#727DA4" fill-opacity="0.5"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon">
                            <path d="M4.11014 13.4201L5.2968 14.6001L11.8901 8.0001L5.29014 1.4001L4.11014 2.5801L9.53014 8.0001L4.11014 13.4201Z" fill="#727DA3"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev starlink_portfolio_land_prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                            <path d="M30.7271 31L15.4934 31L0.000180604 15.978L15.3636 -1.34311e-06L30.7271 0L15.3636 15.5L30.7271 31Z" fill="#727DA4" fill-opacity="0.5"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon">
                            <path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#727DA3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
