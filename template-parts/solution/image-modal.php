<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="iec_image_modal_overlay" id="iecModalOverlay" role="dialog" aria-modal="true" aria-label="<?= __( 'Image preview', 'bbtheme' ); ?>">
	<div class="iec_image_modal_box">
		<button class="iec_modal_close" id="iecModalClose" type="button" aria-label="<?= __( 'Close modal', 'bbtheme' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none" aria-hidden="true">
				<rect x="0.916946" y="0.916946" width="38.5117" height="38.5117" rx="19.2559" stroke="#727DA3" stroke-width="1.83389"/>
				<path d="M13.041 27.3055L27.3066 13.04M27.3066 27.3055L13.041 13.04" stroke="#727DA3" stroke-width="2.5216" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</button>
		<img id="iecModalImg" src="" alt="">
	</div>
</div>
