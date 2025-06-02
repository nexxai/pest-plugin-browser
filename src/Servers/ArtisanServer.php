<?php

declare(strict_types=1);

namespace Pest\Browser\Servers;

use Pest\Browser\Contracts\Server;
use Pest\Browser\Support\Port;
use RuntimeException;
use Symfony\Component\Process\Process;

/**
 * @internal
 */
final class ArtisanServer extends AbstractServer // @pest-arch-ignore-line
{
    /**
     * The server's host.
     */
    private const string HOST = '127.0.0.1';

    /**
     * The server's process.
     */
    private ?Process $process = null;

    /**
     * The server's port.
     */
    private ?int $port = null;

    public function __construct(private readonly string $baseDirectory)
    {
        //
    }

    /**
     * Stars the Laravel server.
     */
    public function start(): void
    {
        if ($this->process instanceof Process) {
            return;
        }

        $this->port = Port::findAvailable(self::HOST, 8010, 9000);

        $this->process = $process = Process::fromShellCommandline(
            'php artisan serve --host='.self::HOST.' --port='.$this->port,
            $this->baseDirectory,
        );

        $process->setTimeout(0);
        $process->start();

        $process->waitUntil(
            fn (string $type, string $output): bool => str_contains($output, 'Server running on'),
        );
    }

    /**
     * Terminates the server.
     */
    public function terminate(): void
    {
        if ($this->process instanceof Process) {
            $this->process->stop(5, SIGTERM);

            $this->process = null;
            $this->port = null;
        }
    }

    /**
     * Returns the URL of the server.
     *
     * @throws RuntimeException If the server has not been started yet.
     */
    public function url(): string
    {
        if ($this->port === null || ! $this->process instanceof Process) {
            throw new RuntimeException('The server has not been started yet.');
        }

        if ($this->process->isRunning() === false) {
            throw new RuntimeException('The server stopped unexpectedly.');
        }

        return 'http://'.self::HOST.':'.$this->port;
    }
}
