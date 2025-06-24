<?php

declare(strict_types=1);

it('may click a link', function (): void {
    Route::get('/', fn (): string => '<a href="/about">About Us</a>');
    Route::get('/about', fn (): string => 'About Page');

    $page = visit('/');

    $page->clickLink('About Us');

    $page->assertSee('About Page');
});

it('may click a link with an id selector', function (): void {
    Route::get('/', fn (): string => '<a id="about-link" href="/about">About Us</a>');
    Route::get('/about', fn (): string => 'About Page');

    $page = visit('/');

    $page->clickLink('#about-link');

    $page->assertSee('About Page');
});
