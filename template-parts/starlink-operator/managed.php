<?php
/**
 * Starlink Operator — managed services.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$managed_url = home_url( '/en/value-added-services/' );
if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$managed_url = iec_resolve_wpml_url( $managed_url );
}

$cards = array(
	array( 'icon' => 'O', 'title' => 'OptiView', 'text' => 'Visibility across every terminal — usage, cost and what the traffic is actually doing.' ),
	array( 'icon' => 'S', 'title' => 'OptiShield', 'text' => 'Cybersecurity and traffic filtering for a high-bandwidth link outside your perimeter.' ),
	array( 'icon' => 'B', 'title' => 'Bandwidth control', 'text' => 'Split crew and operational traffic, cap consumption and protect business-critical applications.' ),
	array( 'icon' => 'F', 'title' => 'Hybrid failover', 'text' => 'Automatic switching between Starlink and GEO or L-band when the primary link drops.' ),
	array( 'icon' => 'A', 'title' => 'OneAssist', 'text' => 'Remote diagnostics and maintenance so a fault does not require a site or vessel visit.' ),
	array( 'icon' => '24', 'title' => 'Global Support', 'text' => 'Installation, commissioning and 24/7 technical support in the regions you operate.' ),
);
?>
<section class="slo-sec slo-managed" id="managed" aria-labelledby="slo-managed-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Beyond Connectivity</span>
			<h2 id="slo-managed-heading" class="slo-h2">Starlink + IEC Telecom Managed Services</h2>
			<div class="wyswig-content">
				<p>A raw Starlink terminal gives you bandwidth. It does not give you control over who uses it, protection for what crosses it, or anyone to call when it stops. That is the part IEC Telecom adds.</p>
			</div>
		</div>

		<div class="slo-managed__grid">
			<?php foreach ( $cards as $i => $card ) : ?>
				<article class="slo-managed__card slo-reveal" style="--i:<?php echo (int) $i; ?>">
					<span class="slo-managed__badge" aria-hidden="true"><?php echo esc_html( $card['icon'] ); ?></span>
					<h3><?php echo esc_html( $card['title'] ); ?></h3>
					<div class="wyswig-content">
						<p><?php echo esc_html( $card['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="slo-actions slo-reveal">
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $managed_url ); ?>">Explore managed services</a>
		</div>
	</div>
</section>
