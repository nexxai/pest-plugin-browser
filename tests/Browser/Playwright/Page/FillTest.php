<?php

declare(strict_types=1);

it('fills text inputs', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->fill('#test-input', 'filled value');
    expect($page->inputValue('#test-input'))->toBe('filled value');
});

it('fills password inputs', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->fill('#password-input', 'secret123');
    expect($page->inputValue('#password-input'))->toBe('secret123');
});

it('fills textarea elements', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->fill('#test-textarea', 'new textarea content');
    expect($page->inputValue('#test-textarea'))->toBe('new textarea content');
});
