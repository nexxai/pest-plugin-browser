<?php

declare(strict_types=1);

it('throws an expectation failed exception when the element is not visible', function (): void {
    $page = page()->goto('/test/element-tests');

    $locator = $page->locator('input[name="404"]');

    $locator->waitFor();
});
