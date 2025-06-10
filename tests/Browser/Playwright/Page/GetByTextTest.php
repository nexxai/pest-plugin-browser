<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an element by its text content', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByText('This is a simple paragraph');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds a button by its text content', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByText('Click Me Button');

    expect($element)->toBeInstanceOf(Locator::class);
});

it('finds an element with exact matching', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByText('This is a special span element', true);

    expect($element)->toBeInstanceOf(Locator::class);
});

it('finds partial text without exact matching', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByText('special span');

    expect($element)->toBeInstanceOf(Locator::class);
});
