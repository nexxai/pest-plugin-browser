<?php

declare(strict_types=1);

it('presses keys and triggers key events', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#keyboard-input');
    $page->focus('#keyboard-input');

    $page->press('#keyboard-input', 'a');
    expect($page->textContent('#key-display'))->toContain('Key pressed: a');

    $page->press('#keyboard-input', 'Enter');
    expect($page->textContent('#key-display'))->toContain('Key pressed: Enter');

    $page->press('#keyboard-input', 'ArrowRight');
    expect($page->textContent('#key-display'))->toContain('Key pressed: ArrowRight');
});
