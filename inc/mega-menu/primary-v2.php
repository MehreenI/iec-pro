<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = IEC_Mega_Menu_Render::visible_sorted( isset( $items ) ? $items : array() );
?>
<ul class="iec_main_menu" data-iec-mega-menu="primary">
	<?php foreach ( $items as $dropdown ) : ?>
		<?php
        $panel         = ! empty( $dropdown['panel'] ) ? $dropdown['panel'] : sanitize_title( $dropdown['label'] );
        $columns       = IEC_Mega_Menu_Render::visible_sorted( isset( $dropdown['children'] ) ? $dropdown['children'] : array() );
        $columns_count = count( $columns );
        $panel_key     = sanitize_key( (string) $panel );

        if ( 2 === $columns_count ) {
            $size = 'menu_mini';
        } elseif ( 3 === $columns_count ) {
            $size = 'menu_sm';
        } elseif ( 5 === $columns_count ) {
            $size = ( 'company' === $panel_key ) ? 'menu_xl' : 'menu_lg';
        } else {
            $size = 'menu_md';
        }

        $panel_id = 'iec-mega-' . sanitize_html_class( $dropdown['id'] );
		?>
		<?php
		$is_dropdown = ( 'dropdown' === ( $dropdown['item_type'] ?? '' ) ) || ! empty( $columns );
		$li_class    = $is_dropdown ? 'iec_menu_dropdown' : '';
		?>
		<li<?php echo $li_class ? ' class="' . esc_attr( $li_class ) . '"' : ''; ?> data-id="<?php echo esc_attr( $dropdown['id'] ); ?>">
			<?php echo IEC_Mega_Menu_Render::anchor_open( $dropdown ); ?>
				<?php echo IEC_Mega_Menu_Resolver::get_label( $dropdown ); ?>
				<?php
				if ( $is_dropdown ) {

					echo '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true" focusable="false"><path d="M10.711 0.89259L5.80179 6.24809L0.892578 0.89259" stroke="#727DA3" stroke-width="1.78517" stroke-linecap="round"/></svg>';
				}
				?>
			</a>

			<?php if ( $is_dropdown && ! empty( $columns ) ) : ?>
				<div id="<?php echo esc_attr( $panel_id ); ?>" class="iec_mega_menu_warpper <?php echo esc_attr( $size ); ?>" role="region" aria-label="<?php echo esc_attr( IEC_Mega_Menu_Resolver::get_label( $dropdown ) ); ?>">
					<?php foreach ( $columns as $column ) : ?>
						<?php
						$col_type = isset( $column['item_type'] ) ? $column['item_type'] : 'column';
						$col_class = 'iec_mega_menu_column';
						if ( 'featured' === $col_type ) {
							$col_class .= ' featured';
						} elseif ( 'explore' === $col_type ) {
							$col_class .= ' explore';
						}
						$kids = IEC_Mega_Menu_Render::visible_sorted( isset( $column['children'] ) ? $column['children'] : array() );
						?>
						<div class="<?php echo esc_attr( $col_class ); ?>" data-id="<?php echo esc_attr( $column['id'] ); ?>">
							<?php if ( empty( $column['hide_header'] ) ) : ?>
								<div class="iec_mega_menu_column_header">
									<div class="iec_mega_menu_column_title_icon">
										<?php echo IEC_Mega_Menu_Icons::render_icon( $column ); ?>
									</div>
									<h4><?php echo IEC_Mega_Menu_Resolver::get_label( $column ); ?></h4>
								</div>
							<?php endif; ?>

							<?php if ( 'featured' === $col_type ) : ?>
								<?php foreach ( $kids as $card ) : ?>
									<?php if ( 'card' !== ( $card['item_type'] ?? '' ) && 'link' !== ( $card['item_type'] ?? '' ) ) { continue; } ?>
									<?php echo IEC_Mega_Menu_Render::anchor_open( $card, 'iec_mega_menu_card' ); ?>
										<div class="iec_mega_menu_card_image_warpper">
											<?php
											$img_id = ! empty( $card['image_attachment_id'] ) ? absint( $card['image_attachment_id'] ) : 0;
											if ( $img_id ) {
												echo wp_get_attachment_image(
													$img_id,
													'medium_large',
													false,
													array(
														'alt'   => esc_attr( IEC_Mega_Menu_Resolver::get_label( $card ) ),
														'class' => 'iec_img_style',
													)
												);
											} elseif ( ! empty( $card['image_url'] ) ) {
												printf(
													'<img src="%s" class="iec_img_style" alt="%s" />',
													esc_url( $card['image_url'] ),
													esc_attr( IEC_Mega_Menu_Resolver::get_label( $card ) )
												);
											}
											?>
										</div>
										<div class="iec_mega_menu_card_content">
											<h5><?php echo IEC_Mega_Menu_Resolver::get_label( $card ); ?></h5>
											<?php if ( ! empty( $card['description'] ) ) : ?>
												<p><?php echo $card['description']; ?></p>
											<?php endif; ?>
											<span>
												<?php
												$card_cta = ! empty( $card['cta_label'] ) ? $card['cta_label'] : __( 'Explore Service', 'iec-mega-menu' );
												echo $card_cta;
												echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
  <path d="M8.49219 3.41666C8.51931 3.41691 8.54751 3.42327 8.5752 3.43619C8.60296 3.44917 8.63095 3.46927 8.65625 3.49771L8.66211 3.50357L11.6621 6.76236C11.7006 6.8041 11.7315 6.86254 11.7441 6.9313C11.7567 7.00001 11.7494 7.07095 11.7256 7.13345V7.13443C11.7101 7.17539 11.6882 7.21038 11.6631 7.23795L8.66309 10.4958L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5834 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.5661C8.3825 10.5538 8.3546 10.5341 8.3291 10.5065C8.30342 10.4786 8.28041 10.4429 8.26465 10.401C8.24888 10.3592 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1727 8.2666 10.1315C8.28294 10.0902 8.30614 10.0552 8.33203 10.028L8.33789 10.0211L10.0576 8.15396L10.8301 7.31509H2.5C2.44774 7.31508 2.3885 7.29274 2.33789 7.23795C2.28597 7.18156 2.25006 7.09668 2.25 7.00064C2.25 6.9045 2.28593 6.81977 2.33789 6.76334C2.38855 6.70835 2.44765 6.6862 2.5 6.68619H10.8301L10.0576 5.84732L8.33691 3.97818L8.33105 3.97232L8.29492 3.92545C8.28406 3.90831 8.27471 3.8893 8.2666 3.8688C8.25023 3.82742 8.24061 3.78135 8.24023 3.73404C8.23989 3.68684 8.24892 3.64104 8.26465 3.59927C8.2804 3.55745 8.30244 3.5217 8.32812 3.4938C8.35361 3.46617 8.3815 3.44657 8.40918 3.43423C8.43682 3.42195 8.46509 3.41641 8.49219 3.41666Z" fill="#727DA3" stroke="#727DA3"/>
</svg>'
												?>
											</span>
										</div>
									</a>
								<?php endforeach; ?>

							<?php elseif ( 'explore' === $col_type ) : ?>
								<div class="iec_mega_menu_explore">
									<?php
									$explore = null;
									foreach ( $kids as $kid ) {
										if ( in_array( $kid['item_type'] ?? '', array( 'cta', 'link' ), true ) ) {
											$explore = $kid;
											break;
										}
									}
									if ( $explore && ! empty( $explore['description'] ) ) :
										?>
										<p><?php echo $explore['description']; ?></p>
									<?php elseif ( ! empty( $column['description'] ) ) : ?>
										<p><?php echo $column['description']; ?></p>
									<?php endif; ?>
									<?php if ( $explore ) : ?>
										<?php echo IEC_Mega_Menu_Render::anchor_open( $explore ); ?>
											<?php
											echo ! empty( $explore['cta_label'] ) ? $explore['cta_label'] : IEC_Mega_Menu_Resolver::get_label( $explore );
											echo'<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
  <path d="M8.49219 3.41666C8.51931 3.41691 8.54751 3.42327 8.5752 3.43619C8.60296 3.44917 8.63095 3.46927 8.65625 3.49771L8.66211 3.50357L11.6621 6.76236C11.7006 6.8041 11.7315 6.86254 11.7441 6.9313C11.7567 7.00001 11.7494 7.07095 11.7256 7.13345V7.13443C11.7101 7.17539 11.6882 7.21038 11.6631 7.23795L8.66309 10.4958L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5834 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.5661C8.3825 10.5538 8.3546 10.5341 8.3291 10.5065C8.30342 10.4786 8.28041 10.4429 8.26465 10.401C8.24888 10.3592 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1727 8.2666 10.1315C8.28294 10.0902 8.30614 10.0552 8.33203 10.028L8.33789 10.0211L10.0576 8.15396L10.8301 7.31509H2.5C2.44774 7.31508 2.3885 7.29274 2.33789 7.23795C2.28597 7.18156 2.25006 7.09668 2.25 7.00064C2.25 6.9045 2.28593 6.81977 2.33789 6.76334C2.38855 6.70835 2.44765 6.6862 2.5 6.68619H10.8301L10.0576 5.84732L8.33691 3.97818L8.33105 3.97232L8.29492 3.92545C8.28406 3.90831 8.27471 3.8893 8.2666 3.8688C8.25023 3.82742 8.24061 3.78135 8.24023 3.73404C8.23989 3.68684 8.24892 3.64104 8.26465 3.59927C8.2804 3.55745 8.30244 3.5217 8.32812 3.4938C8.35361 3.46617 8.3815 3.44657 8.40918 3.43423C8.43682 3.42195 8.46509 3.41641 8.49219 3.41666Z" fill="#727DA3" stroke="#727DA3"/>
</svg>'
											?>
										</a>
									<?php endif; ?>
								</div>

							<?php else : ?>
								<?php
								$has_desc = false;
								$view_all = null;
								$list_kids = array();
								foreach ( $kids as $kid ) {
									if ( 'cta' === ( $kid['item_type'] ?? '' ) ) {
										$view_all = $kid;
										continue;
									}
									$list_kids[] = $kid;
									if ( ! empty( $kid['description'] ) ) {
										$has_desc = true;
									}
								}
								$col_slug = isset( $column['column'] ) ? $column['column'] : '';
								$ul_class = '';
								if ( 'regional-offices' === $col_slug ) {
									$ul_class = 'iec_mega_menu_office_list';
								} elseif ( $has_desc ) {
									$ul_class = 'iec_mega_menu_with_text_list';
								}
								?>
								<ul<?php echo $ul_class ? ' class="' . esc_attr( $ul_class ) . '"' : ''; ?>>
									<?php foreach ( $list_kids as $kid ) : ?>
										<li data-id="<?php echo esc_attr( $kid['id'] ); ?>">
											<?php echo IEC_Mega_Menu_Render::anchor_open( $kid ); ?>
												<?php

												$icon_key = isset( $kid['icon_key'] ) ? $kid['icon_key'] : 'none';
												$icon     = ( 'none' !== $icon_key && 'chevron' !== $icon_key )
													? IEC_Mega_Menu_Icons::render_icon( $kid )
													: '';
												if ( $icon ) {
													echo $icon;
												} else {
													echo IEC_Mega_Menu_Icons::chevron_right();
												}
												echo IEC_Mega_Menu_Resolver::get_label( $kid );
												if ( ! empty( $kid['description'] ) ) {
													echo '<span>' .  $kid['description']  . '</span>';
												}
												?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
								<?php if ( $view_all ) : ?>
									<?php echo IEC_Mega_Menu_Render::anchor_open( $view_all, 'iec_mega_menu_veiw_all_link' ); ?>
										<?php
										echo ! empty( $view_all['cta_label'] ) ? $view_all['cta_label'] : IEC_Mega_Menu_Resolver::get_label( $view_all );
										echo IEC_Mega_Menu_Icons::chevron_right();
										?>
									</a>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
<?php

