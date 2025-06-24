<?php

declare(strict_types=1);

namespace Pest\Browser\Api;

use Pest\Browser\Playwright\Page;

final readonly class Webpage
{
    use Concerns\MakesAssertions;

    /**
     * The page instance.
     */
    public function __construct(
        private Page $page,
    ) {
        //
    }
}
