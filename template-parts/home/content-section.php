<?php
/**
 * Home text content block.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section       = $args['section'] ?? array();
$class         = $args['class'] ?? '';
$show_button   = ! empty( $args['show_button'] );
$button_column = ! empty( $args['button_column'] );

if ( empty( $section['title'] ) && empty( $section['description'] ) ) {
    return;
}

$button      = $section['link_button'] ?? array();
$button_url  = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $button ) : ( $button['url'] ?? '' );
$button_text = $button['title'] ?? '';
$has_button  = $show_button && $button_url && $button_text;
$heading_tag = ( 'section1-v2' === $class ) ? 'h1' : 'h2';
?>

<section class="<?php echo esc_attr( $class ); ?>">
    <div class="container">
        <div class="row<?php echo $button_column ? ' align-items-end' : ''; ?>">
            <div class="<?php echo $button_column ? 'col-md-8' : 'col-md-12'; ?>">
                <div class="iec_home_section_inner">
                    <<?php echo esc_attr( $heading_tag ); ?>><?php echo $section['title']; ?></<?php echo esc_attr( $heading_tag ); ?>>
                <?php echo wp_kses_post( $section['description'] ); ?>

                <?php if ( $has_button && ! $button_column ) : ?>
                    <a href="<?php echo esc_url( $button_url ); ?>" class="iec_button btn btn-primary ms-md-auto me-md-0">
                        <?php echo $button_text; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $button_column && $has_button ) : ?>
            <div class="col-md-4">
                <a href="<?php echo esc_url( $button_url ); ?>" class="iec_button btn btn-primary ms-md-auto me-md-0">
                    <?php echo $button_text; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    </div>
</section>
