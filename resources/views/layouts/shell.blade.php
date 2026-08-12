@php
    $productNavItems = [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
        ['id' => 'schedule', 'label' => 'Schedule', 'icon' => 'calendar'],
        ['id' => 'files', 'label' => 'Files', 'icon' => 'folder'],
        ['id' => 'team', 'label' => 'Team', 'icon' => 'users'],
        ['id' => 'settings', 'label' => 'Settings', 'icon' => 'settings'],
    ];
@endphp

@extends('layouts.app')

@section('content')
{{-- x-data roots the Alpine tree for the theme toggle, mirroring the gallery. --}}
<div class="product-shell" x-data>
    <lyra:shell sidebar-label="Primary navigation">
        <x-slot:sidebar>
            <lyra:app-sidebar brand="Lyra Demo" :width="240">
                <nav class="product-nav" aria-label="Product navigation">
                    @foreach ($productNavItems as $item)
                        <lyra:nav-link
                            href="{{ route($item['id']) }}"
                            :active="request()->routeIs($item['id'])"
                            class="product-nav__link"
                        >
                            <lyra:icon :name="$item['icon']" :size="16" />
                            {{ $item['label'] }}
                        </lyra:nav-link>
                    @endforeach
                </nav>

                <x-slot:footer>
                    <div class="product-shell__footer">
                        <lyra:button
                            type="button"
                            variant="ghost"
                            size="sm"
                            x-on:click="$store.theme.toggle()"
                            x-bind:aria-label="$store.theme.dark ? 'Switch to light theme' : 'Switch to dark theme'"
                        >
                            <span x-show="! $store.theme.dark"><lyra:icon name="moon" :size="16" /></span>
                            <span x-show="$store.theme.dark" x-cloak><lyra:icon name="sun" :size="16" /></span>
                        </lyra:button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <lyra:button type="submit" variant="secondary" size="sm">Log out</lyra:button>
                        </form>
                    </div>
                </x-slot:footer>
            </lyra:app-sidebar>
        </x-slot:sidebar>

        @yield('body')
    </lyra:shell>
</div>
@endsection
