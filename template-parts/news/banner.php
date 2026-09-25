<?php
/**
 * Single news hero banner.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields       = $args['fields'] ?? array();
$term         = $args['term'] ?? null;
$download_url = $args['download_url'] ?? '';
$banner_class = $args['banner_class'] ?? 'iec_single_news_banner iec_defualt_position banner';
$post_id      = (int) get_the_ID();
$image_url    = iec_news_banner_image_from_fields( $fields );
$image        = $fields['image'] ?? array();
$image_w      = $image['width'] ?? '';
$image_h      = $image['height'] ?? '';
$archive_url  = iec_news_archive_url() ?? '/en/news';

$term_name = '';
if ( $term instanceof WP_Term ) {
	$term_name = $term->name;
} elseif ( 'press-release' === get_post_type( $post_id ) ) {
	$term_name = __( 'Press Release', 'bbtheme' );
}
?>

<section class="<?= esc_attr( $banner_class ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<nav class="iec_single_news_breadcrumbs" aria-label="<?= __( 'Breadcrumb', 'bbtheme' ); ?>">
					<?php if ( $archive_url ) : ?>
						<a href="<?= $archive_url; ?>"><?= __( 'All News', 'bbtheme' ); ?></a>
					<?php endif; ?>
					<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="#1B204C"/>
					</svg>
					<?php if ( $term instanceof WP_Term && function_exists( 'iec_news_type_archive_url' ) ) : ?>
						<a href="<?= iec_news_type_archive_url( $term ); ?>"><?= $term_name; ?></a>
					<?php elseif ( $term_name ) : ?>
						<span><?= $term_name; ?></span>
					<?php endif; ?>
				</nav>
				<div class="iec_single_news_banner_content">
					<div class="iec_single_news_meta">
						<?php if ( $term_name ) : ?>
							<span class="category_pill"><?= $term_name; ?></span>
						<?php endif; ?>
						<time class="date text_gray" datetime="<?= get_the_date( 'c', $post_id ); ?>"><?= get_the_date( 'd M Y', $post_id ); ?></time>
					</div>
					<h1 class="iec_primary_heading iec_single_news_post_title"><?= get_the_title( $post_id ); ?></h1>
				</div>
			</div>
			<div class="col-md-7">
				<?php if ( $image_url ) : ?>
					<div class="iec_single_news_banner_image">
						<img
							src="<?= esc_url( $image_url ); ?>"
							class="iec_img_style"
							alt="<?= esc_attr( get_the_title( $post_id ) ); ?>"
							<?php if ( $image_w && $image_h ) : ?>
								width="<?= esc_attr( $image_w ); ?>"
								height="<?= esc_attr( $image_h ); ?>"
							<?php endif; ?>
							fetchpriority="high"
							decoding="async"
						>
					</div>
				<?php endif; ?>

				<?php if ( $download_url ) : ?>
					<a class="iec_single_news_banner_button" download href="<?= esc_url( $download_url ); ?>">
						<?= __( 'Download MEDIA PACK', 'bbtheme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
