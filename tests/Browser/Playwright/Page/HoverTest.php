<?php

declare(strict_types=1);

it('hovers over elements and triggers hover state changes', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    expect($page->textContent('#hover-display'))->toBe('No element hovered yet');

    $page->hover('#hover-target');
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
    expect($page->isVisible('#hover-target'))->toBeTrue();
});

it('hovers over disabled elements with force parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#disabled-button');
    $page->hover('#disabled-button', force: true);
    expect($page->isEnabled('#disabled-button'))->toBeFalse();
});

it('hovers with position parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    $page->hover('#hover-target', position: ['x' => 10, 'y' => 10]);
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('hovers with modifiers parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    $page->hover('#hover-target', modifiers: ['Shift']);
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('hovers with noWaitAfter parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    $page->hover('#hover-target', noWaitAfter: true);
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('hovers with strict parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    $page->hover('#hover-target', strict: true);
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('hovers with timeout parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');
    $page->hover('#hover-target', timeout: 5000);
    expect($page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
});

it('hovers with trial parameter', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');

    $result = $page->hover('#hover-target', trial: true);
    expect($result)->toBe($page);
});
