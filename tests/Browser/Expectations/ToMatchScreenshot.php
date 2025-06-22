<?php

declare(strict_types=1);

it('does match a screenshot', function (): void {
    $page = page()->goto('/');

    expect($page)->toMatchScreenshot();
});
