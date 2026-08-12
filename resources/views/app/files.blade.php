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
        <lyra:file-manager :files="$projectFiles" :path="$filesPath" />
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
