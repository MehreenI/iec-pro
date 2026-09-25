<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = get_sub_field( 'kf_heading' ) ?: __( 'KEY FEATURES', 'bbtheme' );
$features = get_sub_field( 'kf_features' ) ?: array();

if ( empty( $features ) ) {
	return;
}

$items = array();

foreach ( $features as $index => $feature ) {

	if ( ! is_array( $feature ) || empty( $feature['kf_feature_title'] ) ) {
		continue;
	}

	$items[] = array(
		'id'           => 'kf-item-' . $index,
		'title'        => $feature['kf_feature_title'],
		'description'  => $feature['kf_feature_description'] ?? '',
		'open_default' => $index < 2,
	);

}

get_template_part(
	'template-parts/modules/use-cases',
	null,
	array(
		'enabled' => true,
		'heading' => $heading,
		'items'   => $items,
	)
);
