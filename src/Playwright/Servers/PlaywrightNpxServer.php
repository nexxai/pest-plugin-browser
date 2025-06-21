<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright\Servers;

use Pest\Browser\Contracts\PlaywrightServer;
use RuntimeException;
use Symfony\Component\Process\Process as SystemProcess;

/**
 * @internal
 *
 * @codeCoverageIgnore This class is used at plugin level to manage processes.
 */
final class PlaywrightNpxServer implements PlaywrightServer
{
    /**
     * The underlying process instance, if any.
     */
    private ?SystemProcess $systemProcess = null;

    /**
     * Creates a new process instance.
     */
    private function __construct(
        public readonly string $baseDirectory,
        public readonly string $command,
        public readonly string $host,
        public readonly int $port,
        public readonly string $until,
    ) {
        //
    }

    /**
     * Creates a new process instance with the given parameters.
     */
    public static function create(string $baseDirectory, string $command, string $host, int $port, string $until): self
    {
        return new self(
            $baseDirectory, $command, $host, 8077, $until
        );
    }

    /**
     * Starts the process until the given "output" condition is met.
     */
    public function start(): void
    {
        if ($this->isRunning()) {
            return;
        }

        $this->systemProcess = SystemProcess::fromShellCommandline(sprintf(
            $this->command,
            $this->host,
            $this->port,
        ), $this->baseDirectory, [
            'APP_URL' => sprintf('http://%s:%d', $this->host, $this->port),
        ]);

        $this->systemProcess->setTimeout(0);

        $this->systemProcess->start();

        $this->systemProcess->waitUntil(
            function (string $type, string $output): bool {
                // output:
                var_dump($output);

                return str_contains($output, $this->until);
            }
        );

        sleep(10);

        if (! $this->isRunning()) {
            // output all:
            var_dump($this->systemProcess->getOutput());

            throw new RuntimeException(
                sprintf('The process with arguments [%s] did not start successfully.', json_encode([
                    'baseDirectory' => $this->baseDirectory,
                    'command' => $this->command,
                    'host' => $this->host,
                    'port' => $this->port,
                    'until' => $this->until,
                ]),
                ));
        }
    }

    /**
     * Stops the process if it is running.
     */
    public function stop(): void
    {
        if ($this->systemProcess instanceof SystemProcess && $this->isRunning()) {
            $this->systemProcess->stop(
                5,
                defined('SIGTERM') ? SIGTERM : null,
            );
        }

        $this->systemProcess = null;
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
        if (! $this->isRunning()) {
            throw new RuntimeException(
                sprintf('The process with arguments [%s] is not running or has stopped unexpectedly.', json_encode([
                    'baseDirectory' => $this->baseDirectory,
                    'command' => $this->command,
                    'host' => $this->host,
                    'port' => $this->port,
                    'until' => $this->until,
                ]),
                ));
        }

        return sprintf('%s:%d', $this->host, $this->port);
    }

    /**
     * Checks
     */
    private function isRunning(): bool
    {
        return $this->systemProcess instanceof SystemProcess
            && $this->systemProcess->isRunning();
    }
}
