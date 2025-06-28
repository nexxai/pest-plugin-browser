<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can get nth element from multiple matches', function (): void {
    $page = page('/test/element-tests');
    $buttons = $page->locator('button');
    $secondButton = $buttons->nth(1);

    expect($secondButton)->toBeInstanceOf(Locator::class);
});
