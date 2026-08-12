@extends('layouts.app')

@section('content')
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="sm">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Create account</h1>

        @error('email')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/register">
            @csrf

            <lyra:input
                name="name"
                type="text"
                label="Name"
                autocomplete="name"
                required
                :value="old('name')"
            />

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

            <lyra:button type="submit" variant="primary" full>Create account</lyra:button>
        </form>

        <lyra:separator />

        <a href="/login">Already have an account?</a>
    </lyra:card>
</lyra:container>
@endsection
