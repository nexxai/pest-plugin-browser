<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

it('can visit non-subdomain routes with subdomain host browser testing', function (): void {
    Route::get('/app-test', fn (): string => '
        <html>
        <head><title>Non Subdomain</title></head>
        <body>
            <h1>Welcome to NON Subdomain</h1>
            <div id="content">This is the non subdomain content</div>
        </body>
        </html>
    ');

    pest()->browser()->withHost('app.localhost');

    visit('/app-test')
        ->assertSee('Welcome to NON Subdomain')
        ->assertSeeIn('#content', 'This is the non subdomain content')
        ->assertTitle('Non Subdomain');
});

it('works with Laravel subdomain style', function (): void {
    // Simulate Laravel Sail subdomain routing pattern
    Route::domain('{subdomain}.localhost')->group(function (): void {
        Route::get('/api/health', fn (): array => [
            'status' => 'ok',
            'subdomain' => request()->route('subdomain'),
            'host' => request()->getHost(),
        ]);
    });

    pest()->browser()->withHost('api.localhost');

    visit('/api/health')
        ->assertSee('"status":"ok"')
        ->assertSee('"subdomain":"api"')
        ->assertSee('"host":"api.localhost"');
});

it('Can chain withHost on visit', function (): void {
    Route::domain('{subdomain}.localhost')->group(function (): void {
        Route::get('/api/health', fn (): array => [
            'status' => 'ok',
            'subdomain' => request()->route('subdomain'),
            'host' => request()->getHost(),
        ]);
    });

    visit('/api/health')
        ->withHost('api.localhost')
        ->assertSee('"status":"ok"')
        ->assertSee('"subdomain":"api"')
        ->assertSee('"host":"api.localhost"');
});

it('Chaining withHost will not override global host', function (): void {
    Route::domain('{subdomain}.localhost')->group(function (): void {
        Route::get('/api/health', fn (): array => [
            'subdomain' => request()->route('subdomain'),
            'host' => request()->getHost(),
        ]);
    });

    Route::get('/', fn (): array => [
        'host' => request()->getHost(),
    ]);

    // Set global host: test.domain
    pest()->browser()->withHost('test.domain');

    // 1. Visit withHost: api.localhost
    visit('/api/health')
        ->withHost('api.localhost')
        ->assertSee('"host":"api.localhost"')
        ->assertDontSee('test.domain');

    // 2. Visit without withHost: should use global host "test.domain"
    visit('/')
        ->assertSee('"host":"test.domain"')
        ->assertDontSee('api.localhost');
});
