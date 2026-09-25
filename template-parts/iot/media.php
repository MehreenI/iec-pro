<?php
/**
 * ACF image field → URL helper for IoT template parts.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'iec_iot_resolve_image_url' ) ) {
	/**
	 * @param mixed $value ACF image (array, ID, or URL).
	 * @return string
	 */
	function iec_iot_resolve_image_url( $value ) {
		if ( is_array( $value ) ) {
			if ( ! empty( $value['url'] ) ) {
				return (string) $value['url'];
			}
			$id = isset( $value['ID'] ) ? (int) $value['ID'] : 0;
			if ( $id > 0 ) {
				$url = wp_get_attachment_image_url( $id, 'large' );
				return $url ? (string) $url : '';
			}
			return '';
		}

		if ( is_numeric( $value ) && (int) $value > 0 ) {
			$url = wp_get_attachment_image_url( (int) $value, 'large' );
			return $url ? (string) $url : '';
		}

		if ( is_string( $value ) ) {
			$s = trim( $value );
			return $s !== '' ? $s : '';
		}

		return '';
	}
}
