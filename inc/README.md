# Theme `inc/`

PHP bootstrap, helpers, page controllers, and layout markup. New helpers go in the matching domain file, not `helpers/helpers.php`, unless two or more domains share them.

## Layout

```
inc/
  load.php                 Boot order
  setup/                   theme-setup, runtime, enqueue
  helpers/                 Shared + domain helpers
  pages/                   Page controllers (page-*.php)
  api/                     REST / query helpers
  admin/                   Cache tools
  head.php / header.php / footer.php
  iec-mega-menu-*.php      Desktop + mobile menu overrides
```

## Load order (`load.php`)

1. `setup/` — theme-setup, runtime, enqueue
2. `helpers/` — shared helpers, filters, then news / office / product / solution
3. `pages/` — tunisian, starlink, t-solution-product, optiview
4. `api/api.php`
5. `admin/` cache tools

Root `header.php` / `footer.php` load `inc/head`, `inc/header`, and `inc/footer` via `get_template_part()`.

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
