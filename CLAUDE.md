# IEC Telecom Theme 2024 — AI Assistant Rules

## Project Overview

WordPress classic theme for iectelecom.com. Depends on ACF Pro and the BlueBeetle Press framework (`get_config()`, enquiry AJAX). Bootstrap grid classes are used in markup. jQuery is WordPress-bundled (do not defer it). Font Awesome / theme icons in markup.

Text domain: `bbtheme`. Use `__()` / `_e()` for translations. Do not use `esc_html()`, `esc_html__()`, or `esc_html_e()` — ACF titles and body copy may contain HTML.

## Tech Stack

- WordPress classic theme (no FSE)
- ACF Pro (page templates + flexible layouts; **no** `acf-json/` in this repo)
- Bootstrap grid class names (`container`, `row`, `col-*`)
- jQuery (WP bundled)
- CSS in `assets/css/base.css`, `assets/css/sections.css`, `assets/css/responsive.css`, `assets/css/tablet.css`, plus `assets/css/pages/{template-slug}.css`
- JS in `assets/js/plugins/` (global) and `assets/js/pages/{template-slug}.js` (per template)
- No build tools, no Sass, no npm for theme code
- Asset loader: `inc/setup/enqueue.php` (`IEC_Asset_Loader`)

## File Structure

```
theme-root/
├── assets/
│   ├── css/
│   │   ├── base.css
│   │   ├── sections.css
│   │   ├── tablet.css
│   │   ├── responsive.css
│   │   ├── header-dropdown.css
│   │   ├── pages/          # one file per template slug
│   │   └── starlink_maritime/
│   ├── js/
│   │   ├── plugins/        # accordion, enquiry, swiper-init, iec-core
│   │   ├── pages/          # matches page template slug
│   │   └── starlink_maritime/
│   ├── fonts/
│   ├── img/
│   └── vendor/
├── inc/
│   ├── load.php
│   ├── enqueue.php
│   ├── helpers.php
│   ├── theme-setup.php
│   ├── api.php
│   ├── header.php / footer.php / head.php
│   └── helpers-*.php / page-*.php
├── template-parts/
│   ├── modules/        # shared modules, receive $args
│   ├── home/ news/ starlink/ voucher/ …
├── page-templates/
├── functions.php
└── style.css
```

## Coding Standards

### PHP
- Tabs for indentation (tab width: 2)
- Spaces inside parentheses: `function_name( $arg1, $arg2 )`
- Space after `!`: `if ( ! $var )`
- Opening brace on same line
- Yoda conditions: `if ( 'value' === $var )`
- Prefer `array()` over `[]` in new PHP
- Prefix new functions with `iec_`
- Guard `ABSPATH` in include files
- Escape output: `esc_attr`, `esc_url`, `wp_kses_post` — never `esc_html`
- ACF images: `iec_resolve_media_to_url()` / `iec_esc_media_url()` then `esc_url`
- BlueBeetle: `get_config()` is polyfilled if the framework is missing; still call it the same way

### CSS
- Theme prefix: `iec_` (existing typos `warpper`, `defualt`, `acordion` are load-bearing — do not rename without a coordinated CSS/JS/PHP pass)
- Bootstrap grid classes are available
- Put page CSS in `assets/css/pages/{slug}.css`, not new stylesheets
- Avoid `!important` unless overriding third-party

### JS
- `jQuery` via `jQuery(function ($) { ... })` or IIFE
- Spaces inside parentheses: `$( '.selector' )`
- Strict equality: `===`
- Semicolons required
- Page JS: `assets/js/pages/{template-slug}.js` — `IEC_Asset_Loader` loads it automatically
- Global behaviour: `assets/js/plugins/`
- No inline `<script>` in templates unless there is no other option

## Page templates

`IEC_Asset_Loader::slug()` maps `page-templates/foo.php` → `foo`. It then loads:

- `assets/css/pages/foo.css` if present
- `assets/js/pages/foo.js` if present

Default pages (no custom template) use slug `default-page` → `assets/css/pages/default-page.css`.

## Modules

Shared UI lives in `template-parts/modules/` and is included with `get_template_part( ..., null, $args )`. Fetch data from `$args` at the top; early-return if required data is missing.

News flexible layouts: `template-parts/news/flexible/{acf_fc_layout}.php` via `iec_news_render_flexible_section()`.
Voucher flexible layouts: `iec_voucher_render_flexible_section()` (tries layout name, then kebab→snake).

## Global config

`get_config( 'field_name' )` (BlueBeetle). Theme polyfill returns the default when the framework is absent.

Enquiry forms: Cloudflare Turnstile. Site/secret key fallbacks in `iec_turnstile_site_key()` / `iec_turnstile_secret_key()` are intentional.

## Never do

- Do not defer `jquery` / `jquery-migrate` (inline and admin scripts depend on it)
- Do not put a cache-clear secret in the theme; define `IEC_CACHE_KEY` in wp-config.php
- Do not add new CSS files outside `assets/css/pages/` or the existing global sheets
- Do not use `get_row_index()` for HTML IDs
- Do not load third-party JS from a CDN without a local `assets/vendor/` copy
- Do not rename `warpper` / `defualt` / `acordion` class names in a partial fix
- Do not rewrite `CLAUDE.md` back to the old BD Theme / `bd_` / `theme.js` / `page_modules` description — that is a different theme
