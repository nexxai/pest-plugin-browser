<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can get input value', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $input = $page->getByTestId('prefilled-input');

    expect($input->inputValue())->not()->toBe('');
});
