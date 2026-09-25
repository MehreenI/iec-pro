<?php
/**
 * Starlink Operator — global coverage (full-bleed navy + map).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$map_url = 'https://staging.iec-telecom.com/wp-content/uploads/2026/08/coverage-side-1-2.webp';

$notes = array(
	array( 'Land', 'Service is tied to the country a terminal operates in and its regulatory status.' ),
	array( 'Sea', 'Maritime coverage spans the major shipping and sailing routes. Polar latitudes above roughly 75° remain limited.' ),
	array( 'Territorial waters', 'Coastal and port areas fall under the coastal state’s licensing, not open-ocean rules.' ),
	array( 'Always verify', 'Status changes month to month. Confirm the official map before committing to a route or site.' ),
);
?>
<section
	class="slo-coverage"
	id="coverage"
	aria-labelledby="slo-coverage-heading"
	style="--slo-coverage-map: url('<?php echo esc_url( $map_url ); ?>');"
>
	<div class="slo-coverage__map" aria-hidden="true"></div>

	<div class="container">
		<div class="slo-coverage__copy slo-reveal">
			<span class="iec_home_eyebrow">Coverage</span>
			<h2 id="slo-coverage-heading">Starlink Coverage Map</h2>
			<div class="wyswig-content">
				<p>Starlink’s constellation provides near-global coverage, including all major ocean sailing routes. What varies is not whether satellites pass overhead but whether service is licensed in that country — and that is the check that matters before a deployment.</p>
			</div>

			<div class="slo-coverage__notes">
				<?php foreach ( $notes as $note ) : ?>
					<div class="slo-coverage__note">
						<b><?php echo esc_html( $note[0] ); ?></b>
						<span><?php echo esc_html( $note[1] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="slo-actions">
				<a class="iec_button iec_blue_gradient" href="#availability">See availability by region</a>
				<a class="gray_btn" href="#products">Explore hardware</a>
			</div>
		</div>
	</div>
</section>
