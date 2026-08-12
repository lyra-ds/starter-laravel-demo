@extends('layouts.app')

@section('content')
<lyra:container max="480" class="auth-screen">
    <lyra:card>
        <lyra:brand mark="/img/lyra-mark.svg" />
        <h1>Verify your email</h1>
        <p>Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you. If you did not receive the email, we can send another.</p>

        @if (session('status') === 'verification-link-sent')
            <lyra:alert tone="success">A new verification link has been sent to the email address you provided during registration.</lyra:alert>
        @endif

        <form method="POST" action="/email/verification-notification">
            @csrf

            <lyra:button type="submit" variant="primary" full>Resend verification email</lyra:button>
        </form>

        <lyra:separator />

        <form method="POST" action="/logout">
            @csrf

            <lyra:button type="submit" variant="ghost" full>Log out</lyra:button>
        </form>
    </lyra:card>
</lyra:container>
@endsection
