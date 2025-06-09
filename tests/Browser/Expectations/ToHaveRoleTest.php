<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('passes when element has the expected role', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    expect($page->getByTestId('enabled-button'))->toHaveRole('button');
});

it('fails when element does not have the expected role', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $containerLocator = $page->getByTestId('enabled-button');
    $container = $containerLocator->elementHandle();
    expect($container)->toHaveRole('checkbox');
})->throws(ExpectationFailedException::class);

it('passes when element does not have the role and we expect it not to', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $containerLocator = $page->getByTestId('enabled-button');
    $container = $containerLocator->elementHandle();
    expect($container)->not->toHaveRole('checkbox');
});

it('fails when element has the role but we expect it not to', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    expect($page->getByTestId('enabled-button'))->not->toHaveRole('button');
})->throws(ExpectationFailedException::class);
