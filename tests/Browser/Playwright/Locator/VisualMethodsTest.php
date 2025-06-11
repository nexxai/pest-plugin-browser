<?php

declare(strict_types=1);

it('can take screenshot of element', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $screenshot = $button->screenshot();

    expect($screenshot)->toBeString();
    expect(mb_strlen($screenshot))->toBeGreaterThan(0);
    expect($screenshot)->toMatch('/^[A-Za-z0-9+\/]+=*$/');
});

it('can take screenshot with options', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $screenshot = $button->screenshot([
        'type' => 'png',
    ]);

    expect($screenshot)->toBeString();
    expect(mb_strlen($screenshot))->toBeGreaterThan(0);
});

it('can scroll element into view if needed', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->scrollIntoViewIfNeeded();

    expect($button->isVisible())->toBeTrue();
});

it('can highlight element', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $button->highlight();

    expect($button->isVisible())->toBeTrue();
});

it('throws RuntimeException when screenshot element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn() => $locator->screenshot())
        ->toThrow(RuntimeException::class, 'Element not found');
});

it('throws RuntimeException when scrollIntoViewIfNeeded element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn() => $locator->scrollIntoViewIfNeeded())
        ->toThrow(RuntimeException::class, 'Element not found');
});
