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
     */
    public function page(?string $url = null): Page
    {
        return page($url);
    }
}
