<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$height_px = get_sub_field( 'spacer' ) ?: 0;

if ( ! $height_px ) {
	return;
}

$height_rem = round( $height_px / 25.5424, 6 );
?>
<div class="container" style="height: <?= $height_rem; ?>rem;" aria-hidden="true"></div>
