<?php

declare(strict_types=1);

namespace Pest\Browser\Api;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Pest\Browser\Playwright\Playwright;
use Traversable;

/**
 * @internal
 *
 * @implements IteratorAggregate<int, PendingAwaitablePage>
 */
final class MultiBrowserPendingPage implements Countable, IteratorAggregate
{
    /**
     * @param  array<int, PendingAwaitablePage>  $pendingPages
     */
    public function __construct(
        private array $pendingPages,
    ) {
        //
    }

    /**
     * Forward method calls to all pending pages for configuration.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): self
    {
        foreach ($this->pendingPages as $pendingPage) {
            $pendingPage->{$name}(...$arguments); // @phpstan-ignore-line
        }

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->pendingPages);
    }

    public function count(): int
    {
        return count($this->pendingPages);
    }

    /**
     * Execute a callback on each browser sequentially.
     * Each browser is closed before switching to the next.
     * If any browser fails, the exception is thrown immediately.
     *
     * @param  callable(PendingAwaitablePage): mixed  $callback
     */
    public function each(callable $callback): self
    {
        $previousBrowserType = Playwright::defaultBrowserType();

        try {
            foreach ($this->pendingPages as $pendingPage) {
                $browserType = $pendingPage->getBrowserType();

                Playwright::closeOthers($browserType);
                Playwright::setDefaultBrowserType($browserType);

                $callback($pendingPage);
            }
        } finally {
            Playwright::setDefaultBrowserType($previousBrowserType);
        }

        return $this;
    }

    /**
     * Execute a callback and get results from each browser.
     * If any browser fails, the exception is thrown immediately.
     *
     * @param  callable(PendingAwaitablePage): mixed  $callback
     * @return array<int, mixed>
     */
    public function eachResult(callable $callback): array
    {
        $results = [];
        $previousBrowserType = Playwright::defaultBrowserType();

        try {
            foreach ($this->pendingPages as $pendingPage) {
                $browserType = $pendingPage->getBrowserType();

                Playwright::closeOthers($browserType);
                Playwright::setDefaultBrowserType($browserType);

                $results[] = $callback($pendingPage);
            }
        } finally {
            Playwright::setDefaultBrowserType($previousBrowserType);
        }

        return $results;
    }
}
