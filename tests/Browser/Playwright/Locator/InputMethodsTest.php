<?php

declare(strict_types=1);

it('can select all text in input', function (): void {
    $page = page()->goto('/test/element-tests');
    $input = $page->getByTestId('text-input');

    $input->fill('Select this text');
    $input->selectText();

    $input->type('Replaced');
    expect($input->inputValue())->toBe('Replaced');
});

it('can set checked state explicitly', function (): void {
    $page = page()->goto('/test/element-tests');
    $checkbox = $page->getByTestId('checkbox-input');

    $checkbox->setChecked(true);
    expect($checkbox->isChecked())->toBeTrue();

    $checkbox->setChecked(false);
    expect($checkbox->isChecked())->toBeFalse();

    $checkbox->setChecked(true);
    expect($checkbox->isChecked())->toBeTrue();
});

it('throws RuntimeException when selectText element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn() => $locator->selectText())
        ->toThrow(RuntimeException::class, 'Element not found');
});

it('throws RuntimeException when setChecked element is not found', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->locator('.non-existent-element');

    expect(fn() => $locator->setChecked(true))
        ->toThrow(RuntimeException::class, 'Element not found');
});
