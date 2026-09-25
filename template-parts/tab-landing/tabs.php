<?php
/**
 * Tunisian / tab landing — tab buttons + Swiper panels.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) || ! isset( $iec_tab_landing ) ) {
	return;
}

$tabs = $iec_tab_landing->field( 'tabs', [] );

if ( ! is_array( $tabs ) || $tabs === [] ) {
	return;
}

$partials = array(
	'about_content',
	'department_content',
	'contact_content',
);
?>
<div class="iec_single_office_tab_section iec_tab_landing_tab_section">
	<div class="iec_single_office_tabs_warpper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="custom-tab-container" data-tab-landing-tabs>
						<div class="custom-tab-buttons" role="tablist">
							<?php foreach ( $tabs as $index => $tab ) :
								if ( ! is_array( $tab ) ) {
									continue;
								}
								$label = (string) ( $tab['tab_name'] ?? '' );
								if ( $label === '' ) {
									continue;
								}
								?>
								<button
									type="button"
									class="custom-tab-btn<?= 0 === (int) $index ? ' active' : ''; ?>"
									data-tab-index="<?= esc_attr( (string) $index ); ?>"
									role="tab"
									aria-selected="<?= 0 === (int) $index ? 'true' : 'false'; ?>"
									aria-controls="iec-tab-panel-<?= esc_attr( (string) $index ); ?>"
								>
									<?= $label; ?>
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="iec_tab_landing_panels">
		<div class="swiper iec_tab_landing_tabs_swiper" data-tab-landing-swiper>
			<div class="swiper-wrapper">
				<?php
				foreach ( $tabs as $index => $tab ) :
					$partial_slug = $partials[ $index ] ?? '';
					if ( $partial_slug === '' ) {
						continue;
					}
					$partial_path = get_template_directory() . '/template-parts/tab-landing/' . $partial_slug . '.php';
					if ( ! is_readable( $partial_path ) ) {
						continue;
					}
					?>
					<div
						class="swiper-slide"
						id="iec-tab-panel-<?= esc_attr( (string) $index ); ?>"
						role="tabpanel"
					>
						<?php include $partial_path; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
