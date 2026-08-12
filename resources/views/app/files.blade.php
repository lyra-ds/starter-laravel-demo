@php
    $projectFiles = [
        ['id' => 'design', 'name' => 'Design & UI', 'type' => 'folder', 'items' => 6, 'updated' => '2026-08-10'],
        ['id' => 'contracts', 'name' => 'Contracts', 'type' => 'folder', 'items' => 3, 'updated' => '2026-08-05'],
        ['id' => 'brand-assets', 'name' => 'Brand assets.zip', 'size' => 18_874_368, 'updated' => '2026-08-09'],
        ['id' => 'roadmap', 'name' => 'Q3 roadmap.pdf', 'size' => 425_984, 'updated' => '2026-08-08'],
        ['id' => 'onboarding', 'name' => 'Onboarding flow.fig', 'size' => 2_202_009, 'updated' => '2026-08-06', 'shared' => true],
    ];
@endphp

@extends('layouts.shell')

@section('body')
<lyra:page-header title="Files">
    <x-slot:eyebrow>Workspace storage</x-slot:eyebrow>
    <x-slot:description>Upload new documents and browse what the team has shared.</x-slot:description>
</lyra:page-header>

<div class="product-files">
    <section>
        <h2>Upload</h2>
        <lyra:file-upload hint="PDF, Figma, or ZIP up to 25 MB" accept=".pdf,.fig,.zip" :max-size-m-b="25" />
    </section>

    <section>
        <h2>Project files</h2>
        <lyra:file-manager :files="$projectFiles" :path="['Workspace', 'Q3 release']" />
    </section>

    <section>
        <h2>Shared with me</h2>
        <lyra:empty-state title="No files shared with you yet">
            <x-slot:icon><lyra:icon name="folder" :size="28" /></x-slot:icon>
            <x-slot:description>Files teammates share directly with you will show up here.</x-slot:description>
            <x-slot:action><lyra:button variant="secondary" size="sm">Invite a teammate</lyra:button></x-slot:action>
        </lyra:empty-state>
    </section>
</div>
@endsection
