<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may assert input has a specific value', function (): void {
    Route::get('/', fn (): string => '<input name="name" value="John Doe">');

    $page = visit('/');

    $page->assertInputValue('name', 'John Doe');
});

it('may fail when asserting input has a specific value but it does not', function (): void {
    Route::get('/', fn (): string => '<input name="name" value="John Doe">');

    $page = visit('/');

    $page->assertInputValue('name', 'Jane Doe');
})->throws(ExpectationFailedException::class);

it('may assert input does not have a specific value', function (): void {
    Route::get('/', fn (): string => '<input name="name" value="John Doe">');

    $page = visit('/');

    $page->assertInputValueIsNot('name', 'Jane Doe');
});

it('may fail when asserting input does not have a specific value but it does', function (): void {
    Route::get('/', fn (): string => '<input name="name" value="John Doe">');

    $page = visit('/');

    $page->assertInputValueIsNot('name', 'John Doe');
})->throws(ExpectationFailedException::class);
