<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when element has the expected class', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->toHaveClass('check-class');
});

it('fails when element does not have the expected class', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->toHaveClass('some-other-class');
})->throws(ExpectationFailedException::class);

it('passes when element does not have the class and we expect it not to', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->not->toHaveClass('some-other-class');
});

it('fails when element has the class but we expect it not to', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->not->toHaveClass('check-class');
})->throws(ExpectationFailedException::class);
