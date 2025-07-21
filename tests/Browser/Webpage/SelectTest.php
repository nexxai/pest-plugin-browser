<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may select an option by value or label', function (): void {
    Route::get('/', fn (): string => '
        <select name="country" data-testid="my-country-field">
            <option value="us">United States</option>
            <option value="ca">Canada</option>
            <option value="mx">Mexico</option>
        </select>
    ');

    $page = visit('/');

    $page->assertValue('@my-country-field', 'us');

    $page->select('country', 'ca');
    $page->assertValue('country', 'ca');

    $page->select('country', 'Mexico');
    $page->assertValue('country', 'mx');
});

it('may select multiple options', function (): void {
    Route::get('/', fn (): string => '
        <select id="countries" name="countries[]" multiple>
            <option value="us">United States</option>
            <option value="ca">Canada</option>
            <option value="mx">Mexico</option>
        </select>
    ');

    $page = visit('/');

    $page->select('countries', ['us', 'Mexico']);

    // Check that both options are selected
    $selectedOptions = $page->script('() => {
        const select = document.querySelector("#countries");
        return Array.from(select.options)
            .filter(option => option.selected)
            .map(option => option.value);
    }');
    expect($selectedOptions)->toBe(['us', 'mx']);
});

it('may not select an option that does not exist', function (): void {
    Route::get('/', fn (): string => '
        <select name="country">
            <option value="us">United States</option>
            <option value="ca">Canada</option>
            <option value="mx">Mexico</option>
        </select>
    ');

    $page = visit('/');

    $page->select('country', 'fr'); // France does not exist in the options

    $page->assertValue('country', 'us'); // Should remain unchanged
})->throws(ExpectationFailedException::class);
