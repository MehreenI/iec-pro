<?php
/**
 * Starlink landing — FAQ accordions.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['questions_and_answers'] ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_starlink_acordions_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_starlink_acordions_sec_warpper">
					<h2 class="iec_section_heading iec-section-heading"><?= $fields['faq_title']; ?></h2>
					<div class="iec_starlink_acordion_row">
						<?php foreach ( $fields['questions_and_answers'] as $questionsAndAnswer ) { ?>
							<div class="iec_starlink_acordion_item">
								<div class="iec_starlink_acordion_header">
									<?= $questionsAndAnswer['question']; ?>
									<svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M16.6248 6.83301L9.49976 13.958L2.37476 6.83301" stroke="#1B204C" stroke-width="2.27163"/>
									</svg>
								</div>
								<div class="iec_starlink_acordion_body" style="display: none;">
									<p><?= $questionsAndAnswer['answer']; ?></p>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
