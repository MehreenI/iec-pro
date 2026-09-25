<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields   = $args['fields'] ?? array();
$features = $fields['features'] ?? array();

if ( empty( $features ) ) {
	return;
}
?>
<section class="iec_optiview_solutions" aria-labelledby="iec-optiview-solutions-title">
	<div class="container">
		<h2 id="iec-optiview-solutions-title" class="sr-only"><?= __( 'Solutions', 'bbtheme' ); ?></h2>
		<div class="row">
			<?php foreach ( $features as $key => $item ) : ?>
				<?php
				$title     = $item['title'] ?? '';
				$desc      = $item['description'] ?? '';
				$anchor_id = 'item-' . ( (int) $key + 1 );
				?>
				<article class="col-md-4 iec_optiview_solution_box_warpper">
					<div class="iec_optiview_solution_box">
						<?php if ( ! empty( $item['image']['ID'] ) ) : ?>
							<div class="iec_optiview_solution_box_image_warpper">
								<?= wp_get_attachment_image( $item['image']['ID'], 'full', false, array( 'alt' => $title, 'class' => 'iec_img_style' ) ); ?>
							</div>
						<?php endif; ?>

						<div class="iec_optiview_solution_box_content">
							<?php if ( $title ) : ?>
								<h3 class="iec_optiview_solution_title"><?= $title; ?></h3>
							<?php endif; ?>

							<?php if ( $desc ) : ?>
								<p class="iec_optiview_solution_desc"><?= $desc; ?></p>
							<?php endif; ?>

							<a
								href="#<?= $anchor_id; ?>"
								class="more"
								aria-label="<?= $title ? sprintf( __( 'More about %s', 'bbtheme' ), $title ) : __( 'More', 'bbtheme' ); ?>"
							>
								<?= __( 'More', 'bbtheme' ); ?>
								<svg width="25" height="12" viewBox="0 0 25 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<g clip-path="url(#<?= 'clip_sol_a_' . $anchor_id; ?>)">
										<path d="M4.1001 10.8L8.9001 5.99999L4.1001 1.19999" stroke="#727DA4" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" />
									</g>
									<g clip-path="url(#<?= 'clip_sol_b_' . $anchor_id; ?>)">
										<path d="M16.1001 10.8L20.9001 5.99999L16.1001 1.19999" stroke="#727DA4" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" />
									</g>
									<defs>
										<clipPath id="<?= 'clip_sol_a_' . $anchor_id; ?>">
											<rect width="12" height="12" fill="white" transform="translate(0.5 12) rotate(-90)" />
										</clipPath>
										<clipPath id="<?= 'clip_sol_b_' . $anchor_id; ?>">
											<rect width="12" height="12" fill="white" transform="translate(12.5 12) rotate(-90)" />
										</clipPath>
									</defs>
								</svg>
							</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
