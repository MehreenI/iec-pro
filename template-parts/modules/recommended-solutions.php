<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = is_array( $args['section'] ?? null ) ? $args['section'] : get_field( 'offshore_solutions' );
$section = is_array( $section ) ? $section : array();

if ( empty( $section['enabled'] ) ) {
	if ( ! get_field( 'show_rec' ) ) {
		return;
	}

	$section = array(
		'enabled' => true,
		'heading' => get_field( 'rec_title' ),
		'slider'  => get_field( 'slider' ),
	);
}

$heading = ! empty( $section['heading'] ) ? $section['heading'] : 'Recommended Solutions';
$slides  = is_array( $section['slider'] ?? null ) ? $section['slider'] : array();

$slides = array_values(
	array_filter(
		$slides,
		static function ( $slide ) {
			return is_array( $slide ) && ( $slide['title'] ?? '' ) !== '';
		}
	)
);

if ( $slides === array() ) {
	return;
}

$items = array();

foreach ( $slides as $slide ) {
	$solution = $slide['solution'] ?? null;
	$is_post  = ! empty( $slide['solution_type'] ) && $solution instanceof WP_Post;

	if ( $is_post ) {
		$image = get_field( 'landing_image', $solution->ID );

		if ( empty( $image ) ) {
			$image = $slide['image'] ?? null;
		}

		$link = array(
			'title'  => 'Explore More',
			'url'    => (string) get_permalink( $solution->ID ),
			'target' => '_self',
		);
	} else {
		$image    = $slide['image'] ?? null;
		$raw_link = is_array( $slide['link'] ?? null ) ? $slide['link'] : array();
		$link     = array(
			'url'    => (string) ( $raw_link['url'] ?? '' ),
			'title'  => $raw_link['title'] ?? '',
			'target' => $raw_link['target'] ?? '_self',
		);
	}

	$image_id  = 0;
	$image_alt = (string) ( $slide['title'] ?? '' );

	if ( is_array( $image ) ) {
		$image_id  = (int) ( $image['ID'] ?? 0 );
		$image_alt = ! empty( $image['alt'] ) ? (string) $image['alt'] : $image_alt;
	} elseif ( is_numeric( $image ) ) {
		$image_id = (int) $image;
	}

	$items[] = array(
		'title'    => $slide['title'],
		'body'     => (string) ( $slide['body'] ?? '' ),
		'link'     => $link,
		'image_id' => $image_id,
		'image_alt'=> $image_alt,
	);
}
?>

<section class="recommended_solutions_section iec-offshore-solutions-section" id="recommended_solutions">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="iec_section_heading iec-section-heading" data-aos="fade-up"><?= $heading; ?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 order-1 order-md-1" data-aos="fade-right" data-aos-delay="100">
				<div class="recommended_tabs">

					<?php foreach ( $items as $index => $item ) : ?>

						<button
							type="button"
							class="solution_btn<?= 0 === $index ? ' active' : ''; ?>"
							data-target="solution-pane-<?= (int) $index; ?>"
						><?= $item['title']; ?></button>

					<?php endforeach; ?>

				</div>
			</div>
			<div class="col-md-5 order-3 order-md-2" data-aos="fade-up" data-aos-delay="150">
				<div class="recommended_content">

					<?php foreach ( $items as $index => $item ) : ?>

						<?php
						$link      = $item['link'];
						$link_url  = (string) ( $link['url'] ?? '' );
						$anchor_id = '';
						$link_href = $link_url;

						if ( '' !== $link_url && str_starts_with( $link_url, '#' ) ) {
							$anchor_id = ltrim( $link_url, '#' );
							$link_href = $link_url;
						}
						?>

						<div class="solution_pane<?= 0 === $index ? ' active' : ''; ?>" id="solution-pane-<?= (int) $index; ?>">

							<?php if ( '' !== $item['body'] ) : ?>

								<div class="solution_body"><?= $item['body']; ?></div>

							<?php endif; ?>

							<?php if ( '' !== $link_href ) : ?>

								<a
									href="<?= $link_href; ?>"
									class="learn_more_btn"
									<?= '' === $anchor_id && ! empty( $link['target'] ) ? 'target="' . $link['target'] . '"' : ''; ?>
									<?= '' !== $anchor_id ? 'data-id="' . $anchor_id . '"' : ''; ?>
								>
									<?= '' !== $link['title'] ? $link['title'] : 'Learn More'; ?>
									<span><?php get_template_part( 'template-parts/offshore/learn-more-icon' ); ?></span>
								</a>

							<?php else : ?>

								<a href="#iecEnquiryModal" class="learn_more_btn" data-id="iecModelEnquiry">
									Speak to an Expert
									<span><?php get_template_part( 'template-parts/offshore/learn-more-icon' ); ?></span>
								</a>

							<?php endif; ?>

						</div>

					<?php endforeach; ?>

				</div>
			</div>
			<div class="col-md-4 order-2 order-md-3 recommeded_image" data-aos="fade-left" data-aos-delay="200">
				<div class="recommended_solution_image">

					<?php foreach ( $items as $index => $item ) : ?>

						<?php
						$box_class = 'reveal-box solution_image';

						if ( 0 === $index ) {
							$box_class .= ' active';
						}

						if ( $item['image_id'] < 1 ) {
							$box_class .= ' is-empty';
						}
						?>

						<div
							class="<?= $box_class; ?>"
							data-offshore-solution-reveal
							data-slide="<?= (int) $index; ?>"
						>

							<?php if ( $item['image_id'] > 0 ) : ?>

								<?= wp_get_attachment_image( $item['image_id'], 'large', false, array( 'alt' => $item['image_alt'], 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>

								<div class="strips" aria-hidden="true">

									<?php for ( $strip = 0; $strip < 14; $strip++ ) : ?>

										<div class="strip"></div>

									<?php endfor; ?>

								</div>

							<?php endif; ?>

						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>
