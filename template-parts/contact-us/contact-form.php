<?php
/**
 * Contact Us page — enquiry form (office-style layout).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$heading   = $args['form_heading'] ?? ( $form_heading ?? __( 'Contact Us', 'bbtheme' ) );
$form_type = $args['form_type'] ?? ( $args['type'] ?? ( $form_type ?? 'enquiry' ) );
$form_option    = get_config( 'form_options' ) ?: array();
$form_interests = get_config( 'enquiry_form_interest' ) ?: array();
$nonce          = wp_create_nonce( 'enquiry_form_nonce' );
$captcha_key    = function_exists( 'iec_recaptcha_site_key' )
    ? iec_recaptcha_site_key()
    : (string) get_config( 'bbpress_google_captcha_site_key', '0x4AAAAAAENNS8FcNlPbWcAu' );
$page_url       = ( empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) . '://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) );
$submit_label   = $form_option['button'] ?? __( 'Send', 'bbtheme' );

$countries = array();
if ( class_exists( '\BlueBeetle\Press\Common' ) ) {
    $countries = \BlueBeetle\Press\Common::get_instance()->get_countries();
    $countries = array_map( 'unserialize', array_unique( array_map( 'serialize', $countries ) ) );
}

$hear_source = get_config( 'form_hear_source' );
if ( ! is_array( $hear_source ) ) {
    $hear_source = array();
}

$country_placeholder  = ! empty( $form_option['country_field'] ) ? $form_option['country_field'] : __( 'Country...', 'bbtheme' );
$interest_placeholder = ! empty( $form_option['interest_field'] ) ? $form_option['interest_field'] : __( 'Interest...', 'bbtheme' );
$hear_placeholder     = ! empty( $form_option['hear_field'] ) ? $form_option['hear_field'] : __( 'How did you hear about us?', 'bbtheme' );
$heading_id           = 'iec-contact-us-form-heading';
?>
<section class="iec_single_office_contact_us iec-enquiry-root" id="contact" role="region" aria-labelledby="<?= esc_attr( $heading_id ); ?>">
    <div class="loading-overlay iec-enquiry-loading" id="loading-overlay" hidden>
        <div class="dots" aria-hidden="true"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_form_warpper">
                    <h1 id="<?= esc_attr( $heading_id ); ?>">
                        <?= ! empty( $heading ) ? $heading : $form_option['form_heading'] ?? ''; ?>
                    </h1>
                    <form
                        action="<?= esc_url( get_ajax_url( 'enquiry', 'save_new' ) ); ?>"
                        method="post"
                        id="enquiry-form-new"
                        class="iec-enquiry-form"
                        role="form"
                        aria-describedby="form-response"
                        novalidate
                        data-id="contact-form"
                        data-iec-enquiry="1"
                    >
                        <input type="hidden" name="form_type" value="<?= esc_attr( $form_type ); ?>" autocomplete="off">
                        <input type="hidden" name="page_url" value="<?= esc_url( $page_url ); ?>" autocomplete="off">
                        <input type="hidden" name="enquiry_nonce" value="<?= esc_attr( $nonce ); ?>" autocomplete="off">
                        <input type="hidden" name="utm_source" value="">
                        <input type="hidden" name="utm_medium" value="">
                        <input type="hidden" name="utm_campaign" value="">
                        <input type="hidden" name="utm_id" value="">

                        <div class="bf_form_group">
                            <label for="first-name" class="sr-only"><?= $form_option['first_name'] ?? 'First Name'; ?></label>
                            <input type="text" id="first-name" name="first_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['first_name'] ?? '' ); ?>" required autocomplete="given-name">
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <label for="last-name" class="sr-only"><?= $form_option['last_name'] ?? 'Last Name'; ?></label>
                            <input type="text" id="last-name" name="last_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['last_name'] ?? '' ); ?>" required autocomplete="family-name">
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <label for="company" class="sr-only"><?= $form_option['company'] ?? 'Company'; ?></label>
                            <input type="text" id="company" name="company" class="iec_form_control" placeholder="<?= esc_attr( $form_option['company'] ?? '' ); ?>" autocomplete="organization">
                        </div>
                        <div class="bf_form_group">
                            <label for="contact-phone" class="sr-only"><?= 'Phone number'; ?></label>
                            <input type="tel" id="contact-phone" name="phone" placeholder="<?php esc_attr_e( 'Phone...', 'bbtheme' ); ?>" inputmode="tel" autocomplete="tel" required>
                            <p class="error" id="phone-error"><?= 'Please enter a valid number below'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <label for="email" class="sr-only"><?= $form_option['email'] ?? 'Email address'; ?></label>
                            <input type="email" id="email" name="email" class="iec_form_control" placeholder="<?= esc_attr( $form_option['email'] ?? '' ); ?>" required inputmode="email" autocomplete="email">
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <div class="country">
                                <label for="country-select" class="sr-only" id="country-label"><?= $country_placeholder; ?></label>
                                <select name="country" id="country-select" required class="input select2" autocomplete="country-name" data-placeholder="<?= esc_attr( $country_placeholder ); ?>">
                                    <option value=""><?= $country_placeholder; ?></option>
                                    <?php foreach ( $countries as $country ) : ?>
                                        <option value="<?= esc_attr( $country['country_code'] ); ?>"><?= $country['country_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <div class="interest">
                                <label for="interests-select" class="sr-only" id="interest-label"><?= $interest_placeholder; ?></label>
                                <select id="interests-select" name="interests[]" required multiple class="input interest select2" data-placeholder="<?= esc_attr( $interest_placeholder ); ?>">
                                    <option value=""><?= $interest_placeholder; ?></option>
                                    <?php if ( ! empty( $form_interests ) ) : ?>
                                        <?php foreach ( $form_interests as $interest ) : ?>
                                            <option value="<?= esc_attr( $interest['text'] ); ?>"><?= $interest['text']; ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="Shipping">Shipping</option>
                                        <option value="Fishing">Fishing</option>
                                        <option value="Offshore">Offshore</option>
                                        <option value="Leisure">Leisure</option>
                                        <option value="Government">Government</option>
                                        <option value="Humanitarian">Humanitarian</option>
                                        <option value="Energy">Energy</option>
                                        <option value="Enterprise">Enterprise</option>
                                        <option value="Media">Media</option>
                                        <option value="Else">Else</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <label for="message" class="sr-only"><?= $form_option['message'] ?? 'Message'; ?></label>
                            <input type="text" id="message" name="message" class="iec_form_control" placeholder="<?= esc_attr( $form_option['message'] ?? '' ); ?>" required autocomplete="off">
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="bf_form_group">
                            <div class="how hear">
                                <label for="hear-source" class="sr-only" id="hear-source-label"><?= $hear_placeholder; ?></label>
                                <select name="hear_source" id="hear-source" required class="input hear select2" data-placeholder="<?= esc_attr( $hear_placeholder ); ?>">
                                    <option value=""><?= $hear_placeholder; ?></option>
                                    <?php if ( ! empty( $hear_source ) ) : ?>
                                        <?php foreach ( $hear_source as $source ) : ?>
                                            <option value="<?= esc_attr( $source['text'] ); ?>"><?= $source['text']; ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="Google">Google</option>
                                        <option value="LinkedIn">LinkedIn</option>
                                        <option value="Other Social networks">Other Social networks</option>
                                        <option value="Event">Event</option>
                                        <option value="Media advertising">Media advertising</option>
                                        <option value="E-mailing">E-mailing</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <p class="error"><?= 'This field is required'; ?></p>
                        </div>
                        <div class="right_text solution_btn">
                            <div class="captcha-wrapper" aria-label="<?php esc_attr_e( 'Captcha verification', 'bbtheme' ); ?>">
                                <div class="cf-turnstile" data-sitekey="<?= esc_attr( $captcha_key ); ?>"></div>
                            </div>
                            <button id="form_submit_btn" class="iec_button iec_blue_gradient iec-enquiry-submit" type="button" aria-label="<?php esc_attr_e( 'Send the contact form', 'bbtheme' ); ?>">
                                <?= $submit_label; ?>
                            </button>
                        </div>
                        <div id="form-response" class="iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
