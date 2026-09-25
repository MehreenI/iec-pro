<?php
/**
 * Template Name: About Introduction Page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields      = get_fields() ?: array();
	$headshot    = $fields['headshot'] ?? array();
	$caption     = $fields['caption'] ?? '';
	$content     = $fields['content'] ?? '';
	$quote       = $fields['quote'] ?? '';
	$quoted_by   = $fields['quoted_by'] ?? '';
	$designation = $fields['designation'] ?? '';
	$image_id    = $headshot['ID'] ?? 0;
	$image_url   = $headshot['url'] ?? '';
	?>

	<main id="main" class="iec-about-introduction-main">

		<?php get_template_part( 'template-parts/about/hero', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/heading', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<!-- Introduction content. -->
		<?php if ( $caption || $content ) : ?>
			<article class="iec_about_intorduction iec_defualt_position">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="iec_about_intorduction_content_box_warpper">

								<?php if ( $caption ) : ?>
									<h2 id="about-intro-content-heading" class="iec_section_heading"><?php echo $caption; ?></h2>
								<?php endif; ?>

								<?php if ( $content ) : ?>
									<div class="iec_about_intorduction_content_box"><?php echo $content; ?></div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				</div>
			</article>
		<?php endif; ?>

		<!-- Leadership quote. -->
		<?php if ( $quote || $quoted_by || $image_id || $image_url ) : ?>
			<aside class="iec_about_qoute_section iec_defualt_position">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<blockquote class="iec_qoute_box_warpper">
								<div class="iec_qoute_content_warpper">

									<?php if ( $quote ) : ?>
										<?php echo $quote; ?>
									<?php endif; ?>

									<?php if ( $quoted_by || $designation ) : ?>
										<footer class="iec_qoute_author">

											<?php if ( $quoted_by ) : ?>
												<cite class="iec_author_name"><?php echo $quoted_by; ?></cite>
											<?php endif; ?>

											<?php if ( $designation ) : ?>
												<span><?php echo $designation; ?></span>
											<?php endif; ?>

										</footer>
									<?php endif; ?>

								</div>

								<?php if ( $image_id || $image_url ) : ?>
									<figure class="iec_qoute_author_image_warpper">

										<?php if ( $image_id ) : ?>
											<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'iec_qoute_author_image', 'alt' => $quoted_by ) ); ?>
										<?php else : ?>
											<img src="<?php echo $image_url; ?>" alt="<?php echo $quoted_by; ?>" class="iec_qoute_author_image">
										<?php endif; ?>

									</figure>
								<?php endif; ?>

							</blockquote>
						</div>
					</div>
				</div>
			</aside>
		<?php endif; ?>

	</main>

	<?php
endwhile;

get_footer();
