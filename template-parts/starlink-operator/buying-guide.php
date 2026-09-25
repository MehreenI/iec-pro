<?php
/**
 * Starlink Operator — buying guide.
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

$rows = array(
	array(
		'q' => 'Where is it mounted?',
		'if' => 'On a vessel, at sea',
		'then' => 'Flat High Performance + Maritime tier',
	),
	array(
		'q' => 'Does it move while connected?',
		'if' => 'Vehicles, convoys, in-motion use',
		'then' => 'In-motion rated kit + mobility plan',
	),
	array(
		'q' => 'How many users?',
		'if' => 'A whole site or camp',
		'then' => 'Performance kit + network management',
	),
	array(
		'q' => 'Does it need to be carried?',
		'if' => 'Field teams, one bag, low power',
		'then' => 'Starlink Mini',
	),
	array(
		'q' => 'Is it licensed where you operate?',
		'if' => 'Country is pending or restricted',
		'then' => 'A GEO or L-band service instead',
	),
);
?>
<section class="slo-sec slo-buy" id="choose" aria-labelledby="slo-buy-heading">
	<div class="container">
		<div class="slo-section-head slo-reveal">
			<span class="iec_home_eyebrow">Buying Guide</span>
			<h2 id="slo-buy-heading" class="slo-h2">Choosing the Right Starlink Setup</h2>
			<div class="wyswig-content">
				<p>Five questions get you to a kit and a plan. Work down the list and the shortlist narrows quickly.</p>
			</div>
		</div>

		<div class="slo-buy__table slo-reveal" role="table" aria-label="Starlink buying guide">
			<div class="slo-buy__row slo-buy__row--head" role="row">
				<div class="slo-buy__cell" role="columnheader">The question</div>
				<div class="slo-buy__cell" role="columnheader">If this…</div>
				<div class="slo-buy__cell" role="columnheader">…then look at</div>
			</div>
			<?php foreach ( $rows as $row ) : ?>
				<div class="slo-buy__row" role="row">
					<div class="slo-buy__cell slo-buy__q" role="rowheader"><?php echo esc_html( $row['q'] ); ?></div>
					<div class="slo-buy__cell" role="cell" data-col="If this"><?php echo esc_html( $row['if'] ); ?></div>
					<div class="slo-buy__cell" role="cell" data-col="Then look at"><strong><?php echo esc_html( $row['then'] ); ?></strong></div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="slo-actions slo-reveal">
			<a class="iec_button iec_blue_gradient" href="<?php echo esc_url( $contact_url ); ?>">Get a recommendation</a>
			<a class="gray_btn" href="#products">Browse products</a>
		</div>
	</div>
</section>
