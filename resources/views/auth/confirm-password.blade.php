@extends('layouts.app')

@section('content')
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="480">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Confirm password</h1>
        <p>This is a secure area of the application. Please confirm your password before continuing.</p>

        @error('password')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/user/confirm-password">
            @csrf

            <lyra:input
                name="password"
                type="password"
                label="Password"
                autocomplete="current-password"
                required
            />

            <lyra:button type="submit" variant="primary" full>Confirm</lyra:button>
        </form>
    </lyra:card>
</lyra:container>
@endsection
