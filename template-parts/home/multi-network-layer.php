<?php
/**
 * Home page — Multi-Network Layer interactive section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$header_logo_white = function_exists( 'get_config' ) ? get_config( 'header_logo_white' ) : array();
$logo_url          = ! empty( $header_logo_white['url'] ) ? $header_logo_white['url'] : '';
$logo_alt          = ! empty( $header_logo_white['alt'] ) ? $header_logo_white['alt'] : 'IEC Telecom';

$layers = array(
	'leo' => array(
		'label'       => 'LEO',
		'sub_label'   => 'High speed, low latency',
		'heading'     => 'LEO — low earth orbit',
		'description' => 'High speed and low latency for bandwidth-hungry operations — video, cloud applications, crew connectivity.',
		'stats'       => array(
			array(
				'label'     => 'Speed',
				'highlight' => 'very high',
			),
			array(
				'label'     => 'Latency',
				'highlight' => '~40 ms',
			),
			array(
				'label'     => 'Best for',
				'highlight' => 'high-bandwidth ops',
			),
		),
	),
	'geo-vsat' => array(
		'label'       => 'GEO VSAT',
		'sub_label'   => 'Wide coverage & reliability',
		'heading'     => 'GEO VSAT — geostationary satellite',
		'description' => 'Proven wide-area coverage for maritime, offshore and remote sites where consistent global reach matters most.',
		'stats'       => array(
			array(
				'label'     => 'Speed',
				'highlight' => 'medium–high',
			),
			array(
				'label'     => 'Latency',
				'highlight' => '~600 ms',
			),
			array(
				'label'     => 'Best for',
				'highlight' => 'global coverage',
			),
		),
	),
	'l-band' => array(
		'label'       => 'L-BAND',
		'sub_label'   => 'Resilient connectivity',
		'heading'     => 'L-BAND — resilient narrowband',
		'description' => 'Mission-critical backup and safety communications when primary links are degraded or unavailable.',
		'stats'       => array(
			array(
				'label'     => 'Speed',
				'highlight' => 'low',
			),
			array(
				'label'     => 'Latency',
				'highlight' => 'low',
			),
			array(
				'label'     => 'Best for',
				'highlight' => 'safety & backup',
			),
		),
	),
	'lte-5g' => array(
		'label'       => 'LTE / 5G',
		'sub_label'   => 'Local & high bandwidth',
		'heading'     => 'LTE / 5G — terrestrial cellular',
		'description' => 'Cost-effective high bandwidth near coast, in port and on land for hybrid network architectures.',
		'stats'       => array(
			array(
				'label'     => 'Speed',
				'highlight' => 'very high',
			),
			array(
				'label'     => 'Latency',
				'highlight' => 'low',
			),
			array(
				'label'     => 'Best for',
				'highlight' => 'coastal operations',
			),
		),
	),
	'managed' => array(
		'label'       => 'Managed by',
		'sub_label'   => 'IEC Telecom',
		'heading'     => 'Managed by IEC Telecom',
		'description' => 'IEC designs, integrates and operates hybrid environments — balancing speed, availability, coverage and resilience across every layer.',
		'stats'       => array(
			array(
				'label'     => 'Service',
				'highlight' => '24/7 NOC support',
			),
			array(
				'label'     => 'Scope',
				'highlight' => 'global delivery',
			),
			array(
				'label'     => 'Best for',
				'highlight' => 'end-to-end hybrid',
			),
		),
		'is_brand'    => true,
	),
);

$plus_icon = '<svg class="iec-mnl__plus" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true" focusable="false"><path d="M15 7V23M7 15H23" stroke="#727DA3" stroke-width="2" stroke-linecap="round"/></svg>';

$arrow_icon = '<svg class="iec-mnl__arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false"><path d="M9 6L15 12L9 18" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$panel_id = 'iec-mnl-panel-' . wp_unique_id();
?>

<section class="bd_section bd_multi_network iec-mnl" data-iec-mnl aria-labelledby="iec-mnl-heading">
	<div class="iec-mnl__inner">
		<header class="iec-mnl__header">
			<h2 class="iec-mnl__heading" id="iec-mnl-heading">Multi-Network Layer – The Differentiator</h2>
			<p class="iec-mnl__intro">
				No single network can meet every operational requirement. IEC designs hybrid environments that balance speed, availability, coverage and resilience.
			</p>
		</header>

		<div class="iec-mnl__nodes-row" role="tablist" aria-label="Network layers">
			<?php
			$layer_keys = array_keys( $layers );
			$last_index = count( $layer_keys ) - 1;

			foreach ( $layer_keys as $index => $layer_id ) :
				$layer      = $layers[ $layer_id ];
				$is_active  = ( 'leo' === $layer_id );
				$is_brand   = ! empty( $layer['is_brand'] );
				$tab_btn_id = 'iec-mnl-tab-' . $layer_id;
				?>
				<?php if ( $is_brand ) : ?>
					<span class="iec-mnl__arrow-wrap" aria-hidden="true"><?php echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>

				<button
					type="button"
					class="iec-mnl-node<?php echo $is_active ? ' is-active' : ''; ?><?php echo $is_brand ? ' iec-mnl-node--brand' : ''; ?>"
					id="<?php echo esc_attr( $tab_btn_id ); ?>"
					role="tab"
					aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $panel_id ); ?>"
					data-mnl-id="<?php echo esc_attr( $layer_id ); ?>"
					<?php echo $is_active ? '' : 'tabindex="-1"'; ?>
				>
					<span class="iec-mnl-node__icon" aria-hidden="true">
						<?php if ( $is_brand && $logo_url ) : ?>
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="" class="iec-mnl-node__logo" width="72" height="72" loading="lazy" decoding="async">
						<?php else : ?>
							<?php get_template_part( 'template-parts/home/multi-network', 'icon-' . $layer_id ); ?>
						<?php endif; ?>
					</span>
					<span class="iec-mnl-node__title"><?php echo $layer['label']; ?></span>
					<span class="iec-mnl-node__sub"><?php echo $layer['sub_label']; ?></span>
				</button>

				<?php if ( $index < $last_index && 'managed' !== $layer_keys[ $index + 1 ] ) : ?>
					<span class="iec-mnl__plus-wrap" aria-hidden="true"><?php echo $plus_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<div
			id="<?php echo esc_attr( $panel_id ); ?>"
			class="iec-mnl__detail-wrap"
			role="tabpanel"
			aria-live="polite"
		>
			<?php foreach ( $layers as $layer_id => $layer ) : ?>
				<div
					class="iec-mnl-detail<?php echo 'leo' === $layer_id ? ' is-active' : ''; ?>"
					data-mnl-detail="<?php echo esc_attr( $layer_id ); ?>"
					<?php echo 'leo' === $layer_id ? '' : 'hidden'; ?>
				>
					<h3 class="iec-mnl-detail__heading"><?php echo $layer['heading']; ?></h3>
					<p class="iec-mnl-detail__text"><?php echo $layer['description']; ?></p>
					<?php if ( ! empty( $layer['stats'] ) ) : ?>
						<ul class="iec-mnl-detail__stats">
							<?php foreach ( $layer['stats'] as $stat ) : ?>
								<li>
									<?php echo $stat['label']; ?>:
									<strong><?php echo $stat['highlight']; ?></strong>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
