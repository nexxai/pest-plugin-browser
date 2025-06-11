<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can press keys on input elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    $searchInput->press('KeyA');
    $searchInput->press('KeyB');
    $searchInput->press('KeyC');

    expect($searchInput->inputValue())->toBe('abc');
});

it('can press Enter key to submit forms', function (): void {
    $page = page()->goto('/test/element-tests');
    $usernameInput = $page->locator('#username');
    $usernameInput->waitFor();

    $usernameInput->focus();
    $usernameInput->press('Enter');

    expect($usernameInput)->toBeInstanceOf(Locator::class);
});

it('can press Tab key to navigate between elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $usernameInput = $page->locator('#username');
    $usernameInput->waitFor();

    $usernameInput->focus();
    expect($page->textContent('#focus-display'))->toBe('Last focused: username');

    $usernameInput->press('Tab');
    // After pressing Tab, focus should move to the next focusable element
    expect($usernameInput)->toBeInstanceOf(Locator::class);
});

it('can press Escape key', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    $searchInput->press('Escape');

    expect($searchInput->isVisible())->toBeTrue();
});

it('can press Backspace key to delete text', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    $searchInput->type('Hello');
    expect($searchInput->inputValue())->toBe('Hello');

    $searchInput->press('Backspace');
    expect($searchInput->inputValue())->toBe('Hell');
});

it('can press Delete key', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    $searchInput->type('Test');
    $searchInput->press('Home'); // Go to beginning
    $searchInput->press('Delete'); // Delete first character

    expect($searchInput->inputValue())->toBe('est');
});

it('can press arrow keys for navigation', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');
    $searchInput->waitFor();

    $searchInput->focus();
    $searchInput->type('Hello');
    $searchInput->press('ArrowLeft');
    $searchInput->press('ArrowLeft');
    $searchInput->type('X');

    expect($searchInput->inputValue())->toBe('HelXlo');
});

it('can press locator instance with key parameter', function (): void {
    $page = page()->goto('/test/element-tests');
    $searchInput = $page->locator('#search');

    expect($searchInput)->toBeInstanceOf(Locator::class);

    $searchInput->waitFor();
    $searchInput->focus();
    $searchInput->press('KeyT');
    $searchInput->press('KeyE');
    $searchInput->press('KeyS');
    $searchInput->press('KeyT');

    expect($searchInput->inputValue())->toBe('test');
});
