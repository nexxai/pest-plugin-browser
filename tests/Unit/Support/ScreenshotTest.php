<?php

declare(strict_types=1);

use Pest\Browser\Support\Screenshot;

it('places screenshots under tests/Browser/screenshots', function (): void {
    Screenshot::save('asdf', 'test-screenshot.png');

    expect(file_exists(Screenshot::path('test-screenshot.png')))
        ->toBeTrue();
});

it('saves screenshots with .png extension', function (): void {
    Screenshot::save('asdf', 'test-screenshot');

    expect(file_exists(Screenshot::path('test-screenshot.png')))
        ->toBeTrue();
});

it('saves screenshots with .png extension when no extension is provided', function (): void {
    Screenshot::save('asdf', 'test-screenshot.png');

    expect(file_exists(Screenshot::path('test-screenshot.png')))
        ->toBeTrue();
});

it('saves screenshots with .png extension when no extension is provided and the filename starts with a slash', function (): void {
    Screenshot::save('asdf', '/test-screenshot');

    expect(file_exists(Screenshot::path('test-screenshot.png')))
        ->toBeTrue();
});
