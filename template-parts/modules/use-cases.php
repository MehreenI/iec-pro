<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $args['enabled'] ) ) {
	return;
}

$heading = ! empty( $args['heading'] ) ? $args['heading'] : 'Use Cases';
$items   = is_array( $args['items'] ?? null ) ? $args['items'] : array();

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
				<h2 class="iec_section_heading iec-section-heading" data-aos="fade-up"><?= $heading; ?></h2>
				<div class="faq-grid" data-offshore-accordion>

					<?php foreach ( $items as $index => $item ) : ?>

						<?php
						$open  = ! empty( $item['open_default'] );
						$delay = (int) ( $index * 80 );
						$id    = $item['id'] ?? '';
						?>

						<div class="accordion-item custom-faq-item<?= $open ? ' faq-item-active' : ''; ?>"<?= $id ? ' id="' . $id . '"' : ''; ?> data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
							<button type="button" class="accordion-header<?= $open ? ' active' : ''; ?>">
								<span><?= $item['title']; ?></span>
								<div class="icon" aria-hidden="true"></div>
							</button>

							<div class="accordion-content<?= $open ? ' open' : ''; ?>">

								<?php if ( ! empty( $item['description'] ) ) : ?>

									<p><?= $item['description']; ?></p>

								<?php endif; ?>

							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>
