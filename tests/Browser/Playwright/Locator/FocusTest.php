<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('focuses on elements and triggers focus state changes', function (): void {
    $page = page()->goto('/test/element-tests');
    $focusTarget = $page->locator('#focus-target');
    $focusTarget->waitFor();

    expect($page->textContent('#focus-display'))->toBe('No element focused yet');

    $focusTarget->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: focus-target');
    expect($focusTarget->isVisible())->toBeTrue();
});

it('focuses on multiple elements and tracks state changes', function (): void {
    $page = page()->goto('/test/element-tests');
    $usernameInput = $page->locator('#username');
    $usernameInput->waitFor();

    expect($page->textContent('#focus-display'))->toBe('No element focused yet');

    $usernameInput->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: username');

    $passwordInput = $page->locator('#password');
    $passwordInput->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: password');

    $commentsTextarea = $page->locator('#comments');
    $commentsTextarea->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: comments');
});

it('focuses on keyboard input and verifies focus', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: search');

    $searchInput->type('test typing');
    expect($searchInput->inputValue())->toBe('test typing');
});

it('can focus on locator instance', function (): void {
    $page = page()->goto('/test/element-tests');
    $focusTarget = $page->locator('#focus-target');

    expect($focusTarget)->toBeInstanceOf(Locator::class);

    $focusTarget->waitFor();
    $focusTarget->focus();

    expect($page->textContent('#focus-display'))->toBe('Last focused: focus-target');
});
