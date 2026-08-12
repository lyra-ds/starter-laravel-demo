@php
    $stats = [
        ['label' => 'Active projects', 'value' => '12', 'delta' => '2 this month', 'direction' => 'up'],
        ['label' => 'Open tasks', 'value' => '38', 'delta' => '5 since yesterday', 'direction' => 'down'],
        ['label' => 'Team members', 'value' => '9', 'delta' => 'unchanged', 'direction' => 'flat'],
        ['label' => 'Storage used', 'value' => '64%', 'delta' => '3% this week', 'direction' => 'up'],
    ];

    $activityColumns = [
        ['key' => 'actor', 'label' => 'Member'],
        ['key' => 'action', 'label' => 'Action'],
        ['key' => 'target', 'label' => 'Item'],
        ['key' => 'when', 'label' => 'When', 'align' => 'right'],
    ];

    $activityRows = [
        ['id' => 1, 'actor' => 'Maya Chen', 'action' => 'updated', 'target' => 'Q3 roadmap', 'when' => '5 minutes ago'],
        ['id' => 2, 'actor' => 'Diego Ramirez', 'action' => 'uploaded', 'target' => 'Brand assets.zip', 'when' => '1 hour ago'],
        ['id' => 3, 'actor' => 'Priya Nair', 'action' => 'commented on', 'target' => 'Onboarding flow', 'when' => 'Yesterday'],
        ['id' => 4, 'actor' => 'Owen Blake', 'action' => 'archived', 'target' => 'Legacy pricing page', 'when' => '2 days ago'],
    ];
@endphp

@extends('layouts.shell')

@section('body')
<lyra:page-header title="Dashboard">
    <x-slot:eyebrow>Workspace overview</x-slot:eyebrow>
    <x-slot:description>A snapshot of what changed across the team this week.</x-slot:description>
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

<lyra:data-table :columns="$activityColumns" :rows="$activityRows" hover />
@endsection
