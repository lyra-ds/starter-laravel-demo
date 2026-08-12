<?php

it('ships no Tailwind dependency', function (): void {
    $manifest = json_decode((string) file_get_contents(base_path('package.json')), true);
    $dependencies = array_merge(
        $manifest['dependencies'] ?? [],
        $manifest['devDependencies'] ?? [],
    );

    foreach (array_keys($dependencies) as $name) {
        expect($name)->not->toContain('tailwind');
    }
});

it('imports the Lyra stylesheet exactly once', function (): void {
    $css = (string) file_get_contents(resource_path('css/app.css'));

    expect(substr_count($css, '@lyra-ds/styles'))->toBe(1)
        ->and($css)->not->toContain('tailwindcss');
});

it('registers the Lyra plugin before starting Alpine', function (): void {
    $js = (string) file_get_contents(resource_path('js/app.js'));
    $plugin = strpos($js, 'Alpine.plugin(lyra)');
    $start = strpos($js, 'Alpine.start()');

    expect($plugin)->not->toBeFalse()
        ->and($start)->not->toBeFalse()
        ->and($plugin)->toBeLessThan($start);
});
