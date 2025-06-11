<?php

declare(strict_types=1);

it('returns true for editable input elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $inputLocator = $page->getByTestId('text-input');

    expect($inputLocator->isEditable())->toBeTrue();
});

it('returns true for textarea elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $textareaLocator = $page->getByTestId('textarea-input');

    expect($textareaLocator->isEditable())->toBeTrue();
});

it('throws RuntimeException for non-editable elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $divLocator = $page->getByTestId('profile-section');

    expect(fn (): bool => $divLocator->isEditable())
        ->toThrow(RuntimeException::class, 'Element is not an <input>, <textarea>, <select> or [contenteditable]');
});

it('returns false for disabled input elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $disabledInputLocator = $page->getByTestId('disabled-input');

    expect($disabledInputLocator->isEditable())->toBeFalse();
});

it('returns false for readonly input elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $readonlyInputLocator = $page->getByTestId('readonly-input');

    expect($readonlyInputLocator->isEditable())->toBeFalse();
});
