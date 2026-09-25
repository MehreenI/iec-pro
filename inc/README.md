# Theme `inc/`

PHP bootstrap, helpers, page controllers, and layout partials. Markup lives in `layout/`, `mega-menu/`, or `template-parts/`. New helpers go in the matching domain file, not `helpers/helpers.php`, unless two or more domains share them.

## Layout

```
inc/
  load.php                 Boot order
  setup/                   Theme supports, nav, ACF admin
  helpers/                 Shared + domain helpers
  pages/                   Page controllers / queries
  layout/                  head, header, footer markup
  mega-menu/               Desktop + mobile menu overrides
  enqueue.php
  api.php
  filters.php
  cache-tools.php
  cache-tools-admin.php
```

## Load order (`load.php`)

1. `setup/` — theme-setup, nav-menu, admin-acf
2. `helpers/helpers.php` + `filters.php`
3. `pages/` — vertical-market, tunisian-landing, starlink, sp-landing
4. `enqueue.php` + `api.php`
5. Domain helpers (news, voucher, office, product, solution)
6. Cache tools

Root `header.php` / `footer.php` load `inc/layout/*` via `get_template_part()`.

## Naming

Theme functions use the `iec_` prefix. Framework polyfills (`get_config`, `get_ajax_url`) stay unprefixed.

## Turnstile (WPML)

`iec_turnstile_site_key()` / `iec_turnstile_secret_key()` read BlueBeetle config first. If WPML leaves those empty, they use constants from `wp-config.php`:

```php
define( 'IEC_TURNSTILE_SITE_KEY', 'your-site-key' );
define( 'IEC_TURNSTILE_SECRET_KEY', 'your-secret-key' );
```

Do not put secrets in the theme.

## Cache

Logged-in admins (`manage_options`) see a FAB on the front end. It POSTs to `iec_clear_all_cache` with a nonce. There is no `?clear_cache=` URL. Transient wipe is limited to `iec_*` keys.
