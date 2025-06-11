<?php

declare(strict_types=1);

it('passes when element is visible', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="visible"]'))->toBeVisible();
});
