<?php

it('drives the brand selector with a reactive class binding, not the server-side variant prop', function (): void {
    $html = $this->get('/')->getContent();

    // `variant` is a Blade prop resolved on the server; binding it with
    // Alpine (`x-bind:variant`) leaves an inert DOM attribute nothing reads.
    expect($html)->not->toContain('x-bind:variant');

    // Each brand button toggles the real DS classes at runtime instead.
    foreach ([null, 'citrus', 'ocean', 'grape'] as $brand) {
        $selected = $brand === null ? 'null' : "'{$brand}'";

        expect($html)->toContain(
            "x-bind:class=\"{ 'lyra-btn--primary': brand === {$selected}, 'lyra-btn--secondary': brand !== {$selected} }\""
        )->and($html)->toContain(
            "x-bind:aria-pressed=\"brand === {$selected} ? 'true' : 'false'\""
        );
    }
});

it('renders the brand selector buttons with a single baked variant class', function (): void {
    $html = $this->get('/')->getContent();

    preg_match_all('/<button[^>]*x-bind:aria-pressed[^>]*>/', $html, $buttons);

    expect($buttons[0])->toHaveCount(4);

    foreach ($buttons[0] as $button) {
        // Server-side, every selector button is `secondary`; Alpine's class
        // object-syntax swaps it for `lyra-btn--primary` on selection, so
        // the two variant classes must never both be baked into the static
        // class attribute (the runtime expression in `x-bind:class` is the
        // only place `lyra-btn--primary` may appear).
        preg_match('/\sclass="([^"]*)"/', $button, $static);

        expect($static[1] ?? '')->toContain('lyra-btn--secondary')
            ->and($static[1] ?? '')->not->toContain('lyra-btn--primary');
    }
});
