<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may assert input is present', function (): void {
    Route::get('/', fn (): string => '<input name="name"><textarea name="description"></textarea><select name="category"></select>');

    $page = visit('/');

    $page->assertInputPresent('name');
    $page->assertInputPresent('description');
    $page->assertInputPresent('category');
});

it('may fail when asserting input is present but it is not', function (): void {
    Route::get('/', fn (): string => '<input name="name">');

    $page = visit('/');

    $page->assertInputPresent('email');
})->throws(ExpectationFailedException::class);

it('may assert input is missing', function (): void {
    Route::get('/', fn (): string => '<input name="name">');

    $page = visit('/');

    $page->assertInputMissing('email');
});

it('may fail when asserting input is missing but it is present', function (): void {
    Route::get('/', fn (): string => '<input name="name">');

    $page = visit('/');

    $page->assertInputMissing('name');
})->throws(ExpectationFailedException::class);
