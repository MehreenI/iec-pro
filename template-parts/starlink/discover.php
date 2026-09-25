<?php
/**
 * Starlink landing — discover section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['discover_title'] ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_starlink_discover" style="--desktopImage: url('<?= $fields['discover_image']; ?>'); --mobileImage: url('<?= $fields['discover_image_mobile']; ?>');">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-4">
				<div class="iec_starlink_discover_left_contnet">
					<h2 class="iec_section_heading"><?= $fields['discover_title']; ?></h2>
					<h3 class="iec_sec_sub_heading"><?= $fields['discover_description']; ?></h3>
					<?php if ( ! empty( $fields['discover_features'] ) ) : ?>
						<ul class="iec_icon_list">
							<?php foreach ( $fields['discover_features'] as $feature ) : ?>
								<li>
									<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M26.2996 7.89829C26.4266 8.02492 26.5273 8.17535 26.596 8.34097C26.6647 8.50658 26.7001 8.68413 26.7001 8.86343C26.7001 9.04274 26.6647 9.22029 26.596 9.3859C26.5273 9.55152 26.4266 9.70195 26.2996 9.82857L14.0309 22.0973C13.9042 22.2243 13.7538 22.325 13.5882 22.3937C13.4226 22.4624 13.245 22.4978 13.0657 22.4978C12.8864 22.4978 12.7089 22.4624 12.5433 22.3937C12.3777 22.325 12.2272 22.2243 12.1006 22.0973L6.64782 16.6445C6.39185 16.3886 6.24805 16.0414 6.24805 15.6794C6.24805 15.3174 6.39185 14.9702 6.64782 14.7143C6.90379 14.4583 7.25096 14.3145 7.61296 14.3145C7.97496 14.3145 8.32213 14.4583 8.5781 14.7143L13.0657 19.2046L24.3693 7.89829C24.496 7.77134 24.6464 7.67062 24.812 7.6019C24.9776 7.53318 25.1552 7.4978 25.3345 7.4978C25.5138 7.4978 25.6913 7.53318 25.8569 7.6019C26.0226 7.67062 26.173 7.77134 26.2996 7.89829Z" fill="#727DA3"></path>
									</svg>
									<?= $feature['text']; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<a href="<?= $fields['discover_details']; ?>" class="iec_button iec_gray_button">LEARN MORE</a>
				</div>
			</div>
		</div>
	</div>
</section>
