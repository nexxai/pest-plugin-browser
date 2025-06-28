<?php

declare(strict_types=1);

it('may navigate to a page', function (): void {
    Route::get('/page-a', fn (): string => 'page 1');
    Route::get('/page-b', fn (): string => 'page 2');

    $page = visit('/page-a');
    $page->assertSee('page 1');

    $page->navigate('/page-b');
    $page->assertSee('page 2');
});
