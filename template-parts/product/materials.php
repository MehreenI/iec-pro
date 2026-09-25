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

$download_icon = iec_product_material_download_svg();
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
								<th><?= __( 'Language', 'bbtheme' ); ?></th>
								<th><?= __( 'Type', 'bbtheme' ); ?></th>
								<th><?= __( 'Last Updated', 'bbtheme' ); ?></th>
								<th><?= __( 'Size', 'bbtheme' ); ?></th>
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

				<div class="iec_mobile_product_materials" aria-hidden="true">
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
										<span><?= __( 'Type', 'bbtheme' ); ?></span>
										<?= $list['type'] ?? '-'; ?>
									</li>
									<li>
										<span><?= __( 'Language', 'bbtheme' ); ?></span>
										<?= $list['language'] ?? '-'; ?>
									</li>
									<li>
										<span><?= __( 'Last Updated', 'bbtheme' ); ?></span>
										<?= $modified; ?>
									</li>
									<li>
										<span><?= __( 'Size', 'bbtheme' ); ?></span>
										<?= $size; ?>
									</li>
								</ul>
							</div>
							<div class="iec_product_materials_box_link">
								<a href="<?= esc_url( $file['url'] ?? '' ); ?>" target="_blank" rel="noopener noreferrer" tabindex="-1">
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
