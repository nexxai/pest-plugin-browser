<?php

declare(strict_types=1);

it('can fill input fields', function (): void {
    $page = page()->goto('/test/element-tests');
    $input = $page->getByTestId('text-input');

    $input->fill('Hello World');

    expect($input->inputValue())->toBe('Hello World');
});

it('can fill with options', function (): void {
    $page = page()->goto('/test/element-tests');
    $input = $page->getByLabel('Username');

    $input->fill('testuser', ['force' => true]);
    expect($input->inputValue())->toBe('testuser');
});
