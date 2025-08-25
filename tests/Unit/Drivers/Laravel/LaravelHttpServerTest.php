<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

it('rewrites the URLs on JS files', function (): void {
    @file_put_contents(
        public_path('app.js'),
        <<<'JS'
        console.log('Hello http://localhost');
        JS,
    );

    $page = visit('/app.js');

    $page->assertSee('http://127.0.0.1')
        ->assertDontSee('http://localhost');
});

it('changes the hostname for all requests', function () {
    Route::domain('pest.test')->group(function () {
        Route::get('/about', fn (): string => 'Hello Pest');
    });

    pest()->browser()->withHostname('pest.test');

    visit('/about')->assertSee('Hello Pest');
});

