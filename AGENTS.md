# AGENTS.md

Guidance for AI agents (and humans) working in this repository — a minimal
Laravel template for [Lyra Design System](https://lyra-ds.dev).

## Lyra DS documentation

- Docs: https://lyra-ds.dev
- Machine-readable component contracts: https://lyra-ds.dev/llms.txt
- Packages: [`lyra-ds/blade`](https://packagist.org/packages/lyra-ds/blade)
  (`<lyra:*>` Blade components, on Packagist) and
  [`@lyra-ds/styles`](https://www.npmjs.com/package/@lyra-ds/styles) +
  [`@lyra-ds/alpine`](https://www.npmjs.com/package/@lyra-ds/alpine) (CSS
  and behavior, on npm, imported in `resources/css/app.css` and
  `resources/js/app.js`).
- **Never invent Lyra component APIs.** When unsure about a prop or
  variant of a `<lyra:*>` component, check llms.txt or the docs first —
  the published contracts are the source of truth.

## Commands

- `php artisan serve` — dev server · `npm run dev` — Vite dev server
- `npm run build` — production asset build
- `vendor/bin/pest` — tests · `vendor/bin/pint` / `vendor/bin/pint --test`
  — code style (fix / check)
- CI runs Pint, Pest, and the asset build on every push and PR, on PHP 8.3
  and 8.4.

## Conventions

- Blade components come from `lyra-ds/blade` (`<lyra:*>` tags); don't
  hand-roll markup that duplicates a component the package already
  provides.
- No Tailwind, no per-component CSS. Appearance comes from
  `@lyra-ds/styles`; local CSS in `resources/css/app.css` is only for page
  layout (grid, gutter), never for reaching into `.lyra-*` rules.
- White-label branding happens through exactly four CSS variables
  (`--brand`, `--brand-contrast`, `--brand-radius`, `--brand-font`) — see
  `resources/css/app.css`. Don't restyle Lyra components ad hoc; derive
  from the brand tokens. The baseline Lyra look means no `data-brand`
  attribute at all — never set it without defining `--brand`.
- Fortify is **not installed**. `resources/views/auth/*` are ready-made
  views for when a project needs it — see the README's "Autenticação
  (opcional)" section for the exact `Fortify::*View()` wiring.
- Fonts (`@fontsource/plus-jakarta-sans`, `@fontsource/jetbrains-mono`) are
  local dependencies served by Vite — never load fonts from a CDN.
