<?php
/**
 * About section tabs.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$tabs   = array();

if ( ! empty( $fields['tabs'] ) && class_exists( '\BlueBeetle\Press\Generic' ) ) {
	$tabs = \BlueBeetle\Press\Generic::get_instance()->get_banner_links( $fields['tabs'] );
}

if ( ! $tabs ) {
	return;
}

?>

<!-- About tabs. -->
<nav class="iec_pages_tabs iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="iec_pages_tab_button_list">

					<?php foreach ( $tabs as $tab ) : ?>
						<?php if ( ! empty( $tab['url'] ) && ! empty( $tab['caption'] ) ) : ?>
							<li>
								<a href="<?php echo $tab['url']; ?>" class="iec_tab_buton<?php echo ! empty( $tab['active'] ) ? ' iec_tab_buton_active' : ''; ?>"<?php echo ! empty( $tab['active'] ) ? ' aria-current="page"' : ''; ?>><?php echo $tab['caption']; ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>

				</ul>
			</div>
		</div>
	</div>
</nav>
