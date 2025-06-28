<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can filter locators', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filter('[data-testid="click-button"]');

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('can filter by text content', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filter(['hasText' => 'Click']);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
    expect($filteredButtons->count())->toBeGreaterThan(0);
});

it('can filter by exact text content', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filter(['hasText' => 'Click Me', 'exact' => true]);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('can filter by text that should not be present', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filter(['hasNotText' => 'Hidden']);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('can filter by child locator presence', function (): void {
    $page = page('/test/element-tests');
    $containers = $page->locator('.container');
    $filteredContainers = $containers->filter(['has' => $page->locator('button')]);

    expect($filteredContainers)->toBeInstanceOf(Locator::class);
});

it('can filter by child locator absence', function (): void {
    $page = page('/test/element-tests');
    $containers = $page->locator('.container');
    $filteredContainers = $containers->filter(['hasNot' => $page->locator('.hidden')]);

    expect($filteredContainers)->toBeInstanceOf(Locator::class);
});

it('can combine multiple filter options', function (): void {
    $page = page('/test/element-tests');
    $elements = $page->locator('*');
    $filteredElements = $elements->filter([
        'hasText' => 'Click',
        'hasNot' => $page->locator('.disabled'),
    ]);

    expect($filteredElements)->toBeInstanceOf(Locator::class);
});

it('backward compatibility with string filter', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');

    $filteredButtons = $buttons->filter('[data-testid="click-button"]');

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('can use filterBySelector method', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filterBySelector('[data-testid="click-button"]');

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('handles non-string hasText in filter options', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');

    // Test with non-string hasText (this should be ignored based on the code)
    $filteredButtons = $buttons->filter(['hasText' => 123]);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('handles non-string hasNotText in filter options', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');

    // Test with non-string hasNotText (this should be ignored based on the code)
    $filteredButtons = $buttons->filter(['hasNotText' => 123]);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('handles non-locator has in filter options', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');

    // Test with non-locator has (this should be ignored based on the code)
    $filteredButtons = $buttons->filter(['has' => 'not-a-locator']);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});

it('handles non-locator hasNot in filter options', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');

    // Test with non-locator hasNot (this should be ignored based on the code)
    $filteredButtons = $buttons->filter(['hasNot' => 'not-a-locator']);

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});
