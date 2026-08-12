@extends('layouts.app')

@section('content')
{{-- $errors is normally shared by Fortify's `web` middleware group. This
     view can also render standalone (see AuthViewsTest), so we fall back to
     an empty bag when nothing shared one yet. --}}
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="sm">
    <lyra:card>
        {{-- `mark` has no default in the brand component; a placeholder
             asset path is used until the app supplies its own logo. --}}
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Sign in</h1>

        @if (session('status'))
            <lyra:alert tone="success">{{ session('status') }}</lyra:alert>
        @endif

        @error('email')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/login">
            @csrf

            <lyra:input
                name="email"
                type="email"
                label="Email address"
                autocomplete="email"
                required
                :value="old('email')"
            />

            <lyra:input
                name="password"
                type="password"
                label="Password"
                autocomplete="current-password"
                required
            />

            <lyra:checkbox name="remember" label="Remember me" />

            <lyra:button type="submit" variant="primary" full>Sign in</lyra:button>
        </form>

        <lyra:separator />

        <a href="/forgot-password">Forgot your password?</a>
    </lyra:card>
</lyra:container>
@endsection
