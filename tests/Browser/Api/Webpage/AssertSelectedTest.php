<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may assert dropdown has a specific value selected', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red" selected>Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelected('color', 'red');
});

it('may fail when asserting dropdown has a specific value selected but it does not', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red" selected>Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelected('color', 'blue');
})->throws(ExpectationFailedException::class);

it('may assert dropdown does not have a specific value selected', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red" selected>Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertNotSelected('color', 'blue');
});

it('may fail when asserting dropdown does not have a specific value selected but it does', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red" selected>Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertNotSelected('color', 'red');
})->throws(ExpectationFailedException::class);
