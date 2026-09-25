<?php
/**
 * Events single news layout.
 *
 * ACF: event_content, event_details, event_details_title,
 * new_event_detail_style + event_details_repeater | session/time/venue,
 * speaker_photo/name/details, delegates, gradient_generator.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$fields         = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term           = iec_news_single_primary_term();
	$content        = $fields['event_content'] ?? $fields['content'] ?? '';
	$details        = is_array( $fields['event_details'] ?? null ) ? $fields['event_details'] : array();
	$details_title  = $fields['event_details_title'] ?? '';
	$new_style      = ! empty( $fields['new_event_detail_style'] );
	$repeater       = is_array( $fields['event_details_repeater'] ?? null ) ? $fields['event_details_repeater'] : array();
	$session        = $fields['session'] ?? '';
	$speaker_photo  = iec_resolve_media_to_url( $fields['speaker_photo'] ?? null );
	$speaker_name   = $fields['speaker_name'] ?? '';
	$speaker_meta   = $fields['speaker_details'] ?? '';
	$delegates      = is_array( $fields['delegates'] ?? null ) ? $fields['delegates'] : array();
	$gradient_style = iec_news_event_gradient_style( $fields );
	$show_speaker   = ( $new_style && $repeater ) || '' !== $session;
	?>
	<main class="iec-single-news-main" id="main">
		<article>
			<?php
			get_template_part(
				'template-parts/news/banner',
				null,
				array(
					'fields' => $fields,
					'term'   => $term,
				)
			);
			?>

			<section class="iec_single_news_main_section iec_defualt_position">
				<div class="container">
					<div class="iec_single_news_main_content_warpper">
						<div class="row">
							<div class="col-lg-8">
								<?= $content; ?>
							</div>
							<?php if ( $details ) : ?>
								<div class="col-lg-4">
									<ul class="iec_event_detail_list">
										<?php foreach ( $details as $detail ) : ?>
											<?php
											if ( ! is_array( $detail ) ) {
												continue;
											}
											?>
											<li class="iec_event_detail_list_box">
												<?php if ( ! empty( $detail['title'] ) ) : ?>
													<span class="iec_event_badge"><?= $detail['title']; ?></span>
												<?php endif; ?>
												<?php if ( ! empty( $detail['description'] ) ) : ?>
													<h3 class="iec_ed_description"><?= $detail['description']; ?></h3>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>

						<?php if ( $show_speaker ) : ?>
							<div class="iec_single_news_speaker_section">
								<div class="iec_single_news_speaker_box"<?= $gradient_style ? ' style="' . $gradient_style . '"' : ''; ?>>
									<div class="iec_single_news_speaker_details">
										<?php if ( $details_title ) : ?>
											<h2><?= $details_title; ?></h2>
										<?php endif; ?>

										<?php if ( $new_style && $repeater ) : ?>
											<?php
											$total       = count( $repeater );
											$first_half  = $total > 3 ? array_slice( $repeater, 0, 3 ) : $repeater;
											$second_half = $total > 3 ? array_slice( $repeater, 3, 3 ) : array();
											?>
											<div class="row">
												<div class="col-md-<?= $second_half ? '6' : '12'; ?>">
													<ul class="iec_single_news_speaker_details_lists">
														<?php foreach ( $first_half as $item ) : ?>
															<?php if ( ! is_array( $item ) ) { continue; } ?>
															<li>
																<?php if ( ! empty( $item['title'] ) ) : ?>
																	<span><?= $item['title']; ?>:</span>
																<?php endif; ?>
																<?php if ( ! empty( $item['description'] ) ) : ?>
																	<h3><?= $item['description']; ?></h3>
																<?php endif; ?>
															</li>
														<?php endforeach; ?>
													</ul>
												</div>
												<?php if ( $second_half ) : ?>
													<div class="col-md-6">
														<ul class="iec_single_news_speaker_details_lists">
															<?php foreach ( $second_half as $item ) : ?>
																<?php if ( ! is_array( $item ) ) { continue; } ?>
																<li>
																	<?php if ( ! empty( $item['title'] ) ) : ?>
																		<span><?= $item['title']; ?>:</span>
																	<?php endif; ?>
																	<?php if ( ! empty( $item['description'] ) ) : ?>
																		<h3><?= $item['description']; ?></h3>
																	<?php endif; ?>
																</li>
															<?php endforeach; ?>
														</ul>
													</div>
												<?php endif; ?>
											</div>
										<?php else : ?>
											<ul class="iec_single_news_speaker_details_lists">
												<?php if ( $session ) : ?>
													<li>
														<span><?= __( 'SESSION', 'bbtheme' ); ?>:</span>
														<h3><?= $session; ?></h3>
													</li>
												<?php endif; ?>
												<?php if ( ! empty( $fields['time'] ) ) : ?>
													<li>
														<span><?= __( 'TIME', 'bbtheme' ); ?>:</span>
														<h3><?= $fields['time']; ?></h3>
													</li>
												<?php endif; ?>
												<?php if ( ! empty( $fields['venue'] ) ) : ?>
													<li>
														<span><?= __( 'VENUE', 'bbtheme' ); ?>:</span>
														<h3><?= $fields['venue']; ?></h3>
													</li>
												<?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>

									<?php if ( $speaker_photo && $speaker_name ) : ?>
										<div class="iec_single_news_speaker_image_warpper">
											<img src="<?= $speaker_photo; ?>" alt="<?= $speaker_name; ?>" loading="lazy" decoding="async">
											<div class="iec_single_news_speaker_author_details">
												<h3><?= $speaker_name; ?></h3>
												<?php if ( $speaker_meta ) : ?>
													<span><?= $speaker_meta; ?></span>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $delegates ) : ?>
							<div class="iec_single_news_delegates">
								<h2><?= __( 'OUR DELEGATES', 'bbtheme' ); ?></h2>
								<div class="row">
									<?php foreach ( $delegates as $delegate ) : ?>
										<?php
										if ( ! is_array( $delegate ) ) {
											continue;
										}
										$photo = iec_resolve_media_to_url( $delegate['photo'] ?? null );
										$name  = $delegate['name'] ?? '';
										?>
										<div class="col-lg-6 iec_single_news_delegates_box_warpper">
											<div class="iec_single_news_delegates_box">
												<?php if ( $photo ) : ?>
													<img src="<?= $photo; ?>" alt="<?= $name; ?>" loading="lazy" decoding="async">
												<?php endif; ?>
												<div class="iec_single_news_delegates_box_content">
													<?php if ( $name ) : ?>
														<h3 class="iec_single_news_delegate_name"><?= $name; ?></h3>
													<?php endif; ?>
													<?php if ( ! empty( $delegate['position'] ) ) : ?>
														<span class="iec_single_news_delegate_position"><?= $delegate['position']; ?></span>
													<?php endif; ?>
													<?php if ( ! empty( $delegate['company'] ) ) : ?>
														<span class="iec_single_news_delegate_position"><?= $delegate['company']; ?></span>
													<?php endif; ?>
													<?php if ( ! empty( $delegate['linkedin_link'] ) ) : ?>
														<a href="<?= $delegate['linkedin_link']; ?>" target="_blank" rel="noopener noreferrer" class="iec_single_news_linkedin_url"></a>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<?php get_template_part( 'template-parts/modules/contact-form' ); ?>
		</article>
	</main>
	<?php
endwhile;
