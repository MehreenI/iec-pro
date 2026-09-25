<?php
/**
 * Reusable accordion — expand (IoT) or toggle (market detail) layouts.
 *
 * @package iec
 *
 * Args:
 * - items: array of {caption, content}
 * - title: section heading
 * - type: expand|toggle (default expand)
 * - layout: single|columns (default single)
 * - variant: string modifier (e.g. maritime for colored rows)
 * - section_class, wrapper_class, extra_class
 * - open_first: bool (default true for expand)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items         = $args['items'] ?? array();
$title         = $args['title'] ?? '';
$type          = $args['type'] ?? 'expand';
$layout        = $args['layout'] ?? 'single';
$variant       = $args['variant'] ?? '';
$section_class = $args['section_class'] ?? '';
$wrapper_class = $args['wrapper_class'] ?? '';
$extra_class   = $args['extra_class'] ?? '';
$open_first    = $args['open_first'] ?? true;

if ( empty( $items ) || ! is_array( $items ) ) {
	return;
}

if ( 'toggle' === $type ) {
	$section_classes = array_filter(
		array(
			'iec_vertical_market_accordion',
			'iec_defualt_position',
			$section_class,
		)
	);
	?>
	<section class="<?= esc_attr( implode( ' ', $section_classes ) ); ?>" data-iec-accordion="toggle">
		<div class="container">
			<?php if ( $title ) : ?>
				<div class="row">
					<div class="col-md-12">
						<h2 class="iec_iot_section_heading"><?= $title; ?></h2>
					</div>
				</div>
			<?php endif; ?>
			<div class="row">
				<?php
				$render_column = static function ( array $list, int $parity ) {
					?>
					<div class="col-lg-6">
						<?php
						foreach ( $list as $index => $item ) {
							if ( ! is_array( $item ) || $index % 2 !== $parity ) {
								continue;
							}
							$caption = $item['caption'] ?? '';
							?>
							<div class="iec_vertical_market_accordion_box_warpper">
								<div class="title">
									<h5><?= $caption; ?></h5>
								</div>
								<div class="content">
									<?php
									if ( ! empty( $item['content'] ) ) {
										echo wp_kses_post( $item['content'] );
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				};
				$render_column( $items, 0 );
				$render_column( $items, 1 );
				?>
			</div>
		</div>
	</section>
	<?php
	return;
}

$section_classes = array_filter(
	array(
		'iec_iot_accordian_section',
		'iec_defualt_position',
		$section_class,
		$extra_class,
	)
);

$wrapper_classes = array(
	'iec_iot_main_accordian_warpper',
	'need-accordions-widget',
	$wrapper_class,
);

if ( $variant ) {
	$wrapper_classes[] = $variant;
}
?>

<section class="<?= esc_attr( implode( ' ', $section_classes ) ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( $title ) : ?>
					<h2 class="iec_iot_section_heading"><?= $title; ?></h2>
				<?php endif; ?>
				<div
					class="<?= esc_attr( implode( ' ', array_filter( $wrapper_classes ) ) ); ?>"
					data-iec-accordion="expand"
				>
					<?php foreach ( $items as $index => $item ) : ?>
						<?php
						$is_open = $open_first && 0 === (int) $index;
						?>
						<div class="item<?= $is_open ? ' expand' : ''; ?>">
							<div class="iec_iot_accordian_warpper iec_iot_accordian_header title">
								<h5><?= $item['caption'] ?? ''; ?></h5>
							</div>
							<div class="iec_iot_accordian_warpper iec_iot_accordian_body content">
								<?= wp_kses_post( $item['content'] ?? '' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
