@extends('layouts.app')

@section('content')
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="480">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Forgot your password?</h1>
        <p>Enter your email address and we will send you a password reset link.</p>

        @if (session('status'))
            <lyra:alert tone="success">{{ session('status') }}</lyra:alert>
        @endif

        @error('email')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/forgot-password">
            @csrf

            <lyra:input
                name="email"
                type="email"
                label="Email address"
                autocomplete="email"
                required
                :value="old('email')"
            />

            <lyra:button type="submit" variant="primary" full>Email password reset link</lyra:button>
        </form>

        <lyra:separator />

        <a href="/login">Back to sign in</a>
    </lyra:card>
</lyra:container>
@endsection
