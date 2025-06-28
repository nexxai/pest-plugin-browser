<?php

declare(strict_types=1);

namespace Pest\Browser\Drivers\Laravel;

use Pest\Browser\Contracts\HttpServer;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
final class NullableHttpServer implements HttpServer
{
    /**
     * Rewrite the given URL to match the server's host and port.
     */
    public function rewrite(string $url): string
    {
        return $url;
    }

    /**
     * Start the server and listen for incoming connections.
     */
    public function start(): void
    {
        //
    }

    /**
     * Stop the server and close all connections.
     */
    public function stop(): void
    {
        //
    }

    /**
     * Flush pending requests and close all connections.
     */
    public function flush(): void
    {
        //
    }

    /**
     * Bootstrap the server.
     */
    public function bootstrap(): void
    {
        //
    }
}
