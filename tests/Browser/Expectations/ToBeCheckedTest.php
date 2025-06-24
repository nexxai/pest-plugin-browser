<?php

declare(strict_types=1);

it('passes if checkbox is checked', function (): void {
    $page = page('/test/form-inputs');

    expect($page->locator('input[name="checked-checkbox"]'))->toBeChecked();
});
