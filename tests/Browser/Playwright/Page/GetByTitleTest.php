<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an element by its title attribute', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByTitle('Info Button');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->isVisible())->toBeTrue();
});

it('finds a link by its title attribute', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByTitle('Help Link');

    expect($element)->toBeInstanceOf(Locator::class);
});

it('finds an element with exact matching', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByTitle('User\'s Name', true);

    expect($element)->toBeInstanceOf(Locator::class);
});
