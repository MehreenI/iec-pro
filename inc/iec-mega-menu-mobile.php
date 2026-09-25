<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$items = IEC_Mega_Menu_Render::visible_sorted( isset( $items ) ? $items : array() );
$cta   = isset( $cta ) ? $cta : array();
?>
<div class="iec_mobile_navigation" data-iec-mega-menu="mobile">
    <div class="iec_mobile_menu">
        <?php foreach ( $items as $dropdown ) : ?>
            <?php
            $columns = IEC_Mega_Menu_Render::visible_sorted( isset( $dropdown['children'] ) ? $dropdown['children'] : array() );

            if ( empty( $columns ) ) {
                continue;
            }

            $view_all     = null;
            $featured_btn = null;
            ?>
            <div class="iec_mobile_dropdown" data-id="<?= esc_attr( $dropdown['id'] ); ?>">
                <button class="iec_mobile_toggle" type="button">
                    <span><?= IEC_Mega_Menu_Resolver::get_label( $dropdown ); ?></span>
                    <?= IEC_Mega_Menu_Icons::chevron_mobile(); ?>
                </button>

                <div class="iec_mobile_submenu">
                    <?php foreach ( $columns as $column ) : ?>
                        <?php
                        $col_type = strtolower( (string) ( isset( $column['item_type'] ) ? $column['item_type'] : 'column' ) );
                        $kids     = IEC_Mega_Menu_Render::visible_sorted( isset( $column['children'] ) ? $column['children'] : array() );

                        if ( 'explore' === $col_type ) {
                            foreach ( $kids as $kid ) {
                                if ( in_array( $kid['item_type'] ?? '', array( 'cta', 'link' ), true ) ) {
                                    $view_all = $kid;
                                    break;
                                }
                            }

                            if ( ! $view_all ) {
                                $view_all = $column;
                            }
                            continue;
                        }

                        if ( 'featured' === $col_type ) {
                            foreach ( $kids as $kid ) {
                                $kid_type = isset( $kid['item_type'] ) ? $kid['item_type'] : '';
                                if ( ! in_array( $kid_type, array( 'card', 'link', 'cta' ), true ) ) {
                                    continue;
                                }

                                if ( ! $featured_btn ) {
                                    $featured_btn = $kid;
                                }
                            }

                            if ( ! $featured_btn ) {
                                $featured_btn = $column;
                            }
                            continue;
                        }
                        ?>
                        <div class="iec_mobile_card" data-id="<?= esc_attr( $column['id'] ); ?>">
                            <button class="iec_mobile_card_toggle" type="button">
                                <div class="iec_mega_menu_column_title_icon">
                                    <?= IEC_Mega_Menu_Icons::render_icon( $column ); // phpcs:ignore ?>
                                </div>
                                <span><?= IEC_Mega_Menu_Resolver::get_label( $column ); ?></span>
                                <?= IEC_Mega_Menu_Icons::chevron_right(); // phpcs:ignore ?>
                            </button>
                            <ul class="iec_mobile_links">
                                <?php foreach ( $kids as $kid ) : ?>
                                    <?php if ( 'cta' === ( $kid['item_type'] ?? '' ) && empty( $kid['path'] ) && empty( $kid['url'] ) && empty( $kid['object_id'] ) ) { continue; } ?>
                                    <li>
                                        <?= IEC_Mega_Menu_Render::anchor_open( $kid ); // phpcs:ignore ?>
                                        <?= IEC_Mega_Menu_Resolver::get_label( $kid ); ?>
                                        <?= IEC_Mega_Menu_Icons::chevron_right(); // phpcs:ignore ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>

                    <?php
                    $mobile_btn = $view_all ? $view_all : $featured_btn;
                    if ( $mobile_btn ) :
                        $btn_label = IEC_Mega_Menu_Resolver::get_node_string( $mobile_btn, 'cta_label', '' );
                        if ( '' === $btn_label ) {
                            $btn_label = IEC_Mega_Menu_Resolver::get_label( $mobile_btn );
                        }

                        if ( '' === $btn_label ) {
                            $btn_label = 'Explore';
                        }
                        echo IEC_Mega_Menu_Render::anchor_open( $mobile_btn, 'iec_mobile_btn' );
                        echo $btn_label;
                        echo '</a>';
                    endif;
                    ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <?php if ( ! empty( $cta ) && ( ! isset( $cta['visible'] ) || ! empty( $cta['visible'] ) ) ) : ?>
        <?= IEC_Mega_Menu_Render::anchor_open( $cta, 'iec_button iec_blue_gradient' ); // phpcs:ignore ?>
        <?php
        $cta_label = IEC_Mega_Menu_Resolver::get_label( $cta );
        echo '' !== $cta_label ? $cta_label : 'CONTACT US';
        ?>
        </a>
    <?php endif; ?>
</div>
