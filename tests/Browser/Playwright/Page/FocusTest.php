<?php

declare(strict_types=1);

describe('focus', function (): void {
    beforeEach(function (): void {
        $this->page = $this->page('/test/frame-tests');
    });

    it('focuses on elements and triggers focus state changes', function (): void {
        $this->page->waitForSelector('#focus-target');
        expect($this->page->textContent('#focus-display'))->toBe('No element focused yet');

        $this->page->focus('#focus-target');
        expect($this->page->textContent('#focus-display'))->toBe('Last focused: focus-target');
        expect($this->page->isVisible('#focus-target'))->toBeTrue();
    });

    it('focuses on multiple elements and tracks state changes', function (): void {
        $this->page->waitForSelector('#test-input');
        expect($this->page->textContent('#focus-display'))->toBe('No element focused yet');

        $this->page->focus('#test-input');
        expect($this->page->textContent('#focus-display'))->toBe('Last focused: test-input');

        $this->page->focus('#password-input');
        expect($this->page->textContent('#focus-display'))->toBe('Last focused: password-input');

        $this->page->focus('#test-textarea');
        expect($this->page->textContent('#focus-display'))->toBe('Last focused: test-textarea');
    });

    it('focuses on keyboard input and verifies focus', function (): void {
        $this->page->waitForSelector('#keyboard-input');

        $this->page->focus('#keyboard-input');
        expect($this->page->textContent('#focus-display'))->toBe('Last focused: keyboard-input');

        $this->page->type('#keyboard-input', 'test typing');
        expect($this->page->inputValue('#keyboard-input'))->toBe('test typing');
    });
});
