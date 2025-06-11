<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;

it('can hover over elements and trigger hover state changes', function (): void {
    $page = page()->goto('/test/element-tests');
    $hoverTarget = $page->locator('#hover-target');
    $hoverTarget->waitFor();

    expect($page->textContent('#hover-display'))->toBe('No element hovered yet');

    $hoverTarget->hover();
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
    expect($hoverTarget->isVisible())->toBeTrue();
});

it('can hover over multiple elements and track state changes', function (): void {
    $page = page()->goto('/test/element-tests');
    $hoverTarget = $page->locator('#hover-target');

    $hoverTarget->waitFor();

    expect($page->textContent('#hover-display'))->toBe('No element hovered yet');

    $hoverTarget->hover();
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');

    // Hover over the same element again to verify it still works
    $hoverTarget->hover();
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('can hover over buttons and verify visibility', function (): void {
    $page = page()->goto('/test/element-tests');
    $enabledButton = $page->locator('[data-testid="enabled-button"]');
    $enabledButton->waitFor();

    expect($enabledButton->isVisible())->toBeTrue();

    $enabledButton->hover();
    expect($enabledButton->isVisible())->toBeTrue();
});

it('can hover over profile section', function (): void {
    $page = page()->goto('/test/element-tests');
    $profileSection = $page->locator('[data-testid="profile-section"]');

    $profileSection->waitFor();
    expect($profileSection->isVisible())->toBeTrue();

    $profileSection->hover();
    expect($profileSection->isVisible())->toBeTrue();
});

it('can hover over form elements', function (): void {
    $page = page()->goto('/test/element-tests');
    $usernameInput = $page->locator('#username');
    $passwordInput = $page->locator('#password');

    $usernameInput->waitFor();
    $passwordInput->waitFor();

    $usernameInput->hover();
    expect($usernameInput->isVisible())->toBeTrue();

    $passwordInput->hover();
    expect($passwordInput->isVisible())->toBeTrue();
});

it('can hover on locator instance', function (): void {
    $page = page()->goto('/test/element-tests');
    $hoverTarget = $page->locator('#hover-target');

    expect($hoverTarget)->toBeInstanceOf(Locator::class);

    $hoverTarget->waitFor();
    expect($page->textContent('#hover-display'))->toBe('No element hovered yet');

    $hoverTarget->hover();
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});
