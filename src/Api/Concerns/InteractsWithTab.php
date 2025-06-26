<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;
use Pest\Browser\Execution;

/**
 * @mixin Webpage
 */
trait InteractsWithTab
{
    /**
     * Opens the current page URL in the default web browser and waits for a key press.
     *
     * This method is useful for debugging purposes, allowing you to view the page in a browser.
     */
    public function waitForKey(): self
    {
        $this->page->waitForLoadState();

        Execution::instance()->waitForKey();

        return $this;
    }
}
