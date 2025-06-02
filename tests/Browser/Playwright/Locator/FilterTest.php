<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can filter locators', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $buttons = $page->locator('button');
    $filteredButtons = $buttons->filter('[data-testid="click-button"]');

    expect($filteredButtons)->toBeInstanceOf(Locator::class);
});
