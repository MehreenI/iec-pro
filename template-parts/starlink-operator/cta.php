<?php
/**
 * Starlink Operator — final CTA.
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
?>
<section class="slo-sec slo-cta-sec" id="contact" aria-labelledby="slo-cta-heading">
	<div class="container">
		<div class="slo-cta slo-reveal">
			<div class="slo-cta__copy">
				<span class="iec_home_eyebrow">Talk to an Expert</span>
				<h2 id="slo-cta-heading">Find the Right Starlink Solution</h2>
				<div class="wyswig-content">
					<p>Tell us where you operate, what has to stay connected and whether you need an assured backup. We will confirm regulatory status for your region, recommend the kit and plan, and manage the deployment.</p>
				</div>
			</div>
			<div class="slo-actions">
				<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Talk to a Satellite Specialist</a>
			</div>
		</div>
	</div>
</section>
