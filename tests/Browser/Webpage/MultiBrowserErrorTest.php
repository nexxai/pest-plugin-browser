<?php

declare(strict_types=1);

use Pest\Browser\Enums\BrowserType;

it('throws exception when browser assertion fails', function (): void {
    Route::get('/error-test', fn (): string => '<h1>Error Test</h1>');

    visit('/error-test')
        ->browser([BrowserType::CHROME, BrowserType::FIREFOX])
        ->each(function ($page) {
            $page->assertSee('Non-existent text');
        });
})->throws(PHPUnit\Framework\ExpectationFailedException::class);
