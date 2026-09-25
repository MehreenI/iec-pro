<?php

if ( ! defined( 'ABSPATH' ) || ! isset( $iec_tab_landing ) ) {
	return;
}

$contact_us = $iec_tab_landing->field( 'contact_us', [] );

if ( ! is_array( $contact_us ) || empty( $contact_us ) ) {
	return;
}

$heading        = (string) ( $contact_us['heading']        ?? '' );
$address_detail = $contact_us['address_detail'] ?? [];
$iframe_heading = (string) ( $contact_us['iframe_heading'] ?? '' );
$google_map     = (string) ( $contact_us['google_map']     ?? '' );

$map_kses = [
	'iframe' => [
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'frameborder'     => true,
		'style'           => true,
		'allowfullscreen' => true,
		'loading'         => true,
		'referrerpolicy'  => true,
		'allow'           => true,
		'title'           => true,
	],
];
?>
<section id="contact_us" class="iec_slide_contact_us">
	<div class="iec_single_office_tab_contact_us">
		<div class="container">
			<div class="row">

				<div class="col-md-4">
					<?php if ( $heading !== '' ) : ?>
						<h2 class="iec_section_heading"><?= $heading; ?></h2>
					<?php endif; ?>

					<?php foreach ( $address_detail as $address ) :
						if ( ! is_array( $address ) ) {
							continue;
						}
						$addr_heading = (string) ( $address['address_heading'] ?? '' );
						$addr_text    = (string) ( $address['address']         ?? '' );
						$phone        = (string) ( $address['phone_number']    ?? '' );
						$email        = (string) ( $address['email']           ?? '' );
					?>
					<address class="address_detail_repeater">
						<?php if ( $addr_heading !== '' ) : ?>
							<h3 class="address_heading"><?= $addr_heading; ?></h3>
						<?php endif; ?>

						<?php if ( $addr_text !== '' ) : ?>
							<p><?= wp_kses_post( $addr_text ); ?></p>
						<?php endif; ?>
						<ul class="iec_contact_list">
							<?php if ( $phone !== '' ) : ?>
							<li>
								<a href="tel:<?= esc_attr( preg_replace( '/[^\d+\-\(\)\s]/', '', $phone ) ); ?>">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M17.1 5C19.7256 5 22.2437 6.04303 24.1004 7.89964C25.957 9.75625 27 12.2744 27 14.9M17.1 9.4C18.5587 9.4 19.9576 9.97946 20.9891 11.0109C22.0205 12.0424 22.6 13.4413 22.6 14.9M18.0152 21.0248C18.2424 21.1291 18.4983 21.153 18.7409 21.0924C18.9834 21.0318 19.1981 20.8904 19.3495 20.6915L19.74 20.18C19.9449 19.9068 20.2106 19.685 20.5161 19.5323C20.8216 19.3795 21.1585 19.3 21.5 19.3H24.8C25.3835 19.3 25.9431 19.5318 26.3556 19.9444C26.7682 20.3569 27 20.9165 27 21.5V24.8C27 25.3835 26.7682 25.9431 26.3556 26.3556C25.9431 26.7682 25.3835 27 24.8 27C19.5487 27 14.5125 24.9139 10.7993 21.2007C7.08607 17.4875 5 12.4513 5 7.2C5 6.61652 5.23178 6.05695 5.64436 5.64436C6.05695 5.23178 6.61652 5 7.2 5H10.5C11.0835 5 11.6431 5.23178 12.0556 5.64436C12.4682 6.05695 12.7 6.61652 12.7 7.2V10.5C12.7 10.8415 12.6205 11.1784 12.4677 11.4839C12.315 11.7894 12.0932 12.0551 11.82 12.26L11.3052 12.6461C11.1033 12.8003 10.9609 13.0196 10.9024 13.2669C10.8438 13.5141 10.8727 13.774 10.984 14.0024C12.4873 17.0559 14.9599 19.5253 18.0152 21.0248Z" stroke="#727DA3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<?= $phone; ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if ( $email !== '' ) : ?>
							<li>
								<a href="mailto:<?= esc_attr( antispambot( $email ) ); ?>">
									<svg width="28" height="21" viewBox="0 0 28 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M26.25 0C26.7141 0 27.1592 0.184374 27.4874 0.512563C27.8156 0.840752 28 1.28587 28 1.75V19.25C28 19.7141 27.8156 20.1592 27.4874 20.4874C27.1592 20.8156 26.7141 21 26.25 21H1.75C1.28587 21 0.840752 20.8156 0.512563 20.4874C0.184374 20.1592 0 19.7141 0 19.25V1.75C0 1.28587 0.184374 0.840752 0.512563 0.512563C0.840752 0.184374 1.28587 0 1.75 0H26.25ZM26.25 2.98725L15.2513 14.0035C15.0888 14.1675 14.8956 14.2977 14.6826 14.3867C14.4696 14.4757 14.2412 14.5217 14.0104 14.522C13.7795 14.5223 13.5509 14.477 13.3377 14.3886C13.1245 14.3002 12.9309 14.1705 12.768 14.007L1.75 2.98725V18.011L7.2555 12.5055C7.33685 12.4241 7.43343 12.3596 7.53973 12.3156C7.64602 12.2716 7.75995 12.2489 7.875 12.2489C7.99005 12.2489 8.10398 12.2716 8.21027 12.3156C8.31657 12.3596 8.41315 12.4241 8.4945 12.5055C8.57585 12.5869 8.64039 12.6834 8.68442 12.7897C8.72844 12.896 8.75111 13.0099 8.75111 13.125C8.75111 13.2401 8.72844 13.354 8.68442 13.4603C8.64039 13.5666 8.57585 13.6631 8.4945 13.7445L2.9855 19.25H25.0128L19.5055 13.7445C19.3412 13.5802 19.2489 13.3574 19.2489 13.125C19.2489 12.8926 19.3412 12.6698 19.5055 12.5055C19.6698 12.3412 19.8926 12.2489 20.125 12.2489C20.3574 12.2489 20.5802 12.3412 20.7445 12.5055L26.25 18.0128V2.98725ZM25.011 1.75H2.98725L14.0087 12.7715L25.011 1.75Z" fill="#727DA3"/>
									</svg>
									<?= antispambot( $email ); ?>
								</a>
							</li>
							<?php endif; ?>
						</ul>
					</address>
					<?php endforeach; ?>
				</div>

				<div class="col-md-8">
					<?php if ( $iframe_heading !== '' ) : ?>
						<h3 class="address_heading"><?= $iframe_heading; ?></h3>
					<?php endif; ?>

					<?php if ( $google_map !== '' ) : ?>
					<div id="map">
						<?php
						$map = wp_kses( $google_map, $map_kses );
						if ( $map && false === stripos( $map, 'title=' ) ) {
							$map_title = $iframe_heading !== '' ? wp_strip_all_tags( $iframe_heading ) : __( 'Office location map', 'bbtheme' );
							$map = preg_replace( '/<iframe\b/i', '<iframe title="' . esc_attr( $map_title ) . '"', $map, 1 );
						}
						if ( $map && false === stripos( $map, 'loading=' ) ) {
							$map = preg_replace( '/<iframe\b/i', '<iframe loading="lazy"', $map, 1 );
						}
						echo $map;
						?>
					</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
</section>
