@php
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\HtmlString;

    $renderPerson = static fn (string $name, string $detail): HtmlString => new HtmlString(
        Blade::render('<x-lyra::person-cell :name="$name" :detail="$detail" />', compact('name', 'detail')),
    );

    $memberActions = [
        ['type' => 'label', 'label' => 'Member'],
        ['label' => 'View profile'],
        ['label' => 'Change role'],
        ['type' => 'separator'],
        ['label' => 'Remove from team', 'danger' => true],
    ];

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

    $teamRows = [
        ['id' => 'maya', 'member' => $renderPerson('Maya Chen', 'maya@lyra-ds.dev'), 'role' => 'Maintainer', 'status' => 'Active', 'actions' => $renderActions()],
        ['id' => 'diego', 'member' => $renderPerson('Diego Ramirez', 'diego@lyra-ds.dev'), 'role' => 'Designer', 'status' => 'Active', 'actions' => $renderActions()],
        ['id' => 'priya', 'member' => $renderPerson('Priya Nair', 'priya@lyra-ds.dev'), 'role' => 'Engineer', 'status' => 'Active', 'actions' => $renderActions()],
        ['id' => 'owen', 'member' => $renderPerson('Owen Blake', 'owen@lyra-ds.dev'), 'role' => 'Engineer', 'status' => 'Invited', 'actions' => $renderActions()],
    ];
@endphp

@extends('layouts.shell')

@section('body')
<lyra:page-header title="Team">
    <x-slot:eyebrow>Workspace members</x-slot:eyebrow>
    <x-slot:description>Everyone with access to this workspace.</x-slot:description>
</lyra:page-header>

<lyra:data-table :columns="$teamColumns" :rows="$teamRows" hover />
@endsection
