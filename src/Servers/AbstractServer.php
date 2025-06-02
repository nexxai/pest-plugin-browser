<?php

declare(strict_types=1);

namespace Pest\Browser\Servers;

use Pest\Browser\Contracts\Server;

/**
 * @internal
 */
abstract class AbstractServer // @pest-arch-ignore-line
{
    /**
     * Returns the URL of the server.
     */
    abstract public function url(): string;

    /**
     * Starts the server.
     */
    abstract public function start(): void;

    /**
     * Terminates the server.
     */
    abstract public function terminate(): void;
}
