<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$case  = is_array( $args['case'] ?? null ) ? $args['case'] : array();
$icon  = is_array( $case['icon'] ?? null ) ? $case['icon'] : array();
$title = $case['title'] ?? '';
$desc  = $case['description'] ?? '';
?>
<div class="iec_single_solution_use_cases_box">
	<div class="iec_single_solution_use_cases_box_icon">
		<?php if ( ! empty( $icon['url'] ) ) : ?>
			<img src="<?= esc_url( $icon['url'] ); ?>" alt="<?= esc_attr( wp_strip_all_tags( $title ) ); ?>">
		<?php else : ?>
			<?= iec_solution_check_circle_svg(); ?>
		<?php endif; ?>
	</div>
	<?php if ( $title ) : ?>
		<h3><?= $title; ?></h3>
	<?php endif; ?>
	<?php if ( $desc ) : ?>
		<div><?= wp_kses_post( $desc ); ?></div>
	<?php endif; ?>
</div>
