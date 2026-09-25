<?php
/**
 * Contact Us — regional office cards.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $args['heading'] ?? '';
$offices = $args['offices'] ?? array();

if ( empty( $offices ) ) {
	return;
}
?>

<section class="iec_contact_us_regional_offices iec_bg_position_center iec-contact-us-offices">
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-md-12">
					<h2 class="iec_main_heading text_blue"><?= $heading; ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<?php foreach ( $offices as $office ) : ?>
				<?php
				$office_name = $office['office_name'] ?? '';
				$address     = $office['address'] ?? '';
				$number      = $office['number'] ?? '';
				$email       = $office['email'] ?? '';
				$tel_href    = $number ? 'tel:' . preg_replace( '/[^\d+]/', '', $number ) : '';
				$mailto_href = $email ? 'mailto:' . $email : '';
				?>
				<div class="col-md-4 iec_contact_office_box_warpper">
					<article class="iec_contact_office_box">
						<div class="iec_contact_office_top_detail">
							<?php if ( $office_name ) : ?>
								<h5><?= $office_name; ?></h5>
							<?php endif; ?>

							<?php if ( $address ) : ?>
								<span><?= $address; ?></span>
							<?php endif; ?>
						</div>
						<ul class="iec_contact_office_content_list">
							<?php if ( $tel_href ) : ?>
								<li>
									<?php get_template_part( 'template-parts/contact-us/icon', 'phone' ); ?>
									<a href="<?= esc_attr( $tel_href ); ?>" class="link"><?= $number; ?></a>
								</li>
							<?php endif; ?>

							<?php if ( $mailto_href ) : ?>
								<li>
									<?php get_template_part( 'template-parts/contact-us/icon', 'email' ); ?>
									<a href="<?= esc_url( $mailto_href ); ?>" class="link"><?= $email; ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
