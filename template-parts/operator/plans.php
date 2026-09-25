<?php
/**
 * Operator — plan comparison.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$contact_url = home_url('/contact-us/');
if (function_exists('iec_resolve_wpml_url')) {
    $contact_url = iec_resolve_wpml_url($contact_url);
}

$rows = [
    ['Best For', 'Business / Home', 'Mobile / Travel', 'Marine / Offshore'],
    ['Download Speed', '100+ Mbps', '100+ Mbps', '100+ Mbps'],
    ['Latency', '20–40 ms', '20–40 ms', '20–40 ms'],
    ['Mobility', 'Fixed Location', 'In-Motion', 'At Sea'],
    ['Priority Data', 'Yes', 'Yes', 'Yes'],
    ['IP Rating', 'IP54', 'IP54', 'IP56'],
    ['Global Coverage', 'Yes', 'Yes', 'Yes'],
];
?>
<section class="iec_defualt_position p-3" id="choose" aria-labelledby="choose-heading">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_content_box text-md-center">
					<span class="iec-eyebrow text-md-center"><?php _e('Find the Right Solution', 'iec'); ?></span>
					<h2 id="choose-heading" class="iec-section-heading mb-1 text-md-center" data-split="word" data-fade="up"><?php _e('Choose the Plan That Fits You', 'iec'); ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="iec_content_box">
					<div role="table" aria-label="<?= __('Starlink plan comparison', 'iec'); ?>">
						<div role="row">
							<div role="columnheader"><?php _e('Features', 'iec'); ?></div>
							<div role="columnheader"><strong><?php _e('Standard', 'iec'); ?></strong></div>
							<div role="columnheader"><strong><?php _e('Roam', 'iec'); ?></strong></div>
							<div role="columnheader"><strong><?php _e('Maritime', 'iec'); ?></strong></div>
						</div>
						<?php foreach ($rows as $row): ?>
							<div role="row">
								<div role="rowheader"><?= $row[0]; ?></div>
								<div role="cell" data-plan="Standard"><?= $row[1]; ?></div>
								<div role="cell" data-plan="Roam"><?= $row[2]; ?></div>
								<div role="cell" data-plan="Maritime"><?= $row[3]; ?></div>
							</div>
						<?php endforeach; ?>
					</div>
					<nav class="navigation-buttons">
						<a class="btn secondary-btn" href="<?= $contact_url; ?>"><?php _e('Learn More', 'iec'); ?></a>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
