<?php

declare(strict_types=1);

it('can type into input fields', function (): void {
    $page = page()->goto('/test/element-tests');
    $input = $page->getByTestId('text-input');

    $input->type('Typed text');

    expect($input->inputValue())->toBe('Typed text');
});
