<?php
/**
 * Operator — land & remote operations.
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
	array( 'num' => '01', 'title' => 'Remote site broadband', 'text' => 'Camps, plants, lodges and offices beyond fibre — a fixed terminal delivering site-wide connectivity.' ),
	array( 'num' => '02', 'title' => 'Rapid deployment', 'text' => 'Disaster response and emergency operations where a link has to be running within the hour.' ),
	array( 'num' => '03', 'title' => 'Vehicles & convoys', 'text' => 'In-motion connectivity for fleets, mobile command posts and field logistics.' ),
	array( 'num' => '04', 'title' => 'Construction & projects', 'text' => 'Temporary connectivity that moves as the project moves, without a fixed-line contract.' ),
	array( 'num' => '05', 'title' => 'Backup & failover', 'text' => 'A resilient second path for sites where a terrestrial outage stops operations.' ),
	array( 'num' => '06', 'title' => 'Field teams', 'text' => 'Portable kits for survey, media, NGO and inspection teams working away from any network.' ),
);
?>
<section class="slo-sec slo-use" id="land" aria-labelledby="slo-land-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Land</span>
			<h2 id="slo-land-heading" class="slo-h2">Starlink for Land &amp; Remote Operations</h2>
			<div class="wyswig-content">
				<p>Fixed sites, mobile teams and temporary deployments — the three land patterns, and what each one needs.</p>
			</div>
		</div>

		<div class="slo-use__grid slo-use__grid--3">
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
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Starlink land solutions</a>
			<a class="gray_btn" href="#products">See hardware</a>
		</div>
	</div>
</section>
