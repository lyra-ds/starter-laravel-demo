@extends('layouts.app')

@section('content')
@php($errors = $errors ?? new \Illuminate\Support\ViewErrorBag)

<lyra:container max="sm">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Two-factor authentication</h1>
        <p>Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>

        @error('code')
            <lyra:alert tone="danger">{{ $message }}</lyra:alert>
        @enderror

        <form method="POST" action="/two-factor-challenge">
            @csrf

            {{-- Known catalog gap: there is no dedicated OTP-code component,
                 so a plain `lyra:input` stands in for it. --}}
            <lyra:input
                name="code"
                type="text"
                label="Authentication code"
                inputmode="numeric"
                autocomplete="one-time-code"
                required
            />

            <lyra:button type="submit" variant="primary" full>Verify</lyra:button>
        </form>

        <lyra:separator />

        <details>
            <summary>Use a recovery code instead</summary>

            <form method="POST" action="/two-factor-challenge">
                @csrf

                <lyra:input
                    name="recovery_code"
                    type="text"
                    label="Recovery code"
                    autocomplete="off"
                    required
                />

                <lyra:button type="submit" variant="secondary" full>Verify with recovery code</lyra:button>
            </form>
        </details>
    </lyra:card>
</lyra:container>
@endsection
