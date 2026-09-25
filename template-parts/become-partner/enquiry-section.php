<?php
/**
 * Become Partner — enquiry form and sidebar content.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$fields             = $args['fields'] ?? array();
$offices            = $args['offices'] ?? array();
$countries          = $args['countries'] ?? array();
$form_interests     = $args['form_interests'] ?? array();
$hear_source        = $args['hear_source'] ?? array();
$form_option        = $args['form_option'] ?? array();
$interest_query     = $args['interest_query'] ?? '';
$referrer_query     = $args['referrer_query'] ?? '';
$success_popup_html = $args['success_popup_html'] ?? '';

$current_page_id = (int) get_the_ID();
$nonce           = wp_create_nonce( 'enquiry_form_nonce' );
$captcha_key     = function_exists( 'iec_turnstile_site_key' ) ? iec_turnstile_site_key() : iec_recaptcha_site_key();

$title   = $fields['title'] ?? '';
$content = $fields['content'] ?? '';

$submit_label = $form_option['button'] ?? __( 'Send', 'bbtheme' );
?>

<section class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_section_form iec-become-partner-section iec-enquiry-root bd_main_bpa_secvtion">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form
                        action="<?php echo esc_url( get_ajax_url( 'enquiry', 'save_new' ) ); ?>"
                        method="post"
                        id="enquiry-form-new"
                        class="iec-become-partner-form iec-enquiry-form"
                        data-iec-enquiry="1"
                        novalidate
                        aria-describedby="form-response"
                >
                    <input type="hidden" name="form_type" value="contact" autocomplete="off">
                    <input type="hidden" name="utm_source" value="">
                    <input type="hidden" name="utm_medium" value="">
                    <input type="hidden" name="utm_campaign" value="">
                    <input type="hidden" name="utm_id" value="">
                    <input type="hidden" name="enquiry_nonce" value="<?php echo esc_attr( $nonce ); ?>" autocomplete="off">
                    <input type="hidden" name="interest" value="<?php echo esc_attr( $interest_query ); ?>">
                    <input type="hidden" name="referrer_url" value="<?php echo esc_attr( $referrer_query ); ?>">

                    <?php if ( ! empty( $offices ) ) : ?>
                        <div class="country-dropdown" hidden>
                            <label for="become-partner-office"><?php _e( 'Find the nearest office', 'bbtheme' ); ?></label>
                            <select
                                    name="location"
                                    id="become-partner-office"
                                    class="country_list_contact"
                                    data-select2-hide-search="true"
                            >
                                <?php foreach ( $offices as $office_index => $office ) : ?>
                                    <option value="<?php echo esc_attr( $office->post_name ); ?>" <?php selected( 0, $office_index ); ?>>
                                        <?php echo get_the_title( $office->ID ); ?>
                                    </option>
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

                                <h6><?php _e( 'Write us a message', 'bbtheme' ); ?></h6>
                                <div class="error" role="alert"></div>

                                <div class="form-field">
                                    <label class="sr-only" for="become-partner-first-name"><?php echo $form_option['first_name'] ?? __( 'First Name', 'bbtheme' ); ?></label>
                                    <input
                                            type="text"
                                            id="become-partner-first-name"
                                            name="first_name"
                                            placeholder="<?php echo esc_attr( $form_option['first_name'] ?? '' ); ?>"
                                            required
                                            autocomplete="given-name"
                                    >
                                    <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                </div>

                                <div class="form-field">
                                    <label class="sr-only" for="become-partner-last-name"><?php echo $form_option['last_name'] ?? __( 'Last Name', 'bbtheme' ); ?></label>
                                    <input
                                            type="text"
                                            id="become-partner-last-name"
                                            name="last_name"
                                            placeholder="<?php echo esc_attr( $form_option['last_name'] ?? '' ); ?>"
                                            required
                                            autocomplete="family-name"
                                    >
                                    <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                </div>

                                <div class="form-field">
                                    <label class="sr-only" for="become-partner-company"><?php echo $form_option['company'] ?? __( 'Company', 'bbtheme' ); ?></label>
                                    <input
                                            type="text"
                                            id="become-partner-company"
                                            name="company"
                                            placeholder="<?php echo esc_attr( $form_option['company'] ?? '' ); ?>"
                                            autocomplete="organization"
                                    >
                                </div>

                                <div class="form-field">
                                    <label class="sr-only" for="contact-phone"><?php _e( 'Phone', 'bbtheme' ); ?></label>
                                    <input
                                            type="tel"
                                            id="contact-phone"
                                            name="phone"
                                            placeholder="<?php esc_attr_e( 'Phone...', 'bbtheme' ); ?>"
                                            required
                                            autocomplete="tel"
                                            inputmode="tel"
                                    >
                                    <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                </div>

                                <div class="form-field">
                                    <label class="sr-only" for="become-partner-email"><?php echo $form_option['email'] ?? __( 'Email', 'bbtheme' ); ?></label>
                                    <input
                                            type="email"
                                            id="become-partner-email"
                                            name="email"
                                            placeholder="<?php echo esc_attr( $form_option['email'] ?? '' ); ?>"
                                            required
                                            autocomplete="email"
                                            inputmode="email"
                                    >
                                    <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                </div>

                                <?php if ( ! empty( $countries ) ) : ?>
                                    <div class="form-field">
                                        <label class="sr-only" for="country-select" id="country-label">
                                            <?php echo $form_option['country_field'] ?? __( 'Country', 'bbtheme' ); ?>
                                        </label>
                                        <select name="country" id="country-select" required class="select2" data-select2-theme="grey-border">
                                            <option value=""><?php _e( 'Country...', 'bbtheme' ); ?></option>
                                            <?php foreach ( $countries as $country ) : ?>
                                                <option value="<?php echo esc_attr( $country['country_code'] ?? '' ); ?>">
                                                    <?php echo $country['country_name'] ?? ''; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $form_interests ) ) : ?>
                                    <div class="form-field">
                                        <label class="sr-only" for="interests-select" id="interest-label">
                                            <?php echo $form_option['interest_field'] ?? __( 'Interest', 'bbtheme' ); ?>
                                        </label>
                                        <select
                                                name="interests[]"
                                                id="interests-select"
                                                required
                                                multiple
                                                class="select2 select2-interest"
                                                data-select2-theme="grey-border"
                                                data-select2-hide-search="true"
                                                data-select2-placeholder="<?php esc_attr_e( 'Interest...', 'bbtheme' ); ?>"
                                        >
                                            <option value=""><?php _e( 'Interest...', 'bbtheme' ); ?></option>
                                            <?php foreach ( $form_interests as $interest ) : ?>
                                                <?php $interest_text = $interest['text'] ?? ''; ?>
                                                <option value="<?php echo esc_attr( $interest_text ); ?>" <?php selected( $interest_query, $interest_text ); ?>>
                                                    <?php echo $interest_text; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $hear_source ) ) : ?>
                                    <div class="form-field">
                                        <label class="sr-only" for="hear-source" id="hear-source-label">
                                            <?php echo $form_option['hear_field'] ?? ''; ?>
                                        </label>
                                        <select name="hear_source" id="hear-source" required class="select2" data-select2-theme="grey-border">
                                            <option value=""><?php _e( 'How did you hear about us?', 'bbtheme' ); ?></option>
                                            <?php foreach ( $hear_source as $source ) : ?>
                                                <option value="<?php echo esc_attr( $source['text'] ?? '' ); ?>">
                                                    <?php echo $source['text'] ?? ''; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="form-field">
                                    <label class="sr-only" for="become-partner-message"><?php echo $form_option['message'] ?? __( 'Message', 'bbtheme' ); ?></label>
                                    <textarea
                                            name="message"
                                            id="become-partner-message"
                                            cols="30"
                                            rows="4"
                                            placeholder="<?php echo esc_attr( $form_option['message'] ?? '' ); ?>"
                                            class="expand-on-click"
                                            required
                                    ></textarea>
                                    <p class="error"><?php _e( 'This field is required', 'bbtheme' ); ?></p>
                                </div>

                                <div class="form-field" id="promo_wrapper" hidden>
                                    <label class="sr-only" for="promo_code"><?php _e( 'Promo code', 'bbtheme' ); ?></label>
                                    <input type="text" name="promo_code" id="promo_code" placeholder="<?php esc_attr_e( 'Promocode...', 'bbtheme' ); ?>">
                                </div>

                                <div class="form-field no-border google-captcha-wrapper">
                                    <div class="captcha-wrapper" aria-label="<?php esc_attr_e( 'Captcha verification', 'bbtheme' ); ?>">
                                        <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( $captcha_key ); ?>"></div>
                                    </div>
                                </div>

                                <div id="form-response" class="iec-enquiry-response" role="status" aria-live="polite" aria-atomic="true" hidden></div>

                                <div>
                                    <input type="hidden" name="page_url" value="<?php echo esc_url( get_permalink( $current_page_id ) ); ?>">
                                    <button
                                            type="button"
                                            id="form_submit_btn"
                                            class="iec_button btn btn-primary iec-enquiry-submit"
                                            aria-label="<?php esc_attr_e( 'Send the contact form', 'bbtheme' ); ?>"
                                    >
                                        <?php echo $submit_label; ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 iec_col_address">
                            <?php if ( $title || $content ) : ?>
                                <div class="iec_become_a_partner_content">
                                    <?php if ( $title ) : ?>
                                        <h5><?php echo $title; ?></h5>
                                    <?php endif; ?>
                                    <?php if ( $content ) : ?>
                                        <?php echo wp_kses_post( $content ); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ( $success_popup_html ) : ?>
                        <div id="success-popup" class="message-popup lity-hide">
                            <?php echo wp_kses_post( $success_popup_html ); ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</section>
