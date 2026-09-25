<?php
/**
 * Sidebar enquiry form (IoT, market detail, etc.).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$form_type          = $args['form_type'] ?? ( $enquiry_form_type ?? 'iot-enquiry' );
$form_id            = $args['form_id'] ?? ( $enquiry_form_id ?? 'enquiry-form-new' );
$form_heading       = $args['form_heading'] ?? '';
$success_popup_html = $args['success_popup_html'] ?? '';
$form_option        = get_config( 'form_options' ) ?: array();
$nonce              = wp_create_nonce( 'enquiry_form_nonce' );
if ( function_exists( 'iec_turnstile_site_key' ) ) {
    $captcha_key = iec_turnstile_site_key();
} elseif ( function_exists( 'iec_recaptcha_site_key' ) ) {
    $captcha_key = iec_recaptcha_site_key();
} else {
    $captcha_key = '';
}
$page_url           = get_permalink( get_the_ID() ) ?: home_url( '/' );
if ( $form_heading === '' ) {
    $form_heading = $form_option['form_heading'] ?? __( 'Enquiry Now', 'bbtheme' );
}
$submit_label       = $form_option['button'] ?? __( 'Send', 'bbtheme' );

$interest_query = isset( $_GET['interest'] ) ? sanitize_text_field( wp_unslash( $_GET['interest'] ) ) : '';
?>

<div class="iec_form_warpper iec_iot_form_warpper iec-enquiry-root">
    <form
            action="<?= esc_url( get_ajax_url( 'enquiry', 'department_enquiry' ) ); ?>"
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
        <input type="hidden" name="type" value="popup">
        <input type="hidden" name="interest" value="<?= esc_attr( $interest_query ); ?>">

        <div class="loading-overlay iec-enquiry-loading" hidden>
            <div class="loader" aria-hidden="true"></div>
        </div>

        <div class="form-fields">
            <h5><?= $form_heading; ?></h5>
            <p class="content">We will contact you as soon as possible.</p>
            <div class="error" role="alert"></div>

            <div class="bf_form_group">
                <label class="sr-only" for="iot-first-name"><?= $form_option['first_name'] ?? ''; ?></label>
                <input type="text" id="iot-first-name" name="first_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['first_name'] ?? '' ); ?>" required autocomplete="given-name">
                <p class="error"><?= 'This field is required'; ?></p>
            </div>

            <div class="bf_form_group">
                <label class="sr-only" for="iot-last-name"><?= $form_option['last_name'] ?? ''; ?></label>
                <input type="text" id="iot-last-name" name="last_name" class="iec_form_control" placeholder="<?= esc_attr( $form_option['last_name'] ?? '' ); ?>" required autocomplete="family-name">
                <p class="error"><?= 'This field is required'; ?></p>
            </div>

            <div class="bf_form_group">
                <label class="sr-only" for="iot-company"><?= $form_option['company'] ?? ''; ?></label>
                <input type="text" id="iot-company" name="company" class="iec_form_control" placeholder="<?= esc_attr( $form_option['company'] ?? '' ); ?>" autocomplete="organization">
            </div>

            <div class="bf_form_group">
                <label class="sr-only" for="contact-phone"><?= 'Phone'; ?></label>
                <input type="tel" id="contact-phone" name="phone" placeholder="<?php esc_attr_e( 'Phone...', 'bbtheme' ); ?>" required autocomplete="tel" inputmode="tel">
                <p class="error"><?= 'This field is required'; ?></p>
            </div>

            <div class="bf_form_group">
                <label class="sr-only" for="iot-email"><?= $form_option['email'] ?? ''; ?></label>
                <input type="email" id="iot-email" name="email" class="iec_form_control" placeholder="<?= esc_attr( $form_option['email'] ?? '' ); ?>" required autocomplete="email" inputmode="email">
                <p class="error"><?= 'This field is required'; ?></p>
            </div>

            <div class="bf_form_group no-border">
                <label class="sr-only" for="message"><?= $form_option['message'] ?? ''; ?></label>
                <textarea name="message" id="message" rows="4" placeholder="<?= esc_attr( $form_option['message'] ?? '' ); ?>" required></textarea>
                <p class="error"><?= 'This field is required'; ?></p>
            </div>
        </div>

        <div class="form-button">
            <div class="captcha-wrapper" aria-label="<?= __( 'Captcha verification', 'bbtheme' ); ?>">
                <div class="cf-turnstile" data-sitekey="<?= $captcha_key; ?>"></div>
            </div>
            <button type="button" id="form_submit_btn" class="iec_button iec_blue_gradient iec-enquiry-submit">
                <?= $submit_label; ?>
            </button>
        </div>

        <div id="form-response" class="iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" hidden></div>

    </form>
    <div id="success-popup" class="message-popup lity-hide" style="display:none">
        <?php if ( $success_popup_html ) : ?>
            <?= $success_popup_html; ?>
        <?php else : ?>
            <h5><?= __( 'THANK YOU FOR YOUR INQUIRY!', 'bbtheme' ); ?></h5>
            <p><?= __( 'One of our team members will get back to you shortly. If you require an immediate assistance, please contact the IEC Telecom 24/7 Support Center:', 'bbtheme' ); ?></p>
            <p class="links">
                Middle East: <a href="tel:+971 (0)4 55 86 497">+971 (0)4 55 86 497</a>
                <br />
                Europe: <a href="tel:+33 (0) 1 70363232">+33 (0) 1 70363232</a>
                <br />
                <a href="mailto:support-global@iec-telecom.com">support-global@iec-telecom.com</a>
            </p>
            <p class="credits">Sincerely,<br />Customer Care<br />IEC Telecom Group</p>
            <a href="#" class="btn" data-lity-close><?= __( 'Return to Website', 'bbtheme' ); ?></a>
        <?php endif; ?>
    </div>
</div>
