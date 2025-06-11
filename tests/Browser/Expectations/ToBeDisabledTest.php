<?php

declare(strict_types=1);

it('passes when input is disabled', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="disabled-input"]'))->toBeDisabled();
});

it('passes when button is disabled', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('button[name="disabled-button"]'))->toBeDisabled();
});

it('passes when checkbox is disabled', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="disabled-checkbox"]'))->toBeDisabled();
});
