<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when has the expected role', function (): void {
    $page = $this->page()->goto('/test/element-tests');

    expect($page->getByTestId('enabled-button'))->toHaveRole('button');
});

it('fails when has the role but we expect it not to', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    expect($page->getByTestId('enabled-button'))->not->toHaveRole('button');
})->throws(ExpectationFailedException::class);
