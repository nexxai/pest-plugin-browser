<?php

declare(strict_types=1);

it('may press a button with text', function (): void {
    Route::get('/', fn (): string => '
        <form>
            <button data-test="my-button" type="button" id="submit-btn" onclick="document.getElementById(\'result\').textContent = \'Button Pressed\'">Submit</button>
            <div id="result"></div>
        </form>
    ');

    $page = visit('/');

    $page->press('@my-button');

    expect($page->text('#result'))->toBe('Button Pressed');
});

it('may press a button with a name', function (): void {
    Route::get('/', fn (): string => '
        <form>
            <button type="button" name="submit-btn" onclick="document.getElementById(\'result\').textContent = \'Button Pressed\'">Submit</button>
            <div id="result"></div>
        </form>
    ');

    $page = visit('/');

    $page->press('submit-btn');

    expect($page->text('#result'))->toBe('Button Pressed');
});

it('may press a button with an id', function (): void {
    Route::get('/', fn (): string => '
        <form>
            <button type="button" id="submit-btn" onclick="document.getElementById(\'result\').textContent = \'Button Pressed\'">Submit</button>
            <div id="result"></div>
        </form>
    ');

    $page = visit('/');

    $page->press('submit-btn');

    expect($page->text('#result'))->toBe('Button Pressed');
});

it('may press an input button', function (): void {
    Route::get('/', fn (): string => '
        <form>
            <input type="button" value="Click Me" onclick="document.getElementById(\'result\').textContent = \'Input Button Pressed\'">
            <div id="result"></div>
        </form>
    ');

    $page = visit('/');

    $page->press('Click Me');

    expect($page->text('#result'))->toBe('Input Button Pressed');
});

it('can press elements via exact match css selectors', function (string $selector): void {
    Route::get('/', fn (): string => '
        <form>
            <form>
            <button type="button" value="Click Me" name="test" onclick="document.getElementById(\'result\').textContent = \'Button Pressed\'">
            <div id="result"></div>
        </form>
        </form>
    ');

    $page = visit('/');

    $page->press($selector);

    expect($page->text('#result'))->toBe('Button Pressed');
})->with([
    '[name]',
    '[name*="test"]',
    '[name^="test"]',
    '[name$="test"]',
    'button[name="test"]',
]);
