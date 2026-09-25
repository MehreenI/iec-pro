<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_contact' );

if ( empty( $section['enabled'] ) ) {
	return;
}
