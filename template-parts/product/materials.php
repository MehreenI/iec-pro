<?php
/**
 * Single product — downloadable materials table.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_materials = $args['product_materials'] ?? array();
$valid_materials   = $args['valid_materials'] ?? array();

$download_icon = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20 38.75C30.3553 38.75 38.75 30.3553 38.75 20C38.75 9.64466 30.3553 1.25 20 1.25C9.64466 1.25 1.25 9.64466 1.25 20C1.25 30.3553 9.64466 38.75 20 38.75Z" fill="#727DA3" class="at_circle"/><path d="M20 23.575C19.8667 23.575 19.7417 23.5543 19.625 23.513C19.5083 23.4717 19.4 23.4007 19.3 23.3L15.7 19.7C15.5 19.5 15.404 19.2667 15.412 19C15.42 18.7333 15.516 18.5 15.7 18.3C15.9 18.1 16.1377 17.996 16.413 17.988C16.6883 17.98 16.9257 18.0757 17.125 18.275L19 20.15V13C19 12.7167 19.096 12.4793 19.288 12.288C19.48 12.0967 19.7173 12.0007 20 12C20.2827 11.9993 20.5203 12.0953 20.713 12.288C20.9057 12.4807 21.0013 12.718 21 13V20.15L22.875 18.275C23.075 18.075 23.3127 17.979 23.588 17.987C23.8633 17.995 24.1007 18.0993 24.3 18.3C24.4833 18.5 24.5793 18.7333 24.588 19C24.5967 19.2667 24.5007 19.5 24.3 19.7L20.7 23.3C20.6 23.4 20.4917 23.471 20.375 23.513C20.2583 23.555 20.1333 23.5757 20 23.575ZM14 28C13.45 28 12.9793 27.8043 12.588 27.413C12.1967 27.0217 12.0007 26.5507 12 26V24C12 23.7167 12.096 23.4793 12.288 23.288C12.48 23.0967 12.7173 23.0007 13 23C13.2827 22.9993 13.5203 23.0953 13.713 23.288C13.9057 23.4807 14.0013 23.718 14 24V26H26V24C26 23.7167 26.096 23.4793 26.288 23.288C26.48 23.0967 26.7173 23.0007 27 23C27.2827 22.9993 27.5203 23.0953 27.713 23.288C27.9057 23.4807 28.0013 23.718 28 24V26C28 26.55 27.8043 27.021 27.413 27.413C27.0217 27.805 26.5507 28.0007 26 28H14Z" fill="white"/></svg>';
?>
<section id="product-materials" class="iec_product_materials_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( ! empty( $product_materials['heading'] ) ) : ?>
					<h2 class="iec_single_product_section_title"><?= $product_materials['heading']; ?></h2>
				<?php endif; ?>

				<div class="iec_responsive_table">
					<table class="table iec_table">
						<thead>
							<tr>
								<th><?= 'Language'; ?></th>
								<th><?= 'Type'; ?></th>
								<th><?= 'Last Updated'; ?></th>
								<th><?= 'Size'; ?></th>
								<th class="no-border"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $valid_materials as $list ) :
								if ( ! is_array( $list ) ) {
									continue;
								}
								$file     = $list['file'] ?? array();
								$size     = ! empty( $file['filesize'] ) ? size_format( (int) $file['filesize'], 2 ) : '-';
								$modified = ! empty( $file['modified'] ) ? gmdate( 'd M Y', strtotime( $file['modified'] ) ) : '-';
								?>
								<tr>
									<td><?= $list['language'] ?? '-'; ?></td>
									<td><?= $list['type'] ?? '-'; ?></td>
									<td><?= $modified; ?></td>
									<td><?= $size; ?></td>
									<td class="no-border">
										<a href="<?= esc_url( $file['url'] ?? '' ); ?>" target="_blank" rel="noopener noreferrer">
											<?= $download_icon; ?>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<div class="iec_mobile_product_materials">
					<?php foreach ( $valid_materials as $list ) :
						if ( ! is_array( $list ) ) {
							continue;
						}
						$file     = $list['file'] ?? array();
						$size     = ! empty( $file['filesize'] ) ? size_format( (int) $file['filesize'], 2 ) : '-';
						$modified = ! empty( $file['modified'] ) ? gmdate( 'd M Y', strtotime( $file['modified'] ) ) : '-';
						?>
						<div class="iec_product_materials_box_warpper">
							<div class="iec_product_materials_box_content">
								<ul>
									<li>
										<span><?= 'Type'; ?></span>
										<?= $list['type'] ?? '-'; ?>
									</li>
									<li>
										<span><?= 'Language'; ?></span>
										<?= $list['language'] ?? '-'; ?>
									</li>
									<li>
										<span><?= 'Last Updated'; ?></span>
										<?= $modified; ?>
									</li>
									<li>
										<span><?= 'Size'; ?></span>
										<?= $size; ?>
									</li>
								</ul>
							</div>
							<div class="iec_product_materials_box_link">
								<a href="<?= esc_url( $file['url'] ?? '' ); ?>" target="_blank" rel="noopener noreferrer">
									<?= $download_icon; ?>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
