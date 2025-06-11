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
