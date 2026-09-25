<?php
/**
 * Search results template.
 *
 * @package iec
 */

get_header();

/**
 * @param string $post_type
 */
function iec_search_result_type_label( string $post_type ): string {
	$labels = array(
		'page'          => __( 'Page', 'bbtheme' ),
		'news'          => __( 'News', 'bbtheme' ),
		'press-release' => __( 'Press Release', 'bbtheme' ),
		'office'        => __( 'Office', 'bbtheme' ),
		'product'       => __( 'Product', 'bbtheme' ),
		'solution'      => __( 'Solution', 'bbtheme' ),
		'job'           => __( 'Job', 'bbtheme' ),
	);

	return $labels[ $post_type ] ?? '';
}

/**
 * @param int $post_id
 */
function iec_search_result_image_url( int $post_id ): string {
	$meta = get_fields( $post_id );
	if ( ! empty( $meta['landing_image']['url'] ) ) {
		return (string) $meta['landing_image']['url'];
	}
	return '';
}

/**
 * @param int $post_id
 */
function iec_search_result_title( int $post_id ): string {
	$meta = get_fields( $post_id );
	if ( ! empty( $meta['caption'] ) ) {
		return (string) $meta['caption'];
	}
	return get_the_title( $post_id );
}

$current = max( 1, (int) get_query_var( 'paged' ) );
$total   = isset( $GLOBALS['wp_query']->max_num_pages ) ? (int) $GLOBALS['wp_query']->max_num_pages : 1;
?>

<div id="main" class="minimum-height">
	<div class="iec_search_result_widget">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1><?php _e( 'Search results', 'bbtheme' ); ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="iec_search_form_warpper">
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
							<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search', 'bbtheme' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
							<input type="submit" value="<?php esc_attr_e( 'Search', 'bbtheme' ); ?>">
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if ( have_posts() ) : ?>
						<div class="items">
							<?php
							while ( have_posts() ) :
								the_post();
								$post_id   = get_the_ID();
								$post_type = get_post_type( $post_id );
								$cat       = iec_search_result_type_label( $post_type );
								$image     = iec_search_result_image_url( $post_id );
								$title     = iec_search_result_title( $post_id );
								$link      = get_permalink( $post_id );
								?>
								<a href="<?php echo esc_url( $link ); ?>" class="item">
									<div class="cf">
										<?php if ( $image ) : ?>
											<div class="img" style="background-image: url('<?php echo esc_url( $image ); ?>')"></div>
										<?php endif; ?>
										<?php if ( $cat ) : ?>
											<div class="other"><?php echo $cat; ?></div>
										<?php endif; ?>
										<div class="title"><?php echo $title; ?></div>
									</div>
								</a>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<div class="no-result"><?php _e( 'Sorry, no results were found for this query.', 'bbtheme' ); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $total > 1 ) : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="pagination">
							<ul>
								<?php if ( $current > 1 ) : ?>
									<li><a href="<?php echo esc_url( get_pagenum_link( $current - 1 ) ); ?>" class="prev" aria-label="<?php esc_attr_e( 'Previous page', 'bbtheme' ); ?>"></a></li>
								<?php endif; ?>
								<?php for ( $page_no = 1; $page_no <= $total; $page_no++ ) : ?>
									<li>
										<a href="<?php echo esc_url( get_pagenum_link( $page_no ) ); ?>"<?php echo $page_no === $current ? ' class="active"' : ''; ?>><?php echo (int) $page_no; ?></a>
									</li>
								<?php endfor; ?>
								<?php if ( $current < $total ) : ?>
									<li><a href="<?php echo esc_url( get_pagenum_link( $current + 1 ) ); ?>" class="next" aria-label="<?php esc_attr_e( 'Next page', 'bbtheme' ); ?>"></a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
