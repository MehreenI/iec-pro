<?php
/**
 * Latest Update single news layout.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$fields  = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term    = iec_news_single_primary_term();
	$heading = $fields['caption'] ?? '';
	$content = $fields['content'] ?? '';
	$contact = $fields['contact_us_caption'] ?? '';
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
					<div class="row">
						<div class="col-md-12">
							<?php if ( $heading ) : ?>
								<div class="iec_heading_section">
									<h2><?= $heading; ?></h2>
								</div>
							<?php endif; ?>

							<div class="iec_single_news_main_content_warpper">
								<?= $content; ?>

								<?php if ( $contact ) : ?>
									<div class="iec_single_news_bottom_contact">
										<?= $contact; ?>
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
