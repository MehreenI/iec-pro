<?php
/**
 * Starlink Operator — regional availability.
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

$guides = array(
	array(
		'status' => 'pend',
		'label'  => 'Pending approval',
		'title'  => 'Türkiye',
		'desc'   => 'Not yet licensed. What operators in Türkiye can use today instead.',
	),
	array(
		'status' => 'live',
		'label'  => 'Available',
		'title'  => 'Kazakhstan',
		'desc'   => 'Live since 2025. Ordering, installation and coverage across the regions.',
	),
	array(
		'status' => 'slot',
		'label'  => 'Status',
		'title'  => 'Singapore',
		'desc'   => 'Business, maritime and port use in a market with strong terrestrial infrastructure.',
	),
	array(
		'status' => 'live',
		'label'  => 'Available',
		'title'  => 'Malaysia',
		'desc'   => 'Live service. Plans, hardware and use across remote and island sites.',
	),
);

$regions = array(
	'me' => array(
		'label'  => 'Middle East & Türkiye',
		'chips'  => array(
			array( 'live', 'Israel' ),
			array( 'pend', 'Türkiye' ),
			array( 'pend', 'Saudi Arabia' ),
			array( 'no', 'Syria' ),
		),
	),
	'ap' => array(
		'label' => 'Asia-Pacific',
		'chips' => array(
			array( 'live', 'Indonesia' ),
			array( 'live', 'Malaysia' ),
			array( 'live', 'Philippines' ),
			array( 'live', 'Kazakhstan' ),
			array( 'live', 'Mongolia' ),
			array( 'live', 'Japan' ),
			array( 'live', 'South Korea' ),
			array( 'live', 'Australia' ),
			array( 'live', 'New Zealand' ),
			array( 'live', 'Sri Lanka' ),
			array( 'live', 'Bangladesh' ),
			array( 'live', 'Maldives' ),
			array( 'pend', 'India — partial rollout' ),
			array( 'pend', 'Vietnam — licensed, launching' ),
			array( 'pend', 'Pakistan' ),
			array( 'pend', 'Thailand' ),
			array( 'no', 'China' ),
			array( 'no', 'Hong Kong' ),
			array( 'no', 'North Korea' ),
			array( 'no', 'Afghanistan' ),
		),
	),
	'af' => array(
		'label' => 'Africa',
		'chips' => array(
			array( 'live', 'Kenya' ),
			array( 'live', 'Nigeria' ),
			array( 'live', 'Ghana' ),
			array( 'live', 'Rwanda' ),
			array( 'live', 'Zambia' ),
			array( 'live', 'Zimbabwe' ),
			array( 'live', 'Botswana' ),
			array( 'live', 'Mozambique' ),
			array( 'live', 'Madagascar' ),
			array( 'live', 'Cape Verde' ),
			array( 'pend', 'South Africa' ),
			array( 'pend', 'Egypt' ),
			array( 'pend', 'Morocco' ),
			array( 'pend', 'Tunisia' ),
			array( 'pend', 'Algeria' ),
			array( 'pend', 'Senegal' ),
			array( 'pend', 'Namibia' ),
		),
	),
	'eu' => array(
		'label' => 'Europe',
		'chips' => array(
			array( 'live', 'Greece' ),
			array( 'live', 'Cyprus' ),
			array( 'live', 'Malta' ),
			array( 'live', 'Croatia' ),
			array( 'live', 'Slovenia' ),
			array( 'live', 'Hungary' ),
			array( 'live', 'Romania' ),
			array( 'live', 'Bulgaria' ),
			array( 'live', 'Lithuania' ),
			array( 'live', 'Latvia' ),
			array( 'live', 'Estonia' ),
			array( 'live', 'Iceland' ),
			array( 'pend', 'Serbia' ),
			array( 'pend', 'Bosnia & Herzegovina' ),
			array( 'pend', 'Montenegro' ),
			array( 'pend', 'Albania' ),
			array( 'no', 'Russia' ),
			array( 'no', 'Belarus' ),
		),
	),
	'am' => array(
		'label' => 'Americas',
		'chips' => array(
			array( 'live', 'United States' ),
			array( 'live', 'Canada' ),
			array( 'live', 'Mexico' ),
			array( 'live', 'Brazil' ),
			array( 'live', 'Argentina' ),
			array( 'live', 'Chile' ),
			array( 'live', 'Peru' ),
			array( 'live', 'Colombia' ),
			array( 'live', 'Ecuador' ),
			array( 'live', 'Costa Rica' ),
			array( 'live', 'Panama' ),
			array( 'live', 'Jamaica' ),
		),
	),
);

$first_region = array_key_first( $regions );
?>
<section class="slo-sec slo-sec--surface slo-avail" id="availability" aria-labelledby="slo-avail-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Availability</span>
			<h2 id="slo-avail-heading" class="slo-h2">Where is Starlink Available?</h2>
			<div class="wyswig-content">
				<p>Starlink’s satellites pass over almost everywhere. Service, however, requires a licence from each national regulator — so the question is never whether Starlink reaches a country, but whether it is licensed there yet.</p>
			</div>
		</div>

		<div class="slo-avail__block slo-reveal">
			<span class="slo-avail__subhead">Country guides</span>
			<div class="slo-avail__guides">
				<?php foreach ( $guides as $guide ) : ?>
					<a class="slo-avail__guide" href="<?php echo esc_url( $contact_url ); ?>">
						<span class="slo-avail__badge slo-avail__badge--<?php echo esc_attr( $guide['status'] ); ?>"><?php echo esc_html( $guide['label'] ); ?></span>
						<strong><?php echo esc_html( $guide['title'] ); ?></strong>
						<span class="slo-avail__desc"><?php echo esc_html( $guide['desc'] ); ?></span>
						<span class="slo-avail__go">Ask about this market →</span>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="slo-avail__note">More country guides are being added. <a href="<?php echo esc_url( $contact_url ); ?>">Ask us about a country</a> that is not listed yet.</p>
		</div>

		<div class="slo-avail__block slo-reveal">
			<span class="slo-avail__subhead">Status by region</span>
			<div class="wyswig-content">
				<p>A quick reference, not a live feed. Status reflects national licensing, which changes month to month — always confirm on the official Starlink map before ordering hardware or committing to a route.</p>
			</div>

			<div class="slo-avail__key" role="list">
				<span class="slo-avail__key-item" role="listitem"><i class="slo-dot slo-dot--live" aria-hidden="true"></i>Available — licensed and live</span>
				<span class="slo-avail__key-item" role="listitem"><i class="slo-dot slo-dot--pend" aria-hidden="true"></i>Pending — in the regulatory process</span>
				<span class="slo-avail__key-item" role="listitem"><i class="slo-dot slo-dot--no" aria-hidden="true"></i>Restricted — service not permitted</span>
			</div>

			<div class="slo-avail__tabs" data-slo-tabs>
				<div class="slo-avail__tabnav" role="tablist" aria-label="Regions">
					<?php foreach ( $regions as $key => $region ) : ?>
						<button
							type="button"
							class="slo-avail__tab<?php echo $key === $first_region ? ' is-active' : ''; ?>"
							role="tab"
							id="slo-tab-<?php echo esc_attr( $key ); ?>"
							aria-selected="<?php echo $key === $first_region ? 'true' : 'false'; ?>"
							aria-controls="slo-panel-<?php echo esc_attr( $key ); ?>"
							data-slo-tab="<?php echo esc_attr( $key ); ?>"
						><?php echo esc_html( $region['label'] ); ?></button>
					<?php endforeach; ?>
				</div>

				<?php foreach ( $regions as $key => $region ) : ?>
					<div
						class="slo-avail__panel<?php echo $key === $first_region ? ' is-active' : ''; ?>"
						role="tabpanel"
						id="slo-panel-<?php echo esc_attr( $key ); ?>"
						aria-labelledby="slo-tab-<?php echo esc_attr( $key ); ?>"
						<?php echo $key === $first_region ? '' : ' hidden'; ?>
					>
						<div class="slo-avail__chips">
							<?php foreach ( $region['chips'] as $chip ) : ?>
								<span class="slo-avail__chip">
									<i class="slo-dot slo-dot--<?php echo esc_attr( $chip[0] ); ?>" aria-hidden="true"></i>
									<?php echo esc_html( $chip[1] ); ?>
								</span>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="slo-avail__verify slo-reveal">
			<div>
				<strong>Always verify before you commit</strong>
				<span>Compiled from public trackers of Starlink’s official availability data, not from a live feed. Confirm against starlink.com/map before ordering hardware or committing to a route.</span>
			</div>
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Ask us to confirm a country</a>
		</div>
	</div>
</section>
