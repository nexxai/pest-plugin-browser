<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may assert dropdown has specific options', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectHasOptions('color', ['red', 'blue', 'green']);
});

it('may fail when asserting dropdown has specific options but it does not', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectHasOptions('color', ['red', 'blue', 'green']);
})->throws(ExpectationFailedException::class);

it('may assert dropdown is missing specific options', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectMissingOptions('color', ['green', 'yellow']);
});

it('may fail when asserting dropdown is missing specific options but it has them', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectMissingOptions('color', ['green', 'yellow']);
})->throws(ExpectationFailedException::class);

it('may assert dropdown has a specific option', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectHasOption('color', 'red');
});

it('may fail when asserting dropdown has a specific option but it does not', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectHasOption('color', 'green');
})->throws(ExpectationFailedException::class);

it('may assert dropdown is missing a specific option', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectMissingOption('color', 'green');
});

it('may fail when asserting dropdown is missing a specific option but it has it', function (): void {
    Route::get('/', fn (): string => '
        <select name="color">
            <option value="red">Red</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </select>
    ');

    $page = visit('/');

    $page->assertSelectMissingOption('color', 'green');
})->throws(ExpectationFailedException::class);
