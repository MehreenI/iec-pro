<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items         = is_array( $args['items'] ?? null ) ? $args['items'] : array();
$heading       = $args['heading'] ?? __( 'USE CASES', 'bbtheme' );
$heading_class = trim( (string) ( $args['heading_class'] ?? 'directions__main' ) );
$attr          = $args['attr'] ?? '';

if ( empty( $items ) ) {
	return;
}
?>
<section class="directions iec_optiview_directions" <?= $attr; ?> <?= $heading ? 'aria-labelledby="iec-use-case-slider-title"' : ''; ?>>

	<div class="directions__bg" aria-hidden="true">
		<?php foreach ( $items as $index => $case ) : ?>
			<?php if ( ! empty( $case['background']['ID'] ) ) : ?>
				<?= wp_get_attachment_image(
					$case['background']['ID'],
					'full',
					false,
					array(
						'alt'   => '',
						'class' => 0 === $index ? 'active-bg' : '',
					)
				); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

	<div class="container">
		<div class="directions__wrapper">
			<div class="directions__container">

				<?php if ( $heading ) : ?>
					<h2 id="iec-use-case-slider-title" class="<?= $heading_class; ?>"><?= $heading; ?></h2>
				<?php endif; ?>

				<div class="swiper swiper__directions-left vms__directions-left">
					<div class="swiper-wrapper">
						<?php foreach ( $items as $index => $case ) : ?>
							<div class="swiper-slide"<?= 0 === $index ? '' : ' aria-hidden="true"'; ?>>
								<?php if ( ! empty( $case['title'] ) ) : ?>
									<p class="directions__title"><?= $case['title']; ?></p>
								<?php endif; ?>

								<?php if ( ! empty( $case['description'] ) ) : ?>
									<div class="directions__desc">
										<?= wpautop( $case['description'] ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swiper swiper__directions-right vms__directions-right">
					<div class="swiper-wrapper">
						<?php foreach ( $items as $index => $case ) : ?>
							<div class="swiper-slide"<?= 0 === $index ? '' : ' aria-hidden="true"'; ?>>
								<?php if ( ! empty( $case['image']['ID'] ) ) : ?>
									<?= wp_get_attachment_image(
										$case['image']['ID'],
										'full',
										false,
										array( 'alt' => $case['title'] ?? '' )
									); ?>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swiper-button-next vms-swiper-button-next" aria-label="<?= __( 'Next slide', 'bbtheme' ); ?>">
					<svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M0 0.5L15.2337 0.5L30.7269 15.522L15.3634 31.5L0 31.5L15.3634 16L0 0.5Z" fill="#727DA4" fill-opacity="0.5"></path>
					</svg>
				</div>

				<div class="swiper-button-prev vms-swiper-button-prev" aria-label="<?= __( 'Previous slide', 'bbtheme' ); ?>">
					<svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M30.7269 31.5L15.4932 31.5L-2.50143e-06 16.478L15.3634 0.499999L30.7269 0.5L15.3634 16L30.7269 31.5Z" fill="#727DA4" fill-opacity="0.5"></path>
					</svg>
				</div>

			</div>

			<div class="swiper-pagination vms-swiper-pagination" aria-label="<?= __( 'Use case slides', 'bbtheme' ); ?>"></div>
		</div>
	</div>

</section>
