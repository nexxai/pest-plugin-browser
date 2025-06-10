<?php

declare(strict_types=1);

it('gets the value of text inputs', function (): void {
    $page = $this->page('/test/frame-tests');
    $value = $page->inputValue('#prefilled-input');

    expect($value)->toBe('initial value');
});

it('gets empty value for empty inputs', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->fill('#test-input', '');
    $value = $page->inputValue('#test-input');

    expect($value)->toBe('');
});

it('gets value after filling input', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->fill('#test-input', 'new value');
    $value = $page->inputValue('#test-input');

    expect($value)->toBe('new value');
});
