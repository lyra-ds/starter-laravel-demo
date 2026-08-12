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

it('points the workspace brand mark at a shipped asset', function (): void {
    $gallery = (string) file_get_contents(resource_path('views/components-gallery.blade.php'));

    expect($gallery)->not->toContain('mark="/logo.svg"');

    // Every referenced mark must exist under public/.
    preg_match_all('/mark="([^"]+)"/', $gallery, $marks);

    foreach ($marks[1] as $mark) {
        expect(file_exists(public_path(ltrim($mark, '/'))))->toBeTrue("mark asset ausente: {$mark}");
    }
});
