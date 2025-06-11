<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can get element handles', function (): void {
    $page = page()->goto('/test/element-tests');
    $buttons = $page->locator('button');

    $elementHandles = $buttons->all();

    expect($elementHandles)->toBeArray();
    expect(count($elementHandles))->toBeGreaterThan(0);

    foreach ($elementHandles as $handle) {
        expect($handle)->toBeInstanceOf(Locator::class);
    }
});

it('returns empty array for non-existent elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $nonExistent = $page->locator('.non-existent-class');

    $elementHandles = $nonExistent->all();

    expect($elementHandles)->toBeArray();
    expect($elementHandles)->toBeEmpty();
});

it('element handles can be interacted with', function (): void {
    $page = page()->goto('/test/element-tests');
    $buttons = $page->locator('button');

    $elementHandles = $buttons->all();

    expect(count($elementHandles))->toBeGreaterThan(0);

    $firstHandle = $elementHandles[0];
    expect($firstHandle->isVisible())->toBeTrue();
});
