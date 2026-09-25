<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = IEC_Mega_Menu_Render::visible_sorted( isset( $items ) ? $items : array() );
$cta   = isset( $cta ) ? $cta : array();
?>
<div class="iec_mobile_navigation" data-iec-mega-menu="mobile">
	<div class="iec_mobile_menu">
		<?php foreach ( $items as $dropdown ) : ?>
			<?php
			$columns = IEC_Mega_Menu_Render::visible_sorted( isset( $dropdown['children'] ) ? $dropdown['children'] : array() );
			$view_all = null;
			?>
			<div class="iec_mobile_dropdown" data-id="<?php echo esc_attr( $dropdown['id'] ); ?>">
				<button class="iec_mobile_toggle" type="button">
					<span><?php echo IEC_Mega_Menu_Resolver::get_label( $dropdown ); ?></span>
					<?php echo IEC_Mega_Menu_Icons::chevron_mobile(); ?>
				</button>

				<div class="iec_mobile_submenu">
					<?php foreach ( $columns as $column ) : ?>
						<?php
						$col_type = isset( $column['item_type'] ) ? $column['item_type'] : 'column';
						$kids     = IEC_Mega_Menu_Render::visible_sorted( isset( $column['children'] ) ? $column['children'] : array() );

						if ( 'explore' === $col_type ) {
							foreach ( $kids as $kid ) {
								if ( in_array( $kid['item_type'] ?? '', array( 'cta', 'link' ), true ) ) {
									$view_all = $kid;
									break;
								}
							}
							if ( ! $view_all ) {
								$view_all = $column;
							}
							continue;
						}

						if ( 'featured' === $col_type ) {

							?>
							<div class="iec_mobile_card" data-id="<?php echo esc_attr( $column['id'] ); ?>">
								<button class="iec_mobile_card_toggle" type="button">
									<div class="iec_mega_menu_column_title_icon">
										<?php echo IEC_Mega_Menu_Icons::render_icon( $column ); ?>
									</div>
									<span><?php echo IEC_Mega_Menu_Resolver::get_label( $column ); ?></span>
									<?php echo IEC_Mega_Menu_Icons::chevron_right(); ?>
								</button>
								<ul class="iec_mobile_links">
									<?php foreach ( $kids as $kid ) : ?>
										<li>
											<?php echo IEC_Mega_Menu_Render::anchor_open( $kid ); ?>
												<?php echo IEC_Mega_Menu_Resolver::get_label( $kid ); ?>
												<?php echo IEC_Mega_Menu_Icons::chevron_right(); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<?php
							continue;
						}
						?>
						<div class="iec_mobile_card" data-id="<?php echo esc_attr( $column['id'] ); ?>">
							<button class="iec_mobile_card_toggle" type="button">
								<div class="iec_mega_menu_column_title_icon">
									<?php echo IEC_Mega_Menu_Icons::render_icon( $column ); ?>
								</div>
								<span><?php echo IEC_Mega_Menu_Resolver::get_label( $column ); ?></span>
								<?php echo IEC_Mega_Menu_Icons::chevron_right(); ?>
							</button>
							<ul class="iec_mobile_links">
								<?php foreach ( $kids as $kid ) : ?>
									<?php if ( 'cta' === ( $kid['item_type'] ?? '' ) && empty( $kid['path'] ) && empty( $kid['url'] ) && empty( $kid['object_id'] ) ) { continue; } ?>
									<li>
										<?php echo IEC_Mega_Menu_Render::anchor_open( $kid ); ?>
											<?php echo IEC_Mega_Menu_Resolver::get_label( $kid ); ?>
											<?php echo IEC_Mega_Menu_Icons::chevron_right(); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>

					<?php if ( $view_all ) : ?>
						<?php echo IEC_Mega_Menu_Render::anchor_open( $view_all, 'iec_mobile_btn' ); ?>
							<?php echo ! empty( $view_all['cta_label'] ) ? $view_all['cta_label'] : IEC_Mega_Menu_Resolver::get_label( $view_all ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
	<?php if ( ! empty( $cta ) && ( ! isset( $cta['visible'] ) || ! empty( $cta['visible'] ) ) ) : ?>
		<?php echo IEC_Mega_Menu_Render::anchor_open( $cta, 'iec_button btn btn-primary' ); ?>
			<?php echo ! empty( $cta['label'] ) ? IEC_Mega_Menu_Resolver::get_label( $cta ) : 'CONTACT US'; ?>
		</a>
	<?php endif; ?>
</div>
