<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tabs            = iec_home_insights_tabs();
$active_category = 'insights';
$panels          = array();

foreach ( $tabs as $tab ) {
    $slug      = (string) ( $tab['slug'] ?? '' );
    $panel_key = '' !== $slug ? $slug : 'all';
    $query     = iec_home_insights_query( $slug );
    $posts     = array();
	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();
			$posts[] = iec_home_insights_post_data( get_the_ID() );
		}

		wp_reset_postdata();
	}
    $panels[] = array(
        'key'   => $panel_key,
        'slug'  => $slug,
        'label' => $tab['label'] ?? '',
        'posts' => $posts,
    );
}

$archive_url = function_exists( 'iec_news_archive_url' ) ? iec_news_archive_url() : home_url( '/' );
?>

<section class="iec_defualt_position iec_section_home_news_posts" data-iec-home-insights aria-labelledby="iec-home-insights-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="iec_section_heading" id="iec-home-insights-heading" data-aos="fade-up"><?= __( 'Insights & resources', 'bbtheme' ); ?></h2>
            </div>
            <div class="col-md-4">
                <a href="<?= esc_url( $archive_url ); ?>" class="iec_button iec_blue_gradient" data-aos="fade-up" data-aos-delay="100"><?= __( 'Explore all resources', 'bbtheme' ); ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="iec_home_news_post_category_list" role="tablist" aria-label="<?= esc_attr__( 'Resource categories', 'bbtheme' ); ?>" data-aos="fade-up" data-aos-delay="80">
                    <?php foreach ( $panels as $panel ) : ?>
                        <?php
                        $is_active = ( $panel['slug'] === $active_category );
                        $panel_id  = 'iec-home-insights-panel-' . sanitize_title( $panel['key'] );
                        ?>
                        <li class="<?= $is_active ? 'is-active' : ''; ?>" role="presentation">
                            <button
                                    type="button"
                                    class="iec_post_category_btn<?= $is_active ? ' active' : ''; ?>"
                                    role="tab"
                                    id="<?= esc_attr( $panel_id . '-tab' ); ?>"
                                    aria-controls="<?= esc_attr( $panel_id ); ?>"
                                    aria-selected="<?= $is_active ? 'true' : 'false'; ?>"
                                    data-category="<?= esc_attr( $panel['key'] ); ?>"
                                <?= $is_active ? '' : 'tabindex="-1"'; ?>
                            ><?= $panel['label']; ?></button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="iec_home_news_post_panels" data-iec-insights-panels>
                    <?php foreach ( $panels as $panel ) : ?>
                        <?php
                        $is_active = ( $panel['slug'] === $active_category );
                        $panel_id  = 'iec-home-insights-panel-' . sanitize_title( $panel['key'] );
                        ?>
                        <div
                                class="iec_home_news_post_grid"
                                id="<?= esc_attr( $panel_id ); ?>"
                                data-iec-insights-panel="<?= esc_attr( $panel['key'] ); ?>"
                                role="tabpanel"
                                aria-labelledby="<?= esc_attr( $panel_id . '-tab' ); ?>"
                            <?= $is_active ? '' : ' hidden'; ?>
                        >
                            <?php
                            get_template_part(
                                'template-parts/home/insights',
                                'grid',
                                array( 'posts' => $panel['posts'] )
                            );
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
