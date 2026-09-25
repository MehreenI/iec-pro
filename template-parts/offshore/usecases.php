<?php
/**
 * Offshore — use cases accordion.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_usecases' );

if ( empty( $section['enabled'] ) ) {
	return;
}

$heading = ! empty( $section['heading'] ) ? $section['heading'] : 'Use Cases';
$items   = is_array( $section['items'] ?? null ) ? $section['items'] : array();

$items = array_values(
	array_filter(
		$items,
		static function ( $item ) {
			return is_array( $item ) && ! empty( $item['title'] );
		}
	)
);

if ( $items === array() ) {
	return;
}

?>
<section class="iec_default_position iec_use_case_accordion iec-offshore-usecases-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="iec_main_heading text_blue text_right mb-5" data-aos="fade-up"><?php echo $heading; ?></h2>

				<div class="faq-grid" data-offshore-accordion>
					<?php foreach ( $items as $index => $item ) :
						$open  = ! empty( $item['open_default'] );
						$delay = (int) ( $index * 80 );
						?>
						<div class="accordion-item custom-faq-item<?php echo $open ? ' faq-item-active' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( (string) $delay ); ?>">
							<button type="button" class="accordion-header<?php echo $open ? ' active' : ''; ?>">
								<span><?php echo $item['title']; ?></span>
								<div class="icon" aria-hidden="true"></div>
							</button>
							<div class="accordion-content<?php echo $open ? ' open' : ''; ?>">
								<?php if ( ! empty( $item['description'] ) ) : ?>
									<p><?php echo $item['description']; ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
