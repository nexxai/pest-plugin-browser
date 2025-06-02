<?php

declare(strict_types=1);

namespace Pest\Browser;

use Pest\Browser\Exceptions\ServerNotFoundException;
use Pest\Browser\Servers\AbstractServer;
use Pest\Browser\Servers\ArtisanServer;

/**
 * @internal
 */
final class ServerManager
{
    /**
     * The singleton instance of the server manager.
     */
    private static ?ServerManager $instance = null;

    /**
     * The server instance already in use by this process.
     */
    private ?AbstractServer $server = null;

    /**
     * Gets the singleton instance of the server manager.
     */
    public static function instance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * Returns the server instance based on the environment.
     *
     * @throws ServerNotFoundException
     */
    public function resolve(): AbstractServer
    {
        if ($this->server instanceof AbstractServer) {
            return $this->server;
        }

        return $this->server = match (true) {
            // laravel...
            function_exists('app_path') => new ArtisanServer(app_path()),

            // playground...
            file_exists(__DIR__.'/../playground/artisan') => new ArtisanServer(__DIR__.'/../playground'),

            // no server found...
            default => throw new ServerNotFoundException('No server found for the current environment.'),
        };
    }

    /**
     * Terminates the server if it started.
     */
    public function terminate(): void
    {
        if ($this->server instanceof AbstractServer) {
            $this->server->terminate();

            $this->server = null;
        }
    }
}
