<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an element by role with name option', function (): void {
    $page = page('/test/selector-tests');
    $element = $page->getByRole('button', ['name' => 'Save']);

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds a checkbox by role with name option', function (): void {
    $page = page('/test/selector-tests');
    $element = $page->getByRole('checkbox', ['name' => 'Remember Me']);

    expect($element)->toBeInstanceOf(Locator::class);
});
