<?php

declare(strict_types=1);

it('passes when input is editable', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('input[name="enabled-input"]'))->toBeEditable();
});
