<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when element has the expected value', function (): void {
    $page = page()->goto('/test/form-inputs');
    expect($page->locator('input[name="email"]'))->toHaveValue('john.doe@pestphp.com');
});

it('fails when element does not have the expected value', function (): void {
    $page = page()->goto('/test/form-inputs');
    expect($page->locator('input[name="email"]'))->toHaveValue('wrong@email.com');
})->throws(ExpectationFailedException::class);

it('passes when element does not have the value and we expect it not to', function (): void {
    $page = page()->goto('/test/form-inputs');
    expect($page->locator('input[name="email"]'))->not->toHaveValue('wrong@email.com');
});

it('fails when element has the value but we expect it not to', function (): void {
    $page = page()->goto('/test/form-inputs');
    expect($page->locator('input[name="email"]'))->not->toHaveValue('john.doe@pestphp.com');
})->throws(ExpectationFailedException::class);
