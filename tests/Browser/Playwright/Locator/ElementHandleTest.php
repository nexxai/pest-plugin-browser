<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Element;

it('can get element handle from locator', function (): void {
    $page = page('/test/element-tests');
    $locator = $page->getByTestId('profile-section');
    $element = $locator->elementHandle();

    expect($element)->toBeInstanceOf(Element::class);
});

it('returns null for non-existent elements', function (): void {
    $page = page('/test/element-tests');
    $locator = $page->getByTestId('non-existent-element');
    $element = $locator->elementHandle();

    expect($element)->toBeNull();
});
