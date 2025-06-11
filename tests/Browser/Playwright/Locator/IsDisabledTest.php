<?php

declare(strict_types=1);

it('returns false for enabled buttons', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->getByTestId('enabled-button');

    expect($locator->isDisabled())->toBeFalse();
});

it('returns true for disabled buttons', function (): void {
    $page = page()->goto('/test/element-tests');
    $locator = $page->getByTestId('disabled-button');

    expect($locator->isDisabled())->toBeTrue();
});
