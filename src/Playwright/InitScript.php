<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

/**
 * @internal
 */
final class InitScript
{
    /**
     * Get the JavaScript code for the initialization script.
     */
    public static function get(): string
    {
        return <<<'JS'
            window.__pestBrowser = {
                jsErrors: [],
                consoleLogs: [],
                brokenImages: []
            };

            const originalConsoleLog = console.log;
            console.log = function(...args) {
                window.__pestBrowser.consoleLogs.push({
                    timestamp: new Date().getTime(),
                    message: args.map(arg => String(arg)).join(' ')
                });
                originalConsoleLog.apply(console, args);
            };

            window.addEventListener('error', (e) => {
                window.__pestBrowser.jsErrors.push({
                    message: e.message,
                    filename: e.filename,
                    lineno: e.lineno,
                    colno: e.colno
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                const images = Array.from(document.images);
                window.__pestBrowser.brokenImages = images.filter(img => !img.complete || img.naturalWidth === 0).map(img => img.src);
            });
            JS;
    }
}
