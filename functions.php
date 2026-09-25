<?php
/**
 * @package iec
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '18.35.0' );
}

global $bbTheme;

if ( class_exists( '\\BlueBeetle\\Press\\Theme' ) ) {
	$bbTheme = \BlueBeetle\Press\Theme::get_instance();

	if ( class_exists( 'Puc_v4_Factory' ) ) {
		$update_checker = Puc_v4_Factory::buildUpdateChecker(
			'https://s3.eu-west-1.amazonaws.com/bb.wp.updates/iec-telecom.com/bbtheme/theme.json',
			__FILE__,
			'bbpress'
		);
	}
}

/**
 * Polyfill BlueBeetle config when the framework is not loaded.
 * Keeps the theme bootable; real values still come from get_config() when present.
 *
 * @param string $key     Config key.
 * @param mixed  $default Fallback.
 * @return mixed
 */
if ( ! function_exists( 'get_config' ) ) {
	function get_config( $key, $default = '' ) {
		unset( $key );
		return $default;
	}
}

/**
 * Polyfill BlueBeetle AJAX URL helper.
 *
 * @param string $controller Unused without the framework.
 * @param string $action     Unused without the framework.
 * @return string
 */
if ( ! function_exists( 'get_ajax_url' ) ) {
	function get_ajax_url( $controller = '', $action = '' ) {
		unset( $controller, $action );
		return admin_url( 'admin-ajax.php' );
	}
}

require_once get_template_directory() . '/inc/load.php';
