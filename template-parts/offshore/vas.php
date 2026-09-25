<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = get_field( 'offshore_vas' );

if ( empty( $section['enabled'] ) ) {
	return;
}

$heading  = ! empty( $section['heading'] ) ? $section['heading'] : 'Recommended Value-Added Services';
$services = is_array( $section['services'] ?? null ) ? $section['services'] : array();

$services = array_values(
	array_filter(
		$services,
		static function ( $service ) {
			return is_array( $service ) && ( ! empty( $service['label'] ) || ! empty( $service['heading'] ) );
		}
	)
);

if ( $services === array() ) {
	return;
}

$translated_url = static function ( $post_id, $post_type ) {
	$post_id = (int) $post_id;
	$lang    = apply_filters( 'wpml_current_language', null );

	if ( $post_id > 0 && is_string( $lang ) && '' !== $lang && $post_type && has_filter( 'wpml_object_id' ) ) {
		$translated_id = (int) apply_filters( 'wpml_object_id', $post_id, $post_type, true, $lang );

		if ( $translated_id ) {
			$post_id = $translated_id;
		}
	}

	return $post_id > 0 ? (string) get_permalink( $post_id ) : '';
};

$cards = array();

foreach ( $services as $service ) {
	$vas_post = $service['value_added_service'] ?? null;
	$vas_id   = $vas_post instanceof WP_Post ? (int) $vas_post->ID : ( is_numeric( $vas_post ) ? (int) $vas_post : 0 );
	$link     = is_array( $service['link'] ?? null ) ? $service['link'] : array();
	$cta_url  = '';

	if ( $vas_id > 0 ) {
		$cta_url = $translated_url( $vas_id, get_post_type( $vas_id ) );

	} elseif ( ! empty( $link['url'] ) ) {
		$cta_url   = (string) $link['url'];
		$linked_id = ( '' !== $cta_url && ! str_starts_with( $cta_url, '#' ) ) ? url_to_postid( $cta_url ) : 0;

		if ( $linked_id > 0 ) {
			$linked_url = $translated_url( $linked_id, get_post_type( $linked_id ) );

			if ( $linked_url ) {
				$cta_url = $linked_url;
			}
		}
	}

	$image     = $service['image'] ?? null;
	$image_id  = $vas_id > 0 ? (int) get_post_thumbnail_id( $vas_id ) : 0;
	$image_url = '';

	if ( $image_id < 1 && is_array( $image ) ) {
		$image_id  = (int) ( $image['ID'] ?? 0 );
		$image_url = (string) ( $image['url'] ?? '' );

	} elseif ( $image_id < 1 && is_numeric( $image ) ) {
		$image_id = (int) $image;
	}

	if ( $image_id < 1 && '' === $image_url && function_exists( 'iec_resolve_media_to_url' ) ) {
		$image_url = (string) iec_resolve_media_to_url( $image );
	}

	if ( $image_id < 1 && $image_url ) {
		$image_id = (int) attachment_url_to_postid( $image_url );
	}

	$card_heading = ! empty( $service['heading'] ) ? $service['heading'] : ( $vas_id > 0 ? get_the_title( $vas_id ) : '' );

	$cards[] = array(
		'label'       => ! empty( $service['label'] ) ? $service['label'] : $card_heading,
		'heading'     => $card_heading,
		'description' => $service['description'] ?? '',
		'image_id'    => $image_id,
		'image_url'   => $image_url,
		'alt'         => $vas_id > 0 ? get_the_title( $vas_id ) : $card_heading,
		'url'         => $cta_url,
		'title'       => ! empty( $link['title'] ) ? $link['title'] : 'Learn More',
		'target'      => $link['target'] ?? '_self',
	);
}
?>

<section class="block-7 iec-offshore-vas-section">
	<div class="container main-container">
		<h2 class="iec_section_heading iec-section-heading" data-aos="fade-up"><?= $heading; ?></h2>
		<div class="service-card" data-aos="fade-up">
			<div class="tabs-wrapper">

				<?php foreach ( $cards as $index => $card ) : ?>

					<button
						type="button"
						class="custom-tab<?= 0 === (int) $index ? ' active' : ''; ?>"
						data-index="<?= (int) $index; ?>"
					><?= $card['label']; ?></button>

				<?php endforeach; ?>

			</div>
			<div class="swiper serviceSwiper" data-offshore-vas-swiper>
				<div class="swiper-wrapper">

					<?php foreach ( $cards as $card ) : ?>

						<div class="swiper-slide">
							<div class="tab-pane-custom active">
								<div class="row align-items-center">

									<?php if ( $card['image_id'] > 0 ) : ?>

										<div class="col-lg-6">
											<div class="image-section">
												<div class="main-image">
													<?= wp_get_attachment_image( $card['image_id'], 'large', false, array( 'alt' => $card['alt'], 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
												</div>
											</div>
										</div>

									<?php endif; ?>

									<div class="col-lg-6">
										<div class="text-content">

											<?php if ( ! empty( $card['heading'] ) ) : ?>

												<h3><?= $card['heading']; ?></h3>

											<?php endif; ?>

											<?php if ( ! empty( $card['description'] ) ) : ?>

												<?= $card['description']; ?>

											<?php endif; ?>

											<?php if ( '' !== $card['url'] ) : ?>

												<a href="<?= $card['url']; ?>" class="learn_more_btn" target="<?= $card['target']; ?>">
													<?= $card['title']; ?>
													<span><?php get_template_part( 'template-parts/offshore/learn-more-icon' ); ?></span>
												</a>

											<?php endif; ?>

										</div>
									</div>
								</div>
							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>
