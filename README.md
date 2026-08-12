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

## Links

- [Lyra DS](https://lyra-ds.dev)
- [lyra-ds/starter-laravel](https://github.com/lyra-ds/starter-laravel)

A fuller README, covering what this demo adds on top of the template, lands
in a later task.
