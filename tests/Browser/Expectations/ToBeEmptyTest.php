<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when element is empty', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('#empty-element'))->toBeEmpty();
});

it('fails when element is not empty', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('label[for="email"]'))->toBeEmpty();
})->throws(ExpectationFailedException::class);

it('passes when element is not empty and we expect it not to be', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('label[for="email"]'))->not->toBeEmpty();
});

it('fails when element is empty but we expect it not to be', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('#empty-element'))->not->toBeEmpty();
})->throws(ExpectationFailedException::class);
