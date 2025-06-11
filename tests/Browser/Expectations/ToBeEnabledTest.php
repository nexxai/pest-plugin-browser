<?php

declare(strict_types=1);

it('passes when input is enabled', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="enabled-input"]'))->toBeEnabled();
});

it('passes when button is enabled', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('button[name="enabled-button"]'))->toBeEnabled();
});
