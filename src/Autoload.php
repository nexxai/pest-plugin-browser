<?php

declare(strict_types=1);

use Pest\Browser\Api\ArrayablePendingAwaitablePage;
use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Browsable;
use Pest\Plugin;

Plugin::uses(Browsable::class);

if (! function_exists('visit')) {
    /**
     * Browse to the given URL.
     *
     * @template TUrl of array<int, string>|string
     *
     * @param  TUrl  $url
     * @param  array<string, mixed>  $options
     * @return (TUrl is array<int, string> ? ArrayablePendingAwaitablePage : PendingAwaitablePage)
     */
    function visit(array|string $url, array $options = []): ArrayablePendingAwaitablePage|PendingAwaitablePage
    {
        return test()->visit($url, $options);
    }
}
