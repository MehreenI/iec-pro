<?php
/**
 * Starlink Operator — LEO vs GEO comparison.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rows = array(
	array(
		'label' => 'Latency',
		'leo'   => 'Low enough for video calls, VoIP and cloud applications',
		'geo'   => 'Noticeably higher — the signal travels much further',
	),
	array(
		'label' => 'Throughput',
		'leo'   => 'High, but shared — varies with local network demand',
		'geo'   => 'Lower, but committed bandwidth is purchasable',
	),
	array(
		'label' => 'Antenna',
		'leo'   => 'Electronically steered flat panel, no moving parts on most kits',
		'geo'   => 'Often a stabilised dish in a radome',
	),
	array(
		'label' => 'Sky view needed',
		'leo'   => 'A wide field of view — satellites move across the sky constantly',
		'geo'   => 'A single fixed bearing to one satellite',
	),
	array(
		'label' => 'Availability',
		'leo'   => 'Depends on country-level regulatory approval',
		'geo'   => 'Long-established licensing in most markets',
	),
	array(
		'label' => 'Best used as',
		'leo'   => 'Primary high-bandwidth link',
		'geo'   => 'Guaranteed-availability backup, or where Starlink is not licensed',
	),
);
?>
<section class="slo-sec slo-compare" id="why-leo" aria-labelledby="slo-compare-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Why LEO</span>
			<h2 id="slo-compare-heading" class="slo-h2">Starlink vs Traditional Satellite (GEO)</h2>
			<div class="wyswig-content">
				<p>The orbital difference is the whole story. It explains the latency, the coverage behaviour and why many operations still keep a GEO service alongside Starlink.</p>
			</div>
		</div>

		<div class="slo-compare__table slo-reveal" role="table" aria-label="Starlink LEO versus traditional GEO VSAT">
			<div class="slo-compare__row slo-compare__row--head" role="row">
				<div class="slo-compare__cell" role="columnheader"></div>
				<div class="slo-compare__cell" role="columnheader">
					<strong>Starlink (LEO)</strong>
					<span>Thousands of satellites, low orbit</span>
				</div>
				<div class="slo-compare__cell" role="columnheader">
					<strong>Traditional VSAT (GEO)</strong>
					<span>Few satellites, high orbit</span>
				</div>
			</div>
			<?php foreach ( $rows as $row ) : ?>
				<div class="slo-compare__row" role="row">
					<div class="slo-compare__cell slo-compare__label" role="rowheader"><?php echo esc_html( $row['label'] ); ?></div>
					<div class="slo-compare__cell" role="cell" data-col="Starlink (LEO)"><?php echo esc_html( $row['leo'] ); ?></div>
					<div class="slo-compare__cell" role="cell" data-col="Traditional VSAT (GEO)"><?php echo esc_html( $row['geo'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="slo-compare__notice slo-reveal">
			<div class="slo-compare__notice-copy">
				<span class="iec_home_eyebrow">Recommended approach</span>
				<h3>Most operations run both</h3>
				<div class="wyswig-content">
					<p>Starlink carries the bulk of the traffic; a GEO service stays in place as the assured fallback for safety-critical communications and for routes or regions where Starlink is not licensed. IEC Telecom designs and manages the failover between them.</p>
				</div>
			</div>
			<div class="slo-compare__pills">
				<div class="slo-compare__pill">
					<strong>Primary</strong>
					<span>Starlink for crew welfare, operational data, cloud and video.</span>
				</div>
				<div class="slo-compare__pill">
					<strong>Backup</strong>
					<span>GEO or L-band for assured availability and compliance traffic.</span>
				</div>
			</div>
		</div>
	</div>
</section>
