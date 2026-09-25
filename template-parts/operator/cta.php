<?php
/**
 * Operator — closing authorization band.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['cta'];
$badge = iec_filled(get_sub_field('badge'), $defaults['badge']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$order = iec_link_parts(get_sub_field('order_button'), $defaults['order_button']);
$talk = iec_link_parts(get_sub_field('talk_button'), $defaults['talk_button']);
$points = iec_rows_or_defaults(get_sub_field('points'), $defaults['points']);
?>

<section class="iec-starlink-cta bg_blue" id="order" aria-labelledby="starlink-cta-heading">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-7">
				<div class="iec-starlink-cta-inner">
					<span class="iec-starlink-cta-badge" data-fade="up">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path d="M12 2.6 19.6 6v6.1c0 4.2-3.1 8-7.6 9.3-4.5-1.3-7.6-5.1-7.6-9.3V6L12 2.6Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
							<path d="m8.6 12.2 2.4 2.4 4.4-4.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?= $badge; ?>
					</span>

					<h2 id="starlink-cta-heading" class="iec-section-heading mb-2 text-md-center text-white" data-split="word" data-fade="up"><?= $heading; ?></h2>

					<div class="wysiwyg-content text-md-center" data-fade="up" data-delay="100"><?= $content; ?></div>

					<nav class="navigation-buttons" data-fade="up" data-delay="200">
						<?php if ($order['url']): ?>
							<a href="<?= $order['url']; ?>" class="btn iec-starlink-cta-order"<?= $order['target']; ?>><?= $order['title']; ?></a>
						<?php endif; ?>

						<?php if ($talk['url']): ?>
							<a href="<?= $talk['url']; ?>" class="btn iec-starlink-cta-talk"<?= $talk['target']; ?>><?= $talk['title']; ?></a>
						<?php endif; ?>
					</nav>
				</div>
			</div>

			<?php if ($points): ?>
				<div class="col-md-5">
					<ul class="iec-starlink-cta-points" data-fade="up" data-delay="250" data-stagger=".iec-starlink-cta-points li">
						<?php foreach ($points as $point): ?>
							<li>
								<strong><?= $point['label'] ?? ''; ?></strong>
								<span><?= $point['text'] ?? ''; ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
