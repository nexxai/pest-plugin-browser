<?php

declare(strict_types=1);

it('returns a successful response', function () {
    $page = page()->goto(route('database'));

    expect($page->locator('h1'))->toHaveText()('Nunonation Database');
});
