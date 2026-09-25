<?php
/**
 * Shared office / contact enquiry form.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form_option    = get_config( 'form_options' ) ?: array();
$form_interests = get_config( 'enquiry_form_interest' ) ?: array();
$countries      = function_exists( 'iec_unique_countries' ) ? iec_unique_countries() : array();
$nonce          = wp_create_nonce( 'enquiry_form_nonce' );
$page_url       = get_permalink() ?: home_url( '/' );
$submit_label   = $form_option['button'] ?? __( 'Talk to a Connectivity Specialist', 'bbtheme' );

if ( function_exists( 'iec_turnstile_site_key' ) ) {
	$captcha_key = iec_turnstile_site_key();
} elseif ( function_exists( 'iec_recaptcha_site_key' ) ) {
	$captcha_key = iec_recaptcha_site_key();
} else {
	$captcha_key = '';
}

$is_news_event = is_singular( 'news' )
	&& function_exists( 'iec_news_single_type_slug' )
	&& 'events' === iec_news_single_type_slug();

$form_copy = $is_news_event
	? ( $form_option['news_content'] ?? array() )
	: ( $form_option['other_form_content'] ?? array() );

$eyebrow   = $args['eyebrow'] ?? $form_copy['eyebrow'] ?? '';
$heading   = $args['heading'] ?? $args['form_heading'] ?? $form_copy['heading'] ?? '';
$content   = $args['content'] ?? $form_copy['content'] ?? '';
$form_type = $args['form_type'] ?? 'enquiry';

$country_placeholder  = $form_option['country_field'] ?? __( 'Select a country', 'bbtheme' );
$solution_placeholder = $form_option['interest_field'] ?? __( 'Select Market', 'bbtheme' );

$interest_fallback = array(
	'Shipping',
	'Fishing',
	'Offshore',
	'Leisure',
	'Government',
	'Humanitarian',
	'Energy',
	'Enterprise',
	'Media',
	'Else',
);
?>

<section class="iec_defualt_position iec_section_home_contact iec-enquiry-root" id="contact" aria-labelledby="iec-home-contact-heading">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_home_contact_warpper">
					<div class="iec_home_contact_content" data-aos="fade-up">
						<?php if ( $eyebrow ) : ?>
							<span class="iec_home_eyebrow iec-eyebrow"><?= $eyebrow; ?></span>
						<?php endif; ?>

						<?php if ( $heading ) : ?>
							<h2 class="iec_section_heading iec-section-heading" id="iec-home-contact-heading"><?= $heading; ?></h2>
						<?php endif; ?>

						<?php if ( $content ) : ?>
							<div class="wysiwyg-content">
								<?= $content; ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="iec_home_contact_form_warpper" data-aos="fade-up" data-aos-delay="150">
						<div class="loading-overlay iec-enquiry-loading" id="iec-home-contact-loading" hidden>
							<div class="loader" aria-hidden="true"></div>
						</div>

						<form
							action="<?= esc_url( get_ajax_url( 'enquiry', 'save_new' ) ); ?>"
							method="post"
							id="iec-home-enquiry-form"
							class="iec-enquiry-form iec_home_contact_form"
							data-iec-enquiry="1"
							data-id="contact-form"
							novalidate
							aria-describedby="iec-home-form-response"
						>
							<input type="hidden" name="form_type" value="<?= $form_type; ?>" autocomplete="off">
							<input type="hidden" name="page_url" value="<?= esc_url( $page_url ); ?>" autocomplete="off">
							<input type="hidden" name="enquiry_nonce" value="<?= esc_attr( $nonce ); ?>" autocomplete="off">
							<input type="hidden" name="last_name" value="" autocomplete="off">
							<input type="hidden" name="hear_source" value="Website" autocomplete="off">
							<input type="hidden" name="utm_source" value="">
							<input type="hidden" name="utm_medium" value="">
							<input type="hidden" name="utm_campaign" value="">
							<input type="hidden" name="utm_id" value="">

							<div class="iec-home-contact__fields">
								<div class="iec-home-contact__row">
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-full-name"><?= __( 'Full Name', 'bbtheme' ); ?></label>
										<input type="text" id="iec-home-full-name" name="first_name" class="iec-home-contact__input iec_form_control" placeholder="<?= esc_attr__( 'your full name', 'bbtheme' ); ?>" required autocomplete="name">
										<p class="error"><?= __( 'This field is required', 'bbtheme' ); ?></p>
									</div>
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-phone"><?= __( 'Phone', 'bbtheme' ); ?></label>
										<input type="tel" id="iec-home-phone" name="phone" class="iec-home-contact__input" placeholder="<?= esc_attr__( 'your phone', 'bbtheme' ); ?>" inputmode="tel" autocomplete="tel" required>
										<p class="error" id="iec-home-phone-error"><?= __( 'Please enter a valid number below', 'bbtheme' ); ?></p>
									</div>
								</div>

								<div class="iec-home-contact__row">
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-company"><?= __( 'Company', 'bbtheme' ); ?></label>
										<input type="text" id="iec-home-company" name="company" class="iec-home-contact__input iec_form_control" placeholder="<?= esc_attr__( 'your company', 'bbtheme' ); ?>" autocomplete="organization">
									</div>
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-email"><?= __( 'Email', 'bbtheme' ); ?></label>
										<input type="email" id="iec-home-email" name="email" class="iec-home-contact__input iec_form_control" placeholder="<?= esc_attr__( 'your email', 'bbtheme' ); ?>" required inputmode="email" autocomplete="email">
										<p class="error"><?= __( 'This field is required', 'bbtheme' ); ?></p>
									</div>
								</div>

								<div class="iec-home-contact__row">
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-country-select"><?= __( 'Country', 'bbtheme' ); ?></label>
										<div class="country iec-home-contact__select-wrap">
											<select name="country" id="iec-home-country-select" required class="input select2 iec-home-contact__select" autocomplete="country-name" data-placeholder="<?= esc_attr( $country_placeholder ); ?>">
												<option value=""><?= $country_placeholder; ?></option>
												<?php foreach ( $countries as $country ) : ?>
													<option value="<?= esc_attr( $country['country_code'] ); ?>"><?= $country['country_name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<p class="error"><?= __( 'This field is required', 'bbtheme' ); ?></p>
									</div>
									<div class="bf_form_group iec-home-contact__field">
										<label class="iec-home-contact__label" for="iec-home-interests-select" id="interest-label"><?= __( 'Market Interest', 'bbtheme' ); ?></label>
										<div class="interest iec-home-contact__select-wrap">
											<select id="iec-home-interests-select" name="interests[]" required multiple class="input interest select2 iec-home-contact__select" data-placeholder="<?= esc_attr( $solution_placeholder ); ?>">
												<option value=""><?= $solution_placeholder; ?></option>
												<?php if ( ! empty( $form_interests ) ) : ?>
													<?php foreach ( $form_interests as $interest ) : ?>
														<option value="<?= esc_attr( $interest['text'] ); ?>"><?= $interest['text']; ?></option>
													<?php endforeach; ?>
												<?php else : ?>
													<?php foreach ( $interest_fallback as $interest ) : ?>
														<option value="<?= esc_attr( $interest ); ?>"><?= $interest; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>
										<p class="error"><?= __( 'This field is required', 'bbtheme' ); ?></p>
									</div>
								</div>
								<div class="bf_form_group iec-home-contact__field iec-home-contact__field--full">
									<label class="iec-home-contact__label" for="iec-home-message"><?= __( 'Message', 'bbtheme' ); ?></label>
									<textarea id="iec-home-message" name="message" class="iec-home-contact__input iec-home-contact__textarea iec_form_control" placeholder="<?= esc_attr__( 'Tell us about your project...', 'bbtheme' ); ?>" rows="4" required></textarea>
									<p class="error"><?= __( 'This field is required', 'bbtheme' ); ?></p>
								</div>
							</div>
							<div class="iec-home-contact__footer">
								<div class="iec-home-contact__captcha" aria-label="<?= esc_attr__( 'Captcha verification', 'bbtheme' ); ?>">
									<div class="cf-turnstile" data-sitekey="<?= esc_attr( $captcha_key ); ?>"></div>
								</div>
								<button
									type="button"
									id="iec-home-form-submit"
									class="iec_button iec_blue_gradient iec-enquiry-submit"
									aria-label="<?= esc_attr__( 'Send the contact form', 'bbtheme' ); ?>"
								>
									<?= $submit_label; ?>
								</button>
							</div>
							<div id="iec-home-form-response" class="iec-home-contact__response iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" style="display: none;"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
