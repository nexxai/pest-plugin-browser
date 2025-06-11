<?php

declare(strict_types=1);

it('can get attribute values', function (): void {
    $page = page()->goto('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    expect($element->getAttribute('data-testid'))->toBe('profile-section');
});

it('can get multiple attributes and handles null cases', function (): void {
    $page = page()->goto('/test/element-tests');
    $input = $page->getByLabel('Username');

    expect($input->getAttribute('type'))->toBe('text');
    expect($input->getAttribute('name'))->toBe('username');
    expect($input->getAttribute('nonexistent'))->toBeNull();
});
