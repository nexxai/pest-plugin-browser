<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can tap on click counter button and increment the counter', function (): void {
    $page = $this->page(null, ['hasTouch' => true])->goto('/test/element-tests');
    $locator = $page->getByTestId('click-button');

    expect($locator)->toBeInstanceOf(Locator::class);

    $counterLocator = $page->getByTestId('click-counter');
    expect($counterLocator->textContent())->toBe('0');

    $locator->tap();

    expect($counterLocator->textContent())->toBe('1');
});

it('can tap with force option on event button and trigger events', function (): void {
    $page = $this->page(null, ['hasTouch' => true])->goto('/test/element-tests');
    $locator = $page->getByTestId('event-button');

    $resultElement = $page->getByTestId('event-result');
    expect($resultElement->textContent())->toBe('');

    $locator->tap(['force' => true]);

    expect($resultElement->textContent())->toBe('Button was clicked!');
});
