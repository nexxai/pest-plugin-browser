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
                accessibilityViolations: []
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

            import('https://unpkg.com/agnostic-axe@3').then(
              ({ AxeObserver, logViolations }) => {
                const MyAxeObserver = new AxeObserver((violations) => {
                    window.__pestBrowser.accessibilityViolations.push(...violations)
                })
                MyAxeObserver.observe(document)
              }
            )
            JS;
    }
}
