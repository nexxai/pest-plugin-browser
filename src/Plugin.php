<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Browser\Exceptions\BrowserNotSupportedException;
use Pest\Browser\Filters\UsesBrowserTestCaseMethodFilter;
use Pest\Browser\Playwright\Enums\BrowserType;
use Pest\Browser\Playwright\Playwright;
use Pest\Contracts\Plugins\Bootable;
use Pest\Contracts\Plugins\HandlesArguments;
use Pest\Contracts\Plugins\Terminable;
use Pest\Plugins\Concerns\HandleArguments;
use Pest\Plugins\Parallel;
use Pest\TestSuite;

/**
 * @internal
 */
final class Plugin implements Bootable, HandlesArguments, Terminable // @pest-arch-ignore-line
{
    use HandleArguments;

    /**
     * Indicates whether the plugin has been booted.
     */
    public static bool $booted = false;

    /**
     * Boots the plugin.
     */
    public function boot(): void
    {
        TestSuite::getInstance()
            ->tests
            ->addTestCaseMethodFilter(new UsesBrowserTestCaseMethodFilter());

        pest()->afterEach(function (): void {
            ServerManager::instance()->http()->flush();

            Playwright::reset();
        })->in($this->in());
    }

    /**
     * Handles the arguments passed to the plugin.
     *
     * @param  array<int, string>  $arguments}
     */
    public function handleArguments(array $arguments): array
    {
        if ($this->hasArgument('--headed', $arguments)) {
            Playwright::headed();

            $arguments = $this->popArgument('--headed', $arguments);
        }

        if ($this->hasArgument('--browser', $arguments)) {
            $index = array_search('--browser', $arguments, true);

            if ($index === false || ! isset($arguments[$index + 1])) {
                throw new BrowserNotSupportedException(
                    'The "--browser" argument requires a value. Usage: --browser <browser-type> (e.g., chrome, firefox, webkit).'
                );
            }

            $browser = $arguments[$index + 1];

            if (($browser = BrowserType::tryFrom($browser)) === null) {
                throw new BrowserNotSupportedException(
                    'The specified browser type is not supported. Supported types are: '.
                    implode(', ', array_map(fn (BrowserType $type): string => mb_strtolower($type->name), BrowserType::cases()))
                );
            }

            Playwright::defaultTo($browser);

            unset($arguments[$index], $arguments[$index + 1]);

            $arguments = array_values($arguments);
        }

        return $arguments;
    }

    /**
     * Terminates the plugin.
     */
    public function terminate(): void
    {
        if (Parallel::isWorker() || Parallel::isEnabled() === false) {
            ServerManager::instance()->http()->stop();

            Playwright::close();
        }

        if (Parallel::isWorker() === false) {
            ServerManager::instance()->playwright()->stop();
        }
    }

    /**
     * Returns the path where the test files are located.
     */
    private function in(): string
    {
        return TestSuite::getInstance()->rootPath.DIRECTORY_SEPARATOR.TestSuite::getInstance()->testPath;
    }
}
