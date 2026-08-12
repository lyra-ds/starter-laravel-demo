@extends('layouts.app')

@section('content')
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="sm">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Reset password</h1>

        @error('email')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/reset-password">
            @csrf

            {{-- The only raw input this catalog accepts: a hidden token has
                 no visual representation, so there is no component for it. --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <lyra:input
                name="email"
                type="email"
                label="Email address"
                autocomplete="email"
                required
                :value="old('email', $request->query('email'))"
            />

            <lyra:input
                name="password"
                type="password"
                label="Password"
                autocomplete="new-password"
                required
            />

            <lyra:input
                name="password_confirmation"
                type="password"
                label="Confirm password"
                autocomplete="new-password"
                required
            />

            <lyra:button type="submit" variant="primary" full>Reset password</lyra:button>
        </form>
    </lyra:card>
</lyra:container>
@endsection
