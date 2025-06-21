<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright\Servers;

use Pest\Browser\Contracts\PlaywrightServer;
use RuntimeException;

/**
 * @internal
 */
final readonly class PlaywrightFakeServer implements PlaywrightServer
{
    /**
     * Creates a new process instance.
     */
    public function __construct(
        public string $host,
        public int $port,
    ) {
        //
    }

    /**
     * Starts the process until the given "output" condition is met.
     */
    public function start(): void
    {
        //
    }

    /**
     * Stops the process if it is running.
     */
    public function stop(): void
    {
        //
    }

    /**
     * Flushes the process.
     */
    public function flush(): void
    {
        //
    }

    /**
     * Returns the URL of the process.
     *
     * @throws RuntimeException If the process has not been started yet or has stopped unexpectedly.
     */
    public function url(): string
    {
        return sprintf('%s:%d', $this->host, $this->port);
    }
}
