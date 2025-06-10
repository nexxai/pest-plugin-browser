<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an image by its alt text', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByAltText('Pest Logo');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds another image by its alt text', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByAltText('Another Image');

    expect($element)->toBeInstanceOf(Locator::class);
});

it('finds an element with exact matching', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByAltText('Profile Picture', true);

    expect($element)->toBeInstanceOf(Locator::class);
});
