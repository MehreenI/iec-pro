<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$modal  = $fields['coming_soon_modal'] ?? array();

if ( ! is_array( $modal ) || empty( $modal ) ) {
	$modal = get_field( 'coming_soon_modal' ) ?: array();
}

$modal = is_array( $modal ) ? $modal : array();

$eyebrow           = $modal['eyebrow'] ?? '';
$tagline           = $modal['tagline'] ?? '';
$intro             = $modal['feature_intro'] ?? '';
$features          = $modal['features'] ?? array();
$notify_heading    = $modal['notify_heading'] ?? '';
$notify_copy       = $modal['notify_copy'] ?? '';
$email_placeholder = $modal['email_placeholder'] ?? '';
$notify_button     = $modal['notify_button'] ?? '';
$notify_success    = $modal['notify_success'] ?? '';
$footer_message    = $modal['footer_message'] ?? '';
$iec_logo          = $modal['iec_logo'] ?? array();
$iec_logo_alt      = ( $modal['iec_logo_alt'] ?? '' ) ?: __( 'IEC Telecom', 'bbtheme' );
$logo              = $modal['logo'] ?? array();
$logo_alt          = ( $modal['logo_alt'] ?? '' ) ?: __( 'OptiView', 'bbtheme' );
$screen_top        = $modal['screen_top'] ?? array();
$screen_middle     = $modal['screen_middle'] ?? array();
$screen_bottom     = $modal['screen_bottom'] ?? array();
$arrow             = $modal['arrow'] ?? $modal['notify_arrow'] ?? array();
$close_icon        = $modal['close_icon'] ?? $modal['close'] ?? array();
$privacy_url       = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( home_url( '/privacy/' ) ) : home_url( '/privacy/' );
$dialog_title      = $logo_alt ?: __( 'OptiView coming soon', 'bbtheme' );

if ( ! $eyebrow && ! $tagline && ! $intro && empty( $features ) && ! $notify_heading && empty( $logo['ID'] ) && empty( $iec_logo['ID'] ) ) {
	return;
}
?>
<div class="iec_optiview_modal_overlay" id="iec-optiview-modal" hidden aria-hidden="true" role="presentation">
	<div class="iec_optiview_modal" role="dialog" aria-modal="true" aria-labelledby="iec-optiview-modal-title" tabindex="-1">
		<h2 id="iec-optiview-modal-title" class="sr-only"><?= $dialog_title; ?></h2>

		<?php if ( ! empty( $screen_top['ID'] ) || ! empty( $screen_middle['ID'] ) || ! empty( $screen_bottom['ID'] ) ) : ?>
			<div class="product-screens" aria-hidden="true">
				<?php if ( ! empty( $screen_top['ID'] ) ) : ?>
					<?= wp_get_attachment_image( $screen_top['ID'], 'full', false, array( 'alt' => '', 'class' => 'screen screen--top' ) ); ?>
				<?php endif; ?>

				<?php if ( ! empty( $screen_middle['ID'] ) ) : ?>
					<?= wp_get_attachment_image( $screen_middle['ID'], 'full', false, array( 'alt' => '', 'class' => 'screen screen--middle' ) ); ?>
				<?php endif; ?>

				<?php if ( ! empty( $screen_bottom['ID'] ) ) : ?>
					<?= wp_get_attachment_image( $screen_bottom['ID'], 'full', false, array( 'alt' => '', 'class' => 'screen screen--bottom' ) ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="modal-header">
			<?php if ( ! empty( $iec_logo['ID'] ) ) : ?>
				<?= wp_get_attachment_image( $iec_logo['ID'], 'full', false, array( 'alt' => $iec_logo_alt, 'class' => 'iec-logo' ) ); ?>
			<?php endif; ?>
			<button class="close-button" type="button" aria-label="<?= __( 'Close', 'bbtheme' ); ?>">
				<?php if ( ! empty( $close_icon['ID'] ) ) : ?>
					<?= wp_get_attachment_image( $close_icon['ID'], 'full', false, array( 'alt' => '' ) ); ?>
				<?php endif; ?>
			</button>
		</div>

		<div class="modal-content">
			<div class="intro-block">
				<div class="intro-copy">
					<?php if ( $eyebrow ) : ?>
						<span class="coming-soon"><?= $eyebrow; ?></span>
					<?php endif; ?>
					<div class="brand-lockup">
						<?php if ( ! empty( $logo['ID'] ) ) : ?>
							<?= wp_get_attachment_image( $logo['ID'], 'full', false, array( 'alt' => $logo_alt, 'class' => 'optiview-logo' ) ); ?>
						<?php endif; ?>

						<?php if ( $tagline ) : ?>
							<p class="tagline"><?= $tagline; ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( $intro || $features ) : ?>
				<div class="feature-section">
					<?php if ( $intro ) : ?>
						<p class="feature-intro"><?= $intro; ?></p>
					<?php endif; ?>

					<?php if ( $features ) : ?>
						<div class="features-grid">
							<?php foreach ( $features as $i => $feature ) : ?>
								<div class="feature-card">
									<?php if ( ! empty( $feature['icon']['ID'] ) ) : ?>
										<?= wp_get_attachment_image( $feature['icon']['ID'], 'full', false, array( 'alt' => '', 'class' => 'feature-icon' ) ); ?>
									<?php endif; ?>

									<?php if ( ! empty( $feature['title'] ) ) : ?>
										<p><?= $feature['title']; ?></p>
									<?php endif; ?>
								</div>
								<?php if ( $i < count( $features ) - 1 ) : ?>
									<span class="feature-divider" aria-hidden="true"></span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="notify-section">
				<div class="notify-row">
					<?php if ( $notify_heading || $notify_copy ) : ?>
						<div class="notify-copy">
							<?php if ( $notify_heading ) : ?>
								<strong><?= $notify_heading; ?></strong>
							<?php endif; ?>

							<?php if ( $notify_copy ) : ?>
								<span><?= $notify_copy; ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<form class="notify-form" action="<?= admin_url( 'admin-ajax.php' ); ?>" method="post" novalidate>
						<div class="notify-form-fields">
							<label class="sr-only" for="iec-optiview-notify-email"><?= __( 'Email address', 'bbtheme' ); ?></label>
							<input
								id="iec-optiview-notify-email"
								type="email"
								name="email"
								placeholder="<?= $email_placeholder; ?>"
								autocomplete="email"
								inputmode="email"
								required
								aria-required="true"
								aria-describedby="iec-optiview-notify-status"
							>
							<button class="notify-button" type="submit" data-success-label="<?= $notify_success; ?>">
								<?php if ( $notify_button ) : ?>
									<span><?= $notify_button; ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $arrow['ID'] ) ) : ?>
									<?= wp_get_attachment_image( $arrow['ID'], 'full', false, array( 'alt' => '' ) ); ?>
								<?php endif; ?>
							</button>
						</div>
						<div class="notify-consent">
							<input id="iec-optiview-notify-consent" type="checkbox" name="gdpr_consent" value="1" required aria-required="true">
							<label for="iec-optiview-notify-consent">
								<?= sprintf(
									__( 'I agree to the <a href="%s" target="_blank" rel="noopener noreferrer">Privacy Policy</a> and consent to IEC Telecom storing my email to notify me when Optiview is available.', 'bbtheme' ),
									$privacy_url
								); ?>
							</label>
						</div>
						<p class="notify-status" id="iec-optiview-notify-status" role="status" aria-live="polite"></p>
					</form>
				</div>

				<?php if ( $footer_message ) : ?>
					<div class="footer-message">
						<span class="footer-line" aria-hidden="true"></span>
						<p><?= $footer_message; ?></p>
						<span class="footer-line" aria-hidden="true"></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
