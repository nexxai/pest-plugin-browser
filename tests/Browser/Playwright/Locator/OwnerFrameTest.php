<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('returns frame information for elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->getByTestId('profile-section');

    expect($locator)->toBeInstanceOf(Locator::class);

    $frame = $locator->ownerFrame();

    expect($frame)->toBeNull();
});

it('throws RuntimeException when ownerFrame element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn (): ?object => $locator->ownerFrame())
        ->toThrow(RuntimeException::class, 'Element not found');
});
