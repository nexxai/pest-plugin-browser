<?php

declare(strict_types=1);

use Pest\Browser\Support\Screenshot;

it('may screen a page', function (): void {
    $page = page('/test/frame-tests');

    $page->screenshot(filename: 'screenshot.png');

    expect(file_exists(
        Screenshot::path('screenshot.png')
    ))->toBeTrue();
});
