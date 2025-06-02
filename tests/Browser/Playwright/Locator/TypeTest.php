<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can type into input fields', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $input = $page->getByTestId('text-input');

    $input->type('Typed text');

    expect($input->inputValue())->toBe('Typed text');
});
