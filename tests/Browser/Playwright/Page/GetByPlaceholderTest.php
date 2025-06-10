<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an input element by placeholder text', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByPlaceholder('Search...');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->getAttribute('type'))->toBe('text');
});

it('finds a textarea by placeholder text', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByPlaceholder('Enter your comments here');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds an element with exact matching', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByPlaceholder('Search...', true);

    expect($element)->toBeInstanceOf(Locator::class);
});
