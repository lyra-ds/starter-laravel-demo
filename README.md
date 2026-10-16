# Lyra DS Laravel demo

This is the **live demo** of [`lyra-ds/starter-laravel`](https://github.com/lyra-ds/starter-laravel),
the minimal Laravel template for [Lyra Design System](https://lyra-ds.dev).
It is not a template itself — it's a running instance derived from the
template, kept in sync to show the components, theming, and auth views in
practice.

To start your own project, use the template instead:

```sh
git clone https://github.com/lyra-ds/starter-laravel.git my-app
```

## Local setup

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run build
php artisan serve
```

Prefer containers? [Laravel Sail](https://laravel.com/docs/sail) ships as a dev dependency:

```sh
vendor/bin/sail up -d
vendor/bin/sail artisan migrate --seed
```

The app listens on `APP_PORT` (defaults to `80`; set it in `.env` if the port is taken).

## Lyra compatibility and migration

The qualified package combination is `lyra-ds/blade` 1.0.0,
`@lyra-ds/alpine` 2.0.0, and `@lyra-ds/styles` 1.2.0. Blade's public
templates/API and Composer requirement remain unchanged. The Lyra Alpine
package still supports Alpine.js `>=3.13 <4`; this is not an Alpine.js major upgrade.

Lyra Alpine 2.0.0 changes the implicit toast defaults: info/success messages
last 8000 ms, while danger/error messages persist. Pointer hover and focus
independently pause the remaining time. An explicit per-toast duration,
including `duration: 0` for persistence, overrides global configuration.
The demo's info toast explicitly uses `duration: 0` and remains persistent;
other demo toasts inherit the defaults.

To restore the previous 4000 ms default for every tone, set the store duration
after `Alpine.plugin(lyra)` and before `Alpine.start()`:

```js
Alpine.store('lyraToasts').duration = 4000;
```

Changed global configuration applies only to newly queued messages; explicit
per-toast durations still take precedence. No application configuration change
is included in this adoption. To roll back, revert the atomic consumer-adoption
commit to restore the previous manifest ranges and lockfile; no data or schema
migration is needed.

## Authentication

Unlike the template, this demo wires up [Laravel Fortify](https://laravel.com/docs/fortify)
for real, with a SQLite database and a public demo account so visitors can
try the login, registration, and two-factor flows:

```sh
php artisan migrate
php artisan db:seed
```

Demo credentials (public — this is a showcase, not a secured environment):

- Email: `demo@lyra-ds.dev`
- Password: `lyra-demo-2026`

## Scripts

| Command                  | What it does                     |
| ------------------------- | --------------------------------- |
| `php artisan serve`      | Start the dev server              |
| `npm run dev`            | Vite dev server (assets)          |
| `npm run build`          | Production asset build            |
| `vendor/bin/pest`        | Run tests                         |
| `vendor/bin/pint`        | Fix code style                    |
| `vendor/bin/pint --test` | Check code style (used in CI)     |

## Deploy

The demo ships as a single Docker image (`Dockerfile`): a Node stage builds
the Vite assets, then a `dunglas/frankenphp:php8.4` stage runs the app on
port 80 with SQLite — no external database service. On boot the container
runs migrations and the idempotent seeder (`DemoSeeder`), then starts
FrankenPHP.

Prove it locally before deploying:

```sh
docker build -t starter-laravel-demo .
docker run --rm -p 8080:80 -e APP_KEY="$(php artisan key:generate --show)" starter-laravel-demo
```

```sh
curl -sf http://localhost:8080/ > /dev/null && echo "home ok"
curl -sf http://localhost:8080/login | grep -q "lyra-btn" && echo "login com markup Lyra"
curl -sf http://localhost:8080/components | grep -q "lyra-" && echo "galeria ok"
```

### Docploy configuration

Create the application pointing at this repository, build by Dockerfile,
with:

- `APP_KEY` generated once and fixed as an environment variable — without
  it, every deploy invalidates existing sessions;
- `APP_URL` set to the real domain;
- `APP_ENV=production` and `APP_DEBUG=false`;
- optionally, a persistent volume at `/app/database` to keep registered
  accounts across deploys (without it, every deploy restarts from the
  seeder — acceptable for a showcase).

### Post-deploy checklist

Once the app is live, walk the full auth flow to confirm the deployed PHP
runtime actually works end to end:

- [ ] Register an account through the form.
- [ ] Enable two-factor authentication.
- [ ] Log out.
- [ ] Log back in, including the 2FA challenge.

See [Authentication](#authentication) above for the public demo credentials
if you'd rather verify with the seeded account instead of a fresh one.

## Links

- [Lyra DS](https://lyra-ds.dev)
- [lyra-ds/starter-laravel](https://github.com/lyra-ds/starter-laravel)

A fuller README, covering what this demo adds on top of the template, lands
in a later task.
