<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Element;

it('can tap on click counter button and increment the counter', function (): void {
    $page = $this->page(null, ['hasTouch' => true])->goto('/test/element-tests');
    $locator = $page->getByTestId('click-button');
    $element = $locator->elementHandle();

    expect($element)->toBeInstanceOf(Element::class);

    $counterLocator = $page->getByTestId('click-counter');
    expect($counterLocator->textContent())->toBe('0');

    $element->tap();

    expect($counterLocator->textContent())->toBe('1');
});

it('can tap with force option on event button and trigger events', function (): void {
    $page = $this->page(null, ['hasTouch' => true])->goto('/test/element-tests');
    $locator = $page->getByTestId('event-button');
    $element = $locator->elementHandle();

    $resultElement = $page->getByTestId('event-result');
    expect($resultElement->textContent())->toBe('');

    $element->tap(['force' => true]);

    expect($resultElement->textContent())->toBe('Button was clicked!');
});
