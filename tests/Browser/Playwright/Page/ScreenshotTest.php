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

it('may screen a full page', function (): void {
    $page = page('/test/frame-tests');

    $page->screenshot(true, 'full-page-screenshot.png');

    expect(file_exists(
        Screenshot::path('full-page-screenshot.png')
    ))->toBeTrue();
});

it('may screen a page without providing a name', function (): void {
    $this->expectNotToPerformAssertions();

    $page = page('/test/frame-tests');

    $page->screenshot();
});
