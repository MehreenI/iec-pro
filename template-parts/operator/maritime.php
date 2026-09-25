<?php
/**
 * Operator — maritime solutions.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_url = home_url( '/contact-us/' );
if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$contact_url = iec_resolve_wpml_url( $contact_url );
}

$cards = array(
	array(
		'num'   => '01',
		'title' => 'Merchant & offshore',
		'text'  => 'Operational traffic, cloud applications and crew welfare across international routes.',
	),
	array(
		'num'   => '02',
		'title' => 'Fishing & workboats',
		'text'  => 'Catch reporting, weather routing and keeping crews connected on long trips.',
	),
	array(
		'num'   => '03',
		'title' => 'Yachts & leisure',
		'text'  => 'Guest and crew connectivity at anchor, in port and along coastal routes.',
	),
);
?>
<section class="slo-sec slo-sec--surface slo-use" id="maritime" aria-labelledby="slo-maritime-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Maritime</span>
			<h2 id="slo-maritime-heading" class="slo-h2">Starlink for Maritime</h2>
			<div class="wyswig-content">
				<p>Starlink Maritime is a service tier on the same constellation — prioritised data, ocean coverage and a commercial agreement built for vessels. IEC Telecom handles survey, installation, bandwidth control and failover to your existing VSAT or L-band service.</p>
			</div>
		</div>

		<div class="slo-use__grid">
			<?php foreach ( $cards as $i => $card ) : ?>
				<article class="slo-use__card slo-reveal" style="--i:<?php echo (int) $i; ?>">
					<span class="slo-use__num"><?php echo esc_html( $card['num'] ); ?></span>
					<h3><?php echo esc_html( $card['title'] ); ?></h3>
					<div class="wyswig-content">
						<p><?php echo esc_html( $card['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="slo-actions slo-reveal">
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Starlink Maritime solutions</a>
			<a class="gray_btn" href="#choose">Buying guide</a>
		</div>
	</div>
</section>
