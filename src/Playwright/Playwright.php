<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use Pest\Browser\Enums\BrowserType;
use Pest\Browser\Enums\ColorScheme;

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
     * Whether to show the diff on screenshot assertions.
     */
    private static bool $shouldDiffOnScreenshotAssertions = false;

    /**
     * The default browser type.
     */
    private static BrowserType $defaultBrowserType = BrowserType::CHROME;

    /**
     * The default color scheme.
     */
    private static ColorScheme $defaultColorScheme = ColorScheme::LIGHT;

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
     * Set the default color scheme.
     */
    public static function setColorScheme(ColorScheme $colorScheme): void
    {
        self::$defaultColorScheme = $colorScheme;
    }

    /**
     * Get the default color scheme.
     */
    public static function defaultColorScheme(): ColorScheme
    {
        return self::$defaultColorScheme;
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
                );
            }
        }

        return self::$browserTypes[$browser];
    }
}
