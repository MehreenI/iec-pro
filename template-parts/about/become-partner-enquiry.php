<?php
/**
 * About become-partner enquiry form.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$title  = $fields['title'] ?? '';
$content = $fields['content'] ?? '';

$offices = class_exists( '\BlueBeetle\Press\Generic' )
	? \BlueBeetle\Press\Generic::get_instance()->get_offices()
	: array();

$countries = class_exists( '\BlueBeetle\Press\Common' )
	? \BlueBeetle\Press\Common::get_instance()->get_countries()
	: array();

if ( ! empty( $countries ) ) {
	$countries = array_map( 'unserialize', array_unique( array_map( 'serialize', $countries ) ) );
}

$form_interests     = get_config( 'enquiry_form_interest' ) ?: array();
$hear_source        = get_config( 'form_hear_source' ) ?: array();
$form_option        = get_config( 'form_options' ) ?: array();
$success_popup_html = '';
$success_content    = get_config( 'enquiry_success_popup_content' );

if ( is_array( $success_content ) ) {
	$success_key = array_search( 'become-partner', array_column( $success_content, 'form_type' ), true );
	if ( false !== $success_key && ! empty( $success_content[ $success_key ]['content'] ) ) {
		$success_popup_html = $success_content[ $success_key ]['content'];
	}
}

$interest_query = $_GET['interest'] ?? '';
$referrer_query = $_GET['referrer'] ?? '';
$nonce          = wp_create_nonce( 'enquiry_form_nonce' );
$captcha_key    = get_config( 'bbpress_google_captcha_site_key' );
?>

<!-- Become partner enquiry. -->
<section class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_section_form iec-become-partner-section iec-enquiry-root bd_main_bpa_secvtion">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form action="<?php echo get_ajax_url( 'enquiry', 'save_new' ); ?>" method="post" id="enquiry-form-new" class="iec-become-partner-form iec-enquiry-form" data-iec-enquiry="1" novalidate aria-describedby="form-response">
					<input type="hidden" name="form_type" value="contact" autocomplete="off">
					<input type="hidden" name="utm_source" value="">
					<input type="hidden" name="utm_medium" value="">
					<input type="hidden" name="utm_campaign" value="">
					<input type="hidden" name="utm_id" value="">
					<input type="hidden" name="enquiry_nonce" value="<?php echo $nonce; ?>" autocomplete="off">
					<input type="hidden" name="interest" value="<?php echo $interest_query; ?>">
					<input type="hidden" name="referrer_url" value="<?php echo $referrer_query; ?>">
					<input type="hidden" name="page_url" value="<?php echo get_permalink(); ?>">

					<?php if ( ! empty( $offices ) ) : ?>
						<div class="country-dropdown" hidden>
							<label for="become-partner-office">Find the nearest office</label>
							<select name="location" id="become-partner-office" class="country_list_contact" data-select2-hide-search="true">

								<?php foreach ( $offices as $office_index => $office ) : ?>
									<option value="<?php echo $office->post_name; ?>" <?php selected( 0, $office_index ); ?>><?php echo get_the_title( $office->ID ); ?></option>
								<?php endforeach; ?>

							</select>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="col-md-6 iec_col_form">
							<div class="form-fields">
								<div class="loading-overlay iec-enquiry-loading" id="loading-overlay" hidden>
									<div class="loader" aria-hidden="true"></div>
								</div>

								<p class="iec-form-heading">Write us a message</p>
								<div class="error" role="alert"></div>

								<div class="form-field">
									<label class="sr-only" for="become-partner-first-name"><?php echo $form_option['first_name'] ?? 'First Name'; ?></label>
									<input type="text" id="become-partner-first-name" name="first_name" placeholder="<?php echo $form_option['first_name'] ?? 'First Name'; ?>" required autocomplete="given-name">
									<p class="error">This field is required</p>
								</div>

								<div class="form-field">
									<label class="sr-only" for="become-partner-last-name"><?php echo $form_option['last_name'] ?? 'Last Name'; ?></label>
									<input type="text" id="become-partner-last-name" name="last_name" placeholder="<?php echo $form_option['last_name'] ?? 'Last Name'; ?>" required autocomplete="family-name">
									<p class="error">This field is required</p>
								</div>

								<div class="form-field">
									<label class="sr-only" for="become-partner-company"><?php echo $form_option['company'] ?? 'Company'; ?></label>
									<input type="text" id="become-partner-company" name="company" placeholder="<?php echo $form_option['company'] ?? 'Company'; ?>" autocomplete="organization">
								</div>

								<div class="form-field">
									<label class="sr-only" for="contact-phone">Phone</label>
									<input type="tel" id="contact-phone" name="phone" placeholder="Phone..." required autocomplete="tel" inputmode="tel">
									<p class="error">This field is required</p>
								</div>

								<div class="form-field">
									<label class="sr-only" for="become-partner-email"><?php echo $form_option['email'] ?? 'Email'; ?></label>
									<input type="email" id="become-partner-email" name="email" placeholder="<?php echo $form_option['email'] ?? 'Email'; ?>" required autocomplete="email" inputmode="email">
									<p class="error">This field is required</p>
								</div>

								<?php if ( ! empty( $countries ) ) : ?>
									<div class="form-field">
										<label class="sr-only" for="country-select" id="country-label"><?php echo $form_option['country_field'] ?? 'Country'; ?></label>
										<select name="country" id="country-select" required class="select2" data-select2-theme="grey-border">
											<option value="">Country...</option>

											<?php foreach ( $countries as $country ) : ?>
												<option value="<?php echo $country['country_code'] ?? ''; ?>"><?php echo $country['country_name'] ?? ''; ?></option>
											<?php endforeach; ?>

										</select>
										<p class="error">This field is required</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $form_interests ) ) : ?>
									<div class="form-field">
										<label class="sr-only" for="interests-select" id="interest-label"><?php echo $form_option['interest_field'] ?? 'Interest'; ?></label>
										<select name="interests[]" id="interests-select" required multiple class="select2 select2-interest" data-select2-theme="grey-border" data-select2-hide-search="true" data-select2-placeholder="Interest...">
											<option value="">Interest...</option>

											<?php foreach ( $form_interests as $interest ) : ?>
												<?php $interest_text = $interest['text'] ?? ''; ?>
												<option value="<?php echo $interest_text; ?>" <?php selected( $interest_query, $interest_text ); ?>><?php echo $interest_text; ?></option>
											<?php endforeach; ?>

										</select>
										<p class="error">This field is required</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $hear_source ) ) : ?>
									<div class="form-field">
										<label class="sr-only" for="hear-source" id="hear-source-label"><?php echo $form_option['hear_field'] ?? ''; ?></label>
										<select name="hear_source" id="hear-source" required class="select2" data-select2-theme="grey-border">
											<option value="">How did you hear about us?</option>

											<?php foreach ( $hear_source as $source ) : ?>
												<option value="<?php echo $source['text'] ?? ''; ?>"><?php echo $source['text'] ?? ''; ?></option>
											<?php endforeach; ?>

										</select>
										<p class="error">This field is required</p>
									</div>
								<?php endif; ?>

								<div class="form-field">
									<label class="sr-only" for="become-partner-message"><?php echo $form_option['message'] ?? 'Message'; ?></label>
									<textarea name="message" id="become-partner-message" cols="30" rows="4" placeholder="<?php echo $form_option['message'] ?? 'Message'; ?>" class="expand-on-click" required></textarea>
									<p class="error">This field is required</p>
								</div>

								<div class="form-field" id="promo_wrapper" hidden>
									<label class="sr-only" for="promo_code">Promo code</label>
									<input type="text" name="promo_code" id="promo_code" placeholder="Promocode...">
								</div>

								<div class="form-field no-border google-captcha-wrapper">
									<div class="captcha-wrapper">
										<div class="cf-turnstile" data-sitekey="<?php echo $captcha_key; ?>"></div>
									</div>
								</div>

								<div id="form-response" class="iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" hidden></div>

								<div>
									<button type="button" id="form_submit_btn" class="iec_button iec_blue_gradient iec-enquiry-submit"><?php echo $form_option['button'] ?? 'Send'; ?></button>
								</div>
							</div>
						</div>

						<div class="col-md-6 iec_col_address">

							<?php if ( $title || $content ) : ?>
								<div class="iec_become_a_partner_content">

									<?php if ( $title ) : ?>
										<h2 class="iec-primary-heading"><?php echo $title; ?></h2>
									<?php endif; ?>

									<?php if ( $content ) : ?>
										<?php echo $content; ?>
									<?php endif; ?>

								</div>
							<?php endif; ?>

						</div>
					</div>

					<?php if ( $success_popup_html ) : ?>
						<div id="success-popup" class="message-popup lity-hide"><?php echo $success_popup_html; ?></div>
					<?php endif; ?>

				</form>
			</div>
		</div>
	</div>
</section>
