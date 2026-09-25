<?php
/**
 * Starlink Operator — plan comparison.
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

$side_image = 'https://staging.iec-telecom.com/wp-content/uploads/2026/08/Side-image-1-1.webp';

$rows = array(
	array( 'Best For', 'Business / Home', 'Mobile / Travel', 'Marine / Offshore' ),
	array( 'Download Speed', '100+ Mbps', '100+ Mbps', '100+ Mbps' ),
	array( 'Latency', '20–40 ms', '20–40 ms', '20–40 ms' ),
	array( 'Mobility', 'Fixed Location', 'In-Motion', 'At Sea' ),
	array( 'Priority Data', 'Yes', 'Yes', 'Yes' ),
	array( 'IP Rating', 'IP54', 'IP54', 'IP56' ),
	array( 'Global Coverage', 'Yes', 'Yes', 'Yes' ),
);
?>
<section class="slo-sec slo-plans" id="choose" aria-labelledby="slo-plans-heading">
	<div class="container">
		<div class="slo-section-head slo-section-head--center slo-reveal">
			<span class="iec_home_eyebrow">Find the Right Solution</span>
			<h2 class="slo-h2" id="slo-plans-heading">Choose the Plan That Fits You</h2>
		</div>

		<div class="slo-plans__grid">
			<div class="slo-plans__visual slo-reveal">
				<div class="slo-plans__rings" aria-hidden="true"></div>
				<div class="slo-plans__image">
					<img src="<?php echo esc_url( $side_image ); ?>" alt="Starlink management interfaces on desktop and mobile" width="420" height="520" loading="lazy">
				</div>
			</div>

			<div class="slo-plans__comparison slo-reveal">
				<div class="slo-plans__table" role="table" aria-label="Starlink plan comparison">
					<div class="slo-plans__row slo-plans__row--head" role="row">
						<div class="slo-plans__cell slo-plans__feature-title" role="columnheader">Features</div>
						<div class="slo-plans__cell slo-plans__product-head" role="columnheader"><strong>Standard</strong></div>
						<div class="slo-plans__cell slo-plans__product-head" role="columnheader"><strong>Roam</strong></div>
						<div class="slo-plans__cell slo-plans__product-head" role="columnheader"><strong>Maritime</strong></div>
					</div>
					<?php foreach ( $rows as $row ) : ?>
						<div class="slo-plans__row" role="row">
							<div class="slo-plans__cell slo-plans__label" role="rowheader"><?php echo esc_html( $row[0] ); ?></div>
							<div class="slo-plans__cell" role="cell" data-plan="Standard"><?php echo esc_html( $row[1] ); ?></div>
							<div class="slo-plans__cell" role="cell" data-plan="Roam"><?php echo esc_html( $row[2] ); ?></div>
							<div class="slo-plans__cell" role="cell" data-plan="Maritime"><?php echo esc_html( $row[3] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>

				<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Contact Our Experts</a>
			</div>
		</div>
	</div>
</section>
