<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_us = $args['about_us'] ?? array();
if ( ! $about_us ) {
	return;
}

$icon       = function_exists( 'iec_office_check_icon_svg' ) ? iec_office_check_icon_svg() : '';
$why_us     = $about_us['why_us'] ?? array();
$points     = $why_us['why_us'] ?? array();
$membership = $about_us['membership'] ?? array();
?>

<!-- About. -->
<div id="about_us" class="iec_slide_about" role="tabpanel" aria-labelledby="iec-office-tab-0">
	<div class="iec_single_office_about">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<?php if ( ! empty( $about_us['heading'] ) ) : ?>
						<h2 class="iec_section_heading iec-section-heading"><?php echo $about_us['heading']; ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $about_us['content'] ) ) : ?>
						<div class="wysiwyg-content"><?php echo $about_us['content']; ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $why_us['heading'] ) ) : ?>
						<h3 class="iec_sec_sub_heading"><?php echo $why_us['heading']; ?></h3>
					<?php endif; ?>

				</div>
			</div>

			<?php if ( $points ) :
				$chunks = array_chunk( $points, (int) ceil( count( $points ) / 2 ) );
				?>
				<div class="row">
					<?php foreach ( $chunks as $chunk ) : ?>
						<div class="col-md-6">
							<ul class="iec_icon_list">
								<?php foreach ( $chunk as $item ) :
									if ( empty( $item['point'] ) ) {
										continue;
									}
									?>
									<li>
										<?php echo $icon; ?>
										<?php echo $item['point']; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $why_us['body'] ) ) : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="wysiwyg-content about-disclaimer"><?php echo $why_us['body']; ?></div>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<?php if ( ! empty( $about_us['show_membership_section'] ) && $membership ) : ?>
		<div class="iec_about_logo_section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="iec_sec_sub_heading"><?php echo __( 'MEMBERSHIP & ASSOCIATION', 'bbtheme' ); ?></h3>
						<div class="iec_about_logo_boxes_grid">
							<?php foreach ( $membership as $member ) :
								if ( ! is_array( $member ) ) {
									continue;
								}
								$logo       = $member['logo'] ?? array();
								$member_alt = '';
								if ( ! empty( $member['content'] ) ) {
									$member_alt = wp_trim_words( wp_strip_all_tags( $member['content'] ), 12, '' );
								}
								if ( ! $member_alt && ! empty( $logo['alt'] ) ) {
									$member_alt = $logo['alt'];
								} elseif ( ! $member_alt && ! empty( $logo['title'] ) ) {
									$member_alt = $logo['title'];
								}
								if ( ! $member_alt ) {
									$member_alt = __( 'Member logo', 'bbtheme' );
								}
								?>
								<figure class="iec_about_logo_box">

									<?php if ( ! empty( $logo['ID'] ) ) : ?>
										<?php echo wp_get_attachment_image( (int) $logo['ID'], 'thumbnail', false, array( 'alt' => $member_alt ) ); ?>
									<?php elseif ( ! empty( $logo['url'] ) ) : ?>
										<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $member_alt ); ?>" loading="lazy" decoding="async">
									<?php endif; ?>

									<?php if ( ! empty( $member['content'] ) ) : ?>
										<figcaption class="iec_logo_content"><?php echo $member['content']; ?></figcaption>
									<?php endif; ?>

								</figure>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>
