<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

it('can visit subdomain routes with browser testing', function (): void {
    Route::domain('app.localhost')->group(function (): void {
        Route::get('/', fn (): string => '
            <html>
            <head><title>App Subdomain</title></head>
            <body>
                <h1>Welcome to App Subdomain</h1>
                <div id="content">This is the app subdomain content</div>
            </body>
            </html>
        ');
    });

    pest()->browser()->withHost('app.localhost');

    visit('/')
        ->assertSee('Welcome to App Subdomain')
        ->assertSeeIn('#content', 'This is the app subdomain content')
        ->assertTitle('App Subdomain');
});

it('works with Laravel Sail style subdomains', function (): void {
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
