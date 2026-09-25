<?php
/**
 * Template Name: Tunisian Landing Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	IEC_Tunisian_Landing_Page::for_queried_page()->render();
?>
    <div class="iec-modal-overlay iec-popup " id="iecEnquiryModal">
    <div class="iec-modal-content">
        <button type="button" class="iec-modal-close" id="iecEnquiryModalClose" aria-label="<?php esc_attr_e( 'Close', 'bbtheme' ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <?php
        get_template_part(
            'template-parts/modules/popup',
            array(
                'form_type'          => 'Department-enquiry',
                'success_popup_html' => $success_popup_html,
            )
        );
        ?>
    </div>
</div>
<?php
endwhile;

get_footer();
