<?php

declare(strict_types=1);

describe('press', function (): void {
    beforeEach(function (): void {
        $this->page = $this->page('/test/frame-tests');
    });

    it('presses keys and triggers key events', function (): void {
        $this->page->waitForSelector('#keyboard-input');
        $this->page->focus('#keyboard-input');

        $this->page->press('#keyboard-input', 'a');
        expect($this->page->textContent('#key-display'))->toContain('Key pressed: a');

        $this->page->press('#keyboard-input', 'Enter');
        expect($this->page->textContent('#key-display'))->toContain('Key pressed: Enter');

        $this->page->press('#keyboard-input', 'ArrowRight');
        expect($this->page->textContent('#key-display'))->toContain('Key pressed: ArrowRight');
    });
});
