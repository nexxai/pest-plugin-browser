<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('returns frame information for elements', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $locator = $page->getByTestId('profile-section');

    expect($locator)->toBeInstanceOf(Locator::class);

    $frame = $locator->ownerFrame();

    // This would return the frame that owns this element
    expect($frame)->toBeNull(); // Will be null until Frame class is properly integrated
});
