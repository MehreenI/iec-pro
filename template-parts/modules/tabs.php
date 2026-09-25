<?php
/**
 * About section tab navigation.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tab_pages = $args['tab_pages'] ?? array();

if ( empty( $tab_pages ) ) {
	return;
}
?>

<nav class="iec_pages_tabs iec_defualt_position" aria-label="<?php esc_attr_e( 'About section navigation', 'bbtheme' ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="iec_pages_tab_button_list">
					<?php foreach ( $tab_pages as $link ) : ?>
						<?php
						$url     = $link['url'] ?? '';
						$caption = $link['caption'] ?? '';
						$active  = ! empty( $link['active'] );
						if ( ! $url || ! $caption ) {
							continue;
						}
						$tab_class = 'iec_tab_buton' . ( $active ? ' iec_tab_buton_active' : '' );
						?>
						<li>
							<a
								href="<?= esc_url( $url ); ?>"
								class="<?= esc_attr( $tab_class ); ?>"
								<?= $active ? 'aria-current="page"' : ''; ?>
							>
								<?= $caption; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</nav>
