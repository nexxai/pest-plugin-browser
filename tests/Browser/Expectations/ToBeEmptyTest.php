<?php

declare(strict_types=1);

it('passes when element is empty', function (): void {
    $page = page()->goto('/test/form-inputs');

    expect($page->locator('#empty-element'))->toBeEmpty();
});
