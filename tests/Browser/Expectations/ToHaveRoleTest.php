<?php

declare(strict_types=1);

it('passes when has the expected role', function (): void {
    $page = page()->goto('/test/element-tests');

    expect($page->getByTestId('enabled-button'))->toHaveRole('button');
});
