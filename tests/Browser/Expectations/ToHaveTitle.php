<?php

declare(strict_types=1);

it('may have a title', function (): void {
    $page = page()->goto('/');

    expect($page)->toHaveTitle('Hi nunonation');
});

it('may not have a title', function (): void {
    $page = page()->goto('/');

    expect($page)->not->toHaveTitle('Hi nunonation 2');
});
