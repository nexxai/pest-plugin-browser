<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can create frame locator', function (): void {
    $page = page('/test/element-tests');
    $frameElement = $page->getByTestId('test-frame');

    $frameLocator = $frameElement->frameLocator('.frame-content');

    expect($frameLocator)->toBeInstanceOf(Locator::class);
});

it('can get page identifier from locator', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $locatorPageId = $button->page();

    expect($locatorPageId)->toBeString();
    expect($locatorPageId)->not()->toBeEmpty();
});

it('can wait for element state', function (): void {
    $page = page('/test/element-tests');

    $button = $page->getByTestId('click-button');

    $button->waitFor();

    expect($button->isVisible())->toBeTrue();
});

it('can wait for enabled state', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->waitForState('enabled');

    expect($button->isEnabled())->toBeTrue();
});

it('can wait with timeout', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->waitForState('visible', ['timeout' => 5000]);

    expect($button->isVisible())->toBeTrue();
});

it('can wait for element state using waitForElementState method', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->waitForElementState('visible');

    expect($button->isVisible())->toBeTrue();
});

it('can wait for element state with options using waitForElementState', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->waitForElementState('enabled', ['timeout' => 5000]);

    expect($button->isEnabled())->toBeTrue();
});

it('throws RuntimeException when waitForElementState element is not found', function (): void {
    $page = page('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn () => $locator->waitForElementState('visible'))
        ->toThrow(RuntimeException::class, 'Element not found');
});

it('throws RuntimeException when waitForState element is not found', function (): void {
    $page = page('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn () => $locator->waitForState('visible'))
        ->toThrow(RuntimeException::class, 'Element not found');
});
