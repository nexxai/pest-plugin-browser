<?php

declare(strict_types=1);

it('can focus on different elements and track focus changes', function (): void {
    $page = $this->page()->goto('/test/element-tests');

    $page->waitForSelector('[data-testid="focus-target"]');
    expect($page->textContent('[data-testid="focus-display"]'))->toBe('No element focused yet');

    $focusTarget = $page->locator('[data-testid="focus-target"]')->elementHandle();
    $focusTarget->focus();

    $page->waitForSelector('[data-testid="focus-display"]:text("Last focused: focus-target")');
    expect($page->textContent('[data-testid="focus-display"]'))->toBe('Last focused: focus-target');

    $username = $page->locator('#username')->elementHandle();
    $username->focus();

    $page->waitForSelector('[data-testid="focus-display"]:text("Last focused: username")');
    expect($page->textContent('[data-testid="focus-display"]'))->toBe('Last focused: username');
});

it('can focus and interact with the focused element', function (): void {
    $page = $this->page()->goto('/test/element-tests');

    $page->waitForSelector('[data-testid="focus-target"]');

    $input = $page->locator('[data-testid="focus-target"]')->elementHandle();
    $input->focus();

    $page->waitForSelector('[data-testid="focus-display"]:text("Last focused: focus-target")');
    expect($page->textContent('[data-testid="focus-display"]'))->toBe('Last focused: focus-target');

    $input->type('typing in focused element');
    expect($page->inputValue('[data-testid="focus-target"]'))->toBe('typing in focused element');
});
