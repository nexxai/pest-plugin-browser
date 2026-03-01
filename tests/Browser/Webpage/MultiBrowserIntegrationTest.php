<?php

declare(strict_types=1);

use Pest\Browser\Enums\BrowserType;

it('may run assertions on multiple browsers using visit()', function (): void {
    Route::get('/multi', fn (): string => '<h1>Multi Browser</h1>');

    visit('/multi')->browser([BrowserType::CHROME, BrowserType::FIREFOX])
        ->each(function ($page): void {
            $page->assertSee('Multi Browser');
        });
});

it('may run assertions on multiple browsers with visit() and chaining', function (): void {
    Route::get('/multi-dark', fn (): string => '<h1>Dark Mode Test</h1>');

    visit('/multi-dark')
        ->browser([BrowserType::CHROME, BrowserType::FIREFOX])
        ->inDarkMode()
        ->each(function ($page): void {
            $page->assertSee('Dark Mode Test');
        });
});

it('may chain configuration options before each()', function (): void {
    Route::get('/chain', fn (): string => '<h1>Chain Test</h1>');

    visit('/chain')
        ->browser([BrowserType::CHROME, BrowserType::FIREFOX])
        ->inDarkMode()
        ->withLocale('en-US')
        ->each(function ($page): void {
            $page->assertSee('Chain Test');
        });
});

it('may use eachResult() to get results from each browser', function (): void {
    Route::get('/each-result', fn (): string => '<h1>Result Test</h1>');

    $results = visit('/each-result')
        ->browser([BrowserType::CHROME, BrowserType::FIREFOX])
        ->eachResult(fn($page): string => $page->url());

    expect($results)->toHaveCount(2);
});
