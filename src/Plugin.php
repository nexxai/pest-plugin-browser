<?php

declare(strict_types=1);

namespace Pest\Browser;

use Illuminate\Routing\UrlGenerator;
use Pest\Browser\Playwright\Client;
use Pest\Browser\Playwright\Playwright;
use Pest\Browser\Support\Screenshot;
use Pest\Contracts\Plugins\Bootable;
use Pest\Contracts\Plugins\Terminable;
use Pest\Plugins\Parallel;
use Pest\TestSuite;

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

        if (Parallel::isWorker() === false) {
            ServerManager::instance()->playwright()->start();

            Screenshot::cleanup();
        }

        if (Parallel::isWorker() || Parallel::isEnabled() === false) {
            Client::instance()->connectTo(
                ServerManager::instance()->playwright()->url(),
            );

            ServerManager::instance()->http()->start();
        }

        pest()->beforeEach(function (): void {
            $url = ServerManager::instance()->http()->url();

            config(['app.url' => $url]);

            if (app()->bound('url')) {
                $urlGenerator = app('url');

                assert($urlGenerator instanceof UrlGenerator);

                $urlGenerator->useOrigin($url);
            }
        })->in($this->in());

        pest()->afterEach(function (): void {
            Playwright::reset();

            ServerManager::instance()->http()->flush();
        })->in($this->in());
    }

    /**
     * Terminates the plugin.
     */
    public function terminate(): void
    {
        if ($this->usesPlugin === false) {
            return;
        }

        if (Parallel::isWorker() || Parallel::isEnabled() === false) {
            ServerManager::instance()->http()->stop();
        }

        if (Parallel::isWorker() === false) {
            ServerManager::instance()->playwright()->stop();
        }
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
     * Returns the path where the test files are located.
     */
    private function in(): string
    {
        return TestSuite::getInstance()->rootPath.DIRECTORY_SEPARATOR.TestSuite::getInstance()->testPath;
    }
}
