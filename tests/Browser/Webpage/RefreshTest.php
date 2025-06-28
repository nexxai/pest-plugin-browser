<?php

declare(strict_types=1);

it('may refresh the page', function (): void {
    $count = 0;

    Route::get('/page', function () use (&$count): string {
        $count++;

        return Blade::render(<<<'BLADE'
            <h1>Page {{ $count }}</h1>
        BLADE, ['count' => $count]);
    });

    $page = visit('/page');

    $page->assertSee('Page 1');

    $page->refresh();

    $page->assertSee('Page 2');
});
