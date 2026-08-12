@extends('layouts.shell')

@section('body')
<lyra:page-header title="Settings">
    <x-slot:eyebrow>Workspace preferences</x-slot:eyebrow>
    <x-slot:description>Update profile details, notification behavior, and defaults.</x-slot:description>
</lyra:page-header>

<lyra:fieldset>
    <x-slot:legend>Profile</x-slot:legend>
    <x-slot:description>Shown to teammates across the workspace.</x-slot:description>

    <lyra:form-row :columns="2">
        <lyra:input label="Full name" name="name" value="{{ auth()->user()?->name }}" />
        <lyra:input label="Email address" name="email" type="email" value="{{ auth()->user()?->email }}" />
    </lyra:form-row>

    <lyra:select label="Default landing page" name="default_page">
        <option value="dashboard">Dashboard</option>
        <option value="schedule">Schedule</option>
        <option value="files">Files</option>
    </lyra:select>
</lyra:fieldset>

<lyra:fieldset>
    <x-slot:legend>Notifications</x-slot:legend>
    <x-slot:description>Choose how you want to hear about workspace activity.</x-slot:description>

    <lyra:switch label="Email me about mentions" name="notify_mentions" checked />
    <lyra:switch label="Weekly digest" name="notify_digest" checked />
    <lyra:switch label="Product announcements" name="notify_announcements" />
</lyra:fieldset>

@php($user = auth()->user())

{{-- Wired to Fortify's real two-factor endpoints. `confirmPassword => true`
     puts them behind the `password.confirm` middleware, so Fortify may
     bounce through the confirm-password view before honoring a request. --}}
<lyra:fieldset data-testid="security-2fa">
    <x-slot:legend>Security</x-slot:legend>
    <x-slot:description>Protect your account with two-factor authentication from a TOTP app.</x-slot:description>

    @if (session('status') === Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
        <lyra:alert tone="info">Scan the QR code and confirm a code below to finish enabling two-factor authentication.</lyra:alert>
    @elseif (session('status') === Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED)
        <lyra:alert tone="success">Two-factor authentication confirmed. Store your recovery codes somewhere safe.</lyra:alert>
    @elseif (session('status') === Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED)
        <lyra:alert tone="info">Two-factor authentication has been disabled.</lyra:alert>
    @endif

    @if (! $user?->two_factor_secret)
        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            <lyra:button type="submit">Enable two-factor authentication</lyra:button>
        </form>
    @else
        @if (! $user->hasEnabledTwoFactorAuthentication())
            <p>Scan the QR code with your authenticator app, then confirm with a generated code.</p>
            <div class="settings-qr">{!! $user->twoFactorQrCodeSvg() !!}</div>
            <form method="POST" action="/user/confirmed-two-factor-authentication">
                @csrf
                <lyra:input
                    label="Confirmation code"
                    name="code"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    :error="$errors->first('code')"
                />
                <lyra:button type="submit">Confirm</lyra:button>
            </form>
        @else
            <lyra:alert tone="success">Two-factor authentication is enabled.</lyra:alert>
            <p>Recovery codes get you back in if you lose your device — each works once:</p>
            <lyra:code-block language="text">{{ implode("\n", $user->recoveryCodes()) }}</lyra:code-block>
        @endif

        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            @method('DELETE')
            <lyra:button type="submit" variant="danger">Disable two-factor authentication</lyra:button>
        </form>
    @endif
</lyra:fieldset>

<lyra:fieldset>
    <x-slot:legend>Appearance</x-slot:legend>
    <x-slot:description>Applies to this browser only.</x-slot:description>

    <lyra:segmented-control
        label="Theme"
        value="system"
        :options="[
            ['label' => 'Light', 'value' => 'light'],
            ['label' => 'Dark', 'value' => 'dark'],
            ['label' => 'System', 'value' => 'system'],
        ]"
    />
</lyra:fieldset>
@endsection
