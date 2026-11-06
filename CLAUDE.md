# CLAUDE.md

Guidance for Claude Code when working in this repository.

<!--
  MAINTENANCE NOTES (stripped before this file enters context — free to keep here)

  Behavioral rules — scope discipline, evidence over claims, output style — live in
  ~/.claude/CLAUDE.md plus one model overlay (model/opus5.md | fable5.md | sonnet5.md).
  They are deliberately NOT repeated here. Two copies drift, and when two loaded rules
  contradict each other Claude picks one arbitrarily.

  Verify both loaded: /context → "Memory files". If ~/.claude/CLAUDE.md is missing on this
  machine, drop CLAUDE.core.md in before working.

  Detail that used to live in this file now sits in path-scoped rules that load only when
  Claude opens a matching file:
      .claude/rules/php.md        → **/*.php
      .claude/rules/testing.md    → tests/**
      .claude/rules/frontend.md   → resources/**, webpack.mix.js

  Removed as derivable from the codebase (per /doctor's trim criteria): the composer
  package/version list, the per-module purpose table, and generic Laravel/PHP style rules
  the current models already apply. Removed as irrelevant: the Laravel Cloud deployment note.
-->

---

## Project-specific behavior

The user-scope core rules apply in full. These are the additions for this repo.

**Ask me first:**

- Changing `composer.json` or `package.json` dependencies
- Creating a new top-level directory
- Deleting or disabling an existing test
- Running a migration or any write query against a non-local database
- Toggling a row in the `modules` table (a disabled module silently loads nothing)

**Don't ask, just do:** running tests, reading the DB, `route:list`, `config:show`, rebuilding
assets, creating factories and seeders alongside a new model. These are reversible and follow
from the request.

**Don't write a verification script or a tinker snippet** to prove behavior that a test can
cover. Write the test. Tinker is for inspecting state, not for demonstrating correctness.

**Skills:** domain skills live in `**/skills/**`. Always look for skills that improve assigned tasks.
`.claude/skills/` and `.agents/skills/` are identical Boost-generated copies (`boost:update`); don't edit them.
Activate the relevant one when you start work in that domain, not after you get stuck.

**Don't overexplain:** I don't need to know every unnecessary detail. Don't give explanations of
each step. Be straight and to the point. 

---

## What this is

Laraship — a modular Laravel platform by Corals for marketplaces, e-commerce, directories,
reservations, subscriptions, and classifieds. Modules are pluggable and registered from the
database at runtime.

### Version traps

These differ from what you'd assume for a stock Laravel 13 app (`composer.json` `^13.0`). Check before writing code:

- **Vue 2 + Vuex 3**, not Vue 3. Bootstrap 4 + jQuery 3.
- **Laravel Mix (webpack)**, not Vite. Compiled assets land in `public/assets/`.
- **Pre-Laravel-11 file structure on Laravel 13.** `bootstrap/app.php` is the classic one that
  binds `App\Http\Kernel` / `App\Console\Kernel`; there is no `Application::configure()`
  builder. Middleware in `app/Http/Kernel.php`, exceptions in `app/Exceptions/Handler.php`, schedule and commands in
  `app/Console/Kernel.php`, rate limits in `RouteServiceProvider` or the HTTP kernel. This is
  intentional and supported — don't migrate it unless I ask.
- **PHPUnit**, not Pest. PHP 8.3.

## Template workflow

This project (`laraship-marketplace`) is the master template. New client projects (named `laraship-{name}`) are created by copying this entire project folder, then customizing modules/themes/features for that client. `resources/themes/marketplace-master` is the canonical theme reference (see `resources/themes/CLAUDE.md`).

Consequences for a Claude session working here:
- Changes made here do **not** automatically propagate to any already-copied client project — a fix or improvement made here (including to `CLAUDE.md` files) must be ported by hand to client projects that should also get it.
- Conversely, don't pull a specific client's customizations back into this template unless they're genuinely reusable across future clients — this template should stay generic, not mirror one client's changes.
- If asked to bootstrap a brand-new client project, the correct action is copying this entire project folder — not just `resources/themes/marketplace-master` — since the template covers modules, config, and everything else outside theming too.

### Bootstrapping `laraship-{name}`

1. Copy the project folder, **excluding** `.git`, `.env`, `auth.json`, `graphify-out/`,
   `.phpunit.cache/`, `.phpunit.result.cache` and `storage/logs/*` (local state or secrets,
   not template). Keep `vendor/` — it holds `vendor/corals/*`.
2. `git init` a fresh repository for the client; never reuse the template's history.
3. `cp .env.example .env`, then `php artisan key:generate` and set `APP_NAME`, `APP_URL` and
   `DB_DATABASE=laraship_{name}` (plus the DB user/password).
4. `cp auth.json.example auth.json`. Fill in credentials only once the project has its Laraship
   license; until then install modules from Settings → Modules.
5. Create the empty `laraship_{name}` database and run `php artisan corals:install`.
6. Run `php artisan boost:update` to regenerate `AGENTS.md`, the Boost block below and the
   skills copies, and rebuild `graphify-out/` with `/graphify` if you use it.

Tests run against `laraship_{name}` too (see Commands), so run them after `corals:install`.

---

## Commands

```bash
npm run watch                 # dev build, watching
npm run production            # production build

php artisan test --compact                                  # all
php artisan test --compact tests/Feature/ExampleTest.php     # one file
php artisan test --compact --filter=testName                 # by name

php artisan corals:install                              # interactive install wizard
php artisan make:module {ModuleName} {MainModel} [--modal]   # copies vendor/corals/foo/src to Corals/modules/{Name}; run from repo root
php artisan corals:modules                              # module manager (recovery mode, minimal boot)
```

Tests run against the **database configured in `.env`** (`DB_DATABASE`), not SQLite in memory:
`phpunit.xml` doesn't override it, and the app needs its seeded modules/settings. Feature tests
isolate with `DatabaseTransactions` (rollback per test), so never use `RefreshDatabase`/
`DatabaseMigrations` here — they would wipe that database. A failing test may be leftover state
rather than your change.

---

## Architecture

### Two-tier modules

**Core** (`Corals/core/`) always loads via `CoralServiceProvider` → `FoundationServiceProvider`:
Foundation, User, Settings, Theme, Activity, Media, Menu, Utility.

**Dynamic** modules are registered at runtime by `Corals\Modules\ModulesServiceProvider`
(`Corals/modules/ModulesServiceProvider.php`), which reads the `modules` table where `enabled=1`
and registers each row's `provider`. A disabled module contributes nothing — no routes, no
migrations, no views. If something "doesn't exist," check that table before concluding the code
is missing.

Dynamic modules live in two places:

- **`vendor/corals/*`** — the installed modules (marketplace, subscriptions, cms, payment-*,
  utility-*, …). Source is under `src/` (`src/Models`, `src/Http/Controllers`, `src/routes`,
  `src/database`, `src/Providers`, …) with `module.json` at the package root. Each has its
  own `composer.json`; the proprietary ones (Marketplace, Subscriptions, …) are wired into the
  root `composer.json` `autoload.psr-4` and tracked in git (`!/vendor/corals` in `.gitignore`).
  Some have their own `CLAUDE.md` — read it before editing that package.
- **`Corals/modules/{Name}/`** — where `make:module` scaffolds *new* project-specific modules
  (flat layout: `routes/`, `Models/`, `Http/Controllers/`, `module.json`, …).

Proprietary modules (Marketplace, E-commerce, Subscriptions, Reservations) need a Laraship
license to download from private repos. `auth.json` does not carry those credentials until the
project goes to final hosting, so don't run `composer update` on them.
`auth.json` is git-ignored; copy `auth.json.example` and fill in your own credentials.

Modules can be installed/enabled by hand from the dashboard at Settings → Modules (or
`php artisan corals:modules`); install Subscriptions before Marketplace.

### Base classes to extend

| For | Extend |
|---|---|
| Admin controllers | `Corals\Foundation\Http\Controllers\BaseController` |
| API endpoints | `APIBaseController` / `APIPublicController` |
| List views (Yajra) | `Corals\Foundation\DataTables\BaseDataTable` |
| Model policies | `Corals\Foundation\Policies\BasePolicy` |
| API transformers | `Corals\Foundation\View\Transformers\Transformer` (League Fractal) |

### Hook system

WordPress-style actions and filters, used heavily. Extend module behavior through these rather
than editing core:

```php
Actions::add_action('hook_name', [$this, 'method'], $priority);
Actions::do_action('hook_name', $arg1, $arg2);   // canonical; wraps dispatch($hook, [$args])

Filters::add_filter('hook_name', [$this, 'method'], $priority);
$value = Filters::do_filter('hook_name', $value, ...$extraArgs);
```

### Themes

`resources/themes/{theme-name}/`, each with a `theme.json`. The `Theme` facade resolves view
paths, so any theme can override any view. Admin themes are DB-configurable per user session.

### URL IDs

Public URLs use Hashids. Use `hashids()->encode($id)` / `hashids()->decode($hash)` — never expose
raw integer IDs in a public route.

---

## Boost tools

- `database-schema` — inspect table structure before writing a migration or model.
- `database-query` — read-only queries, instead of raw SQL in tinker.
- `get-absolute-url` — resolve scheme/domain/port. Use it before giving me any URL.
- `browser-logs` — recent browser errors only; ignore stale entries.
- `search-docs` — version-specific docs for the installed packages. Use it before calling a
  package API you haven't verified in this session, and whenever behavior looks version-dependent.
  Scope with a `packages` array. Query with broad topics, several at once:
  `['rate limiting', 'routing rate limiting', 'routing']`. Don't put package names in the query
  string — that's what `packages` is for. Words auto-stem and AND together; `"quoted phrases"`
  match adjacent words in order.

**Tinker:** always single-quote to prevent shell expansion, double quotes for PHP strings inside:
`php artisan tinker --execute 'User::where("active", true)->count();'`

**Boost block below** (from `<laravel-boost-guidelines>` to the end) and `AGENTS.md` are generated
by `php artisan boost:update`; don't hand-edit them. Where they conflict with the sections above,
the sections above win — notably the Boost "Frontend Bundling" advice about Vite/`npm run build`
doesn't apply (this project uses Mix: `npm run watch` / `npm run production`).

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.3. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== phpunit/core rules ===

# PHPUnit

- This project uses PHPUnit. Create tests with `php artisan make:test --phpunit {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/phpunit` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

=== spatie/laravel-medialibrary/core rules ===

## Media Library

- `spatie/laravel-medialibrary` associates files with Eloquent models, with support for collections, conversions, and responsive images.
- Always activate the `medialibrary-development` skill when working with media uploads, conversions, collections, responsive images, or any code that uses the `HasMedia` interface or `InteractsWithMedia` trait.

</laravel-boost-guidelines>
