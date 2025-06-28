<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may match a screenshot', function (): void {
    Route::get('/', fn (): string => '
        <div>
            <h1>1</h1>
        </div>
    ');

    $page = visit('/');

    $page->assertScreenshotMatches();
});

it('may not match a screenshot', function (): void {
    $randomNumber = random_int(1, PHP_INT_MAX);

    Route::get('/', fn (): string => "
        <div>
            <h1>$randomNumber</h1>
        </div>
    ");

    $page = visit('/');

    $page->assertScreenshotMatches();
})->throws(ExpectationFailedException::class);
