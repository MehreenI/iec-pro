<?php
/**
 * Sidebar enquiry form.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form_type      = $args['form_type'] ?? $enquiry_form_type ?? 'iot-enquiry';
$form_id        = $args['form_id'] ?? $enquiry_form_id ?? 'enquiry-form-new';
$form_heading   = $args['form_heading'] ?? '';
$countries      = $args['countries'] ?? array();
$form_interests = $args['form_interests'] ?? ( get_config( 'enquiry_form_interest' ) ?: array() );
$hear_source    = $args['hear_source'] ?? ( get_config( 'form_hear_source' ) ?: array() );
$form_option    = get_config( 'form_options' ) ?: array();
$nonce          = wp_create_nonce( 'enquiry_form_nonce' );
$page_url       = get_permalink() ?: home_url( '/' );
$submit_label   = $form_option['button'] ?? __( 'Send', 'bbtheme' );
$required_text  = __( 'This field is required', 'bbtheme' );

$success_popup_html = $args['success_popup_html'] ?? '';
if ( '' === $success_popup_html && ! empty( $success_popup_content ) && isset( $success_popup_content_key ) ) {
	$success_popup_html = $success_popup_content[ $success_popup_content_key ]['content'] ?? '';
}

if ( '' === $form_heading ) {
	$form_heading = $form_option['form_heading'] ?? __( 'Enquiry Now', 'bbtheme' );
}

if ( function_exists( 'iec_turnstile_site_key' ) ) {
	$captcha_key = iec_turnstile_site_key();
} elseif ( function_exists( 'iec_recaptcha_site_key' ) ) {
	$captcha_key = iec_recaptcha_site_key();
} else {
	$captcha_key = '';
}

$interest_query = isset( $_GET['interest'] ) ? sanitize_text_field( wp_unslash( $_GET['interest'] ) ) : '';
?>

<div class="iec_form_warpper iec_iot_form_warpper iec-enquiry-root">
	<form
		action="<?= esc_url( get_ajax_url( 'enquiry', 'save_new' ) ); ?>"
		method="post"
		id="<?= esc_attr( $form_id ); ?>"
		class="iec-enquiry-form"
		data-iec-enquiry="1"
		novalidate
		aria-describedby="form-response"
	>
		<input type="hidden" name="form_type" value="<?= esc_attr( $form_type ); ?>" autocomplete="off">
		<input type="hidden" name="page_url" value="<?= esc_url( $page_url ); ?>" autocomplete="off">
		<input type="hidden" name="enquiry_nonce" value="<?= esc_attr( $nonce ); ?>" autocomplete="off">
		<input type="hidden" name="utm_source" value="">
		<input type="hidden" name="utm_medium" value="">
		<input type="hidden" name="utm_campaign" value="">
		<input type="hidden" name="utm_id" value="">
		<input type="hidden" name="interest" value="<?= esc_attr( $interest_query ); ?>">

		<div class="loading-overlay iec-enquiry-loading" hidden>
			<div class="loader" aria-hidden="true"></div>
		</div>

		<div class="form-fields">
			<h5><?= $form_heading; ?></h5>
			<div class="error" role="alert"></div>

			<div class="bf_form_group">
				<label class="sr-only" for="iot-first-name"><?= $form_option['first_name'] ?? ''; ?></label>
				<input type="text" id="iot-first-name" name="first_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['first_name'] ?? '' ); ?>" required autocomplete="given-name">
				<p class="error"><?= $required_text; ?></p>
			</div>

			<div class="bf_form_group">
				<label class="sr-only" for="iot-last-name"><?= $form_option['last_name'] ?? ''; ?></label>
				<input type="text" id="iot-last-name" name="last_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['last_name'] ?? '' ); ?>" required autocomplete="family-name">
				<p class="error"><?= $required_text; ?></p>
			</div>

			<div class="bf_form_group">
				<label class="sr-only" for="iot-company"><?= $form_option['company'] ?? ''; ?></label>
				<input type="text" id="iot-company" name="company" class="iec_form_control" placeholder="<?= esc_attr( $form_option['company'] ?? '' ); ?>" autocomplete="organization">
			</div>

			<div class="bf_form_group">
				<label class="sr-only" for="contact-phone"><?= __( 'Phone', 'bbtheme' ); ?></label>
				<input type="tel" id="contact-phone" name="phone" placeholder="<?= esc_attr__( 'Phone...', 'bbtheme' ); ?>" required autocomplete="tel" inputmode="tel">
				<p class="error"><?= $required_text; ?></p>
			</div>

			<div class="bf_form_group">
				<label class="sr-only" for="iot-email"><?= $form_option['email'] ?? ''; ?></label>
				<input type="email" id="iot-email" name="email" class="iec_form_control" placeholder="<?= esc_attr( $form_option['email'] ?? '' ); ?>" required autocomplete="email" inputmode="email">
				<p class="error"><?= $required_text; ?></p>
			</div>

			<?php if ( ! empty( $countries ) ) : ?>
				<div class="bf_form_group">
					<label class="sr-only" for="country-select"><?= $form_option['country_field'] ?? __( 'Country', 'bbtheme' ); ?></label>
					<select name="country" id="country-select" required class="select2" data-select2-theme="grey-border">
						<option value=""><?= __( 'Country...', 'bbtheme' ); ?></option>
						<?php foreach ( $countries as $country ) : ?>
							<option value="<?= esc_attr( $country['country_code'] ?? '' ); ?>"><?= $country['country_name'] ?? ''; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="error"><?= $required_text; ?></p>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $form_interests ) ) : ?>
				<div class="bf_form_group">
					<label class="sr-only" for="interests-select" id="interest-label"><?= $form_option['interest_field'] ?? ''; ?></label>
					<select
						name="interests[]"
						id="interests-select"
						required
						multiple
						class="select2 select2-interest"
						data-select2-theme="grey-border"
						data-select2-hide-search="true"
					>
						<?php foreach ( $form_interests as $interest ) :
							$text = $interest['text'] ?? '';
							?>
							<option value="<?= esc_attr( $text ); ?>" <?php selected( $interest_query, $text ); ?>><?= $text; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="error"><?= $required_text; ?></p>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $hear_source ) ) : ?>
				<div class="bf_form_group">
					<label class="sr-only" for="hear-source" id="hear-source-label"><?= $form_option['hear_field'] ?? ''; ?></label>
					<select name="hear_source" id="hear-source" required class="select2" data-select2-theme="grey-border">
						<option value=""><?= __( 'How did you hear about us?', 'bbtheme' ); ?></option>
						<?php foreach ( $hear_source as $source ) : ?>
							<option value="<?= esc_attr( $source['text'] ?? '' ); ?>"><?= $source['text'] ?? ''; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="error"><?= $required_text; ?></p>
				</div>
			<?php endif; ?>

			<div class="bf_form_group no-border">
				<label class="sr-only" for="iot-message"><?= $form_option['message'] ?? ''; ?></label>
				<textarea name="message" id="iot-message" rows="4" placeholder="<?= esc_attr( $form_option['message'] ?? '' ); ?>" required></textarea>
				<p class="error"><?= $required_text; ?></p>
			</div>
		</div>

		<div class="form-button">
			<div class="captcha-wrapper" aria-label="<?= esc_attr__( 'Captcha verification', 'bbtheme' ); ?>">
				<div class="cf-turnstile" data-sitekey="<?= esc_attr( $captcha_key ); ?>"></div>
			</div>
			<button type="button" id="form_submit_btn" class="iec_button iec_blue_gradient iec-enquiry-submit">
				<?= $submit_label; ?>
			</button>
		</div>

		<div id="form-response" class="iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" hidden></div>

		<?php if ( $success_popup_html ) : ?>
			<div id="success-popup" class="message-popup lity-hide" style="display:none">
				<?= wp_kses_post( $success_popup_html ); ?>
			</div>
		<?php endif; ?>
	</form>
</div>
