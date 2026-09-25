<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section     = $args['section'] ?? array();
$items_key   = $args['items_key'] ?? '';
$variant     = $args['variant'] ?? '';
$extra_class = $args['extra_class'] ?? '';
$title       = $section['section_title'] ?? '';
$items       = $items_key ? ( $section[ $items_key ] ?? array() ) : array();

if ( empty( $items ) || ! is_array( $items ) ) {
	return;
}

$section_class = 'iec_iot_accordian_section iec_defualt_position';

if ( 'maritime' === $variant ) {
	$section_class .= ' iec_iot_accordian_maritime';
}

if ( $extra_class ) {
	$section_class .= ' ' . $extra_class;
}

$wrapper_class = 'iec_iot_main_accordian_warpper need-accordions-widget';

if ( $variant ) {
	$wrapper_class .= ' ' . $variant;
}
?>
<section class="<?= $section_class; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $title ) : ?>
					<h2 class="iec_section_heading iec-section-heading"><?= $title; ?></h2>
				<?php endif; ?>

				<div class="<?= $wrapper_class; ?>" data-iec-accordion="expand">

					<?php foreach ( $items as $index => $item ) : ?>

						<?php
						if ( ! is_array( $item ) ) {
							continue;
						}

						$is_open = 0 === (int) $index;
						?>

						<div class="item<?= $is_open ? ' expand' : ''; ?>">
							<div class="iec_iot_accordian_warpper iec_iot_accordian_header title">
								<h3><?= $item['caption'] ?? ''; ?></h3>
							</div>
							<div class="iec_iot_accordian_warpper iec_iot_accordian_body content">
								<?= $item['content'] ?? ''; ?>
							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>
