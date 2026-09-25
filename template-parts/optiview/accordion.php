<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$items  = $fields['items'] ?? array();

if ( empty( $items ) ) {
	return;
}
?>
<section class="iec_optiview_acordion" data-optiview-accordion aria-labelledby="iec-optiview-features-title">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 id="iec-optiview-features-title" class="sr-only"><?= __( 'Features', 'bbtheme' ); ?></h2>
				<div class="iec_optiview_acordion_warpper">
					<?php foreach ( $items as $key => $item ) : ?>
						<?php
						$item_id   = 'item-' . ( (int) $key + 1 );
						$panel_id  = $item_id . '-panel';
						$title_id  = $item_id . '-title';
						$title     = $item['title'] ?? '';
						$subitems  = $item['subitems'] ?? array();
						?>
						<div id="<?= $item_id; ?>" class="acordion__item">
							<h3 id="<?= $title_id; ?>" class="acordion__item__heading">
								<button
									type="button"
									class="acordion__item__trigger"
									aria-expanded="false"
									aria-controls="<?= $panel_id; ?>"
								>
									<span class="acordion__item__trigger__info">
										<?php if ( ! empty( $item['image']['ID'] ) ) : ?>
											<span class="iec_accorediabn_header_image_wrapper">
												<?= wp_get_attachment_image( $item['image']['ID'], 'full', false, array( 'alt' => $title, 'class' => 'iec_img_style' ) ); ?>
											</span>
										<?php endif; ?>

										<?php if ( $title ) : ?>
											<span class="acordion__item__trigger__label"><?= $title; ?></span>
										<?php endif; ?>
									</span>
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<g clip-path="url(#<?= 'clip_acc_' . $item_id; ?>)">
											<path d="M1.59961 4.80005L7.99961 11.2L14.3996 4.80005" stroke="#727DA4" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
										</g>
										<defs>
											<clipPath id="<?= 'clip_acc_' . $item_id; ?>">
												<rect width="16" height="16" fill="white" />
											</clipPath>
										</defs>
									</svg>
								</button>
							</h3>

							<div id="<?= $panel_id; ?>" class="acordion__item__info" role="region" <?= $title ? 'aria-labelledby="' . $title_id . '"' : ''; ?>>
								<?php foreach ( $subitems as $subitem ) : ?>
									<div class="acordion__item__info__value">
										<?php if ( ! empty( $subitem['title'] ) ) : ?>
											<h4><?= $subitem['title']; ?></h4>
										<?php endif; ?>

										<?php if ( ! empty( $subitem['description'] ) ) : ?>
											<p><?= $subitem['description']; ?></p>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
