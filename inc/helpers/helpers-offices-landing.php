<?php
// Helpers for the "Offices Landing Page" template.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Map image size (px), used to convert ACF pin coordinates to percentages.
const IEC_OFFICES_MAP_DESKTOP_W = 764;
const IEC_OFFICES_MAP_DESKTOP_H = 744;
const IEC_OFFICES_MAP_MOBILE_W  = 386;
const IEC_OFFICES_MAP_MOBILE_H  = 465;

function iec_offices_float( $value, float $default = 0.0 ): float {
	return ( null === $value || '' === $value ) ? $default : (float) $value;
}

function iec_offices_coord_to_percent( float $coord, int $size ): float {
	return $coord ? round( ( $coord / $size ) * 100, 4 ) : 0.0;
}

function iec_offices_get_languages(): array {
	$current = apply_filters( 'wpml_current_language', null );

	return array(
		'current' => ( is_string( $current ) && '' !== $current && has_filter( 'wpml_object_id' ) ) ? $current : null,
		'default' => apply_filters( 'wpml_default_language', null ),
	);
}

function iec_offices_translate_id( int $post_id, ?string $lang ): int {
	$translated = apply_filters( 'wpml_object_id', $post_id, 'office', true, $lang );

	return $translated ? (int) $translated : $post_id;
}

function iec_offices_format_address( array $detail, string $fallback = '' ): array {
	$heading = $detail['heading'] ?? '';
	$html    = $heading ? '<h6>' . esc_html( $heading ) . '</h6>' : '';
	$html   .= $detail['address'] ?? $fallback;

	return array(
		'address' => $html,
		'phone'   => (string) ( $detail['phone_number'] ?? '' ),
		'email'   => (string) ( $detail['email'] ?? '' ),
	);
}

function iec_offices_prepare_item( array $row, array $langs ): ?array {
	$office = $row['office'] ?? null;
	if ( ! $office instanceof WP_Post ) {
		return null;
	}

	$office_id   = (int) $office->ID;
	$title       = $office->post_title;
	$original_id = iec_offices_translate_id( $office_id, $langs['default'] );
	$link_id     = $langs['current'] ? iec_offices_translate_id( $office_id, $langs['current'] ) : $office_id;

	$details = $row['address_detail'] ?? array();
	$pin_cx  = iec_offices_float( $row['pin_cx'] ?? null );
	$pin_cy  = iec_offices_float( $row['pin_cy'] ?? null );

	return array(
		'title'      => $title,
		'permalink'  => get_permalink( $link_id ),
		'card_class' => 'iec_map_card_' . sanitize_title( get_the_title( $original_id ) ),
		'flag'       => iec_resolve_media_to_url( $row['flag_image'] ?? '' ),
		'pin_label'  => ! empty( $row['pin_label'] ) ? $row['pin_label'] : $title,
		'data_title' => 'IEC TELECOM <br />' . mb_strtoupper( $title ),
		'primary'    => iec_offices_format_address( $details[0] ?? array(), (string) $office->post_content ),
		'secondary'  => iec_offices_format_address( $details[1] ?? array() ),
		'coords'     => array(
			'dx' => iec_offices_coord_to_percent( $pin_cx, IEC_OFFICES_MAP_DESKTOP_W ),
			'dy' => iec_offices_coord_to_percent( $pin_cy, IEC_OFFICES_MAP_DESKTOP_H ),
			// Mobile falls back to desktop coordinates when empty.
			'mx' => iec_offices_coord_to_percent( iec_offices_float( $row['mobile_cx'] ?? null, $pin_cx ), IEC_OFFICES_MAP_MOBILE_W ),
			'my' => iec_offices_coord_to_percent( iec_offices_float( $row['mobile_cy'] ?? null, $pin_cy ), IEC_OFFICES_MAP_MOBILE_H ),
		),
	);
}

function iec_offices_get_items( $rows ): array {
	if ( empty( $rows ) || ! is_array( $rows ) ) {
		return array();
	}

	$langs = iec_offices_get_languages();
	$items = array();

	foreach ( $rows as $row ) {
		$item = is_array( $row ) ? iec_offices_prepare_item( $row, $langs ) : null;
		if ( $item ) {
			$items[] = $item;
		}
	}

	return $items;
}

// Returns an escaped attribute string for a map pointer <a>.
function iec_offices_pointer_attributes( array $item ): string {
	$c     = $item['coords'];
	$style = sprintf( '--dx: %s%%; --dy: %s%%; --mx: %s%%; --my: %s%%;', $c['dx'], $c['dy'], $c['mx'], $c['my'] );

	$attrs = array(
		'href'          => esc_url( $item['permalink'] ),
		'class'         => 'iec_map_pointer',
		'style'         => esc_attr( $style ),
		'data-class'    => esc_attr( $item['card_class'] ),
		'data-image'    => esc_url( $item['flag'] ),
		'data-name'     => esc_attr( wp_strip_all_tags( $item['title'] ) ),
		'data-title'    => esc_attr( $item['data_title'] ),
		'data-address'  => esc_attr( wp_kses_post( $item['primary']['address'] ) ),
		'data-phone'    => esc_attr( $item['primary']['phone'] ),
		'data-email'    => esc_attr( $item['primary']['email'] ),
		'data-address2' => esc_attr( wp_kses_post( $item['secondary']['address'] ) ),
		'data-phone2'   => esc_attr( $item['secondary']['phone'] ),
		'data-email2'   => esc_attr( $item['secondary']['email'] ),
		'data-link'     => esc_url( $item['permalink'] ),
	);

	$html = '';
	foreach ( $attrs as $name => $value ) {
		$html .= sprintf( ' %s="%s"', $name, $value );
	}

	return $html;
}