<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();

if ( empty( $section ) ) {
	return;
}

$heading = $section['heading'] ?? '';
$content = $section['content'] ?? '';
$layers = $section['network_layers'] ?? array();

if ( empty( $layers ) ) {
	return;
}

$plus_url  = '/wp-content/uploads/2026/08/plus.svg';
$arrow_url = '/wp-content/uploads/2026/08/arrow.svg';
$last_index = count( $layers ) - 1;
?>

<section class="iec_defualt_position iec_section_home_network_layer">
    <div id="iec-home-network-particles" class="iec_home_network_particles" aria-hidden="true"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_home_network_layer_header" >
                    <?php if ( $heading ) : ?>

                        <h2 class="iec_section_heading"><?= $heading; ?></h2>

                    <?php endif; ?>

                    <?php if ( $content ) : ?>

                        <div class="wysiwyg-content" data-aos="fade-up"><?= $content; ?></div>

                    <?php endif; ?>
                </div>

                <div class="iec_home_network_layer_icon_warpper">
                    <?php foreach ( $layers as $index => $layer ) : ?>
                        <?php
                        $title       = trim( (string) ( $layer['title'] ?? '' ) );
                        $label       = trim( (string) ( $layer['label'] ?? '' ) );
                        $description = $layer['description'] ?? '';
                        $map_image   = $layer['map_image'] ?? null;
                        $img_url     = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $map_image ) : ( $map_image['url'] ?? '' );
                        $img_id      = is_array( $map_image ) && ! empty( $map_image['ID'] ) ? (int) $map_image['ID'] : ( is_numeric( $map_image ) ? (int) $map_image : 0 );

                        if ( $img_id < 1 && $img_url ) {
                            $img_id = (int) attachment_url_to_postid( $img_url );
                        }
                        $is_last     = ( $index === $last_index );
                        ?>
                        <article class="iec_home_network_layer_icon_box" tabindex="0" data-aos="fade-up" data-aos-delay="<?= esc_attr( (string) ( $index * 100 ) ); ?>">
                            <?php if ( $img_id ) : ?>

                                <?= wp_get_attachment_image( $img_id, 'medium', false, array( 'alt' => $title ) ); ?>

                            <?php endif; ?>

                            <?php if ( $is_last ) : ?>

                                <?php if ( $title ) : ?>

                                    <span><?= $title; ?></span>

                                <?php endif; ?>

                                <?php if ( $label ) : ?>

                                    <h3><?= $label; ?></h3>

                                <?php endif; ?>

                            <?php else : ?>

                                <?php if ( $title ) : ?>

                                    <h3><?= $title; ?></h3>

                                <?php endif; ?>

                                <?php if ( $label ) : ?>

                                    <span><?= $label; ?></span>

                                <?php endif; ?>

                                <?php if ( $description ) : ?>

                                    <div class="iec_home_network_detail"><?= $description; ?></div>

                                <?php endif; ?>

                            <?php endif; ?>
                        </article>
                        <?php if ( ! $is_last ) : ?>

                            <?php if ( $index === $last_index - 1 ) : ?>

                                <div class="iec_home_network_layer_icon_arrow" aria-hidden="true">
                                    <img src="<?= esc_url( $arrow_url ); ?>" width="20" height="15" alt="">
                                </div>

                            <?php else : ?>

                                <div class="iec_home_network_layer_icon_plus" aria-hidden="true">
                                    <img src="<?= esc_url( $plus_url ); ?>" width="30" height="30" alt="">
                                </div>

                            <?php endif; ?>

                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
