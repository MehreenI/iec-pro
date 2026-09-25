<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading     = get_sub_field( 'sa_heading' ) ?: '';
$description = get_sub_field( 'sa_description' ) ?: '';
$items       = get_sub_field( 'sa_items' ) ?: array();

if ( empty( $items ) ) {
	return;
}

$chevron = '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="white"/></svg>';
?>
<section class="iec-solution-architecture" <?= $heading ? 'aria-labelledby="iec-voucher-architecture-title"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $heading || $description ) : ?>
					<div>
						<?php if ( $heading ) : ?>
							<h2 id="iec-voucher-architecture-title" class="iec_section_heading iec-section-heading mb-0"><?= $heading; ?></h2>
						<?php endif; ?>

						<?php if ( $description ) : ?>
							<div class="iec_main_content_warpper wysiwyg-content">
								<?= $description; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="row iec-arch-cards">
					<?php foreach ( $items as $index => $item ) : ?>
						<?php
						$label    = $item['sa_item_label'] ?? '';
						$subtitle = $item['sa_item_description'] ?? '';
						$body     = $item['body'] ?? '';
						$icon     = $item['sa_item_icon'] ?? array();
						$link     = $item['anchor_link'] ?? '';
						$card_id  = 'sa-card-' . $index;

						$href = '';
						if ( $link ) {
							if ( 0 === strpos( $link, '#' ) ) {
								$href = $link;
							} elseif ( 0 === strpos( $link, 'http' ) ) {
								$href = apply_filters( 'wpml_permalink', $link );
							} else {
								$href = '#' . ltrim( $link, '#' );
							}
						}

						$icon_id = 0;
						if ( is_array( $icon ) && ! empty( $icon['ID'] ) ) {
							$icon_id = (int) $icon['ID'];
						} elseif ( is_numeric( $icon ) ) {
							$icon_id = (int) $icon;
						}
						?>
						<div class="col-md-4">
							<div class="iec-arch-card iec-arch-card--active">

								<div class="card_front" aria-hidden="true">
									<?php if ( $body ) : ?>
										<p class="iec-arch-card__subtitle"><?= $body; ?></p>
									<?php endif; ?>
									<?php if ( $href ) : ?>
										<a href="<?= $href; ?>" class="iec-arch-card__link">
											<?= __( 'More', 'bbtheme' ); ?> <?= $chevron; ?>
										</a>
									<?php endif; ?>
								</div>

								<?php if ( $icon_id ) : ?>
									<div class="iec-arch-card__icon">
										<?= wp_get_attachment_image( $icon_id, 'full', false, array( 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
									</div>
								<?php endif; ?>

								<?php if ( $label ) : ?>
									<h3 class="iec-arch-card__title" id="<?= $card_id; ?>"><?= $label; ?></h3>
								<?php endif; ?>

								<?php if ( $subtitle ) : ?>
									<p class="iec-arch-card__subtitle"><?= $subtitle; ?></p>
								<?php endif; ?>

								<div class="mob_show">
									<?php if ( $body ) : ?>
										<p class="iec-arch-card__subtitle"><?= $body; ?></p>
									<?php endif; ?>
									<?php if ( $href ) : ?>
										<a href="<?= $href; ?>" class="iec-arch-card__link">
											<?= __( 'More', 'bbtheme' ); ?> <?= $chevron; ?>
										</a>
									<?php endif; ?>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
	</div>
</section>
