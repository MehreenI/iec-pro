<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$partners_raw = $args['partners'] ?? array();
$label        = $args['label'] ?? '';

if ( ! is_array( $partners_raw ) || empty( $partners_raw ) ) {
	return;
}

$partners = array();

foreach ( $partners_raw as $row ) {

	if ( ! is_array( $row ) ) {
		continue;
	}

	$logo    = $row['logo'] ?? ( $row['image'] ?? null );
	$link    = $row['link'] ?? null;
	$id      = 0;
	$url     = '';
	$alt     = '';
	$caption = '';

	if ( is_array( $logo ) ) {
		$id      = (int) ( $logo['ID'] ?? 0 );
		$url     = (string) ( $logo['url'] ?? '' );
		$alt     = (string) ( $logo['alt'] ?? ( $logo['title'] ?? '' ) );
		$caption = (string) ( $logo['caption'] ?? $alt );

	} elseif ( is_numeric( $logo ) ) {
		$id = (int) $logo;

	} elseif ( is_string( $logo ) ) {
		$url = trim( $logo );
	}

	if ( $id < 1 && '' === $url && function_exists( 'iec_resolve_media_to_url' ) ) {
		$url = (string) iec_resolve_media_to_url( $logo );
	}

	if ( $id < 1 && $url ) {
		$id = (int) attachment_url_to_postid( $url );
	}

	if ( $id < 1 ) {
		continue;
	}

	$href   = '';
	$target = '';

	if ( is_array( $link ) && ! empty( $link['url'] ) ) {
		$href   = (string) $link['url'];
		$target = $link['target'] ?? '';

	} elseif ( is_string( $link ) && '' !== trim( $link ) ) {
		$href = trim( $link );
	}

	$partners[] = array(
		'id'      => $id,
		'alt'     => $alt,
		'href'    => $href,
		'target'  => $target,
		'caption' => $caption,
	);
}

if ( empty( $partners ) ) {
	return;
}
?>

<section class="iec_defualt_position iec_marquee_section"<?= $label ? ' aria-label="' . esc_attr( $label ) . '"' : ''; ?> data-aos="fade-up">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_partner_bar">

					<?php if ( $label ) : ?>

						<span class="iec_partner_label"><?= esc_html( $label ); ?></span>

					<?php endif; ?>

					<div class="iec_partner_logos_wrapper">
						<div class="iec_partner_logos">
							<div class="iec_partner_logos_set">

								<?php foreach ( $partners as $partner ) : ?>

									<?php if ( $partner['href'] ) : ?>

										<a class="iec_partner_logo" href="<?= esc_url( $partner['href'] ); ?>"<?= $partner['target'] ? ' target="' . esc_attr( $partner['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>

									<?php else : ?>

										<div class="iec_partner_logo">

									<?php endif; ?>

										<?php if ( $partner['caption'] ) : ?>

											<span class="sr-only"><?= esc_html( $partner['caption'] ); ?></span>

										<?php endif; ?>

										<?= wp_get_attachment_image( (int) $partner['id'], 'medium', false, array( 'alt' => $partner['alt'], 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>

									<?php if ( $partner['href'] ) : ?>

										</a>

									<?php else : ?>

										</div>

									<?php endif; ?>

								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
