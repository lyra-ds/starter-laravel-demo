@php
    // Presentational only: turns the route's $members/$memberActions data into data-table
    // cell HTML. data-table only accepts scalar/Htmlable/Stringable cell values, so the
    // person-cell, badge, and dropdown markup for each row has to be pre-rendered here.
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\HtmlString;

    $renderPerson = static fn (string $name, string $detail): HtmlString => new HtmlString(
        Blade::render('<x-lyra::person-cell :name="$name" :detail="$detail" />', compact('name', 'detail')),
    );

    $statusTones = ['Active' => 'success', 'Invited' => 'info', 'Suspended' => 'warning'];
    $renderStatus = static fn (string $status): HtmlString => new HtmlString(
        Blade::render(
            '<x-lyra::badge :tone="$tone" dot>{{ $status }}</x-lyra::badge>',
            ['tone' => $statusTones[$status] ?? 'neutral', 'status' => $status],
        ),
    );

    $renderActions = static fn (): HtmlString => new HtmlString(
        Blade::render(
            '<x-lyra::dropdown :items="$items" align="end"><x-slot:trigger><x-lyra::icon name="ellipsis" :size="17" /></x-slot:trigger></x-lyra::dropdown>',
            ['items' => $memberActions],
        )
    );

    $teamColumns = [
        ['key' => 'member', 'label' => 'Member', 'sortable' => true, 'sortValueKey' => 'name'],
        ['key' => 'role', 'label' => 'Role', 'sortable' => true],
        ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'sortValueKey' => 'status_text'],
        ['key' => 'actions', 'label' => '', 'align' => 'right'],
    ];

    $teamRows = collect($members)
        ->map(fn (array $member): array => [
            'id' => $member['id'],
            'member' => $renderPerson($member['name'], $member['email']),
            'name' => $member['name'],
            'role' => $member['role'],
            'status' => $renderStatus($member['status']),
            'status_text' => $member['status'],
            'actions' => $renderActions(),
        ])
        ->all();
@endphp

@extends('layouts.shell')

@section('body')
<div x-data="{ inviteOpen: false }">
    <lyra:page-header title="Team">
        <x-slot:description>Everyone with access to this workspace — {{ $totalMembers }} members.</x-slot:description>
        <x-slot:actions>
            <lyra:button variant="primary" size="sm" type="button" x-on:click="inviteOpen = true">
                <lyra:icon name="user-plus" :size="16" /> Invite member
            </lyra:button>
        </x-slot:actions>
    </lyra:page-header>

    <lyra:dialog title="Invite a member" x-model="inviteOpen">
        <form id="invite-member-form" x-on:submit.prevent="inviteOpen = false; $store.lyraToasts.success('Invitation sent — demo only, nothing was saved.')">
            <lyra:stack gap="4">
                <lyra:input name="invite_name" label="Name" placeholder="e.g. Ana Souza" required />
                <lyra:input name="invite_email" type="email" label="Email address" placeholder="ana@example.com" required />
                <lyra:select name="invite_role" label="Role">
                    <option value="engineer">Engineer</option>
                    <option value="designer">Designer</option>
                    <option value="product">Product</option>
                    <option value="support">Support</option>
                    <option value="maintainer">Maintainer</option>
                </lyra:select>
            </lyra:stack>
        </form>
        <x-slot:footer>
            <lyra:button type="button" variant="ghost" x-on:click="inviteOpen = false">Cancel</lyra:button>
            <lyra:button type="submit" variant="primary" form="invite-member-form">Send invite</lyra:button>
        </x-slot:footer>
    </lyra:dialog>
</div>

<section class="page-section">
    <lyra:data-table :columns="$teamColumns" :rows="$teamRows" client-sort hover />
    <lyra:pagination :page="$page" :total="$totalPages" url="{{ route('team') }}?page={page}" />
</section>
@endsection
