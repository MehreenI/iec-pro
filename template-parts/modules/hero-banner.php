<?php
/**
 * Hero banner with CSS variable --bgImage.
 *
 * @package iec
 *
 * @var array $args {
 *     @type string $image_url         Background image URL.
 *     @type string $title             Optional H1 in overlay.
 *     @type bool   $show_back_link    Show return-back control.
 *     @type string $section_class     Extra section classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$image_url     = $args['image_url'] ?? '';
$image_id      = (int) ( $args['image_id'] ?? 0 );
$title         = $args['title'] ?? '';
$title_tag     = ( isset( $args['title_tag'] ) && 'p' === $args['title_tag'] ) ? 'p' : 'h1';
$show_back     = ! empty( $args['show_back_link'] );
$section_class = $args['section_class'] ?? 'iec_optisim_hero_banner';
$style_attr    = ( $image_id < 1 && $image_url ) ? '--bgImage: url(' . esc_url( $image_url ) . ');' : '';
?>
<section class="iec_hero_banner iec_hero_content_banner <?= esc_attr( $section_class ); ?> iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"<?= $style_attr ? ' style="' . esc_attr( $style_attr ) . '"' : ''; ?>>

	<?php if ( $image_id > 0 ) : ?>

		<div class="iec_hero_banner__media" aria-hidden="true">
			<?= wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'iec_hero_banner__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?>
		</div>

	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( $show_back ) : ?>
					<div class="iec_return_link">
						<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M9.22004 0.284552C9.12191 0.23294 9.0115 0.209219 8.90083 0.215969C8.79015 0.222718 8.68345 0.25968 8.59231 0.322835L0.692563 5.79189C0.612082 5.84806 0.546354 5.92283 0.50097 6.00985C0.455585 6.09687 0.431885 6.19356 0.431885 6.29171C0.431885 6.38985 0.455585 6.48654 0.50097 6.57356C0.546354 6.66058 0.612082 6.73535 0.692563 6.79152L8.59231 12.2606C8.68348 12.3237 8.79017 12.3606 8.90082 12.3674C9.01148 12.3742 9.12188 12.3506 9.22008 12.2991C9.31829 12.2477 9.40054 12.1704 9.45795 12.0755C9.51535 11.9807 9.54572 11.8719 9.54575 11.7611V0.822951C9.54577 0.712028 9.51543 0.603216 9.45801 0.508309C9.4006 0.413402 9.3183 0.33602 9.22004 0.284552Z" fill="url(#paint0_linear_53_7)" />
							<defs>
								<linearGradient id="paint0_linear_53_7" x1="2.59197" y1="6.14302" x2="11.0106" y2="8.69411" gradientUnits="userSpaceOnUse">
									<stop stop-color="#1B204C" />
									<stop offset="1" stop-color="#727DA3" />
								</linearGradient>
							</defs>
						</svg>
						<a href="<?= esc_url( home_url( '/' ) ); ?>" onclick="if ( history.length > 1 ) { event.preventDefault(); history.back(); }"><?= 'Return Back'; ?></a>
					</div>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<div class="iec_hero_content_box">
						<<?= $title_tag; ?> class="iec_main_heading iec_tect_decoration_none"><?= $title; ?></<?= $title_tag; ?>>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
