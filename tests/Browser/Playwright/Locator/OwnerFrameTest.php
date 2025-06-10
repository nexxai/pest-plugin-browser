<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('returns frame information for elements', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $locator = $page->getByTestId('profile-section');

    expect($locator)->toBeInstanceOf(Locator::class);

    $frame = $locator->ownerFrame();

    expect($frame)->toBeNull();
});
