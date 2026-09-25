<?php
/**
 * Flexible: dynamic_table_builder
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block      = $args['block'] ?? array();
$num_cols   = ! empty( $block['number_of_columns'] ) ? (int) $block['number_of_columns'] : 0;
$rows       = is_array( $block['table'] ?? null ) ? $block['table'] : array();
$heading    = $block['heading'] ?? '';
$content    = $block['content'] ?? '';
$link       = is_array( $block['link'] ?? null ) ? $block['link'] : array();
$link_url   = $link['url'] ?? '';
$link_title = $link['title'] ?? __( 'Learn More', 'bbtheme' );

if ( $num_cols < 1 || empty( $rows ) ) {
	return;
}

$header_row = $rows[0] ?? array();
$data_rows  = array_slice( $rows, 1 );

if ( empty( $data_rows ) ) {
	return;
}

$raw_last_width = $block['column_width'] ?? '';
$last_col_pct   = 0;

if ( '' !== $raw_last_width ) {
	$last_col_pct = (float) str_replace( '%', '', $raw_last_width );
	if ( $last_col_pct < 1 ) {
		$last_col_pct = 0;
	} elseif ( $last_col_pct > 99 ) {
		$last_col_pct = 99;
	}
}

$col_widths = array();

if ( $last_col_pct > 0 && $num_cols > 1 ) {
	$other_pct = ( 100 - $last_col_pct ) / ( $num_cols - 1 );
	for ( $c = 1; $c < $num_cols; $c++ ) {
		$col_widths[ $c ] = $other_pct;
	}
	$col_widths[ $num_cols ] = $last_col_pct;
} else {
	$equal_pct = 100 / $num_cols;
	for ( $c = 1; $c <= $num_cols; $c++ ) {
		$col_widths[ $c ] = $equal_pct;
	}
}
?>
<section class="iec_single_news_main_section iec_single_news_table_section iec_defualt_position" data-news-table-accordion>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( $heading ) : ?>
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="iec_single_news_main_content_warpper">
						<?= $content; ?>
					</div>
				<?php endif; ?>

				<?php if ( $link_url ) : ?>
					<div class="mt-10 btn">
						<a href="<?= $link_url; ?>" class="iec_button iec_blue_gradient mx-r"><?= $link_title; ?></a>
					</div>
				<?php endif; ?>

				<table class="iec_single_news_table">
					<colgroup>
						<?php for ( $c = 1; $c <= $num_cols; $c++ ) : ?>
							<col style="width: <?= rtrim( rtrim( number_format( $col_widths[ $c ], 4, '.', '' ), '0' ), '.' ); ?>%;">
						<?php endfor; ?>
					</colgroup>
					<thead>
						<tr>
							<?php for ( $c = 1; $c <= $num_cols; $c++ ) : ?>
								<th><?= $header_row[ 'column_' . $c ] ?? ''; ?></th>
							<?php endfor; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data_rows as $row ) : ?>
							<?php $row = is_array( $row ) ? $row : array(); ?>
							<tr>
								<?php for ( $c = 1; $c <= $num_cols; $c++ ) : ?>
									<td><?= $row[ 'column_' . $c ] ?? ''; ?></td>
								<?php endfor; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="iec_single_news_accordion">
					<?php foreach ( $data_rows as $i => $row ) : ?>
						<?php
						$row     = is_array( $row ) ? $row : array();
						$feature = $row['column_1'] ?? '';
						?>
						<div class="iec_single_news_accordion_item<?= 0 === $i ? ' active' : ''; ?>">
							<div class="iec_single_news_accordion_header" role="button" tabindex="0">
								<?= $feature; ?>
								<span class="iec_single_news_accordion_icon" aria-hidden="true"></span>
							</div>
							<div class="iec_single_news_accordion_content">
								<?php for ( $c = 2; $c <= $num_cols; $c++ ) : ?>
									<?php
									$col_header = $header_row[ 'column_' . $c ] ?? '';
									$col_value  = $row[ 'column_' . $c ] ?? '';
									?>
									<?php if ( $col_header || $col_value ) : ?>
										<p>
											<strong><?= $col_header; ?></strong><br>
											<?= $col_value; ?>
										</p>
									<?php endif; ?>
								<?php endfor; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
