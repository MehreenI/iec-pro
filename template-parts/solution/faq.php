<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = is_array( $args['faqs'] ?? null ) ? $args['faqs'] : array();
$list = is_array( $args['list'] ?? null ) ? $args['list'] : array();

if ( $list === array() ) {
	return;
}
?>
<section id="faqs" class="iec_defualt_position iec_single_solution_acordions_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_single_solution_acordions_sec_warpper">
					<h2 class="iec_single_product_section_title"><?= $faqs['heading'] ?? __( 'Frequently Asked Questions', 'bbtheme' ); ?></h2>
					<div class="iec_single_solution_acordion_row">
						<?php foreach ( $list as $index => $faq ) :
							$question = $faq['question'] ?? '';
							if ( ! $question ) {
								continue;
							}
							$panel_id = 'iec-solution-faq-' . (int) $index;
							?>
							<div class="iec_single_solution_acordion_item">
								<button type="button" class="iec_single_solution_acordion_header" aria-expanded="false" aria-controls="<?= esc_attr( $panel_id ); ?>">
									<?= $question; ?>
									<svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M16.6248 6.83301L9.49976 13.958L2.37476 6.83301" stroke="#1B204C" stroke-width="2.27163"/>
									</svg>
								</button>
								<div class="iec_single_solution_acordion_body" id="<?= esc_attr( $panel_id ); ?>">
									<?= wp_kses_post( $faq['answer'] ?? '' ); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
