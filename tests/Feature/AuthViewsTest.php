<?php

use Illuminate\Support\Facades\View;

dataset('auth views', [
    'auth.login',
    'auth.register',
    'auth.forgot-password',
    'auth.reset-password',
    'auth.verify-email',
    'auth.confirm-password',
    'auth.two-factor-challenge',
]);

it('renders every Fortify view with Lyra markup', function (string $view): void {
    $html = View::make($view, ['request' => request()])->render();

    expect(trim($html))->not->toBe('')
        ->and($html)->toContain('lyra-');
})->with('auth views');

it('never falls back to raw HTML controls', function (string $view): void {
    $html = View::make($view, ['request' => request()])->render();

    // `type="hidden"` inputs are ignored: `@csrf` always emits a raw hidden
    // input, and reset-password adds a hidden token input. Both are
    // sanctioned since they have no visual representation — the coverage
    // this test protects is about visible controls only.
    $html = preg_replace('/<input[^>]*\btype="hidden"[^>]*>/', '', $html);

    expect($html)->not->toMatch('/<input(?![^>]*class="[^"]*lyra-)/')
        ->and($html)->not->toMatch('/<button(?![^>]*class="[^"]*lyra-)/');
})->with('auth views');
