<?php

declare(strict_types=1);

namespace Pest\Browser\Drivers\Laravel;

use Pest\Browser\Playwright\BrowserState;

/**
 * @internal
 */
final readonly class Autoload
{
    /**
     * Bootstraps the autoloading process.
     */
    public static function boot(): void
    {
        BrowserState::unpackFromHeaders();
    }
}
