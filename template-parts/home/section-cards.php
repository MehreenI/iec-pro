<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();
$cards   = $section['cards'] ?? array();

if ( empty( $cards ) ) {
	return;
}

$main  = $cards[0];
$grid  = array_slice( $cards, 1 );
$stats = $section['statistics'] ?? ( $main['statistics'] ?? array() );
$link  = $main['link'] ?? array();
$url   = ! empty( $link['url'] ) && function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : ( $link['url'] ?? '' );
$bg    = apply_filters( 'iec_home_section_cards_bg_url', content_url( '/uploads/2026/08/glass-effect.webp' ) );
?>

<section class="iec_defualt_position iec_section_home_cards" aria-labelledby="iec-home-cards-heading" style="background-image: url('<?= esc_url( $bg ); ?>');">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_home_card_sec_warper">
					<div class="iec_home_card iec_home_card_full" data-aos="fade-up">
						<?php if ( ! empty( $main['eyebrow'] ) ) : ?>

							<span class="iec_home_card_eyebrow"><?= $main['eyebrow']; ?></span>

						<?php endif; ?>

						<?php if ( ! empty( $main['heading'] ) ) : ?>

							<h2 class="iec_section_heading iec-section-heading" id="iec-home-cards-heading"><?= $main['heading']; ?></h2>

						<?php endif; ?>

						<?php if ( ! empty( $main['content'] ) ) : ?>

							<div class="iec_home_card_para"><?= $main['content']; ?></div>

						<?php endif; ?>

						<?php if ( $stats ) : ?>

							<div class="iec_home_card_stats" role="list">

								<?php foreach ( $stats as $stat ) : ?>

									<?php
									$value = $stat['value'] ?? ( $stat['number'] ?? '' );
									$label = $stat['label'] ?? '';

									if ( ! $value && ! $label ) {
										continue;
									}
									?>

									<div class="iec_home_card_stat" role="listitem">

										<?php if ( $value ) : ?>

											<span class="iec_home_card_stat_number"><?= $value; ?></span>

										<?php endif; ?>

										<?php if ( $label ) : ?>

											<span class="iec_home_card_stat_label"><?= $label; ?></span>

										<?php endif; ?>

									</div>

								<?php endforeach; ?>

							</div>

						<?php endif; ?>

						<?php if ( $url && ! empty( $link['title'] ) ) : ?>

							<a class="iec_home_card_link" href="<?= esc_url( $url ); ?>"<?= ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : ''; ?>>
								<?= $link['title']; ?>
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M8.49219 3.41675C8.51931 3.417 8.54751 3.42336 8.5752 3.43628C8.60296 3.44926 8.63095 3.46936 8.65625 3.4978L8.66211 3.50366L11.6621 6.76245C11.7006 6.80419 11.7315 6.86263 11.7441 6.9314C11.7567 7.00011 11.7494 7.07104 11.7256 7.13354V7.13452C11.7101 7.17548 11.6882 7.21047 11.6631 7.23804L8.66309 10.4958L8.65723 10.5027C8.63196 10.5311 8.6039 10.5512 8.57617 10.5642C8.54854 10.5771 8.52024 10.5835 8.49316 10.5837C8.46606 10.584 8.4378 10.5784 8.41016 10.5662C8.3825 10.5539 8.3546 10.5342 8.3291 10.5066C8.30342 10.4787 8.28041 10.4429 8.26465 10.4011C8.24888 10.3593 8.24083 10.3127 8.24121 10.2654C8.24163 10.2184 8.25039 10.1727 8.2666 10.1316C8.28294 10.0903 8.30614 10.0553 8.33203 10.0281L8.33789 10.0212L10.0576 8.15405L10.8301 7.31519H2.5C2.44774 7.31517 2.3885 7.29283 2.33789 7.23804C2.28597 7.18165 2.25006 7.09677 2.25 7.00073C2.25 6.90459 2.28593 6.81986 2.33789 6.76343C2.38855 6.70844 2.44765 6.68629 2.5 6.68628H10.8301L10.0576 5.84741L8.33691 3.97827L8.33105 3.97241L8.29492 3.92554C8.28406 3.9084 8.27471 3.88939 8.2666 3.8689C8.25023 3.82751 8.24061 3.78144 8.24023 3.73413C8.23989 3.68693 8.24892 3.64113 8.26465 3.59937C8.2804 3.55754 8.30244 3.52179 8.32812 3.4939C8.35361 3.46626 8.3815 3.44666 8.40918 3.43433C8.43682 3.42204 8.46509 3.4165 8.49219 3.41675Z" fill="#CAD1EA" stroke="#CAD1EA"/></svg>
							</a>

						<?php endif; ?>

					</div>

					<?php if ( $grid ) : ?>

						<div class="iec_home_card_grid">

							<?php foreach ( $grid as $i => $card ) : ?>

								<?php if ( empty( $card['heading'] ) ) : ?>

									<?php continue; ?>

								<?php endif; ?>

								<article class="iec_home_card" data-aos="fade-up" data-aos-delay="<?= esc_attr( ( $i + 1 ) * 100 ); ?>">
									<div class="iec_home_card_head">
										<span class="iec_home_card_icon"><?php get_template_part( 'template-parts/home/section-cards', 'icon' ); ?></span>
										<h3 class="iec_home_card_heading"><?= $card['heading']; ?></h3>
									</div>

									<?php if ( ! empty( $card['content'] ) ) : ?>

										<div class="iec_home_card_para"><?= $card['content']; ?></div>

									<?php endif; ?>

									<?php if ( ! empty( $card['tag'] ) ) : ?>

										<span class="iec_home_card_tag"><?= $card['tag']; ?></span>

									<?php endif; ?>

								</article>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
