<?php

declare(strict_types=1);

it('presses keys on input elements and verifies input changes', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $locator = $page->getByTestId('text-input');
    $element = $locator->elementHandle();

    $element->focus();
    $element->fill('');

    $element->press('a');
    $element->press('b');
    $element->press('c');
    expect($element->inputValue())->toBe('abc');

    $element->press('Backspace');
    expect($element->inputValue())->toBe('ab');

    if (PHP_OS_FAMILY === 'Windows' || PHP_OS_FAMILY === 'Linux') {
        $element->press('Control+a');
    } else {
        $element->press('Meta+a');
    }

    $element->press('Delete');
    expect($element->inputValue())->toBe('');
});
