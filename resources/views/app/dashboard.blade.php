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
