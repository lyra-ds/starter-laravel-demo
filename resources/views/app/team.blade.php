@php
    // Presentational only: turns the route's $members/$memberActions data into data-table
    // cell HTML. data-table only accepts scalar/Htmlable/Stringable cell values, so the
    // person-cell and dropdown markup for each row has to be pre-rendered here.
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\HtmlString;

    $renderPerson = static fn (string $name, string $detail): HtmlString => new HtmlString(
        Blade::render('<x-lyra::person-cell :name="$name" :detail="$detail" />', compact('name', 'detail')),
    );

    $renderActions = static fn (): HtmlString => new HtmlString(
        Blade::render(
            '<x-lyra::dropdown :items="$items" align="end"><x-slot:trigger><x-lyra::icon name="ellipsis" :size="17" /></x-slot:trigger></x-lyra::dropdown>',
            ['items' => $memberActions],
        )
    );

    $teamColumns = [
        ['key' => 'member', 'label' => 'Member'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'actions', 'label' => '', 'align' => 'right'],
    ];

    $teamRows = collect($members)
        ->map(fn (array $member): array => [
            'id' => $member['id'],
            'member' => $renderPerson($member['name'], $member['email']),
            'role' => $member['role'],
            'status' => $member['status'],
            'actions' => $renderActions(),
        ])
        ->all();
@endphp

@extends('layouts.shell')

@section('body')
<lyra:page-header title="Team">
    <x-slot:eyebrow>Workspace members</x-slot:eyebrow>
    <x-slot:description>Everyone with access to this workspace.</x-slot:description>
</lyra:page-header>

<lyra:data-table :columns="$teamColumns" :rows="$teamRows" hover />
@endsection
