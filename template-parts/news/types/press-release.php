<?php
/**
 * Press Release single layout.
 *
 * ACF: file_for_downloading, text_blocks (title, text), contacts.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$fields       = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term         = iec_news_single_primary_term();
	$download_url = $fields['file_for_downloading'] ?? '';
	$text_blocks  = is_array( $fields['text_blocks'] ?? null ) ? $fields['text_blocks'] : array();
	$contacts     = is_array( $fields['contacts'] ?? null ) ? $fields['contacts'] : array();
	$heading_done = false;
	?>
	<main class="iec-single-news-main" id="main">
		<article>
			<?php
			get_template_part(
				'template-parts/news/banner',
				null,
				array(
					'fields'       => $fields,
					'term'         => $term,
					'download_url' => $download_url,
				)
			);
			?>

			<section class="iec_single_news_main_section iec_defualt_position">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="iec_single_news_main_content_warpper">
								<?php foreach ( $text_blocks as $block ) : ?>
									<?php
									if ( ! is_array( $block ) ) {
										continue;
									}
									$title = $block['title'] ?? '';
									$text  = $block['text'] ?? '';
									?>
									<?php if ( $title ) : ?>
										<?php if ( ! $heading_done ) : ?>
											<div class="iec_heading_section">
												<h2><?= $title; ?></h2>
											</div>
											<?php $heading_done = true; ?>
										<?php else : ?>
											<h3><?= $title; ?></h3>
										<?php endif; ?>
									<?php endif; ?>

									<?php if ( $text ) : ?>
										<?= $text; ?>
									<?php endif; ?>
								<?php endforeach; ?>

								<?php if ( $contacts ) : ?>
									<div class="iec_single_news_contacts_media_section">
										<h2>
											<?= __( 'CONTACTS', 'bbtheme' ); ?><br>
											<?= __( 'FOR MEDIA', 'bbtheme' ); ?>
										</h2>
										<div class="iec_single_news_contacts_media_box_warpper">
											<?php foreach ( $contacts as $contact ) : ?>
												<?php
												if ( ! is_array( $contact ) ) {
													continue;
												}
												$name     = $contact['name'] ?? '';
												$position = $contact['position'] ?? '';
												$phone    = $contact['phone'] ?? '';
												$email    = $contact['email'] ?? '';
												?>
												<div class="iec_single_news_contacts_media_box">
													<div class="iec_single_news_contacts_media_top_content">
														<?php if ( $name ) : ?>
															<h3><?= $name; ?></h3>
														<?php endif; ?>
														<?php if ( $position ) : ?>
															<span><?= $position; ?></span>
														<?php endif; ?>
													</div>
													<div class="iec_single_news_contacts_media_content_list">
														<?php if ( $phone ) : ?>
															<a href="tel:<?= preg_replace( '/\s+/', '', (string) $phone ); ?>"><span>T:</span> <?= $phone; ?></a>
														<?php endif; ?>
														<?php if ( $email ) : ?>
															<a href="mailto:<?= $email; ?>"><span>E:</span> <?= $email; ?></a>
														<?php endif; ?>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</article>
	</main>
	<?php
endwhile;
