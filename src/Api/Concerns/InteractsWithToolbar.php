<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;

/**
 * @mixin Webpage
 */
trait InteractsWithToolbar
{
    /**
     * Reloads the current page.
     */
    public function refresh(): self
    {
        $this->page->reload();

        return $this;
    }
}
