<?php

declare(strict_types=1);

use Pest\Browser\Api\Webpage;
use Pest\Browser\Browsable;
use Pest\Plugin;

Plugin::uses(Browsable::class);

if (! function_exists('visit')) {
    /**
     * Browse to the given URL.
     *
     * @param  array<string, mixed>  $options
     */
    function visit(?string $url = null, array $options = []): Webpage
    {
        return test()->visit($url, $options);
    }
}
