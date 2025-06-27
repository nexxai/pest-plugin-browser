<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

pest()->uses(RefreshDatabase::class);

test('example', function (): void {
    Route::get('/', fn (): string => Blade::render(<<<'BLADE'
        <div>
            <h1>Hi {{ auth()->user()?->name ?? "Guest" }}</h1>
        </div>
        BLADE,
    ));

    $response = visit('/')->on()->mobile()->inDarkMode();

    $response->assertSee('Hi Guest');

    $response = visit('/')->on()->desktop()->inLightMode();

    $response->assertSee('Hi Guest');

    $response = $response->on()->desktop()->inLightMode();

    $response->assertSee('Hi Guest');
});
