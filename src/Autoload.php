<?php

declare(strict_types=1);

use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Browsable;
use Pest\Plugin;

Plugin::uses(Browsable::class);

if (! function_exists('visit')) {
    /**
     * Browse to the given URL.
     *
     * @param  array<string, mixed>  $options
     */
    function visit(string $url, array $options = []): PendingAwaitablePage
    {
        return test()->visit($url, $options);
    }
}
