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
