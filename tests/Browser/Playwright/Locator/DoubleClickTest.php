<?php

declare(strict_types=1);

it('can double click on buttons', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('dblclick-button');
    $counter = $page->getByTestId('dblclick-counter');

    expect($counter->textContent())->toBe('0');

    $button->dblclick();

    expect($counter->textContent())->toBe('1');
});

it('can double click multiple times', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('dblclick-button');
    $counter = $page->getByTestId('dblclick-counter');

    expect($counter->textContent())->toBe('0');

    $button->dblclick();
    expect($counter->textContent())->toBe('1');

    $button->dblclick();
    expect($counter->textContent())->toBe('2');

    $button->dblclick();
    expect($counter->textContent())->toBe('3');
});

it('can double click with options', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('dblclick-button');
    $counter = $page->getByTestId('dblclick-counter');

    expect($counter->textContent())->toBe('0');

    $button->dblclick(['force' => true]);

    expect($counter->textContent())->toBe('1');
});

it('can double click with button and modifiers options', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('dblclick-button');
    $counter = $page->getByTestId('dblclick-counter');

    expect($counter->textContent())->toBe('0');

    $button->dblclick([
        'button' => 'left',
        'modifiers' => ['Shift']
    ]);

    expect($counter->textContent())->toBe('1');
});

it('can double click with position option', function (): void {
    $page = page()->goto('/test/element-tests');
    $button = $page->getByTestId('dblclick-button');
    $counter = $page->getByTestId('dblclick-counter');

    expect($counter->textContent())->toBe('0');

    $button->dblclick([
        'position' => ['x' => 10, 'y' => 10]
    ]);

    expect($counter->textContent())->toBe('1');
});
