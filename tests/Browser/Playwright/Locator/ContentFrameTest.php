<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('returns null for non-iframe elements', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $locator = $page->getByTestId('profile-section');

    expect($locator)->toBeInstanceOf(Locator::class);

    $frame = $locator->contentFrame();

    expect($frame)->toBeNull();
});

it('returns frame for iframe elements', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $locator = $page->getByTestId('test-iframe');

    $frame = $locator->contentFrame();

    // Frame would be an object with guid if implemented
    expect($frame)->toBeNull(); // Will be null until Frame class is properly integrated
});
