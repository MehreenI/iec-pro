<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$materials = is_array( $args['materials'] ?? null ) ? $args['materials'] : array();
$list      = is_array( $args['valid_materials'] ?? null ) ? $args['valid_materials'] : array();
$icon      = iec_product_material_download_svg();

if ( $list === array() ) {
	return;
}
?>
<section id="product-materials" class="iec_product_materials_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="iec_single_product_section_title"><?= $materials['heading'] ?? __( 'Product Materials', 'bbtheme' ); ?></h2>

				<div class="iec_responsive_table">
					<table class="table iec_table">
						<thead>
							<tr>
								<th><?= __( 'Language', 'bbtheme' ); ?></th>
								<th><?= __( 'Type', 'bbtheme' ); ?></th>
								<th><?= __( 'Last Updated', 'bbtheme' ); ?></th>
								<th><?= __( 'Size', 'bbtheme' ); ?></th>
								<th class="iec_table_buttons_warpper no-border"><?= __( 'Action', 'bbtheme' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $list as $item ) :
								$file     = $item['file'] ?? array();
								$file_url = $file['url'] ?? '';
								$size     = ! empty( $file['filesize'] ) ? size_format( (int) $file['filesize'], 2 ) : '-';
								$modified = ! empty( $file['modified'] ) ? gmdate( 'd M Y', strtotime( $file['modified'] ) ) : '-';
								$type     = $item['type'] ?? '';
								?>
								<tr>
									<td><?= strtoupper( $item['language'] ?? '' ); ?></td>
									<td><?= $type; ?></td>
									<td><?= $modified; ?></td>
									<td><?= $size; ?></td>
									<td class="iec_table_buttons_warpper no-border">
										<?php if ( $file_url ) : ?>
											<a href="<?= esc_url( $file_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr( sprintf( __( 'Download %s', 'bbtheme' ), $type ) ); ?>">
												<?= $icon; ?>
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<div class="iec_mobile_product_materials" aria-hidden="true">
					<?php foreach ( $list as $item ) :
						$file     = $item['file'] ?? array();
						$file_url = $file['url'] ?? '';
						$size     = ! empty( $file['filesize'] ) ? size_format( (int) $file['filesize'], 2 ) : '-';
						$modified = ! empty( $file['modified'] ) ? gmdate( 'd M Y', strtotime( $file['modified'] ) ) : '-';
						?>
						<div class="iec_product_materials_box_warpper">
							<div class="iec_product_materials_box_content">
								<ul>
									<li><span><?= __( 'Type', 'bbtheme' ); ?></span><?= $item['type'] ?? '-'; ?></li>
									<li><span><?= __( 'Language', 'bbtheme' ); ?></span><?= strtoupper( $item['language'] ?? '' ); ?></li>
									<li><span><?= __( 'Last Updated', 'bbtheme' ); ?></span><?= $modified; ?></li>
									<li><span><?= __( 'Size', 'bbtheme' ); ?></span><?= $size; ?></li>
								</ul>
							</div>
							<div class="iec_product_materials_box_link">
								<?php if ( $file_url ) : ?>
									<a href="<?= esc_url( $file_url ); ?>" target="_blank" rel="noopener noreferrer" tabindex="-1">
										<?= $icon; ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
