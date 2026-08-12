@php
    $tomorrow = now()->addDay()->startOfDay();
    $scheduleSlots = collect([9, 10, 11, 14, 15])
        ->map(fn (int $hour) => [
            'start' => $tomorrow->copy()->setTime($hour, 0)->toIso8601String(),
            'end' => $tomorrow->copy()->setTime($hour, 30)->toIso8601String(),
        ])
        ->all();
@endphp

@extends('layouts.shell')

@section('body')
<lyra:page-header title="Schedule">
    <x-slot:eyebrow>Team calendar</x-slot:eyebrow>
    <x-slot:description>Review the month at a glance and book time with the team.</x-slot:description>
</lyra:page-header>

<div class="product-schedule">
    <section>
        <h2>Month overview</h2>
        <lyra:calendar today-button />
    </section>

    <section>
        <h2>Book a meeting</h2>
        <lyra:slot-picker :slots="$scheduleSlots" timezone="America/Sao_Paulo" />
    </section>

    <section>
        <h2>Notification time zone</h2>
        <lyra:time-zone-picker
            label="Time zone for reminders"
            hint="Used for meeting reminders and digests."
            value="America/Sao_Paulo"
        />
    </section>
</div>
@endsection
