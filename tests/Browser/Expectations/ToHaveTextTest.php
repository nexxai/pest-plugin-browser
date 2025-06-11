<?php

declare(strict_types=1);

it('may have a title', function (): void {
    $page = page()->goto('/');

    $locator = $page->locator('h3');

    expect($locator)->toHaveText('Pest is a testing');
});

it('may not have a title', function (): void {
    $page = page()->goto('/');

    $locator = $page->locator('h3');

    expect($locator)->not->toHaveText('PhpUnit is a testing framework');
});
