<?php

declare(strict_types=1);

it('can get text content', function (): void {
    $page = page()->goto('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    expect($element->textContent())->toContain('Profile Section');
});

it('can get text content as empty string when no content', function (): void {
    $page = page()->goto('/test/element-tests');
    $element = $page->locator('#empty-id');

    expect($element->textContent())->toBe('');
});
