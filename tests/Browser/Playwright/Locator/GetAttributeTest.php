<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can get attribute values', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    expect($element->getAttribute('data-testid'))->toBe('profile-section');
});
