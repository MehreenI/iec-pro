<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ctx        = is_array( $args['ctx'] ?? null ) ? $args['ctx'] : array();
$filter     = $ctx['filter'] ?? array();
$bg_desktop = $ctx['bg_desktop'] ?? '';
$bg_mobile  = $ctx['bg_mobile'] ?? '';
$bg_mobile  = $bg_mobile ? $bg_mobile : $bg_desktop;
$heading    = $ctx['heading'] ?? '';
$sub        = $ctx['sub_heading'] ?? '';
$quote      = $ctx['quote_btn_label'] ?? __( 'Request Quote', 'bbtheme' );
$download   = $ctx['download_label'] ?? __( 'Downloads', 'bbtheme' );
$file_url   = $ctx['attachment_url'] ?? '';

$pill_colors = array(
	'maritime' => '#92C0E9',
	'land'     => '#DDC9A3',
);

$hero_style = '';
if ( $bg_desktop ) {
	$hero_style = '--bg_desktop: url(' . esc_url( $bg_desktop ) . '); --bg_mobile: url(' . esc_url( $bg_mobile ) . ');';
}
?>
<section class="iec_defualt_position iec_single_solution_hero"<?= $hero_style ? ' style="' . $hero_style . '"' : ''; ?> aria-labelledby="iec-solution-page-title">
	<div class="iec_single_solution_tagline">
		<span><?= __( 'Solution', 'bbtheme' ); ?></span>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="iec_single_solution_hero_content">
					<?php if ( $filter ) : ?>
						<ul class="iec_single_solution_slide_pills iec-anim-stagger" data-iec-anim-on-load="true" data-iec-anim-stagger="0.1">
							<?php foreach ( $filter as $app ) : ?>
								<li style="--bg: <?= $pill_colors[ $app ] ?? '#DDC9A3'; ?>">
									<?= 'maritime' === $app ? __( 'Maritime', 'bbtheme' ) : __( 'Land', 'bbtheme' ); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<h1 id="iec-solution-page-title" class="iec_single_solution_name iec-anim-split-words" data-iec-anim-on-load="true"><?= $heading; ?></h1>

					<?php if ( $sub ) : ?>
						<p class="iec_single_solution_sub_head"><?= $sub; ?></p>
					<?php endif; ?>

					<ul class="iec_single_solution_slide_buttons iec-anim-stagger" data-iec-anim-on-load="true" data-iec-anim-stagger="0.12">
						<li>
							<a href="#contact" class="gray_btn"><?= $quote; ?></a>
						</li>
						<?php if ( $file_url ) : ?>
							<li>
								<a href="<?= esc_url( $file_url ); ?>" download class="download at_btn iec_outline_button_with_icon" target="_blank" rel="noopener noreferrer">
									<?= $download; ?>
									<?= iec_solution_download_svg(); ?>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
