# AGENTS.md

## Project
Sistem Informasi Manajemen RT/RW ("SiRT-RW"): Laravel 13 (^13.17), PHP ^8.3, Pest 5, Laravel Boost, Tailwind v4 + Vite, Blade + vanilla JS, Bootstrap 5.3.2 via CDN. Server-rendered views with client-side page switching.

## Commands
- Setup: `composer setup` (installs deps, copies `.env` if missing, key:generate, migrate --force, npm install --ignore-scripts, npm run build)
- Dev: `composer dev` (runs `php artisan dev`; concurrently PHP + Vite). Fallback: `php artisan serve` + `npm run dev`
- Build: `npm run build` (Vite -> `public/build`)
- Tests: `composer test` (config:clear, `php artisan test`); raw: `vendor/bin/pest`
- Single test: `vendor/bin/pest tests/Feature/ExampleTest.php` or `vendor/bin/pest --filter=testName`
- Format: `vendor/bin/pint --dirty --format agent`

## Verify
- After backend changes: `vendor/bin/pint --dirty --format agent`, then run focused tests (`vendor/bin/pest <file>` or `--filter=<name>`).

## Gotchas
- Baseline failure: `tests/Feature/ExampleTest.php` expects `GET /` to return 200, but `routes/web.php` always redirects (302): authed warga -> `portal.index`, everyone else -> `dashboard`. Pre-existing; do not change the route to make it pass.
- DB/tests: `.env` uses MySQL `127.0.0.1:3306`/`db_rtku_app`. `phpunit.xml` overrides to SQLite in-memory for tests. `tests/Pest.php` has `RefreshDatabase` commented out - feature tests do **not** auto-reset DB; add `uses(RefreshDatabase::class)` where isolation is needed. `ModuleSmokeTest`/`PortalTest` use `uses(RefreshDatabase::class)` + `$this->seed()` + `actingAs(...)`.
- Seeded accounts: `ketua@rtku.id`, `bendahara@rtku.id`, `sekretaris@rtku.id` (pengurus) and `warga@rtku.id` (warga), all password `password`; `UserSeeder`/`WargaUserSeeder` run via `DatabaseSeeder`.
- Auth/roles: `User` has `role` (`warga|pengurus`), helpers `isWarga()`, `isPengurus()`. Middleware `pengurus.only` (`EnsurePengurus`) redirects non-pengurus to `portal.index`; `warga.only` (`EnsureWarga`) redirects non-warga to `dashboard` and forces warga without a linked `warga` record to `portal.lengkapi` (except those routes).

## Architecture
- Single Laravel app. Modules are parallel top-level areas (no nesting): `app/Http/Controllers/{Module}Controller`, `app/Models/{Module}`, `resources/views/{module}`, `public/assets/js/{module}.js`.
- Modules: `warga`, `surat`, `keuangan`, `kategori-keuangan`, `iuran`, `pengumuman`, `pengguna`, plus `Auth`, `Dashboard`, `Portal`. Routes in `routes/web.php`.
- Pengurus area under `auth` + `pengurus.only`: resources for warga/surat/keuangan/kategori-keuangan/iuran/pengumuman/pengguna (+ `warga/export`, `surat/{surat}/status`, `iuran/{warga}/lunas`).
- Warga portal under `auth` + `warga.only` prefix `portal/` (name `portal.*`): index/profil/iuran/surat/pengumuman/agenda; warga without `warga` record must complete via `portal.lengkapi`.
- Validation is inline in controllers via `$request->validate([...])` - no Form Requests.
- User has one `warga` (HasOne); `WargaUserSeeder` links `warga@rtku.id` to `Warga` with NIK `3275012304880001`. Seeders run in `DatabaseSeeder`.

## Frontend
- Layouts: `resources/views/layouts/app.blade.php` (pengurus), `layouts/auth.blade.php`, `layouts/portal.blade.php`. Views load **static** `public/assets/{css,js}` via `asset()`, **not** `@vite`; edit `public/assets/css/style.css` and `public/assets/js/*.js` for actual UI/JS changes.
- `layouts/app.blade.php` sets `window.SIRT.routes` (dashboard/warga/surat/keuangan/pengumuman/pengguna/login/logout) and `window.SIRT.user`; page-specific JS pushed via `@stack('scripts')` (e.g. `dashboard.js`). Helpers `showToast`/`logoutNow` live in `public/assets/js/app.js`.
- Bootstrap 5.3.2 + Icons + Chart.js via CDN; dark mode via `data-bs-theme` + `sirt-theme` localStorage (`theme-init.js`). Sidebar/topbar built by `layout.js` from `body[data-page]`.
- Vite/Tailwind is built (`resources/css/app.css`, `resources/js/app.js` is empty) but not referenced by any Blade view; Tailwind classes generally won't apply unless you wire `@vite` in. Vite ignores `storage/framework/views/**`.

## Conventions
- PHP: curly braces on all control structures; PHP 8 constructor promotion; explicit return types/param types; PHPDoc preferred over inline comments; array shapes in PHPDoc. Use `php artisan make:` with `--no-interaction`.
- Models: prefer `#[Fillable]`/`#[Hidden]` attributes or `$fillable`/`$hidden` as in existing files; casts via `casts()` method. Follow existing controller patterns.

## Agent tooling
- Laravel Boost MCP via `php artisan boost:mcp` (configured in `opencode.json` and `.mcp.json`); prefer Boost tools over manual exploration, use `search-docs` for version-specific questions.
- Skills in `.agents/skills/` and `.claude/skills/`: `laravel-best-practices`, `testing-best-practices`, `tailwindcss-development`, `deploying-to-cloud`, `infer-conventions`. `boost.json` lists agents/skills/mcp.