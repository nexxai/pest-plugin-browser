<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when element has the expected id', function (): void {
    $page = $this->page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->toHaveId('default-checkbox');
});

it('fails when element does not have the expected id', function (): void {
    $page = $this->page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->toHaveId('some-other-id');
})->throws(ExpectationFailedException::class);

it('passes when element does not have the id and we expect it not to', function (): void {
    $page = $this->page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->not->toHaveId('some-other-id');
});

it('fails when element has the id but we expect it not to', function (): void {
    $page = $this->page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->not->toHaveId('default-checkbox');
})->throws(ExpectationFailedException::class);
