<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'getStarlinkLocationByLocale' ) ) {
		function getStarlinkLocationByLocale( $lang ) {
		switch ( $lang ) {
			case 'tr':
				return 'turkey';
			case 'no':
				return 'norway';
			case 'it':
				return 'italy';
			case 'id':
				return 'indonesia';
			case 'fr':
				return 'france';
			case 'en':
			default:
				return 'global';
		}
	}
}

if ( ! function_exists( 'iec_starlink_default_thank_content' ) ) {
		function iec_starlink_default_thank_content() {
		return '<h5>THANK YOU FOR YOUR INQUIRY!</h5>
<p>One of our team members will get back to you shortly. If you require an immediate assistance, please contact the IEC Telecom 24/7 Support Center:</p>
<p class="links">
Middle East: <a href="tel:+971 (0)4 55 86 497">+971 (0)4 55 86 497</a>
<br />
Europe: <a href="tel:+33 (0) 1 70363232">+33 (0) 1 70363232</a>
<br />
<a href="mailto:support-global@iec-telecom.com">support-global@iec-telecom.com</a>
</p>
<p class="credits">Sincerely,<br />Customer Care<br />IEC Telecom Group</p>
<a href="#" class="btn" data-lity-close>Return to Website</a>';
	}
}

if ( ! function_exists( 'iec_starlink_landing_context' ) ) {
		function iec_starlink_landing_context() {
		$fields = function_exists( 'get_fields' ) ? get_fields() : array();
		$fields = is_array( $fields ) ? $fields : array();

		$countries      = \BlueBeetle\Press\Common::get_instance()->get_countries( 'en' );
		$form_interests = get_config( 'enquiry_form_interest' );
		$hear_source    = get_config( 'form_hear_source' );

		// Returns a 2-letter language code like 'en'.
		$current_lang = apply_filters( 'wpml_current_language', null );

		$success_popup_content     = get_config( 'enquiry_success_popup_content' );
		$success_popup_content_key = 'product-enquiry ';

		if ( isset( $success_popup_content[ $success_popup_content_key ]['content'] ) ) {
			$success_popup_html = $success_popup_content[ $success_popup_content_key ]['content'];
		} else {
			$success_popup_html = iec_starlink_default_thank_content();
		}

		$actual_link = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
		if ( empty( $actual_link ) ) {
			$host        = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
			$uri         = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
			$actual_link = ( is_ssl() ? 'https://' : 'http://' ) . $host . $uri;
		}

		return array(
			'fields'             => $fields,
			'countries'          => $countries,
			'form_interests'     => $form_interests,
			'hear_source'        => $hear_source,
			'current_lang'       => $current_lang,
			'success_popup_html' => $success_popup_html,
			'actual_link'        => $actual_link,
		);
	}
}
