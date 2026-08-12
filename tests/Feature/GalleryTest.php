<?php

it('renders the gallery route', function (): void {
    $this->get('/components')->assertOk()->assertSee('lyra-', escape: false);
});

it('covers every component the package ships', function (): void {
    $installed = collect(glob(base_path('vendor/lyra-ds/blade/resources/views/components/*.blade.php')) ?: [])
        ->map(fn (string $path): string => basename($path, '.blade.php'));

    $gallery = (string) file_get_contents(resource_path('views/components-gallery.blade.php'));

    $missing = $installed->reject(fn (string $slug): bool => str_contains($gallery, "<lyra:{$slug}"));

    expect($missing->all())->toBe([], 'componentes ausentes da galeria: '.$missing->implode(', '));
});
