<?php
/**
 * Starlink landing — tabbed functionality slider (flexible tab objects).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['tabs'] ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_starlink_tabs_functionality_section">
	<img src="<?= get_template_directory_uri(); ?>/assets/img/starlink_landing/functionalityBg.png" class="iec_tabs_bg_img" alt="">
	<div class="iec_starlink_tabs_sec_warpper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="iec_tabs_list">
						<?php
						$counter = 0;
						foreach ( $fields['tabs'] as $tab ) { ?>
							<li class="iec_tab_item" data-slide-index="<?= $counter; ?>"><?= $tab['tab_name']; ?></li>
							<?php $counter++;
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="iec_starlink_tabs_slide_sec_warpper">
		<div class="swiper iec_swiper_tabs_slide">
			<div class="swiper-wrapper">
				<?php
				foreach ( $fields['tabs'] as $block ) {
					if ( ! empty( $block['tab_objects'] ) ) {
						foreach ( $block['tab_objects'] as $object ) {
							switch ( $object['acf_fc_layout'] ) {
								case 'simple': ?>
									<div class="swiper-slide">
										<div class="iec_starlink_tab_slide_warpper">
											<div class="container">
												<div class="row">
													<div class="col-md-5 order-2 order-md-1">
														<h3><?= $object['heading']; ?></h3>
														<div class="iec_starlink_tab_slide_desc">
															<?= $object['description']; ?>
														</div>
														<ul class="iec_icon_list iec_starlink_tab_slide_icon_list">
															<?php foreach ( $object['features'] as $feature ) { ?>
																<li>
																	<div class="iec_starlink_tab_slide_icon_list_wrapper">
																		<svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M26.3 8.24961C26.4269 8.37624 26.5277 8.52667 26.5964 8.69228C26.6651 8.8579 26.7005 9.03544 26.7005 9.21475C26.7005 9.39406 26.6651 9.5716 26.5964 9.73722C26.5277 9.90283 26.4269 10.0533 26.3 10.1799L14.0312 22.4486C13.9046 22.5756 13.7542 22.6763 13.5886 22.745C13.423 22.8137 13.2454 22.8491 13.0661 22.8491C12.8868 22.8491 12.7092 22.8137 12.5436 22.745C12.378 22.6763 12.2276 22.5756 12.101 22.4486L6.64819 16.9959C6.39222 16.7399 6.24841 16.3927 6.24841 16.0307C6.24841 15.6687 6.39222 15.3215 6.64819 15.0656C6.90416 14.8096 7.25133 14.6658 7.61333 14.6658C7.97533 14.6658 8.3225 14.8096 8.57847 15.0656L13.0661 19.5559L24.3697 8.24961C24.4963 8.12266 24.6468 8.02194 24.8124 7.95322C24.978 7.8845 25.1555 7.84912 25.3348 7.84912C25.5141 7.84912 25.6917 7.8845 25.8573 7.95322C26.0229 8.02194 26.1734 8.12266 26.3 8.24961Z" fill="#1B204C"/>
																		</svg>
																		<?= $feature['text']; ?>
																	</div>
																	<?php if ( ! empty( $feature['types'] ) ) { ?>
																		<div class="iec_starlink_tab_slide_icon_list_badge">
																			<?php foreach ( $feature['types'] as $type ) { ?>
																				<span class="iec_starlink_tab_slide_icon_list_badgevalue">
																					<?= $type['type']; ?>
																				</span>
																			<?php } ?>
																		</div>
																	<?php } ?>
																</li>
															<?php } ?>
														</ul>
													</div>
													<div class="col-md-7 order-1 order-md-2">
														<div class="iec_starlink_tab_slide_right_image">
															<img src="<?= $object['image']; ?>" alt="<?= $object['title'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php break;
								case 'four_products':
									?>
									<div class="swiper-slide">
										<div class="iec_starlink_tab_slide_warpper iec_starlink_tab_tag_line_slide_warpper">
											<div class="container">
												<div class="row">
													<div class="col-md-12">
														<div class="iec_starlink_tab_products_grid">
															<div class="iec_starlink_tab_product_left_content">
																<h3><?= $object['title']; ?></h3>
																<h4><?= $object['description']; ?></h4>
																<div class="iec_starlink_tab_slide_horizontal_tag_line">
																	<span>
																		<?= $object['side_title_first']; ?>
																	</span>
																</div>
															</div>
															<?php foreach ( $object['products'] as $product ) { ?>
																<div class="iec_starlink_tab_product_post_box">
																	<h5 class="iec_starlink_tab_product_post_title"><?= $product['title']; ?></h5>
																	<img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>">
																	<a href="<?= $product['url']; ?>" class="iec_starlink_product_button"><?php esc_attr_e( 'LOAD MORE', 'bbtheme' ); ?></a>
																</div>
															<?php } ?>

															<?php if(!empty($object['side_title_first'])):?>
															<div class="iec_starlink_tab_slide_vertical_tag_line">
																<span>
																	<?= $object['side_title_first']; ?>
																</span>
															</div>
															<?php endif; ?>
														</div>
													</div>
												</div>
												<div class="row iec_starlink_tab_products_warpper">
													<div class="col-md-12">
														<div class="iec_starlink_tab_second_products_grid_warpper">
															<div class="iec_starlink_tab_slide_horizontal_tag_line">
																<span><?= $object['side_title_second']; ?></span>
															</div>
															<div class="iec_starlink_tab_products_grid">
																<?php foreach ( $object['products_second'] as $product ) { ?>
																	<div class="iec_starlink_tab_product_post_box">
																		<h5 class="iec_starlink_tab_product_post_title"><?= $product['title']; ?></h5>
																		<img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>">
																		<a href="<?= $product['url']; ?>" class="iec_starlink_product_button"><?php esc_attr_e( 'LOAD MORE', 'bbtheme' ); ?></a>
																	</div>
																<?php } ?>
																<div class="iec_starlink_tab_slide_vertical_tag_line">
																	<span><?= $object['side_title_second']; ?></span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php break;
								case 'extended':
									?>
									<div class="swiper-slide">
										<div class="iec_starlink_tab_slide_warpper">
											<div class="container">
												<div class="row">
													<div class="col-md-5">
														<h3><?= $object['title']; ?></h3>
														<div class="iec_starlink_tab_slide_desc">
															<?= $object['description']; ?>
														</div>
														<ul class="iec_icon_list iec_starlink_tab_slide_icon_list">
															<?php if ( ! empty( $object['features'] ) ) {
																foreach ( $object['features'] as $feature ) { ?>
																	<li>
																		<div class="iec_starlink_tab_slide_icon_list_wrapper">
																			<svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
																				<path d="M26.3 8.24961C26.4269 8.37624 26.5277 8.52667 26.5964 8.69228C26.6651 8.8579 26.7005 9.03544 26.7005 9.21475C26.7005 9.39406 26.6651 9.5716 26.5964 9.73722C26.5277 9.90283 26.4269 10.0533 26.3 10.1799L14.0312 22.4486C13.9046 22.5756 13.7542 22.6763 13.5886 22.745C13.423 22.8137 13.2454 22.8491 13.0661 22.8491C12.8868 22.8491 12.7092 22.8137 12.5436 22.745C12.378 22.6763 12.2276 22.5756 12.101 22.4486L6.64819 16.9959C6.39222 16.7399 6.24841 16.3927 6.24841 16.0307C6.24841 15.6687 6.39222 15.3215 6.64819 15.0656C6.90416 14.8096 7.25133 14.6658 7.61333 14.6658C7.97533 14.6658 8.3225 14.8096 8.57847 15.0656L13.0661 19.5559L24.3697 8.24961C24.4963 8.12266 24.6468 8.02194 24.8124 7.95322C24.978 7.8845 25.1555 7.84912 25.3348 7.84912C25.5141 7.84912 25.6917 7.8845 25.8573 7.95322C26.0229 8.02194 26.1734 8.12266 26.3 8.24961Z" fill="#1B204C"/>
																			</svg>
																			<?= $feature['text']; ?>
																		</div>
																	</li>
																<?php }
															} ?>
														</ul>
													</div>
													<div class="col-md-7">
														<div class="iec_starlink_tab_slide_right_image">
															<img src="<?= $object['image']; ?>" alt="<?= $object['title']; ?>">
														</div>
													</div>
												</div>
												<div class="row iec_starlink_icon_warpper">
													<div class="col-md-12">
														<h3><?= $object['second_block_title']; ?></h3>
														<div class="iec_starlink_icon_box_grid iec_starlink_land_icon_box_grid">
															<?php foreach ( $object['items'] as $item ) { ?>
																<div class="iec_starlink_icon_box">
																	<img src="<?= $item['image']; ?>" alt="<?= $item['title']; ?>">
																	<h4 class="iec_starlink_icon_title"><?= $item['title']; ?></h4>
																	<ul class="iec_icon_list">
																		<?php foreach ( $item['features'] as $feature ) { ?>
																			<li>
																				<div class="iec_starlink_tab_slide_icon_list_wrapper">
																					<svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path d="M26.3 8.24961C26.4269 8.37624 26.5277 8.52667 26.5964 8.69228C26.6651 8.8579 26.7005 9.03544 26.7005 9.21475C26.7005 9.39406 26.6651 9.5716 26.5964 9.73722C26.5277 9.90283 26.4269 10.0533 26.3 10.1799L14.0312 22.4486C13.9046 22.5756 13.7542 22.6763 13.5886 22.745C13.423 22.8137 13.2454 22.8491 13.0661 22.8491C12.8868 22.8491 12.7092 22.8137 12.5436 22.745C12.378 22.6763 12.2276 22.5756 12.101 22.4486L6.64819 16.9959C6.39222 16.7399 6.24841 16.3927 6.24841 16.0307C6.24841 15.6687 6.39222 15.3215 6.64819 15.0656C6.90416 14.8096 7.25133 14.6658 7.61333 14.6658C7.97533 14.6658 8.3225 14.8096 8.57847 15.0656L13.0661 19.5559L24.3697 8.24961C24.4963 8.12266 24.6468 8.02194 24.8124 7.95322C24.978 7.8845 25.1555 7.84912 25.3348 7.84912C25.5141 7.84912 25.6917 7.8845 25.8573 7.95322C26.0229 8.02194 26.1734 8.12266 26.3 8.24961Z" fill="#1B204C"/>
																					</svg>
																					<?= $feature['text']; ?>
																				</div>
																			</li>
																		<?php } ?>
																	</ul>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php break;
								case 'three_blocks':
									?>
									<div class="swiper-slide">
										<div class="iec_starlink_tab_slide_warpper iec_starlink_three_section_slide_warpper">
											<div class="container">
												<div class="row">
													<div class="col-md-5 order-2 order-md-1">
														<h3><?= $object['title']; ?></h3>
														<ul class="iec_icon_list iec_starlink_tab_slide_icon_list">
															<?php foreach ( $object['features'] as $feature ) { ?>
																<li>
																	<div class="iec_starlink_tab_slide_icon_list_wrapper">
																		<svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M26.3 8.24961C26.4269 8.37624 26.5277 8.52667 26.5964 8.69228C26.6651 8.8579 26.7005 9.03544 26.7005 9.21475C26.7005 9.39406 26.6651 9.5716 26.5964 9.73722C26.5277 9.90283 26.4269 10.0533 26.3 10.1799L14.0312 22.4486C13.9046 22.5756 13.7542 22.6763 13.5886 22.745C13.423 22.8137 13.2454 22.8491 13.0661 22.8491C12.8868 22.8491 12.7092 22.8137 12.5436 22.745C12.378 22.6763 12.2276 22.5756 12.101 22.4486L6.64819 16.9959C6.39222 16.7399 6.24841 16.3927 6.24841 16.0307C6.24841 15.6687 6.39222 15.3215 6.64819 15.0656C6.90416 14.8096 7.25133 14.6658 7.61333 14.6658C7.97533 14.6658 8.3225 14.8096 8.57847 15.0656L13.0661 19.5559L24.3697 8.24961C24.4963 8.12266 24.6468 8.02194 24.8124 7.95322C24.978 7.8845 25.1555 7.84912 25.3348 7.84912C25.5141 7.84912 25.6917 7.8845 25.8573 7.95322C26.0229 8.02194 26.1734 8.12266 26.3 8.24961Z" fill="#1B204C"/>
																		</svg>
																		<?= $feature['text']; ?>
																	</div>
																</li>
															<?php } ?>
														</ul>
													</div>
													<div class="col-md-7 order-1 order-md-2">
														<div class="iec_starlink_tab_slide_right_image">
															<img src="<?= $object['image']; ?>" alt="<?= $object['title']; ?>">
														</div>
													</div>
												</div>
												<div class="row iec_starlink_tab_products_warpper">
													<div class="col-md-12">
														<?php
														$page_id       = 430;
														$translated_id = apply_filters( 'wpml_object_id', $page_id, 'page', true );
														$url           = get_permalink( $translated_id );
														?>
														<a href="<?= $url; ?>" class="iec_starlink_product_button"><?= 'View All'; ?></a>
														<h3><?= $object['third_title']; ?></h3>
														<div class="iec_starlink_tab_products_grid">
															<?php foreach ( $object['items'] as $item ) { ?>
																<div class="iec_starlink_tab_product_post_box">
																	<h4 class="iec_starlink_tab_product_post_title"><?= $item['title']; ?></h4>
																	<h5><?= $item['description']; ?></h5>
																	<img src="<?= $item['image']; ?>" alt="<?= $item['title']; ?>">
																	<a href="<?= $item['url']; ?>" class="iec_starlink_product_button"><?php esc_attr_e( 'LOAD MORE', 'bbtheme' ); ?></a>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php break;
								case 'three_services':
									?>
									<div class="swiper-slide">
										<div class="iec_starlink_tab_slide_warpper">
											<div class="container">
												<div class="row">
													<div class="col-md-12">
														<div class="iec_starlink_tab_service_box_grid">
															<?php foreach ( $object['services'] as $service ) { ?>
																<div class="iec_starlink_tab_service_post_box">
																	<h4 class="iec_starlink_tab_service_post_title"><?= $service['title']; ?></h4>
																	<div class="iec_starlink_tab_slide_desc">
																		<?= $service['description']; ?>
																	</div>
																	<img src="<?= $service['image']; ?>" alt="<?= $service['title']; ?>">
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php break; ?>
								<?php }
						}
					}
				} ?>
			</div>
		</div>
	</div>
</section>
