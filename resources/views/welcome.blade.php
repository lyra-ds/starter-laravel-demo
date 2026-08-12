@extends('layouts.app')

@section('content')
<div class="welcome-shell" x-data="{ brand: null }">
    <header class="welcome-header">
        {{-- `mark` has no default in the brand component; a placeholder
             asset path is used until the app supplies its own logo. --}}
        <lyra:brand mark="/img/lyra-mark.svg" href="/" :size="28">Lyra starter</lyra:brand>

        {{-- $store.theme is registered by @lyra-ds/alpine; toggle() flips
             data-theme and persists the choice under the layout's
             data-lyra-theme-key. --}}
        <lyra:button
            type="button"
            variant="secondary"
            size="sm"
            x-on:click="$store.theme.toggle()"
            x-bind:aria-label="$store.theme.dark ? 'Switch to light theme' : 'Switch to dark theme'"
        >
            <span x-show="! $store.theme.dark"><lyra:icon name="moon" :size="16" /></span>
            <span x-show="$store.theme.dark" x-cloak><lyra:icon name="sun" :size="16" /></span>
        </lyra:button>
    </header>

    <p class="welcome-lede">A starter Laravel app wired to the Lyra Design System: CSS-first tokens, Alpine-powered interactions, and a live white-label demo below.</p>

    <section class="welcome-section">
        <h2>Buttons</h2>
        <p>Every variant, each shown enabled and disabled.</p>
        <div class="welcome-row">
            <lyra:button variant="primary">Primary</lyra:button>
            <lyra:button variant="primary" disabled>Primary</lyra:button>
        </div>
        <div class="welcome-row">
            <lyra:button variant="secondary">Secondary</lyra:button>
            <lyra:button variant="secondary" disabled>Secondary</lyra:button>
        </div>
        <div class="welcome-row">
            <lyra:button variant="soft">Soft</lyra:button>
            <lyra:button variant="soft" disabled>Soft</lyra:button>
        </div>
        <div class="welcome-row">
            <lyra:button variant="ghost">Ghost</lyra:button>
            <lyra:button variant="ghost" disabled>Ghost</lyra:button>
        </div>
        <div class="welcome-row">
            <lyra:button variant="danger">Danger</lyra:button>
            <lyra:button variant="danger" disabled>Danger</lyra:button>
        </div>
    </section>

    <section class="welcome-section">
        <h2>A card, an input, and a switch</h2>
        <lyra:card>
            <x-slot:title>Workspace preferences</x-slot:title>
            <lyra:input
                label="Workspace name"
                hint="Shown across your team's dashboards."
                name="workspace_name"
                value="Lyra starter"
            />
            <lyra:switch label="Notify me about product updates" name="notify_updates" checked />
        </lyra:card>
    </section>

    <section class="welcome-section">
        <h2 id="white-label">White-label, live</h2>
        <p>
            <code>@lyra-ds/styles</code> re-derives every accent color, hover, and focus ring from
            four input tokens (<code>--brand</code>, <code>--brand-contrast</code>,
            <code>--brand-radius</code>, <code>--brand-font</code>) set on <code>[data-brand]</code>.
            Pick a brand below to swap <code>data-brand</code> on <code>&lt;html&gt;</code> and watch
            the preview update with no rebuild.
        </p>

        {{-- `variant` is a server-side Blade prop, so it can't react to
             Alpine state. Each button renders as `secondary` and Alpine's
             class object-syntax toggles the real `lyra-btn--*` classes at
             runtime — object syntax also removes the server-baked
             `lyra-btn--secondary` while a button is selected, so the two
             variant classes never stack. --}}
        <div class="welcome-row" role="group" aria-label="White-label brand">
            <lyra:button
                type="button"
                size="sm"
                variant="secondary"
                x-bind:class="{ 'lyra-btn--primary': brand === null, 'lyra-btn--secondary': brand !== null }"
                x-bind:aria-pressed="brand === null ? 'true' : 'false'"
                x-on:click="brand = null; document.documentElement.removeAttribute('data-brand')"
            >
                Default
            </lyra:button>
            <lyra:button
                type="button"
                size="sm"
                variant="secondary"
                x-bind:class="{ 'lyra-btn--primary': brand === 'citrus', 'lyra-btn--secondary': brand !== 'citrus' }"
                x-bind:aria-pressed="brand === 'citrus' ? 'true' : 'false'"
                x-on:click="brand = 'citrus'; document.documentElement.dataset.brand = 'citrus'"
            >
                Citrus
            </lyra:button>
            <lyra:button
                type="button"
                size="sm"
                variant="secondary"
                x-bind:class="{ 'lyra-btn--primary': brand === 'ocean', 'lyra-btn--secondary': brand !== 'ocean' }"
                x-bind:aria-pressed="brand === 'ocean' ? 'true' : 'false'"
                x-on:click="brand = 'ocean'; document.documentElement.dataset.brand = 'ocean'"
            >
                Ocean
            </lyra:button>
            <lyra:button
                type="button"
                size="sm"
                variant="secondary"
                x-bind:class="{ 'lyra-btn--primary': brand === 'grape', 'lyra-btn--secondary': brand !== 'grape' }"
                x-bind:aria-pressed="brand === 'grape' ? 'true' : 'false'"
                x-on:click="brand = 'grape'; document.documentElement.dataset.brand = 'grape'"
            >
                Grape
            </lyra:button>
        </div>

        <lyra:card>
            <x-slot:title>Live preview</x-slot:title>
            <p>Buttons, links, and focus rings all derive from the four tokens above.</p>
            <div class="welcome-row">
                <lyra:button variant="primary">Primary action</lyra:button>
                <lyra:switch label="Enabled" checked />
            </div>
        </lyra:card>
    </section>
</div>
@endsection
