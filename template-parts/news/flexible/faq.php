<?php
/**
 * Flexible: faq
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$heading = $block['heading'] ?? '';
$faqs    = is_array( $block['fqas'] ?? null ) ? $block['fqas'] : array();

if ( empty( $faqs ) ) {
	return;
}
?>
<section class="iec_faq_section iec_single_news_main_section iec_defualt_position news_accordion">
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-md-12">
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-12">
				<div class="iec_faq_grid">
					<?php foreach ( $faqs as $item ) : ?>
						<?php
						if ( ! is_array( $item ) || empty( $item['question'] ) ) {
							continue;
						}
						?>
						<div class="iec_faq_item">
							<div class="iec_faq_header" aria-expanded="false" role="button" tabindex="0">
								<h3 class="iec_faq_title"><?= $item['question']; ?></h3>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="iec_faq_icon" aria-hidden="true">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</div>
							<div class="iec_faq_answer">
								<div class="iec_faq_answer_inner wysiwyg-content">
									<?= $item['answer'] ?? ''; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
