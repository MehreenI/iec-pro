# Template classes

Classes used in checked page templates, section by section. Includes shared modules those templates load.

Checked: **Optiview**, **VAS Detail**, **IoT**.

---

## Optiview

`page-templates/optiview-page.php`

### Banner

`template-parts/optiview/banner.php` + `logo.php` (inline SVG, no class)

- `banner`
- `iec_optiview_bannaer`
- `banner__bg`
- `container`
- `row`
- `col-md-12`
- `banner__wrapper`
- `banner__wrapper__info`
- `banner__wrapper__info__top`
- `sr-only` (H1 when subtitle exists)
- `iec_optiview_banner_subtitle`
- `banner__wrapper__info__links`
- `bd_optiview_slide_buttons`
- `banner__wrapper__info__download`
- `banner-progress`
- `banner-progress__item`
- `banner__main`

**JS adds** (`js/pages/optiview-page.js`)

- `banner__active`
- `progress-active`

### Solutions

`template-parts/optiview/solutions.php`

- `iec_optiview_solutions`
- `container`
- `sr-only`
- `row`
- `col-md-4`
- `iec_optiview_solution_box_warpper`
- `iec_optiview_solution_box`
- `iec_optiview_solution_box_image_warpper`
- `iec_img_style`
- `iec_optiview_solution_box_content`
- `iec_optiview_solution_title`
- `iec_optiview_solution_desc`
- `more`

### Video

`template-parts/optiview/video.php`

- `iec_optiview_video_section`
- `container`
- `row`
- `col-md-12`
- `sr-only`
- `iec_optiview_video_box`

### Accordion

`template-parts/optiview/accordion.php`

- `iec_optiview_acordion`
- `container`
- `row`
- `col-md-12`
- `sr-only`
- `iec_optiview_acordion_warpper`
- `acordion__item`
- `acordion__item__heading`
- `acordion__item__trigger`
- `acordion__item__trigger__info`
- `iec_accorediabn_header_image_wrapper`
- `iec_img_style`
- `acordion__item__trigger__label`
- `acordion__item__info`
- `acordion__item__info__value`

**JS adds**

- `active` (on `.acordion__item`)
- `rotate` (on trigger SVG)

### Benefits

`template-parts/optiview/benefits.php`

- `iec_optiview_benefits`
- `iec_defualt_position`
- `container`
- `sr-only`
- `row`
- `col-md-4`
- `iec_optiview_benefits_box_warpper`
- `iec_optiview_benefits_box`
- `iec_optiview_benefits_box_img_wrapper`

### Use cases

`template-parts/optiview/use-cases.php` → `template-parts/modules/use-case-slider.php`

- `directions`
- `iec_optiview_directions`
- `directions__bg`
- `active-bg` (first background image)
- `container`
- `directions__wrapper`
- `directions__container`
- `directions__main`
- `swiper`
- `swiper__directions-left`
- `vms__directions-left`
- `swiper-wrapper`
- `swiper-slide`
- `directions__title`
- `directions__desc`
- `swiper__directions-right`
- `vms__directions-right`
- `swiper-button-next`
- `vms-swiper-button-next`
- `swiper-button-prev`
- `vms-swiper-button-prev`
- `swiper-pagination`
- `vms-swiper-pagination`

### Coming soon modal

`template-parts/optiview/coming-soon-modal.php` (outside `<main>`)

- `iec_optiview_modal_overlay`
- `iec_optiview_modal`
- `sr-only`
- `product-screens`
- `screen`
- `screen--top`
- `screen--middle`
- `screen--bottom`
- `modal-header`
- `iec-logo`
- `close-button`
- `modal-content`
- `intro-block`
- `intro-copy`
- `coming-soon`
- `brand-lockup`
- `optiview-logo`
- `tagline`
- `feature-section`
- `feature-intro`
- `features-grid`
- `feature-card`
- `feature-icon`
- `feature-divider`
- `notify-section`
- `notify-row`
- `notify-copy`
- `notify-form`
- `notify-form-fields`
- `sr-only`
- `notify-button`
- `notify-consent`
- `notify-status`
- `footer-message`
- `footer-line`

**JS adds**

- `iec_optiview_modal_open` (on `body`)
- `is-closing` (overlay)
- `is-invalid`
- `is-loading`
- `is-success`
- `is-consent-invalid`

---

## VAS Detail

`page-templates/vas-detail-page.php`

### Hero

`template-parts/vas/detail-hero.php` → `template-parts/modules/hero-banner.php`

- `iec_hero_banner`
- `iec_hero_content_banner`
- `iec_optisim_hero_banner`
- `iec_defualt_position`
- `iec_bg_repeat`
- `iec_bg_cover`
- `iec_bg_position_center`
- `iec_hero_banner__media`
- `iec_hero_banner__image`
- `container`
- `row`
- `col-md-12`
- `iec_return_link`

Module can also output `iec_hero_content_box`, `iec_main_heading`, `iec_tect_decoration_none` when a title is passed. VAS Detail does not pass a title.

### Content

`template-parts/vas/detail-content.php`

- `iec_background_image_section`
- `iec_defualt_position`
- `iec_bg_repeat`
- `iec_bg_cover`
- `iec_bg_position_left`
- `iec_main_contact_section`
- `iec_optisim_content`
- `container`
- `row`
- `col-md-12`
- `iec_primary_heading`
- `col-md-6`
- `wysiwyg-content`
- `iec_key_points`
- `iec_key_point_box`

### Actions

`template-parts/vas/detail-actions.php`

- `iec_button_list_warpper`
- `buttons-container`
- `iec_additional_buttons`
- `iec_outline_buttton`
- `iec_sign_in_button`
- `download`
- `iec_download_content`
- `download__content`
- `iec_button`
- `iec_blue_gradient`
- `download__caption`
- `download__sub-caption`

---

## IoT

`page-templates/iot-page.php`

### Hero

`template-parts/iot/hero-slider.php`

- `iec_iot_slider_section`
- `swiper`
- `iec-iot-hero-swiper`
- `swiper-wrapper`
- `swiper-slide`
- `iec_bg_repeat`
- `iec_bg_cover`
- `iec_iot_slide_bg`
- `iec_iot_slide`
- `container`
- `row`
- `col-md-12`
- `iec_iot_slide_title`
- `iec_primary_heading`
- `iec_iot_slide_content`
- `wysiwyg-content`
- `iec_iot_slide_arrow_warpper`
- `slider-button-prev`
- `slider-button-next`

### Enquiry

`template-parts/iot/enquiry-section.php` + `template-parts/modules/sidebar-enquiry-form.php`

- `iec_iot_enquriy_section`
- `iec_defualt_position`
- `container`
- `row`
- `col-lg-8`
- `iec_iot_enquriy_content_warpper`
- `iec_section_heading`
- `wysiwyg-content`
- `iec_iot_enquriy_arrow_link`
- `col-lg-4`
- `iec_form_warpper`
- `iec_iot_form_warpper`
- `iec-enquiry-root`

### Services

`template-parts/iot/services.php`

- `iec_iot_our_services`
- `iec_defualt_position`
- `container`
- `row`
- `col-md-12`
- `iec_section_heading`
- `iec_iot_our_service_sec_warpper`
- `col-md-6`
- `iec_iot_service_box_warpper`
- `iec_iot_service_box`
- `iec_bg_repeat`
- `iec_iot_service_box_image`

### Areas

`template-parts/iot/areas.php`

- `iec_iot_area_expert`
- `iec_defualt_position`
- `container`
- `row`
- `col-md-12`
- `iec_section_heading`
- `col-md-6`
- `iec_iot_area_expert_box_warpper`
- `iec_iot_area_expert_box`
- `iec_bg_repeat`
- `iec_bg_cover`
- `iec_w_100`
- `iec_h_100`
- `iec_iot_area_expert_box_image`
- `iec_iot_area_expert_content`
- `iec_iot_area_expert_link`

### Push to talk

`template-parts/iot/push-to-talk.php`

- `iec_iot_talk_solution_section`
- `iec_defualt_position`
- `container`
- `row`
- `align-items-center`
- `col-md-7`
- `col-lg-8`
- `iec_iot_talk_solution_content`
- `iec_section_heading`
- `wysiwyg-content`
- `col-md-5`
- `col-lg-4`
- `iec_iot_talk_solution_content_video`

### Accordion

`template-parts/iot/accordion.php`

- `iec_iot_accordian_section`
- `iec_defualt_position`
- `iec_iot_accordian_maritime`
- `iec_iot_accordian_in_land`
- `pt-0`
- `container`
- `row`
- `col-md-12`
- `iec_section_heading`
- `iec_iot_main_accordian_warpper`
- `need-accordions-widget`
- `maritime`
- `in_land`
- `item`
- `expand`
- `iec_iot_accordian_warpper`
- `iec_iot_accordian_header`
- `title`
- `iec_iot_accordian_body`
- `content`

### Footer spacer

- `background-bottom-block`
