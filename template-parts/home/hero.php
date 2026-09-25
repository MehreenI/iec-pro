<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero = $args['hero'] ?? array();

$heading        = $hero['heading'] ?? '';
$content        = $hero['content'] ?? '';
$buttons        = $hero['buttons'] ?? array();
$gallery        = $hero['gallery'] ?? array();
$mobile_gallery = $hero['mobile_gallery'] ?? array();
$bg = $hero['background_image'] ?? null;

$normalize_gallery = static function ( $items ) {
    $slides = array();

	foreach ( $items as $img ) {

		if ( ! is_array( $img ) ) {
			continue;
		}

		$img_id  = $img['ID'] ?? 0;
		$img_url = $img['url'] ?? '';

		if ( ! $img_id && ! $img_url ) {
			continue;
		}
        $slides[] = array(
            'id'    => $img_id,
            'src'   => $img_url,
            'alt'   => $img['alt'] ?? '',
            'name'  => $img['title'] ?? '',
            'focal' => 'center center',
        );
    }

    return $slides;
};

$desktop_slides = $normalize_gallery( $gallery );
$mobile_slides  = $normalize_gallery( $mobile_gallery );

if ( empty( $desktop_slides ) && $bg ) {
	$desktop_slides = $normalize_gallery( array( $bg ) );
}

if ( empty( $desktop_slides ) && ! empty( $mobile_slides ) ) {
	$desktop_slides = $mobile_slides;
	$mobile_slides  = array();
}

$has_mobile_gallery = ! empty( $mobile_slides );

if ( empty( $desktop_slides ) && ! $heading ) {
	return;
}

$cta_links = array();

foreach ( $buttons as $row ) {

	if ( ! is_array( $row ) ) {
		continue;
	}

	$link = $row['link'] ?? null;

	if ( empty( $link['url'] ) || empty( $link['title'] ) ) {
		continue;
	}
    $cta_links[] = array(
        'url'    => function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : (string) $link['url'],
        'title'  => $link['title'] ?? '',
        'target' => $link['target'] ?? '',
    );
}

$content_text = trim( wp_strip_all_tags( $content ) );
$cycle_id = 'iec-home-hero-cycle-' . wp_unique_id();

$render_hero_img = static function ( $image, $index, $priority = false ) {
	if ( empty( $image['id'] ) && ! empty( $image['src'] ) ) {
		$image['id'] = (int) attachment_url_to_postid( $image['src'] );
	}

	if ( empty( $image['id'] ) ) {
		return;
	}


    $attrs = array(
        'class'    => 'iec_home_hero_bg_img',
        'style'    => 'object-position: ' . $image['focal'] . ';',
        'loading'  => 0 === (int) $index ? 'eager' : 'lazy',
        'decoding' => 'async',
        'alt'      => $image['alt'] ? $image['alt'] : '',
    );

	if ( $priority ) {
		$attrs['fetchpriority'] = 'high';
	}

	echo wp_get_attachment_image( (int) $image['id'], 'full', false, $attrs );
};

$render_hero_track = static function ( $slides, $track_class, $track_key, $priority ) use ( $render_hero_img ) {

	if ( empty( $slides ) ) {
		return;
	}
    ?>
    <div
            class="iec_home_hero_bg <?= esc_attr( $track_class ); ?>"
            data-iec-hero-track="<?= esc_attr( $track_key ); ?>"
            aria-hidden="true"
    >
        <?php foreach ( $slides as $i => $slide ) : ?>
            <figure
                    class="iec_home_hero_slide<?= 0 === (int) $i ? ' is-active' : ''; ?>"
                    data-slide-index="<?= esc_attr( (string) $i ); ?>"
            >
                <?php $render_hero_img( $slide, $i, $priority && 0 === (int) $i ); ?>
            </figure>
        <?php endforeach; ?>
    </div>
    <?php
};

$render_hero_dots = static function ( $slides, $track_key ) {

	if ( count( $slides ) < 2 ) {
		return;
	}
    ?>
    <div
            class="iec_home_hero_controls iec_home_hero_controls--<?= esc_attr( $track_key ); ?>"
            data-iec-hero-dots="<?= esc_attr( $track_key ); ?>"
    >
        <div class="iec_home_hero_dots" role="tablist" aria-label="Hero slides"></div>
    </div>
    <?php
};

$section_class = 'iec_defualt_position iec_section_home_hero iec_section_home_hero--cycle iec-anim-hero-curtain iec-anim-particles iec-anim-spotlight';

if ( $has_mobile_gallery ) {
	$section_class .= ' has-mobile-hero-bg';
}
?>

<section
        id="<?= esc_attr( $cycle_id ); ?>"
        class="<?= esc_attr( $section_class ); ?>"
        data-iec-hero-cycle="1"
        data-iec-particle-count="16"
        aria-label="Main Hero Banner"
>
    <div class="iec-anim-curtain" aria-hidden="true">
        <span class="iec-anim-curtain-panel"></span>
        <span class="iec-anim-curtain-panel"></span>
        <span class="iec-anim-curtain-panel"></span>
    </div>

    <?php
    $render_hero_track( $desktop_slides, 'bg-hero-img-desktop', 'desktop', true );

    if ( $has_mobile_gallery ) {
        $render_hero_track( $mobile_slides, 'bg-hero-img-mobile', 'mobile', false );
    }
    ?>

    <div class="iec_home_hero_shade" aria-hidden="true"></div>
    <div class="iec_home_hero_bloom" aria-hidden="true"></div>

    <div class="iec_home_hero_contain iec-anim-hero-content container">
        <?php if ( $heading ) : ?>

            <h1 class="iec_primary_heading iec_home_hero_anim"><?= $heading; ?></h1>

        <?php endif; ?>

        <?php if ( $content_text ) : ?>

            <div class="iec_sub_heading_content iec_home_hero_anim bd_wysiwyg">
                <?= $content; ?>
            </div>

        <?php endif; ?>

        <?php if ( ! empty( $cta_links ) ) : ?>

            <div class="iec_home_hero_actions">
                <?php foreach ( $cta_links as $index => $cta ) : ?>
                    <?php $btn_class = ( 0 !== (int) $index % 2 ) ? ' outline_btn' : ''; ?>
                    <a
                            href="<?= esc_url( $cta['url'] ); ?>"
                            class="iec_home_hero_cta iec_home_hero_anim<?= esc_attr( $btn_class ); ?>"
                        <?= $cta['target'] ? ' target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
                        <?= '_blank' === $cta['target'] ? ' rel="noopener noreferrer"' : ''; ?>
                    ><?= esc_html( $cta['title'] ); ?></a>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

    <?php
    $render_hero_dots( $desktop_slides, 'desktop' );

    if ( $has_mobile_gallery ) {
        $render_hero_dots( $mobile_slides, 'mobile' );
    }
    ?> 

</section>
