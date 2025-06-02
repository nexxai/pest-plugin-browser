<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can get inner text', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    expect($element->innerText())->toContain('Profile Section');
});
