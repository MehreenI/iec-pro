<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$field          = $args['field'] ?? array();
$news           = $field['news'] ?? array();
$content_blocks = $field['content_blocks'] ?? array();
$slider_query   = iec_office_regional_news_query( (int) get_the_ID() );
?>

<!-- Regional news. -->
<section id="regional_news" class="iec_slide_regional_news" role="tabpanel" aria-labelledby="iec-office-tab-1">
	<div class="iec_do_featured_news">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<?php if ( ! empty( $news['heading'] ) ) : ?>
						<h2 class="iec_section_heading iec-section-heading"><?php echo $news['heading']; ?></h2>
					<?php endif; ?>

				</div>
			</div>

			<?php if ( $slider_query->have_posts() ) : ?>
				<?php iec_module( 'office-featured-news', array( 'query' => $slider_query ) ); ?>
			<?php else : ?>
				<div class="article-message">
					<p><?php echo __( 'No news articles are available', 'bbtheme' ); ?></p>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<?php get_template_part( 'template-parts/office/content', 'blocks', array( 'blocks' => $content_blocks ) ); ?>
</section>
