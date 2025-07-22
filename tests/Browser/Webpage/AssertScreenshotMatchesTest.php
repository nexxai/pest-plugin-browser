<?php

declare(strict_types=1);

beforeEach()->skipOnCI();

it('may match a screenshot', function (): void {
    Route::get('/', fn (): string => '
        <div>
            <h1>1</h1>
        </div>
    ');

    $page = visit('/');

    $page->assertScreenshotMatches();
});
