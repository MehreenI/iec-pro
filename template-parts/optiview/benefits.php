<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$parts  = $fields['parts'] ?? array();

if ( empty( $parts ) ) {
	return;
}
?>
<section class="iec_optiview_benefits iec_defualt_position" aria-labelledby="iec-optiview-benefits-title">
	<div class="container">
		<h2 id="iec-optiview-benefits-title" class="sr-only"><?= __( 'Benefits', 'bbtheme' ); ?></h2>
		<div class="row">
			<?php foreach ( $parts as $part ) : ?>
				<?php
				$title = $part['title'] ?? '';
				?>
				<article class="col-md-4 iec_optiview_benefits_box_warpper">
					<div class="iec_optiview_benefits_box">
						<?php if ( ! empty( $part['image']['ID'] ) ) : ?>
							<div class="iec_optiview_benefits_box_img_wrapper">
								<?= wp_get_attachment_image( $part['image']['ID'], 'full', false, array( 'alt' => $title ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<h3><?= $title; ?></h3>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
