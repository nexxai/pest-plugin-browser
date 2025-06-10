<?php

declare(strict_types=1);

use Pest\Browser\Support\Screenshot;

it('deletes the screenshots directory', function (): void {
    $screenshotDir = Screenshot::dir();

    expect(is_dir($screenshotDir))->toBeFalse();
});

it('may screen a page', function (): void {
    $page = $this->page('/test/frame-tests');

    $page->screenshot('screenshot.png');

    expect(file_exists(
        Screenshot::path('screenshot.png')
    ))->toBeTrue();
});
