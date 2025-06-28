<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('asserts that there are no console logs', function (): void {
    Route::get('/', fn (): string => '
        <div></div>
    ');

    $page = visit('/');

    $page->assertNoConsoleLogs();
});

it('asserts that there are console logs', function (): void {
    Route::get('/', fn (): string => '
        <script>
            console.log("Hello, World!");
        </script>
        <div></div>
    ');

    $page = visit('/');

    $page->assertNoConsoleLogs();
})->throws(ExpectationFailedException::class, 'Expected no console logs, but found 1: Hello, World!');
