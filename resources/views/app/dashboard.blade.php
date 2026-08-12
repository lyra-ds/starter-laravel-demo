@extends('layouts.shell')

@section('body')
<lyra:page-header title="Dashboard">
    <x-slot:description>A snapshot of what changed across the team this week.</x-slot:description>
    <x-slot:actions>
        <lyra:button variant="secondary" size="sm" type="button" x-on:click="window.location.assign('{{ route('files') }}')">
            <lyra:icon name="upload" :size="16" /> Upload file
        </lyra:button>
        <lyra:button variant="primary" size="sm" type="button" x-on:click="window.location.assign('{{ route('schedule') }}')">
            <lyra:icon name="plus" :size="16" /> New booking
        </lyra:button>
    </x-slot:actions>
</lyra:page-header>

<div class="product-stats">
    @foreach ($stats as $stat)
        <lyra:stat direction="{{ $stat['direction'] }}">
            <x-slot:label>{{ $stat['label'] }}</x-slot:label>
            <x-slot:value>{{ $stat['value'] }}</x-slot:value>
            <x-slot:delta>{{ $stat['delta'] }}</x-slot:delta>
        </lyra:stat>
    @endforeach
</div>

<section class="page-section">
    <h2 class="page-section__title">Recent activity</h2>
    <lyra:data-table :columns="$activityColumns" :rows="$activityRows" client-sort hover density="comfortable" />
</section>
@endsection
