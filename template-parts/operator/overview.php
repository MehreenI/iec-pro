<?php
/**
 * Operator — overview.
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

$steps = array(
	'Dish / Terminal',
	'LEO Satellite',
	'Ground Gateway',
	'Internet',
);
?>
<section class="slo-sec slo-overview" id="overview" aria-labelledby="slo-overview-heading">
	<div class="container">
		<div class="slo-overview__grid">
			<div class="slo-overview__copy slo-reveal">
				<span class="iec_home_eyebrow">Overview</span>
				<h2 id="slo-overview-heading" class="slo-h2">What is Starlink?</h2>
				<div class="wyswig-content">
					<p>Starlink is a satellite internet network operated by SpaceX. Unlike traditional satellite services that use a small number of satellites in high geostationary orbit, Starlink uses thousands of satellites in low earth orbit — much closer to the ground, so latency is far lower.</p>
					<p>In practice that means video calls, cloud applications and remote access behave closer to a terrestrial connection — which is why Starlink has changed what is realistic for vessels, remote sites and field deployments.</p>
				</div>
				<div class="slo-actions">
					<a class="iec_button iec_blue_gradient" href="#availability">Check country availability</a>
					<a class="gray_btn" href="<?php echo esc_url( $contact_url ); ?>">Talk to a specialist</a>
				</div>
			</div>

			<div class="slo-overview__visual slo-reveal" aria-label="How Starlink connects">
				<div class="slo-overview__flow">
					<?php foreach ( $steps as $i => $step ) : ?>
						<?php if ( $i > 0 ) : ?>
							<span class="slo-overview__arrow" aria-hidden="true">→</span>
						<?php endif; ?>
						<div class="slo-overview__node">
							<span class="slo-overview__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<span><?php echo esc_html( $step ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
