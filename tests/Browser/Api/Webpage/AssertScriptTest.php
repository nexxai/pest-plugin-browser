<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may assert javascript expression evaluates to true', function (): void {
    Route::get('/', fn (): string => '<div id="content">Hello World</div>');

    $page = visit('/');

    $page->assertScript("document.querySelector('#content').textContent === 'Hello World'");
});

it('may assert javascript expression evaluates to specific value', function (): void {
    Route::get('/', fn (): string => '<div id="content">Hello World</div>');

    $page = visit('/');

    $page->assertScript("document.querySelector('#content').textContent", 'Hello World');
});

it('may fail when javascript expression evaluates to false', function (): void {
    Route::get('/', fn (): string => '<div id="content">Hello World</div>');

    $page = visit('/');

    $page->assertScript("document.querySelector('#content').textContent === 'Hello Universe'");
})->throws(ExpectationFailedException::class);

it('may fail when javascript expression does not evaluate to expected value', function (): void {
    Route::get('/', fn (): string => '<div id="content">Hello World</div>');

    $page = visit('/');

    $page->assertScript("document.querySelector('#content').textContent", 'Hello Universe');
})->throws(ExpectationFailedException::class);
