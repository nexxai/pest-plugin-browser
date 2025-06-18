<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Browser\Playwright\Client;
use Pest\Browser\Support\Screenshot;
use Pest\Contracts\Plugins\Bootable;
use Pest\Contracts\Plugins\Terminable;
use Pest\Plugins\Parallel;

/**
 * @internal
 */
final class Plugin implements Bootable, Terminable // @pest-arch-ignore-line
{
    /**
     * Indicates whether the plugin is used in the current test suite.
     */
    private bool $usesPlugin = false;

    /**
     * Boots the plugin.
     */
    public function boot(): void
    {
        if (($this->usesPlugin = $this->usesPlugin()) === false) {
            return;
        }

        $this->ensureSqliteDatabaseIsTouched();

        if (Parallel::isWorker() === false) {
            ServerManager::instance()->playwright()->start();

            Screenshot::cleanup();
        }

        Client::instance()->connectTo(
            '127.0.0.1:8077/?browser=chromium',
        );

        if (Parallel::isEnabled() === false || Parallel::isWorker()) {
            $http = ServerManager::instance()->http();

            $http->start();

            $_ENV['APP_URL'] = "http://{$http->url()}";
        }
    }

    /**
     * Terminates the plugin.
     */
    public function terminate(): void
    {
        if ($this->usesPlugin === false) {
            return;
        }

        if (Parallel::isWorker() === false) {
            ServerManager::instance()->playwright()->stop();
        }

        ServerManager::instance()->http()->stop();
    }

    /**
     * Checks if the plugin is used in the current test suite.
     */
    private function usesPlugin(): bool
    {
        // check if any of the tests uses the page() function...

        return true;
    }

    /**
     * Ensures the SQLite database is touched.
     */
    private function ensureSqliteDatabaseIsTouched(): void
    {
        // todo...
    }
}
