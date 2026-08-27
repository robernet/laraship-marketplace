# CLAUDE.md — Marketplace Theme Creation

Scope: creating a new Marketplace frontend theme by adapting a design provided as HTML, React, Next.js, Angular, or Vue source into this repo's Blade-based theme system. Reference implementation: `marketplace-master`.

## Two folders, always kept in sync, both required

- `resources/themes/{theme}/` — Blade views: layouts, page templates, partials, components, auth pages, emails, lang files, `theme.json`, `demo_data.php`, `update-batches/`.
- `public/assets/themes/{theme}/` — compiled static assets (css, js, img, fonts, plugins) that the Blade views reference.

A theme is broken if either folder is missing files the other side expects.

## Naming convention

- Folder name, **identical in both locations**: `marketplace-{name}` (e.g. `marketplace-modern`).
- `theme.json`'s `"name"` field — **this, not the folder name, is the theme's actual runtime identity**: `Theme::set()`, `Theme::find()`, and the `active_frontend_theme` setting all key off this string. Follow `marketplace-master`'s pattern → `corals-marketplace-{name}`.
- `theme.json`'s `"assetPath"` must equal `assets/themes/marketplace-{name}` — this is the literal path `Theme::url()`/`Theme::css()`/`Theme::js()`/`Theme::img()` resolve against under `public/`. Get this wrong and every asset call silently fails.
- `"platform": "Marketplace"` and `"type": "frontend"` — keep both, unchanged, matching `marketplace-master`.

## `theme.json` reference (from `marketplace-master`)

```json
{
  "type": "frontend",
  "name": "corals-marketplace-master",
  "caption": "Corals Marketplace Master",
  "extends": null,
  "assetPath": "assets/themes/marketplace-master",
  "version": "3.7.6",
  "css": ["font-awesome-4.7.0/css/font-awesome.min.css", "css/vendor.min.css", "css/styles.css", "..."],
  "js": ["js/modernizr.min.js", "js/vendor.min.js", "js/scripts.min.js", "..."],
  "platform": "Marketplace"
}
```

`css`/`js` here are an inventory of the theme's asset files, relative to `assetPath` — they are **not** auto-injected into pages. The actual `<link>`/`<script>` tags come from explicit `Theme::css('css/styles.css')` / `Theme::js('js/main.js')` calls inside `layouts/*.blade.php`. When you add or rename an asset file, update **both** the `theme.json` array and the corresponding `Theme::css()`/`Theme::js()` call — one without the other is a broken theme.

## Directory structure to replicate exactly (mirror `marketplace-master`)

- `layouts/` — `master.blade.php`, `public.blade.php`, `auth.blade.php`, `blank.blade.php`, `crud/` (`index`, `grid`, `show`, `create_edit`).
- `templates/` — one file per page type: `home`, `shop`, `store`, `product_single`, `cart`, `checkout`, `checkout_success`, `checkout_failed`, `contact`, `left`, `right`, `full`, `default`, `stores`, plus `templates/partials/` (SKU selectors, offers list, etc.).
- `partials/` — shared chrome and content blocks: `header`, `footer`, `sidebar`, `page_header`, `paginator`, `notifications`, `cart_summary`, product/store/category grid & list items, featured-* sections, plus `partials/menu/`, `partials/tabs/`, `partials/components/`.
- `components/` — small reusable Blade components (`box`, `modal`, `rating`, `address`, `button_group`, etc.).
- `auth/` — `login`, `register`, `profile`, `passwords/`.
- `emails/` — transactional email blades (`contact.blade.php`, etc.).
- `lang/{en,ar,pt-br}/` — theme-scoped translations, loaded via `app('translator')->addNamespace($theme->name, $path)`.
- `views/redirect_page.blade.php`.
- Top-level content pages: `blog.blade.php`, `post.blade.php`, `faqs.blade.php`, `pricing.blade.php`, `pricing_public.blade.php`, `tt_show.blade.php`, `tt_create.blade.php`.
- `update-batches/release-notes.txt` and `demo_data.php` — carry these over even if empty; other tooling (`Theme::importDemo()`) expects them to exist.

Do not invent new file/folder names for equivalent pages — map the provided design's pages onto these exact existing files so the rest of the app (controllers picking templates by these names) keeps working.

## Asset resolution rules (why "not broken when installed" depends on these)

- Never hardcode `/assets/themes/marketplace-master/...` paths in a new theme's blades — always go through `Theme::css()`, `Theme::js()`, `Theme::img()`, or the `theme_url()` helper, using a path **relative to the theme's own `assetPath`**.
- Resolution order (`Theme::url()` in `Corals/core/Theme/Theme.php`): current theme's `assetPath` → parent theme's `assetPath` (only if `extends` is set) → public root. A miss doesn't throw by default (`themes.asset_not_found` config = `LOG_ERROR`) — it logs a warning and the browser gets a 404. This means a missing asset won't crash the page, but it will silently look broken; always verify referenced files physically exist after porting a design.

## Workflow: turning a provided HTML/React/Next.js/Angular/Vue design into a new theme

This stack has no client-side component framework runtime wired into the theme system — pages are server-rendered Blade. Adapting a design is a one-way port of markup, styles, and behavior into Blade, not a framework integration.

1. **Scaffold**: copy both folders as the starting point —
   `resources/themes/marketplace-master` → `resources/themes/marketplace-{name}`
   `public/assets/themes/marketplace-master` → `public/assets/themes/marketplace-{name}`
2. **Update `theme.json`**: `name` → `corals-marketplace-{name}`, `caption`, `version`, `assetPath` → `assets/themes/marketplace-{name}`. Leave `type`/`platform` as-is. If the theme should visually extend another instead of being fully standalone, set `extends` to that theme's `name`.
3. **Map each provided page/component to its Blade equivalent** (don't create parallel files): a design's Home page → `templates/home.blade.php` (+ the partials it `@include`s); Product detail → `templates/product_single.blade.php`; a shared nav → `partials/header.blade.php`; footer → `partials/footer.blade.php`; a React/Vue "Header" component → the same `partials/header.blade.php`, etc.
4. **Port markup, preserve app wiring**: keep every existing Blade directive that binds real data — `@foreach($products as $product)`, `{{ $product->name }}`, `route()`/`hashids()`-based links, `@include`/`@component` calls into other theme partials, and any `Actions::do_action()` / `Filters::do_filter()` hook points. Only replace the static/placeholder parts of the source design. Deleting or bypassing these breaks the page's actual functionality even if it looks right.
5. **React/Vue/Angular/Next-specific components have no runtime home here**: convert their JSX/template markup + scoped styles into plain Blade + CSS. Any interactive behavior they had becomes vanilla JS (or jQuery, matching the existing stack — Bootstrap 4 + jQuery 3 + laravel-echo) appended into the new theme's own JS bundle — don't introduce a second framework's runtime/build step.
6. **Move assets**: CSS into `public/assets/themes/marketplace-{name}/css/` (split vendor vs custom the way `marketplace-master` does), JS into `.../js/`, images/fonts/plugins into the matching subfolders. Update `theme.json`'s `css`/`js` arrays **and** the `Theme::css()`/`Theme::js()` calls in `layouts/master.blade.php` (and `layouts/public.blade.php` / `auth.blade.php` as needed) together.
7. **Branding assets**: logo, favicon, `thumb.png`, hero/slider images — every `Theme::img('img/...')` call in a template needs a real file at that path under the new theme's `img/` tree.
8. **Out of scope for a theme change**: never touch `vendor/corals/marketplace` or `vendor/corals/subscriptions` (controllers, routes, models, business logic). Themes are presentation-only; see their own `CLAUDE.md` files for that layer.
9. **Register & activate**: the default `config('themes.cache')` is `false`, so a new folder under `resources/themes/` is picked up automatically on the next request (`Themes::scanJsonFiles()` globs the directory live). If theme caching has been turned on, run `php artisan theme:refresh-cache` first. Then activate it via Settings → Themes (sets the `active_frontend_theme` setting to the new `theme.json` `"name"` value) — don't leave it unverified as a config-only addition.
10. **Verify before calling it done**: with the new theme active, load every top-level route it covers — home, shop, product page, store page, cart, checkout (+ success/failed), blog, auth pages — and check the browser console/network tab for 404s on theme assets. That's the concrete definition of "not broken when installed."
