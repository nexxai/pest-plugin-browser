<?php

declare(strict_types=1);

use App\Models\User;
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

    $user = User::factory()->create([
        'name' => 'Nuno Maduro',
    ]);

    $this->actingAs($user);

    $response = visit('/')->onDesktop();

    $response->assertSee('Hi Nuno Maduro');
});
