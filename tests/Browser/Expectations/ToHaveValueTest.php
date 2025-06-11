<?php

declare(strict_types=1);

it('passes when element has the expected value', function (): void {
    $page = page()->goto('/test/form-inputs');
    expect($page->locator('input[name="email"]'))->toHaveValue('john.doe@pestphp.com');
});
