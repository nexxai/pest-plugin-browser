<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use PHPUnit\Util\GlobalState;

/**
 * @internal
 *
 * @todo Ensure this code can't ever be executed in a web context...
 */
final class BrowserState
{
    /**
     * Packs the current server's global state into a JSON string.
     */
    public static function packAsString(): string
    {
        return json_encode([
            'globals' => GlobalState::getGlobalsAsString(),
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * Unpacks the global state from a JSON string.
     */
    public static function unpackFromHeaders(): void
    {
        /** @var array{ globals?: string } $headers */
        $headers = json_decode(
            isset($_SERVER['HTTP_X_PEST_PLUGIN_BROWSER']) && is_string($_SERVER['HTTP_X_PEST_PLUGIN_BROWSER'])
                ? $_SERVER['HTTP_X_PEST_PLUGIN_BROWSER']
                : '',
            true,
        );

        if (isset($headers['globals'])) {
            eval($headers['globals']);

            unset($_SERVER['HTTP_X_PEST_PLUGIN_BROWSER']);
        }
    }
}
