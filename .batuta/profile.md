# Batuta profile — lyra-ds/starter-laravel-demo

Stack: Laravel 13 / PHP >=8.3; Blade + Lyra Alpine/CSS peers; Vite asset build; Composer and npm
Methodology: tests-after; Conventional Commits; feature branches and PRs to main
Test: vendor/bin/pest
Build: npm run build
Install: composer install --no-interaction && npm ci
Lint: vendor/bin/pint --test
Execution: sequential
Worktree: medium+
Worktree-home: cache
Template: templates/laravel.md

## Conventions

- Follow the repository AGENTS.md and the published Lyra contracts; never invent component APIs.
- Preserve the existing white-label brand tokens, local fonts and framework conventions.
- Treat Lyra as the owner of component appearance and behavior; do not add local substitutes.
- Keep changes scoped and verify the repository CI commands before integration.

## Project map

Refreshed from local source on 2026-10-14.

`composer.json` and composer.lock define the framework and package dependencies.
`package.json` and package-lock.json define the Vite build and npm peers.
`app/` contains framework controllers, models and providers.
`routes/web.php` owns the public web routes.
`routes/console.php` owns console integration.
`resources/views/` contains Blade pages and reusable layouts.
`resources/views/layouts/` owns the application shell composition.
`resources/css/app.css` imports Lyra CSS and owns local page layout.
`resources/js/app.js` boots Alpine and the Lyra plugin.
Public component templates come from the external lyra-ds/blade package.
Brand variables remain in the existing application CSS.
Local font packages are served through the asset build.
`tests/Feature/` exercises the rendered application routes.
`tests/Unit/` contains pure unit checks.
`tests/Pest.php` and tests/TestCase.php configure Pest.
`phpunit.xml` pins testing to in-memory SQLite and array-backed services.
`bootstrap/` owns framework bootstrap and generated cache.
`config/` owns environment-backed framework configuration.
`database/` owns the application migrations and seeders.
`public/` serves static files and the generated asset manifest.
`storage/` holds generated framework logs and caches.
`.github/workflows/ci.yml` defines PHP8.3/8.4 gates and asset builds.
`vite.config.js` owns frontend build integration.
`AGENTS.md` carries public API and brand rules.
Do not hand-edit vendor/, node_modules/ or public/build/.
