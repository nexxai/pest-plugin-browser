<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use Pest\Browser\Support\Port;
use Symfony\Component\Process\Process;

/**
 * @internal
 */
final class Server
{
    private const string DEFAULT_HOST = '127.0.0.1';

    /**
     * Playwright server process.
     */
    private ?Process $process = null;

    /**
     * Server instance.
     */
    private static ?Server $instance = null;

    /**
     * Constructs new server instance.
     */
    public function __construct(
        private readonly string $host,
        private readonly int $port
    ) {
        //
    }

    /**
     * Returns the server instance.
     */
    public static function instance(): self
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self(
                self::DEFAULT_HOST,
                Port::findAvailable(self::DEFAULT_HOST, 9357, 9800),
            );
        }

        return self::$instance;
    }

    /**
     * Starts the Playwright server.
     */
    public function start(): void
    {
        if ($this->isRunning()) {
            return;
        }

        $this->process = new Process([
            'npx',
            'playwright',
            'run-server',
            '--host',
            $this->host,
            '--port',
            $this->port,
        ]);

        $this->process->start();

        $this->process->waitUntil(
            fn (string $type, string $output): bool => $output === "Listening on {$this->url()}\n"
        );
    }

    /**
     * Checks if the specified port is free for use.
     */
    public function isRunning(): bool
    {
        return $this->process?->isRunning() === true;
    }

    /**
     * Stops the Playwright server.
     */
    public function stop(): void
    {
        if ($this->isRunning()) {
            $this->process->stop(5, SIGTERM);

            $this->process = null;
        }
    }

    /**
     * Returns the URL of the Playwright server.
     */
    public function url(string $query = ''): string
    {
        return sprintf('ws://%s:%s/%s', self::DEFAULT_HOST, $this->port, $query);
    }
}
