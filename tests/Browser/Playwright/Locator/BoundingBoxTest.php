<?php

declare(strict_types=1);

it('can get bounding box of element', function (): void {
    $page = page('/test/element-tests');
    $button = $page->getByTestId('click-button');

    $boundingBox = $button->boundingBox();

    expect($boundingBox)->toBeArray();
    expect($boundingBox)->toHaveKeys(['x', 'y', 'width', 'height']);
    expect($boundingBox['x'])->toBeFloat();
    expect($boundingBox['y'])->toBeFloat();
    expect($boundingBox['width'])->toBeFloat();
    expect($boundingBox['height'])->toBeFloat();
    expect($boundingBox['width'])->toBeGreaterThan(0);
    expect($boundingBox['height'])->toBeGreaterThan(0);
});

it('returns null for hidden elements', function (): void {
    $page = page('/test/element-tests');
    $hiddenElement = $page->getByTestId('hidden-element');

    $boundingBox = $hiddenElement->boundingBox();

    expect($boundingBox)->toBeNull();
});

it('returns null when boundingBox element is not found', function (): void {
    $page = page('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    $boundingBox = $locator->boundingBox();

    expect($boundingBox)->toBeNull();
});

it('returns null for elements without visible bounding boxes', function (): void {
    $page = page('/test/element-tests');

    $locator = $page->locator('head');
    $boundingBox = $locator->boundingBox();
    expect($boundingBox)->toBeNull();
});

it('handles edge case elements that might return malformed bounding box data', function (): void {
    $page = page('/test/element-tests');

    $locator = $page->getByTestId('zero-width-element');
    $boundingBox = $locator->boundingBox();

    expect($boundingBox)->toBeNull();
})->todo('find a way to handle zero-width elements gracefully');
