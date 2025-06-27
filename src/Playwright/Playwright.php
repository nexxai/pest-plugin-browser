<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use Pest\Browser\Playwright\Enums\BrowserType;

/**
 * @internal
 */
final class Playwright
{
    /**
     * Browser types
     *
     * @var array<string, BrowserFactory>
     */
    private static array $browserTypes = [];

    /**
     * Whether to run browsers in headless mode.
     */
    private static bool $headless = true;

    /**
     * Whether to run browsers in dark mode.
     */
    private static bool $darkMode = false;

    /**
     * Whether to show the diff on screenshot assertions.
     */
    private static bool $shouldDiffOnScreenshotAssertions = true;

    /**
     * The default browser type.
     */
    private static BrowserType $defaultBrowserType = BrowserType::CHROME;

    /**
     * Get the default browser type.
     */
    public static function default(): BrowserFactory
    {
        $name = self::$defaultBrowserType->toPlaywrightName();

        return self::$browserTypes[$name] ?? self::initialize($name);
    }

    /**
     * Close all browser pages
     */
    public static function close(): void
    {
        foreach (self::$browserTypes as $browserType) {
            $browserType->close();
        }

        self::$browserTypes = [];
    }

    /**
     * Set playwright in non-headless mode.
     */
    public static function headed(): void
    {
        self::$headless = false;
    }

    /**
     * Set whether to show the diff on screenshot assertions.
     */
    public static function setShouldDiffOnScreenshotAssertions(): void
    {
        self::$shouldDiffOnScreenshotAssertions = true;
    }

    /**
     * Set whether to run in dark mode.
     */
    public static function darkMode(): void
    {
        self::$darkMode = true;
    }

    /**
     * Whether to show the diff on screenshot assertions.
     */
    public static function shouldShowDiffOnScreenshotAssertions(): bool
    {
        return self::$shouldDiffOnScreenshotAssertions;
    }

    /**
     * Reset playwright state, reset browser types, without closing them.
     */
    public static function reset(): void
    {
        foreach (self::$browserTypes as $browserType) {
            $browserType->reset();
        }
    }

    /**
     * Sets the default browser type.
     */
    public static function defaultTo(BrowserType $browserType): void
    {
        self::$defaultBrowserType = $browserType;
    }

    /**
     * Initialize Playwright
     */
    private static function initialize(string $browser): BrowserFactory
    {
        $response = Client::instance()->execute(
            '',
            'initialize',
            ['sdkLanguage' => 'javascript']
        );

        /** @var array{method: string|null, params: array{type: string|null, guid: string, initializer: array{name: string|null}}} $message */
        foreach ($response as $message) {
            if (
                isset($message['method'])
                && $message['method'] === '__create__'
                && isset($message['params']['type'])
                && $message['params']['type'] === 'BrowserType'
            ) {
                $name = $message['params']['initializer']['name'] ?? '';

                self::$browserTypes[$name] = new BrowserFactory(
                    $message['params']['guid'],
                    $name,
                    self::$headless,
                    self::$darkMode
                );
            }
        }

        return self::$browserTypes[$browser];
    }
}
