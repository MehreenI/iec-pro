<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_voucher_render_flexible_section( string $layout ): void {
	$layout = trim( $layout );
	if ( '' === $layout ) {
		return;
	}

	$normalized = str_replace( '-', '_', $layout );
	$aliases    = array(
		'split_media_text'     => 'split_media_and_text',
		'split_media_and_text' => 'split_media_and_text',
		'video_demo'           => 'video_section',
		'solution_architectur' => 'solution_architecture',
	);
	$slug = $aliases[ $normalized ] ?? $normalized;
	$part = 'template-parts/voucher/flexible/' . $slug;

	if ( locate_template( $part . '.php' ) ) {
		get_template_part( $part );
	}
}

function iec_voucher_sub_field_first( array $keys ) {
	foreach ( $keys as $key ) {
		$value = get_sub_field( $key );
		if ( $value !== null && $value !== '' && $value !== array() ) {
			return $value;
		}
	}
	return null;
}

function iec_voucher_enquire_icon(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="19" viewBox="0 0 18 15" fill="none" aria-hidden="true" focusable="false"><path d="M5.518 0H11.982C12.795 0 13.451 2.19792e-07 13.982 0.0430002C14.528 0.0880002 15.008 0.183 15.452 0.409C16.1581 0.768372 16.7322 1.34214 17.092 2.048C17.318 2.492 17.412 2.972 17.457 3.518C17.5 4.049 17.5 4.705 17.5 5.518V8.982C17.5 9.795 17.5 10.451 17.457 10.982C17.412 11.528 17.317 12.008 17.091 12.452C16.7316 13.1581 16.1579 13.7322 15.452 14.092C15.008 14.318 14.528 14.412 13.982 14.457C13.451 14.5 12.795 14.5 11.982 14.5H5.518C4.705 14.5 4.049 14.5 3.518 14.457C2.972 14.412 2.492 14.317 2.048 14.091C1.34192 13.7316 0.767803 13.1579 0.408 12.452C0.182 12.008 0.088 11.528 0.043 10.982C0 10.451 0 9.795 0 8.982V5.518C0 4.705 0 4.049 0.043 3.518C0.088 2.972 0.183 2.492 0.409 2.048C0.768372 1.34192 1.34214 0.767803 2.048 0.408C2.492 0.182 2.972 0.0880002 3.518 0.0430002C4.049 0 4.705 0 5.518 0Z" fill="#1B204C"/></svg>';
}

function iec_voucher_download_icon(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 14" fill="none" aria-hidden="true" focusable="false"><path d="M6.66667 9.64584L3.08333 6.41667C2.91667 6.25 3.08333 5.25 3.25 5.08334C4.10472 5.06306 4.27083 5.22917L5.83333 6.79167V0.833336C6.23333 0.0805585 6.43111 0.000558429 6.66667 0C7.10028 0.0794474 7.42139 0.400559 7.5 0.833336V6.79167L9.0625 5.22917C10.0839 5.08278 10.25 5.25C10.4172 6.25 10.25 6.41667L7.25 9.41667C7.16667 9.5 6.77778 9.64639 6.66667 9.64584ZM1.66667 13.3333C1.20833 13.3333 0.49 12.8442C0.163889 12.5181 0 11.6667V10C0 9.76389 0.24 9.40667C0.597778 9.16723 0.833333 9.16667C1.06889 9.16611 1.4275 9.40667 1.66667 10V11.6667H11.6667V10C12.0667 9.24723 12.5 9.16667C12.7356 9.16611 13.0942 9.40667C13.3333 10V11.6667C13.3333 12.125 12.5181 13.1708 11.6667 13.3333H1.66667Z" fill="white"/></svg>';
}

function iec_voucher_accordion_icon(): string {
	return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M2 11L8 5L14 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

function iec_voucher_arch_link_icon(): string {
	return '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="white"/></svg>';
}
