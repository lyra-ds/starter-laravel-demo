@php
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\HtmlString;

    $navIcon = static fn (string $name): HtmlString => new HtmlString(
        Blade::render('<lyra:icon name="'.$name.'" :size="18" />'),
    );

    $navGroups = [
        [
            'heading' => 'Workspace',
            'items' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => $navIcon('layout-dashboard'), 'active' => request()->routeIs('dashboard')],
                ['id' => 'schedule', 'label' => 'Schedule', 'icon' => $navIcon('calendar'), 'active' => request()->routeIs('schedule')],
                ['id' => 'files', 'label' => 'Files', 'icon' => $navIcon('folder'), 'active' => request()->routeIs('files')],
            ],
        ],
        [
            'heading' => 'Organization',
            'items' => [
                ['id' => 'team', 'label' => 'Team', 'icon' => $navIcon('users'), 'active' => request()->routeIs('team')],
                ['id' => 'settings', 'label' => 'Settings', 'icon' => $navIcon('settings'), 'active' => request()->routeIs('settings')],
            ],
        ],
    ];
@endphp

@extends('layouts.app')

@section('content')
{{--
    The sidebar's group items are buttons that announce selection via the
    lyra:select event (the served component has no href variant), so this
    wrapper owns the route map and navigates on select.
--}}
<div
    class="product-shell"
    x-data="{ routes: {
        dashboard: '{{ route('dashboard') }}',
        schedule: '{{ route('schedule') }}',
        files: '{{ route('files') }}',
        team: '{{ route('team') }}',
        settings: '{{ route('settings') }}',
    } }"
    x-on:lyra:select="const url = routes[$event.detail.id]; if (url) window.location.assign(url)"
>
    <lyra:shell scroll="content" sidebar-label="Primary navigation">
        <x-slot:topbar>
            {{-- Proxies the app-sidebar's own collapse control (hidden via CSS):
                 the component keeps the state, the topbar carries the affordance.
                 Upstream issue: app-sidebar should expose toggle placement. --}}
            <span x-data="{ railed: false }" class="sidebar-toggle">
                <lyra:icon-button
                    variant="ghost"
                    size="sm"
                    label="Toggle sidebar"
                    x-on:click="document.querySelector('.lyra-appsidebar__toggle')?.click(); railed = ! railed"
                >
                    <span x-show="! railed"><lyra:icon name="chevrons-left" :size="16" /></span>
                    <span x-show="railed" x-cloak><lyra:icon name="chevrons-right" :size="16" /></span>
                </lyra:icon-button>
            </span>

            <nav class="topbar-nav" aria-label="Global">
                <lyra:nav-link href="{{ route('components') }}">Components</lyra:nav-link>
                <lyra:nav-link href="https://lyra-ds.dev">Docs</lyra:nav-link>
            </nav>

            <div class="topbar-actions">
                <lyra:icon-button
                    variant="ghost"
                    size="sm"
                    label="Toggle theme"
                    x-on:click="$store.theme.toggle()"
                >
                    <span x-show="! $store.theme.dark"><lyra:icon name="moon" :size="16" /></span>
                    <span x-show="$store.theme.dark" x-cloak><lyra:icon name="sun" :size="16" /></span>
                </lyra:icon-button>

                <lyra:popover align="end" :width="240" aria-label="User menu">
                    <x-slot:trigger>
                        <span class="user-chip">
                            <lyra:avatar :name="auth()->user()->name" size="sm" />
                            <span class="user-chip__name">{{ auth()->user()->name }}</span>
                            <lyra:icon name="chevron-down" :size="14" />
                        </span>
                    </x-slot:trigger>
                    <div class="user-menu">
                        <div class="user-menu__id">
                            <span class="user-menu__name">{{ auth()->user()->name }}</span>
                            <span class="user-menu__email">{{ auth()->user()->email }}</span>
                        </div>
                        <lyra:separator />
                        <a class="user-menu__item" href="{{ route('settings') }}">
                            <lyra:icon name="settings" :size="16" /> Settings
                        </a>
                        <a class="user-menu__item" href="{{ route('components') }}">
                            <lyra:icon name="layout-grid" :size="16" /> Component gallery
                        </a>
                        <lyra:separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="user-menu__item user-menu__item--danger">
                                <lyra:icon name="log-out" :size="16" /> Log out
                            </button>
                        </form>
                    </div>
                </lyra:popover>
            </div>
        </x-slot:topbar>

        <x-slot:sidebar>
            <lyra:app-sidebar :groups="$navGroups" :width="248" collapsible>
                <x-slot:brand>
                    {{-- The switcher announces selection via lyra:change; "create"
                         opens the demo's create-workspace dialog. --}}
                    <div
                        class="sidebar-brand"
                        x-data="{ wsOpen: false }"
                        x-on:lyra:change="$event.detail.id === 'create'
                            ? wsOpen = true
                            : $store.lyraToasts.info('Workspace switching is a demo — nothing was changed.')"
                    >
                        <lyra:brand mark="/img/lyra-mark.svg" href="{{ route('dashboard') }}" :size="22">Lyra Demo</lyra:brand>
                        <lyra:workspace-switcher
                            :workspaces="[
                                ['id' => 'q3', 'name' => 'Q3 Release', 'plan' => 'Pro'],
                                ['id' => 'marketing', 'name' => 'Marketing', 'plan' => 'Free'],
                            ]"
                            current="q3"
                            create
                        />

                        <lyra:dialog title="Create workspace" x-model="wsOpen">
                            <form id="create-workspace-form" x-on:submit.prevent="wsOpen = false; $store.lyraToasts.success('Workspace created — demo only, nothing was saved.')">
                                <lyra:stack gap="4">
                                    <lyra:input name="workspace_name" label="Workspace name" placeholder="e.g. Q4 Launch" required />
                                    <lyra:select name="workspace_plan" label="Plan">
                                        <option value="free">Free</option>
                                        <option value="pro">Pro</option>
                                    </lyra:select>
                                </lyra:stack>
                            </form>
                            <x-slot:footer>
                                <lyra:button type="button" variant="ghost" x-on:click="wsOpen = false">Cancel</lyra:button>
                                <lyra:button type="submit" variant="primary" form="create-workspace-form">Create workspace</lyra:button>
                            </x-slot:footer>
                        </lyra:dialog>
                    </div>
                </x-slot:brand>
                <x-slot:footer>
                    <div class="lyra-appsidebar__user">
                        <lyra:avatar :name="auth()->user()->name" size="sm" />
                        <div>
                            <div class="lyra-appsidebar__user-name">{{ auth()->user()->name }}</div>
                            <div class="lyra-appsidebar__user-role">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </x-slot:footer>
            </lyra:app-sidebar>
        </x-slot:sidebar>

        <div class="page">
            @yield('body')
        </div>

        <lyra:footer links-label="Demo resources" class="page-footer">
            <x-slot:note>Built with the Lyra Design System. Demo data only — resets on every deploy.</x-slot:note>
            <x-slot:links>
                <a href="https://lyra-ds.dev">lyra-ds.dev</a>
                <a href="https://github.com/lyra-ds/starter-laravel">Use the template</a>
                <a href="{{ route('components') }}">All 72 components</a>
            </x-slot:links>
        </lyra:footer>
    </lyra:shell>

    {{-- Mobile: the sidebar hides below 768px and this fixed bar takes over.
         nav-link renders real anchors, so navigation works without JS. --}}
    <nav class="mobile-nav" aria-label="Primary navigation">
        @foreach ([
            ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'layout-dashboard'],
            ['route' => 'schedule', 'label' => 'Schedule', 'icon' => 'calendar'],
            ['route' => 'files', 'label' => 'Files', 'icon' => 'folder'],
            ['route' => 'team', 'label' => 'Team', 'icon' => 'users'],
            ['route' => 'settings', 'label' => 'Settings', 'icon' => 'settings'],
        ] as $item)
            <lyra:nav-link
                href="{{ route($item['route']) }}"
                :active="request()->routeIs($item['route'])"
                class="mobile-nav__link"
            >
                <lyra:icon :name="$item['icon']" :size="20" />
                <span>{{ $item['label'] }}</span>
            </lyra:nav-link>
        @endforeach
    </nav>

    <lyra:toast-stack />
</div>
@endsection
