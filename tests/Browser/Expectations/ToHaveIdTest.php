<?php

declare(strict_types=1);

it('passes when element has the expected id', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="default-checkbox"]'))->toHaveId('default-checkbox');
});
