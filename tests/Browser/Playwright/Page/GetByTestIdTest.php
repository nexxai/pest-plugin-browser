<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an element by test ID', function (): void {
    $page = page('/test/selector-tests');
    $element = $page->getByTestId('profile-section');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds a nested element by test ID', function (): void {
    $page = page('/test/selector-tests');
    $element = $page->getByTestId('user-email');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});
