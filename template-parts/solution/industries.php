<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = is_array( $args['items'] ?? null ) ? $args['items'] : array();

if ( $items === array() ) {
	return;
}
?>
<section id="industries" class="iec_single_solution_use_cases">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?= __( 'Industries', 'bbtheme' ); ?></h2>
				<div class="iec_single_solution_use_cases_box_grid">
					<?php foreach ( $items as $item ) :
						$title = $item['title'] ?? ( $item['text'] ?? '' );
						$desc  = $item['description'] ?? ( $item['body'] ?? '' );
						$image = is_array( $item['image'] ?? null ) ? $item['image'] : array();
						$href  = '';
						if ( function_exists( 'iec_resolve_wpml_url' ) ) {
							$href = (string) iec_resolve_wpml_url( $item['link'] ?? '' );
						} elseif ( is_array( $item['link'] ?? null ) ) {
							$href = $item['link']['url'] ?? '';
						}
						?>
						<div class="iec_single_solution_use_cases_box">
							<?php if ( ! empty( $image['url'] ) ) : ?>
								<div class="iec_single_solution_use_cases_box_icon">
									<img src="<?= esc_url( $image['url'] ); ?>" alt="<?= esc_attr( wp_strip_all_tags( $title ) ); ?>">
								</div>
							<?php endif; ?>
							<?php if ( $title ) : ?>
								<h3><?= $title; ?></h3>
							<?php endif; ?>
							<?php if ( $desc ) : ?>
								<div><?= wp_kses_post( $desc ); ?></div>
							<?php endif; ?>
							<?php if ( $href ) : ?>
								<a href="<?= esc_url( $href ); ?>"><?= __( 'Learn more', 'bbtheme' ); ?></a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
