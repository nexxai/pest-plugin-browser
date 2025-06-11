<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('returns null for non-iframe elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->getByTestId('profile-section');

    expect($locator)->toBeInstanceOf(Locator::class);

    $frame = $locator->contentFrame();

    expect($frame)->toBeNull();
});

it('returns frame for iframe elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->getByTestId('test-iframe');

    $frame = $locator->contentFrame();

    expect($frame)->toBeNull();
});

it('throws RuntimeException when contentFrame element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn (): ?object => $locator->contentFrame())
        ->toThrow(RuntimeException::class, 'Element not found');
});
