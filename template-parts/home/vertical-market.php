<?php
/**
 * Home vertical markets widget.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$vertical_markets = $args['vertical_markets'] ?? array();

if ( empty( $vertical_markets ) ) {
    return;
}

$maritime_bg   = $vertical_markets['background_image']['url'] ?? '';
$land_bg       = $vertical_markets['land_background_image']['url'] ?? '';
$sea_items     = $vertical_markets['vertical_markets'] ?? array();
$land_items    = $vertical_markets['vertical_markets_land'] ?? array();
$maritime_head = $vertical_markets['maritime_heading'] ?? '';
$land_head     = $vertical_markets['land_heading'] ?? '';
?>

<section class="vertical-markets-widget-v2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="bd_icet_vm_warpper">
                    <div class="left-block">
                        <ul class="markets-widget-list">
                            <?php if ( $maritime_bg ) : ?>
                                <li class="main-widget-item">
                                    <div class="vm-panel" style="background-image: url(<?php echo esc_url( $maritime_bg ); ?>);">
                                        <span><?php echo $maritime_head; ?></span>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <?php foreach ( $sea_items as $item ) : ?>
                                <?php
                                $item_bg   = $item['background_image']['url'] ?? '';
                                $item_link = $item['link'] ?? '';
                                $item_link = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $item_link ) : $item_link;
                                $item_title = $item['title'] ?? '';
                                if ( ! $item_bg || ! $item_link ) {
                                    continue;
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $item_link ); ?>">
                                        <div class="vm-panel" style="background-image: url(<?php echo esc_url( $item_bg ); ?>);">
                                            <span><?php echo $item_title; ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="right-block">
                        <ul class="markets-widget-list">
                            <?php foreach ( $land_items as $item ) : ?>
                                <?php
                                $item_bg    = $item['background_image']['url'] ?? '';
                                $item_link  = $item['page_link'] ?? '';
                                $item_link  = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $item_link ) : $item_link;
                                $item_title = $item['title'] ?? '';
                                if ( ! $item_bg || ! $item_link ) {
                                    continue;
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $item_link ); ?>">
                                        <div class="vm-panel" style="background-image: url(<?php echo esc_url( $item_bg ); ?>);">
                                            <span><?php echo $item_title; ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                            <?php if ( $land_bg ) : ?>
                                <li class="main-widget-item">
                                    <div class="vm-panel" style="background-image: url(<?php echo esc_url( $land_bg ); ?>);">
                                        <span><?php echo $land_head; ?></span>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
