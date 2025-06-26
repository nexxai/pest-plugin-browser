<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Support\Container;
use React\EventLoop\Loop;
use React\Stream\ReadableResourceStream;
use Symfony\Component\Console\Output\OutputInterface;

use function React\Async\async;
use function React\Async\await;
use function React\Promise\Timer\sleep;

/**
 * @internal
 */
final class Execution
{
    /**
     * Either the current context
     */
    private bool $waiting = false;

    /**
     * The current context instance, or null if not set.
     */
    private static ?Execution $instance = null;

    /**
     * Creates a new context instance.
     */
    public static function instance(): self
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Pauses the execution.
     */
    public function wait(int|float $seconds = 1): void
    {
        $this->waiting = true;

        try {
            Loop::get()->futureTick(async(function () use ($seconds): void {
                await(sleep($seconds));

                Loop::stop();
            }));

            Loop::run();
        } finally {
            $this->waiting = false;
        }
    }

    /**
     * Checks if the execution is paused.
     */
    public function isWaiting(): bool
    {
        return $this->waiting;
    }

    /**
     * Ticks the execution.
     */
    public function tick(): void
    {
        Loop::get()->futureTick(async(function (): void {
            if ($this->waiting) {
                return;
            }

            Loop::stop();
        }));

        Loop::run();
    }

    /**
     * Waits for a key press.
     */
    public function waitForKey(): void
    {
        $this->waiting = true;

        Loop::get()->futureTick(async(function (): void {
            $loop = Loop::get();

            // @phpstan-ignore-next-line
            Container::getInstance()->get(OutputInterface::class)->writeln(
                '<info>Press any key to continue...</info>'
            );

            $stdin = new ReadableResourceStream(STDIN, $loop);

            $stdin->on('data', function () use ($stdin, $loop) {
                $this->waiting = false;

                $stdin->close();
                $loop->stop();
            });
        }));

        $this->tick();
    }
}
