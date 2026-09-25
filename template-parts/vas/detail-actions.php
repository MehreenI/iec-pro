<?php
/**
 * VAS detail — additional links and download buttons.
 *
 * @package iec
 *
 * @var array $args { fields: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

$additional = $fields['additional_buttons'] ?? array();
$downloads  = $fields['downloads'] ?? array();

if ( empty( $additional ) && empty( $downloads ) ) {
	return;
}
?>
<div class="iec_button_list_warpper buttons-container">

	<?php if ( $additional ) : ?>
		<div class="iec_additional_buttons">

			<?php foreach ( $additional as $button ) : ?>

				<?php
				if ( ! is_array( $button ) ) {
					continue;
				}

				$href   = $button['link'] ?? '';
				$label  = $button['label'] ?? '';
				$target = $button['target'] ?? '_self';

				if ( ! $href || ! $label ) {
					continue;
				}
				?>

				<a href="<?= $href; ?>" class="iec_outline_buttton iec_sign_in_button" target="<?= $target; ?>"<?= '_blank' === $target ? ' rel="noopener noreferrer"' : ''; ?>>
					<?= $label; ?>
				</a>

			<?php endforeach; ?>

		</div>
	<?php endif; ?>

	<?php foreach ( $downloads as $download ) : ?>

		<?php
		if ( ! is_array( $download ) ) {
			continue;
		}

		$file     = $download['download_file'] ?? array();
		$file_id  = 0;
		$file_url = '';

		if ( is_array( $file ) && ! empty( $file['ID'] ) ) {
			$file_id  = (int) $file['ID'];
			$file_url = wp_get_attachment_url( $file_id );

		} elseif ( is_numeric( $file ) ) {
			$file_id  = (int) $file;
			$file_url = wp_get_attachment_url( $file_id );
		}

		$caption     = $download['caption'] ?? '';
		$sub_caption = $download['sub_caption'] ?? '';

		if ( ! $caption && ! $sub_caption && is_array( $file ) ) {
			$caption = $file['title'] ?? $file['filename'] ?? '';
		}

		if ( ! $file_url || ( ! $caption && ! $sub_caption ) ) {
			continue;
		}
		?>

		<a href="<?= $file_url; ?>" download class="download">
			<div class="iec_download_content download__content iec_button iec_blue_gradient">

				<?php if ( $caption ) : ?>
					<span class="download__caption"><?= $caption; ?></span>
				<?php endif; ?>

				<?php if ( $sub_caption ) : ?>
					<span class="download__sub-caption"><?= $sub_caption; ?></span>
				<?php endif; ?>

				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M4 16V17C4 17.7956 4.31607 18.5587 4.87868 19.1213C5.44129 19.6839 6.20435 20 7 20H17C17.7956 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7956 20 17V16M16 12L12 16M12 16L8 12M12 16V4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

			</div>
		</a>

	<?php endforeach; ?>

</div>
