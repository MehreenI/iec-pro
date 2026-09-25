<?php
/**
 * VSAT Portfolio — recommended solutions tabs.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! get_field( 'show_rec' ) ) {
    return;
}

$eyebrow = get_field( 'rec_eyebrow' );
$title   = get_field( 'rec_title' );
$slider  = get_field( 'slider' );
$slider  = is_array( $slider ) ? $slider : array();

$slides = array_values(
    array_filter(
        $slider,
        static function ( $slide ) {
            return is_array( $slide ) && ( $slide['title'] ?? '' ) !== '';
        }
    )
);

if ( empty( $slides ) ) {
    return;
}

$items = array();

foreach ( $slides as $slide ) {
    $is_existing = ! empty( $slide['solution_type'] ) && $slide['solution'] instanceof WP_Post;
    if ( $is_existing ) {
        $solution_post = $slide['solution'];
        $slide_image   = $slide['image'] ?? null;
        if ( empty( $slide_image ) ) {
            $slide_image = get_field( 'landing_image', $solution_post->ID );
        }

        if ( empty( $slide_image ) ) {
            $thumb_id = get_post_thumbnail_id( $solution_post->ID );
            if ( $thumb_id ) {
                $slide_image = array( 'ID' => (int) $thumb_id );
            }
        }
        $solution_id  = (int) $solution_post->ID;
        $current_lang = apply_filters( 'wpml_current_language', null );
        if ( is_string( $current_lang ) && $current_lang !== '' && has_filter( 'wpml_object_id' ) ) {
            $translated_id = apply_filters( 'wpml_object_id', $solution_id, $solution_post->post_type, true, $current_lang );
            if ( $translated_id ) {
                $solution_id = (int) $translated_id;
            }
        }
        $slide_link = array(
            'title'  => 'Explore More',
            'url'    => (string) get_permalink( $solution_id ),
            'target' => '_self',
        );
    } else {
        $slide_image = $slide['image'] ?? null;
        $raw_link    = $slide['link'] ?? array();
        $link_url    = $raw_link['url'] ?? '';
        if ( $link_url !== '' && ! str_starts_with( $link_url, '#' ) ) {
            $linked_post_id = url_to_postid( $link_url );
            $current_lang   = apply_filters( 'wpml_current_language', null );
            if ( $linked_post_id > 0 && is_string( $current_lang ) && $current_lang !== '' && has_filter( 'wpml_object_id' ) ) {
                $translated_id = apply_filters( 'wpml_object_id', $linked_post_id, get_post_type( $linked_post_id ), true, $current_lang );
                if ( $translated_id ) {
                    $translated_url = get_permalink( (int) $translated_id );
                    if ( $translated_url ) {
                        $link_url = (string) $translated_url;
                    }
                }
            }
        }
        $slide_link = array(
            'url'    => $link_url,
            'title'  => $raw_link['title'] ?? '',
            'target' => $raw_link['target'] ?? '_self',
        );
    }
    $items[] = array(
        'title' => $slide['title'],
        'body'  => (string) ( $slide['body'] ?? '' ),
        'image' => $slide_image,
        'link'  => $slide_link,
    );
}

$strip_count = 14;
?>
<style>
    .t-vsat-portfolio .recommended_content .solution_pane { display: none; }
    .t-vsat-portfolio .recommended_content .solution_pane.active { display: block; }
    .t-vsat-portfolio .recommended_tabs .solution_btn.active { font-weight: 600; }

    .t-vsat-portfolio .recommended_content .solution_pane.active .solution_body,
    .t-vsat-portfolio .recommended_content .solution_pane.active .learn_more_btn {
        opacity: 0;
        transform: translateX(-1.5rem);
    }

    .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .solution_body,
    .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .learn_more_btn {
        opacity: 1;
        transform: translateX(0);
        transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .solution_body {
        transition-delay: 0.08s;
    }

    .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .learn_more_btn {
        transition-delay: 0.2s;
    }

    .t-vsat-portfolio .recommended_solution_image .reveal-box.solution_image { display: none; }
    .t-vsat-portfolio .recommended_solution_image .reveal-box.solution_image.active { display: block; }

    .t-vsat-portfolio .recommended_solution_image .reveal-box {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 3;
        max-height: 10.999397rem;
        border-radius: 0.234876rem;
        overflow: hidden;
        margin-left: auto;
    }

    .t-vsat-portfolio .recommended_solution_image .reveal-box img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        max-width: none;
        max-height: none;
        margin: 0;
        object-fit: cover;
        display: block;
    }

    .t-vsat-portfolio .recommended_solution_image .strips {
        position: absolute;
        inset: 0;
        display: flex;
        z-index: 2;
        pointer-events: none;
    }

    .t-vsat-portfolio .recommended_solution_image .strip {
        flex: 1 0 0;
        background: #f6f7f8;
        transform: translateY(0);
        transition: transform 0.85s cubic-bezier(0.76, 0, 0.24, 1);
    }

    .t-vsat-portfolio .recommended_solution_image .reveal-box.is-visible .strip {
        transform: translateY(-100%);
    }

    @media (prefers-reduced-motion: reduce) {
        .t-vsat-portfolio .recommended_content .solution_pane.active .solution_body,
        .t-vsat-portfolio .recommended_content .solution_pane.active .learn_more_btn,
        .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .solution_body,
        .t-vsat-portfolio .recommended_content .solution_pane.active.is-text-visible .learn_more_btn {
            opacity: 1;
            transform: none;
            transition: none;
        }

        .t-vsat-portfolio .recommended_solution_image .strip {
            transition: none;
        }

        .t-vsat-portfolio .recommended_solution_image .reveal-box.is-visible .strip {
            transform: translateY(-100%);
        }
    }
</style>

<section class="recommended_solutions_section" id="recommended_solutions">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_section_heading">
                    <?php if ( $eyebrow ) : ?>
                        <span class="iec_section_eyebrow"><?= $eyebrow; ?></span>
                    <?php endif; ?>

                    <?php if ( $title ) : ?>
                        <h2 class="recommended_title js-vsat-section-title"><?= $title; ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 order-1 order-md-1">
                <div class="recommended_tabs">
                    <?php foreach ( $items as $index => $item ) :
                        $pane_id = 'solution-pane-' . $index;
                        ?>
                        <button
                                type="button"
                                class="solution_btn<?= 0 === $index ? ' active' : ''; ?>"
                                data-target="<?= esc_attr( $pane_id ); ?>"
                                aria-controls="<?= esc_attr( $pane_id ); ?>"
                        >
                            <?= $item['title']; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-5 order-3 order-md-2">
                <div class="recommended_content">
                    <?php foreach ( $items as $index => $item ) :
                        $link      = $item['link'];
                        $pane_id   = 'solution-pane-' . $index;
                        $link_url  = $link['url'];
                        $anchor_id = '';
                        $link_href = $link_url;
                        if ( $link_url !== '' && str_starts_with( $link_url, '#' ) ) {
                            $anchor_id = ltrim( $link_url, '#' );
                            $link_href = 'javascript:void(0);';
                        }
                        ?>
                        <div class="solution_pane<?= 0 === $index ? ' active is-text-visible' : ''; ?>" id="<?= esc_attr( $pane_id ); ?>">
                            <?php if ( $item['body'] !== '' ) : ?>
                                <div class="solution_body"><?= wp_kses_post( $item['body'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( $link_href !== '' ) : ?>
                                <a
                                        href="<?= esc_url( $link_href ); ?>"
                                        class="learn_more_btn"
                                        target="<?= esc_attr( $link['target'] ); ?>"
                                    <?= $anchor_id !== '' ? 'data-id="' . esc_attr( $anchor_id ) . '"' : ''; ?>
                                >
                                    <?= $link['title'] !== '' ? $link['title'] : 'Learn More'; ?>
                                    <span><?php get_template_part( 'template-parts/offshore/learn-more-icon' ); ?></span>
                                </a>
                            <?php else : ?>
                                <a href="" class="learn_more_btn" target="_self" data-id="iecModelEnquiry">
                                    Speak to an Expert
                                    <span><?php get_template_part( 'template-parts/offshore/learn-more-icon' ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4 order-2 order-md-3 recommeded_image">
                <div class="recommended_solution_image">
                    <?php foreach ( $items as $index => $item ) :
                        $image       = $item['image'] ?? null;
                        $box_class   = 'reveal-box solution_image' . ( 0 === $index ? ' active' : '' );
                        $alt         = $item['title'];
                        $has_image   = false;
                        $image_url   = '';
                        $image_id    = 0;
                        if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
                            $has_image = true;
                            $image_id  = (int) $image['ID'];
                            if ( ! empty( $image['alt'] ) ) {
                                $alt = $image['alt'];
                            }
                        } else {
                            $image_url = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $image ) : '';
                            $has_image = $image_url !== '';
                            if ( is_array( $image ) && ! empty( $image['alt'] ) ) {
                                $alt = $image['alt'];
                            }
                        }

                        if ( ! $has_image ) {
                            continue;
                        }
                        ?>
                        <div class="<?= esc_attr( $box_class ); ?>" data-solution-reveal>
                            <?php
                            if ( $image_id ) {
                                echo wp_get_attachment_image(
                                    $image_id,
                                    'large',
                                    false,
                                    array(
                                        'alt'      => $alt,
                                        'loading'  => 'lazy',
                                        'decoding' => 'async',
                                    )
                                );
                            } else {
                                ?>
                                <img
                                        src="<?= esc_url( $image_url ); ?>"
                                        alt="<?= esc_attr( $alt ); ?>"
                                        loading="lazy"
                                        decoding="async"
                                >
                                <?php
                            }
                            ?>
                            <div class="strips" aria-hidden="true">
                                <?php for ( $strip_i = 0; $strip_i < $strip_count; $strip_i++ ) : ?>
                                    <div class="strip" style="transition-delay: <?= (int) ( $strip_i * 45 ); ?>ms;"></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
