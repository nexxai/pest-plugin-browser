<?php

declare(strict_types=1);

it('can select options from select elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $selectElement = $page->getByTestId('test-select');

    $selected = $selectElement->selectOption('option2');

    expect($selected)->toBeArray();
});

it('can select multiple options', function (): void {
    $page = page()->goto('/test/element-tests');
    $selectElement = $page->getByTestId('test-select');

    $selected = $selectElement->selectOption(['option1', 'option2']);

    expect($selected)->toBeArray();
});

it('can select options with options parameter', function (): void {
    $page = page()->goto('/test/element-tests');
    $selectElement = $page->getByTestId('test-select');

    $selected = $selectElement->selectOption('option1', ['force' => true]);

    expect($selected)->toBeArray();
});
