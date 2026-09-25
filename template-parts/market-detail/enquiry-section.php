<?php
/**
 * Market detail — intro, downloads, and sidebar enquiry form.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$caption            = $args['caption'] ?? '';
$content            = $args['content'] ?? '';
$downloads          = $args['downloads'] ?? array();
$countries          = $args['countries'] ?? array();
$form_interests     = $args['form_interests'] ?? array();
$hear_source        = $args['hear_source'] ?? array();
$success_popup_html = $args['success_popup_html'] ?? '';

if ( ! is_array( $downloads ) ) {
	$downloads = array();
}

?>

<section class="iec_iot_enquriy_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<?php if ( $caption || $content || ! empty( $downloads ) ) : ?>
				<div class="iec_iot_enquriy_content_warpper">
					<?php if ( $caption ) : ?>
						<h3 class="iec_iot_section_heading"><?= $caption; ?></h3>
					<?php endif; ?>

					<?php if ( $content ) : ?>
						<?= wp_kses_post( $content ); ?>
					<?php endif; ?>

					<?php foreach ( $downloads as $download ) : ?>
						<?php
						if ( ! is_array( $download ) || empty( $download['download_file']['url'] ) ) {
							continue;
						}
						$dl_url            = (string) $download['download_file']['url'];
						$has_both_captions = ! empty( $download['caption'] ) && ! empty( $download['sub_caption'] );
						?>
						<a href="<?= esc_url( $dl_url ); ?>" download class="download-button">
							<div class="icon"></div>
							<div class="text <?= $has_both_captions ? '' : 'has-one-caption'; ?>">
								<?php if ( ! empty( $download['caption'] ) ) : ?>
									<span class="caption"><?= $download['caption']; ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $download['sub_caption'] ) ) : ?>
									<span class="<?= empty( $download['caption'] ) ? 'caption' : 'sub-caption'; ?>"><?= $download['sub_caption']; ?></span>
								<?php endif; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-4">
				<?php
				get_template_part(
					'template-parts/modules/sidebar',
					'enquiry-form',
					array(
						'form_type'          => 'market-enquiry',
						'countries'          => $countries,
						'form_interests'     => $form_interests,
						'hear_source'        => $hear_source,
						'success_popup_html' => $success_popup_html,
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
