<?php
/**
 * Product card for product-solution landing grid.
 *
 * Args: post (WP_Post|int).
 *
 * @package iec
 */

$post = $args['post'] ?? null;
$post_id = is_object( $post ) ? (int) $post->ID : (int) $post;
$hide_card_category = ! empty( $args['hide_card_category'] );
$search             = $args['search'] ?? '';

if ( $post_id < 1 ) {
    return;
}

$permalink = get_permalink( $post_id );
if ( ! $permalink ) {
    return;
}

$title      = get_the_title( $post_id );
$title_html = function_exists( 'iec_operators_highlight_search' )
    ? iec_operators_highlight_search( $title, $search )
    : wp_strip_all_tags( (string) $title );

$applications = function_exists( 'get_field' ) ? get_field( 'ps_filter_application', $post_id ) : array();
if ( ! is_array( $applications ) ) {
    $applications = $applications ? array( $applications ) : array();
}

$image_id = (int) get_post_thumbnail_id( $post_id );

if ( $image_id < 1 && function_exists( 'get_field' ) ) {
    $landing = get_field( 'landing_image', $post_id );

    if ( is_array( $landing ) && ! empty( $landing['ID'] ) ) {
        $image_id = (int) $landing['ID'];
    } elseif ( is_numeric( $landing ) ) {
        $image_id = (int) $landing;
    } elseif ( is_string( $landing ) && '' !== $landing ) {
        $image_id = (int) attachment_url_to_postid( $landing );
    }
}

$thumb = '';

if ( $image_id < 1 && function_exists( 'iec_get_post_thumbnail_url' ) ) {
    $thumb = iec_get_post_thumbnail_url( $post_id );
}

if ( $image_id < 1 && '' === $thumb && function_exists( 'iec_solution_card_image_url' ) ) {
    $thumb = iec_solution_card_image_url( $post_id );
}

if ( $image_id < 1 && '' !== $thumb ) {
    $image_id = (int) attachment_url_to_postid( $thumb );
}

if ( $image_id < 1 && '' === $thumb && function_exists( 'bbtheme_get_image_or_placeholder' ) ) {
    $thumb = bbtheme_get_image_or_placeholder( '' );
}

$app_filters = function_exists( 'get_ps_filter_choices' ) ? get_ps_filter_choices( 'application' ) : array();
?>
<a href="<?= esc_url( $permalink ); ?>" class="iec-product-solution-wrapper" data-product-id="<?= esc_attr( (string) $post_id ); ?>">
    <?php if ( $applications !== array() ) : ?>
        <div class="category<?= $hide_card_category ? ' d-none' : ''; ?>">
            <?php foreach ( $applications as $application ) : ?>
                <?php
                $tag_slug = sanitize_html_class( strtolower( str_replace( ' ', '-', (string) $application ) ) );
                $label    = isset( $app_filters[ $application ] ) ? $app_filters[ $application ] : $application;
                ?>
                <p class="<?= esc_attr( $tag_slug ); ?>"><?= $label; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="image">
        <?php if ( $image_id > 0 ) : ?>
            <?= wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'img-fluid', 'alt' => wp_strip_all_tags( (string) $title ), 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
        <?php elseif ( '' !== $thumb ) : ?>
            <img src="<?= esc_url( $thumb ); ?>" alt="<?= esc_attr( wp_strip_all_tags( $title ) ); ?>" class="img-fluid" loading="lazy" decoding="async">
        <?php endif; ?>
    </div>

    <div class="wrapper-content">
        <h3><?= $title_html; ?></h3>
        <span class="link-to">Select</span>
    </div>
</a>
