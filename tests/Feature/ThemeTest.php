<?php

it('emits the pre-paint theme script in the layout', function (): void {
    $html = $this->get('/')->getContent();

    expect($html)->toContain('data-lyra-theme-key')
        ->and($html)->toContain('lyra-theme');
});

it('renders the landing page with Lyra components', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('lyra-btn', escape: false);
});
