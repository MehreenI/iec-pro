<?php
/**
 * Starlink landing — benefits (two type columns).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['types'] ) ) {
	return;
}
?>
<section class="iec_benefits_section iec_defualt_position">
	<img src="<?= get_template_directory_uri(); ?>/assets/img/starlink_landing/benefits-bg.png" class="iec_benefits_bg" alt="">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_benefits_box_warpper">
					<div class="iec_benefits_box">
						<h2 class="iec_section_heading">
							<span><?= $fields['types'][0]['type_title']; ?></span>
							<span><?= $fields['types'][0]['type_title']; ?></span>
							<span><?= $fields['types'][0]['type_title']; ?></span>
						</h2>
						<ul class="iec_benefits_items_lists left">
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][0]['features'][0]['title']; ?></h3>
										<h4><?= $fields['types'][0]['features'][0]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][0]['features'][0]['icon']; ?>" alt="<?= $fields['types'][0]['features'][0]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="457" height="2" viewBox="0 0 457 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H457" stroke="#F3F2F4"/>
									</svg>
								</div>
								<div class="is--mobile">
									<svg width="457" height="2" viewBox="0 0 457 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H457" stroke="#F3F2F4"/>
									</svg>
								</div>
							</li>
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][0]['features'][1]['title']; ?></h3>
										<h4><?= $fields['types'][0]['features'][1]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][0]['features'][1]['icon']; ?>" alt="<?= $fields['types'][0]['features'][1]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="541" height="2" viewBox="0 0 541 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H541" stroke="#F3F2F4"/>
									</svg>
								</div>
								<div class=" is--mobile">
									<svg width="541" height="2" viewBox="0 0 541 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H541" stroke="#F3F2F4"/>
									</svg>
								</div>
							</li>
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][0]['features'][2]['title']; ?></h3>
										<h4><?= $fields['types'][0]['features'][2]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][0]['features'][2]['icon']; ?>" alt="<?= $fields['types'][0]['features'][2]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="601" height="2" viewBox="0 0 601 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H600.644" stroke="#F3F2F4"/>
									</svg>
								</div>
								<div class="is--mobile">
									<svg width="601" height="2" viewBox="0 0 601 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H600.644" stroke="#F3F2F4"/>
									</svg>
								</div>
								<span class="sub"><?= $fields['types'][0]['features'][2]['sub']; ?></span>
							</li>
						</ul>
					</div>
					<div class="iec_benefits_box">
						<h2 class="iec_section_heading">
							<span><?= $fields['types'][1]['type_title']; ?></span>
							<span><?= $fields['types'][1]['type_title']; ?></span>
							<span><?= $fields['types'][1]['type_title']; ?></span>
						</h2>
						<ul class="iec_benefits_items_lists right">
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][1]['features'][0]['title']; ?></h3>
										<h4><?= $fields['types'][1]['features'][0]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][1]['features'][0]['icon']; ?>" alt="<?= $fields['types'][1]['features'][0]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
								<div class=" is--mobile">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
							</li>
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][1]['features'][1]['title']; ?></h3>
										<h4><?= $fields['types'][1]['features'][1]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][1]['features'][1]['icon']; ?>" alt="<?= $fields['types'][1]['features'][1]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
								<div class=" is--mobile">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
							</li>
							<li class="iec_benefits_item_warpper">
								<div class="iec_benefits_item">
									<div class="iec_benefits_item_content">
										<h3><?= $fields['types'][1]['features'][2]['title']; ?></h3>
										<h4><?= $fields['types'][1]['features'][2]['description']; ?></h4>
									</div>
									<div class="iec_benefits_item_image">
										<img src="<?= $fields['types'][1]['features'][2]['icon']; ?>" alt="<?= $fields['types'][1]['features'][2]['title']; ?>">
									</div>
								</div>
								<div class="bottom">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
								<div class=" is--mobile">
									<svg width="389" height="2" viewBox="0 0 389 2" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 1H194.5H389" stroke="white"/>
									</svg>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
