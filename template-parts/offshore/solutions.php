<?php
/**
 * Offshore — recommended solutions tabs.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section = get_field( 'offshore_solutions' );

if ( empty( $section['enabled'] ) ) {
    return;
}

$heading = ! empty( $section['heading'] ) ? $section['heading'] : 'Recommended Solutions';
$slider  = is_array( $section['slider'] ?? null ) ? $section['slider'] : array();

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

$strip_count = 14;

$items = array();

foreach ( $slides as $slide ) {
    $is_existing = ! empty( $slide['solution_type'] ) && $slide['solution'] instanceof WP_Post;

    if ( $is_existing ) {
        $solution_post = $slide['solution'];
        $slide_image   = get_field( 'landing_image', $solution_post->ID );

        if ( empty( $slide_image ) ) {
            $slide_image = $slide['image'] ?? null;
        }

        $solution_id = (int) $solution_post->ID;
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
        $raw_link    = is_array( $slide['link'] ?? null ) ? $slide['link'] : array();
        $link_url    = ! empty( $raw_link['url'] ) ? (string) $raw_link['url'] : '';

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
            'title'  => ! empty( $raw_link['title'] ) ? (string) $raw_link['title'] : '',
            'target' => ! empty( $raw_link['target'] ) ? (string) $raw_link['target'] : '_self',
        );
    }

    $items[] = array(
        'title' => $slide['title'],
        'body'  => (string) ( $slide['body'] ?? '' ),
        'image' => $slide_image,
        'link'  => $slide_link,
    );
}

?>
<style>
    .recommended_content .solution_pane { display: none; }
    .recommended_content .solution_pane.active { display: block; }
    .recommended_tabs .solution_btn.active { font-weight: 600; }
    .offshore .iec-offshore-solutions-section .recommended_solution_image .reveal-box.solution_image { display: none; }
    .offshore .iec-offshore-solutions-section .recommended_solution_image .reveal-box.solution_image.active { display: block; }
    .offshore .iec-offshore-solutions-section .recommended_solution_image .solution_image.is-empty { display: none !important; }
</style>

<section class="recommended_solutions_section iec-offshore-solutions-section">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h2 class="recommended_title" data-aos="fade-up"><?php echo $heading; ?></h2>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3 order-1 order-md-1" data-aos="fade-right" data-aos-delay="100">
                <div class="recommended_tabs">
                    <?php foreach ( $items as $index => $item ) :
                        $pane_id = 'solution-pane-' . $index;
                        ?>
                        <button
                                type="button"
                                class="solution_btn<?php echo 0 === $index ? ' active' : ''; ?>"
                                data-target="<?php echo $pane_id; ?>"
                        >
                            <?php echo $item['title']; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-5 order-3 order-md-2" data-aos="fade-up" data-aos-delay="150">
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
                        <div class="solution_pane<?php echo 0 === $index ? ' active' : ''; ?>" id="<?php echo $pane_id; ?>">
                            <?php if ( $item['body'] !== '' ) : ?>
                                <div class="solution_body"><?php echo wp_kses_post( $item['body'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( $link_href !== '' ) : ?>
                                <a
                                        href="<?php echo esc_url( $link_href ); ?>"
                                        class="learn_more_btn"
                                        target="<?php echo esc_attr( $link['target'] ); ?>"
                                    <?php echo $anchor_id !== '' ? 'data-id="' . esc_attr( $anchor_id ) . '"' : ''; ?>
                                >
                                    <?php echo $link['title'] !== '' ? $link['title'] : 'Learn More'; ?>
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

            <div class="col-md-4 order-2 order-md-3 recommeded_image" data-aos="fade-left" data-aos-delay="200">
                <div class="recommended_solution_image">
                    <?php foreach ( $items as $index => $item ) :
                        $image     = is_array( $item['image'] ?? null ) ? $item['image'] : array();
                        $alt       = ! empty( $image['alt'] ) ? $image['alt'] : $item['title'];
                        $has_image = false;
                        $image_url = '';
                        $image_id  = 0;

                        if ( ! empty( $image['ID'] ) ) {
                            $has_image = true;
                            $image_id  = (int) $image['ID'];
                        } else {
                            $image_url = iec_resolve_media_to_url( $item['image'] ?? null );
                            $has_image = $image_url !== '';
                        }

                        $is_empty = ! $has_image;
                        $box_class = 'reveal-box solution_image' . ( 0 === $index ? ' active' : '' ) . ( $is_empty ? ' is-empty' : '' );
                        ?>
                        <div
                            class="<?php echo esc_attr( $box_class ); ?>"
                            data-offshore-solution-reveal
                            data-slide="<?php echo (int) $index; ?>"
                        >
                            <?php if ( $has_image ) : ?>
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
                                        src="<?php echo esc_url( $image_url ); ?>"
                                        alt="<?php echo esc_attr( $alt ); ?>"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <?php
                                }
                                ?>
                                <div class="strips" aria-hidden="true">
                                    <?php for ( $strip_i = 0; $strip_i < $strip_count; $strip_i++ ) : ?>
                                        <div class="strip" style="transition-delay: <?php echo (int) ( $strip_i * 45 ); ?>ms;"></div>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    (function ( $ ) {
        var $section     = $( '.iec-offshore-solutions-section' );
        var fadeOutSpeed = 200;
        var fadeInSpeed  = 300;

        if ( ! $section.length ) {
            return;
        }

        var revealReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
        var revealBoxes   = $section.find( '[data-offshore-solution-reveal].solution_image' ).toArray();

        function playSolutionReveal( box ) {
            if ( ! box || box.classList.contains( 'is-empty' ) ) {
                return;
            }

            if ( revealReduced ) {
                box.classList.add( 'is-visible' );
                return;
            }

            box.classList.remove( 'is-visible' );
            void box.offsetWidth;
            box.classList.add( 'is-visible' );
        }

        $section.find( '.solution_pane.active' ).show();
        $section.find( '.solution_image.active' ).show();

        if ( revealBoxes.length && ! revealReduced && typeof IntersectionObserver !== 'undefined' ) {
            var revealObserver = new IntersectionObserver( function ( entries ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        playSolutionReveal( entry.target );
                        revealObserver.unobserve( entry.target );
                    }
                } );
            }, { threshold: 0.3 } );

            revealBoxes.forEach( function ( box ) {
                if ( box.classList.contains( 'active' ) ) {
                    revealObserver.observe( box );
                }
            } );
        } else if ( revealBoxes.length ) {
            revealBoxes.forEach( function ( box ) {
                playSolutionReveal( box );
            } );
        }

        $section.on( 'click', '.solution_btn', function () {
            var $button      = $( this );
            var $scope       = $button.closest( '.iec-offshore-solutions-section' );
            var targetId     = $button.data( 'target' );
            var slideIndex   = String( targetId ).replace( 'solution-pane-', '' );
            var $nextPane    = $scope.find( '#' + targetId );
            var $nextImage   = $scope.find( '.solution_image[data-slide="' + slideIndex + '"]' );
            var $activePane  = $scope.find( '.solution_pane.active' );
            var $activeImage = $scope.find( '.solution_image.active' );

            if ( $button.hasClass( 'active' ) ) {
                return;
            }

            $scope.find( '.solution_btn' ).removeClass( 'active' );
            $button.addClass( 'active' );

            $activePane.fadeOut( fadeOutSpeed, function () {
                $( this ).removeClass( 'active' );
                $nextPane.addClass( 'active' ).fadeIn( fadeInSpeed );
            } );

            $activeImage.removeClass( 'active' );

            if ( $nextImage.length && ! $nextImage.hasClass( 'is-empty' ) ) {
                $nextImage.addClass( 'active' );
                playSolutionReveal( $nextImage.get( 0 ) );
            }
        } );
    }( jQuery ));
</script>
