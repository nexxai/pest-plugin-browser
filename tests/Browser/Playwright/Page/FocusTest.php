<?php

declare(strict_types=1);

it('focuses on elements and triggers focus state changes', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForSelector('#focus-target');
    expect($page->textContent('#focus-display'))->toBe('No element focused yet');

    $page->focus('#focus-target');
    expect($page->textContent('#focus-display'))->toBe('Last focused: focus-target');
    expect($page->isVisible('#focus-target'))->toBeTrue();
});

it('focuses on multiple elements and tracks state changes', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForSelector('#test-input');
    expect($page->textContent('#focus-display'))->toBe('No element focused yet');

    $page->focus('#test-input');
    expect($page->textContent('#focus-display'))->toBe('Last focused: test-input');

    $page->focus('#password-input');
    expect($page->textContent('#focus-display'))->toBe('Last focused: password-input');

    $page->focus('#test-textarea');
    expect($page->textContent('#focus-display'))->toBe('Last focused: test-textarea');
});

it('focuses on keyboard input and verifies focus', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForSelector('#keyboard-input');

    $page->focus('#keyboard-input');
    expect($page->textContent('#focus-display'))->toBe('Last focused: keyboard-input');

    $page->type('#keyboard-input', 'test typing');
    expect($page->inputValue('#keyboard-input'))->toBe('test typing');
});
