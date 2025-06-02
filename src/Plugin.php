<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Browser\Playwright\Server;
use Pest\Contracts\Plugins\Terminable;

/**
 * @internal
 */
final readonly class Plugin implements Terminable
{
    /**
     * Terminates the plugin.
     */
    public function terminate(): void
    {
        ServerManager::instance()->terminate();

        Server::instance()->stop();
    }
}
