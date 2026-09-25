<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();

if ( empty( $section ) ) {
	return;
}

$heading  = $section['heading'] ?? '';
$link     = $section['link'] ?? array();
$tags     = $section['tags'] ?? array();
$services = $section['services'] ?? array();

if ( empty( $services ) ) {
	return;
}

$link_url    = ! empty( $link['url'] ) && function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : ( $link['url'] ?? '' );
$link_title  = $link['title'] ?? '';
$link_target = $link['target'] ?? '';

$featured    = $services[0] ?? null;
$flips       = array_slice( $services, 1 );
$arrow       = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M8.49219 3.41663C8.51931 3.41688 8.54751 3.42324 8.5752 3.43616C8.60296 3.44914 8.63095 3.46924 8.65625 3.49768L8.66211 3.50354L11.6621 6.76233C11.7006 6.80407 11.7315 6.86251 11.7441 6.93127C11.7567 6.99998 11.7494 7.07092 11.7256 7.13342V7.1344C11.7101 7.17536 11.6882 7.21035 11.6631 7.23792L8.66309 10.4957L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5833 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.566C8.3825 10.5538 8.3546 10.534 8.3291 10.5065C8.30342 10.4786 8.28041 10.4428 8.26465 10.401C8.24888 10.3591 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1726 8.2666 10.1315C8.28294 10.0902 8.30614 10.0551 8.33203 10.028L8.33789 10.0211L10.0576 8.15393L10.8301 7.31506H2.5C2.44774 7.31505 2.3885 7.29271 2.33789 7.23792C2.28597 7.18153 2.25006 7.09665 2.25 7.00061C2.25 6.90447 2.28593 6.81974 2.33789 6.76331C2.38855 6.70832 2.44765 6.68617 2.5 6.68616H10.8301L10.0576 5.84729L8.33691 3.97815L8.33105 3.97229L8.29492 3.92542C8.28406 3.90828 8.27471 3.88927 8.2666 3.86877C8.25023 3.82739 8.24061 3.78131 8.24023 3.73401C8.23989 3.68681 8.24892 3.64101 8.26465 3.59924C8.2804 3.55742 8.30244 3.52167 8.32812 3.49377C8.35361 3.46614 8.3815 3.44654 8.40918 3.4342C8.43682 3.42192 8.46509 3.41638 8.49219 3.41663Z" fill="#727DA3" stroke="#727DA3"/></svg>';

$resolve_service = static function ( $row ) {
	$post = $row['services'] ?? null;

	if ( ! $post instanceof WP_Post ) {
		return null;
	}

	$post_id      = (int) $post->ID;
	$current_lang = apply_filters( 'wpml_current_language', null );

	if ( is_string( $current_lang ) && '' !== $current_lang && has_filter( 'wpml_object_id' ) ) {
		$translated_id = apply_filters( 'wpml_object_id', $post_id, $post->post_type, true, $current_lang );

		if ( $translated_id ) {
			$post_id = (int) $translated_id;
		}
	}

	$permalink = get_permalink( $post_id );

	if ( ! $permalink ) {
		return null;
	}

	$image     = $row['image'] ?? null;
	$image_url = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $image ) : ( $image['url'] ?? '' );

	return array(
		'title'     => $row['title'] ?? get_the_title( $post_id ),
		'permalink' => $permalink,
		'excerpt'   => $row['excerpt'] ?? '',
		'image_url' => $image_url,
		'image_id'  => is_array( $image ) && ! empty( $image['ID'] ) ? (int) $image['ID'] : 0,
	);
};

$render_service_image = static function ( $item, $class, $size = 'large' ) {
	$image_id = (int) ( $item['image_id'] ?? 0 );

	if ( $image_id < 1 && ! empty( $item['image_url'] ) ) {
		$image_id = (int) attachment_url_to_postid( $item['image_url'] );
	}

	if ( $image_id > 0 ) {
		return wp_get_attachment_image(
			$image_id,
			$size,
			false,
			array(
				'class' => $class,
				'alt'   => $item['title'] ?? '',
			)
		);
	}

	return '';
};

$get_mini_modifier = static function ( $permalink ) {
	$slug = sanitize_title( basename( untrailingslashit( (string) parse_url( $permalink, PHP_URL_PATH ) ) ) );
	$map  = array(
		'optishield'               => 'optishield',
		'global-technical-support' => 'support',
		'iec-voucher-management'   => 'vouchers',
		'iot-tracking'             => 'traksat',
	);

	return $map[ $slug ] ?? 'default';
};

$render_tags = static function ( $rows ) {

	foreach ( $rows as $tag_row ) {

		if ( empty( $tag_row['tag'] ) ) {
			continue;
		}

		echo '<li><span>' . $tag_row['tag'] . '</span></li>';
	}
};

$featured_data = $featured ? $resolve_service( $featured ) : null;
?>

<section class="iec_defualt_position iec_section_home_spotlights">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<?php if ( $heading ) : ?>

					<h2 class="iec_section_heading" data-aos="fade-up"><?= $heading; ?></h2>

				<?php endif; ?>

				<?php if ( ! empty( $tags ) ) : ?>

					<ul class="iec_home_spotlight_tags_lists d-md-none d-flex" data-iec-spotlight-tags>
						<?php $render_tags( $tags ); ?>
					</ul>

				<?php endif; ?>

			</div>
			<div class="col-md-4">

				<?php if ( $link_url && $link_title ) : ?>

					<a
						href="<?= esc_url( $link_url ); ?>"
						class="iec_button iec_blue_gradient"
						data-aos="fade-up"
						data-aos-delay="100"
						<?= $link_target ? ' target="' . esc_attr( $link_target ) . '"' : ''; ?>
					><?= $link_title; ?></a>

				<?php endif; ?>

			</div>
		</div>

		<?php if ( ! empty( $tags ) ) : ?>

			<div class="row">
				<div class="col-md-12">
					<ul class="iec_home_spotlight_tags_lists d-md-flex d-none" data-iec-spotlight-tags>
						<?php $render_tags( $tags ); ?>
					</ul>
				</div>
			</div>

		<?php endif; ?>

		<div class="row">
			<div class="col-12">
				<div class="iec_platform_grid" id="services" data-aos="fade-up" data-aos-delay="100">

					<?php if ( $featured_data ) : ?>

						<article class="iec_optiview_card">
							<div class="iec_optiview_card__header">
								<div class="iec_platform_badge"><?= __( 'Network Management Platform', 'bbtheme' ); ?></div>
								<h3 class="iec_optiview_card__title"><?= $featured_data['title']; ?></h3>
							</div>

							<?php if ( $featured_data['image_id'] || $featured_data['image_url'] ) : ?>

								<div class="iec_optiview_card__art" aria-hidden="true">
									<?= $render_service_image( $featured_data, 'iec_optiview_card__image', 'large' ); ?>
								</div>

							<?php endif; ?>

							<?php if ( $featured_data['excerpt'] ) : ?>

								<p class="iec_optiview_card__description"><?= $featured_data['excerpt']; ?></p>

							<?php endif; ?>

							<a class="iec_platform_card_link iec_optiview_card__link" href="<?= esc_url( $featured_data['permalink'] ); ?>">
								<span><?= __( 'Explore', 'bbtheme' ); ?> <?= $featured_data['title']; ?></span>
								<span class="iec_platform_card_link__arrow" aria-hidden="true"><?= $arrow; ?></span>
							</a>
						</article>

					<?php endif; ?>

					<?php if ( ! empty( $flips ) ) : ?>

						<div class="iec_mini_grid">

							<?php foreach ( $flips as $flip_i => $flip_row ) : ?>

								<?php
								$item = $resolve_service( $flip_row );

								if ( ! $item ) {
									continue;
								}

								$modifier       = $get_mini_modifier( $item['permalink'] );
								$modifier_class = 'iec_mini_card--' . $modifier;

								if ( 'optishield' !== $modifier ) {
									$modifier_class .= ' iec_mini_card--image';
								}
								?>

								<article
									class="iec_flip_card iec_mini_card <?= esc_attr( $modifier_class ); ?>"
									tabindex="0"
									data-aos="fade-up"
									data-aos-delay="<?= esc_attr( (string) ( 200 + ( (int) $flip_i * 80 ) ) ); ?>"
								>
									<div class="iec_flip_card__inner">
										<div class="iec_flip_card__face iec_flip_card__face--front">

											<?php if ( $item['image_id'] || $item['image_url'] ) : ?>

												<div class="iec_mini_card__media">
													<?= $render_service_image( $item, 'iec_mini_card__image iec_mini_card__image--desktop', 'medium_large' ); ?>
													<?= $render_service_image( $item, 'iec_mini_card__image iec_mini_card__image--mobile', 'medium' ); ?>
													<span class="iec_mini_card__media-gradient" aria-hidden="true"></span>
												</div>

											<?php endif; ?>

											<div class="iec_mini_card__body iec_mini_card__body--front">
												<p class="iec_mini_card__title" aria-hidden="true"><?= $item['title']; ?></p>
											</div>
										</div>
										<div class="iec_flip_card__face iec_flip_card__face--back">
											<div class="iec_mini_card__body iec_mini_card__body--back">
												<h3 class="iec_mini_card__title"><?= $item['title']; ?></h3>

												<?php if ( $item['excerpt'] ) : ?>

													<p class="iec_mini_card__description"><?= $item['excerpt']; ?></p>

												<?php endif; ?>

												<a class="iec_platform_card_link iec_mini_card__link" href="<?= esc_url( $item['permalink'] ); ?>">
													<span><?= __( 'View more', 'bbtheme' ); ?></span>
													<span class="iec_platform_card_link__arrow" aria-hidden="true"><?= $arrow; ?></span>
												</a>
											</div>
										</div>
									</div>
								</article>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</section>
