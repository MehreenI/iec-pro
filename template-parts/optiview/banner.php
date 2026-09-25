<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields     = $args['fields'] ?? array();
$slides     = $fields['slides'] ?? array();
$info_links = $fields['info_links'] ?? array();
$subtitle   = $fields['subtitle'] ?? '';
$page_title = get_the_title() ?: __( 'OptiView', 'bbtheme' );

if ( empty( $slides ) ) {
	return;
}
?>
<section class="banner iec_optiview_bannaer" data-optiview-banner aria-labelledby="iec-optiview-title">

	<?php foreach ( $slides as $index => $slide ) : ?>
		<?php $eager = 0 === $index; ?>
		<?php if ( ! empty( $slide['background']['ID'] ) ) : ?>
			<?= wp_get_attachment_image(
				$slide['background']['ID'],
				'full',
				false,
				array(
					'alt'           => '',
					'class'         => 'banner__bg',
					'loading'       => $eager ? 'eager' : 'lazy',
					'decoding'      => 'async',
					'fetchpriority' => $eager ? 'high' : 'auto',
					'aria-hidden'   => 'true',
				)
			); ?>
		<?php endif; ?>
	<?php endforeach; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="banner__wrapper">
					<div class="banner__wrapper__info">
						<div class="banner__wrapper__info__top">
							<?php get_template_part( 'template-parts/optiview/logo' ); ?>

							<?php if ( $subtitle && $subtitle !== $page_title ) : ?>
								<h1 id="iec-optiview-title" class="sr-only"><?= $page_title; ?></h1>
								<p class="iec_optiview_banner_subtitle"><?= $subtitle; ?></p>
							<?php else : ?>
								<h1 id="iec-optiview-title"><?= $page_title; ?></h1>
							<?php endif; ?>
						</div>

						<?php if ( $info_links ) : ?>
							<ul class="banner__wrapper__info__links">
								<?php foreach ( $info_links as $item ) : ?>
									<?php if ( ! empty( $item['title'] ) ) : ?>
										<li><span><?= $item['title']; ?></span></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<div class="bd_optiview_slide_buttons">
							<?php foreach ( $slides as $slide ) : ?>
								<?php
								$download_url   = iec_resolve_media_to_url( $slide['download_file'] ?? '' );
								$download_label = $slide['download_button_text'] ?? __( 'Download', 'bbtheme' );
								?>
								<?php if ( $download_url ) : ?>
									<a
										href="<?= $download_url; ?>"
										class="banner__wrapper__info__download"
										download
										aria-label="<?= sprintf( __( 'Download %s', 'bbtheme' ), $download_label ); ?>"
									>
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
											<path d="M7.00016 10.1272C6.88905 10.1272 6.78488 10.1099 6.68766 10.0755C6.59044 10.041 6.50016 9.98188 6.41683 9.89799L3.41683 6.89799C3.25016 6.73133 3.17016 6.53688 3.17683 6.31466C3.1835 6.09244 3.2635 5.89799 3.41683 5.73133C3.5835 5.56466 3.78155 5.47799 4.011 5.47133C4.24044 5.46466 4.43822 5.54438 4.60433 5.71049L6.16683 7.27299V1.31466C6.16683 1.07855 6.24683 0.880771 6.40683 0.721326C6.56683 0.561882 6.76461 0.481882 7.00016 0.481326C7.23572 0.480771 7.43377 0.560771 7.59433 0.721326C7.75489 0.881882 7.83461 1.07966 7.8335 1.31466V7.27299L9.396 5.71049C9.56266 5.54383 9.76072 5.46383 9.99016 5.47049C10.2196 5.47716 10.4174 5.5641 10.5835 5.73133C10.7363 5.89799 10.8163 6.09244 10.8235 6.31466C10.8307 6.53688 10.7507 6.73133 10.5835 6.89799L7.5835 9.89799C7.50016 9.98133 7.40988 10.0405 7.31266 10.0755C7.21544 10.1105 7.11127 10.1277 7.00016 10.1272ZM2.00016 13.8147C1.54183 13.8147 1.14961 13.6516 0.823496 13.3255C0.497385 12.9994 0.334052 12.6069 0.333496 12.148V10.4813C0.333496 10.2452 0.413496 10.0474 0.573496 9.88799C0.733496 9.72855 0.931274 9.64855 1.16683 9.64799C1.40238 9.64744 1.60044 9.72744 1.761 9.88799C1.92155 10.0485 2.00127 10.2463 2.00016 10.4813V12.148H12.0002V10.4813C12.0002 10.2452 12.0802 10.0474 12.2402 9.88799C12.4002 9.72855 12.5979 9.64855 12.8335 9.64799C13.0691 9.64744 13.2671 9.72744 13.4277 9.88799C13.5882 10.0485 13.6679 10.2463 13.6668 10.4813V12.148C13.6668 12.6063 13.5038 12.9988 13.1777 13.3255C12.8516 13.6522 12.4591 13.8152 12.0002 13.8147H2.00016Z" fill="white" />
										</svg>
										<?= $download_label; ?>
									</a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>

						<div class="banner-progress" role="tablist" aria-label="<?= __( 'Banner slides', 'bbtheme' ); ?>">
							<?php foreach ( $slides as $index => $slide ) : ?>
								<?php
								$tab_id   = 'iec-optiview-banner-tab-' . $index;
								$panel_id = 'iec-optiview-banner-panel-' . $index;
								?>
								<button
									type="button"
									id="<?= $tab_id; ?>"
									class="banner-progress__item"
									role="tab"
									aria-controls="<?= $panel_id; ?>"
									aria-selected="<?= 0 === $index ? 'true' : 'false'; ?>"
									aria-label="<?= sprintf( __( 'Slide %d', 'bbtheme' ), $index + 1 ); ?>"
								></button>
							<?php endforeach; ?>
						</div>
					</div>

					<?php foreach ( $slides as $index => $slide ) : ?>
						<?php
						$eager    = 0 === $index;
						$tab_id   = 'iec-optiview-banner-tab-' . $index;
						$panel_id = 'iec-optiview-banner-panel-' . $index;
						$main_attrs = array(
							'alt'             => $eager ? $page_title : '',
							'class'           => 'banner__main',
							'id'              => $panel_id,
							'role'            => 'tabpanel',
							'aria-labelledby' => $tab_id,
							'loading'         => $eager ? 'eager' : 'lazy',
							'decoding'        => 'async',
						);
						if ( ! $eager ) {
							$main_attrs['hidden'] = 'hidden';
						}
						?>
						<?php if ( ! empty( $slide['image']['ID'] ) ) : ?>
							<?= wp_get_attachment_image( $slide['image']['ID'], 'full', false, $main_attrs ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

</section>
