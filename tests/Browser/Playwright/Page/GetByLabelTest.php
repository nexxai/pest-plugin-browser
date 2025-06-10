<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('finds an input element by its associated label', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByLabel('Username');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->getAttribute('value'))->toBe('johndoe');
});

it('finds a password input by its label', function (): void {
    $page = $this->page('/test/selector-tests');
    $element = $page->getByLabel('Password');

    expect($element)->toBeInstanceOf(Locator::class);
    expect($element->getAttribute('type'))->toBe('password');
});
