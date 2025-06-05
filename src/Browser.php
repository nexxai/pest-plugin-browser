<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Browser\Playwright\Page;

/**
 * @internal
 */
trait Browser
{
    /**
     * gets the page instance for given URL.
     *
     * @param  string|null  $url  The URL to visit
     * @param  array<string, mixed>  $options  Options for the page, e.g. ['hasTouch' => true]
     */
    public function page(?string $url = null, array $options = []): Page
    {
        return page($url, $options);
    }
}
