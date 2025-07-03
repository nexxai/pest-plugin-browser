<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may see text on a page', function (): void {
    Route::get('/', fn (): string => 'Hello World');

    $page = visit('/');

    $page->waitForText('Hello World');
});

it('may not see text on a page', function (): void {
    Route::get('/', fn (): string => 'Hello World');

    $page = visit('/');

    $page->waitForText('Hello Universe');
})->throws(ExpectationFailedException::class);
