<?php

declare(strict_types=1);

use Pest\Browser\Api\On;
use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Api\Webpage;
use Pest\Browser\Enums\ColorScheme;

// grab all methods from PendingAwaitablePage
$reflection = new ReflectionClass(On::class);

$methods = array_map(
    fn (ReflectionMethod $method): string => $method->getName(),
    array_filter(
        $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
        fn (ReflectionMethod $method): bool => $method->getName() !== '__construct' && $method->getName() !== '__call',
    ),
);

it('may visit a page', function (string $method): void {
    Route::get('/', fn (): string => file_get_contents(
        fixture('responsive.html'),
    ));

    /** @var Webpage $page */
    $page = visit('/')->on()->{$method}();

    $page->assertSee('Experience elegance across every device.')
        ->assertScreenshotMatches();
})->with($methods);

it('may visit a page in dark mode', function (): void {
    Route::get('/', fn (): string => '
        <html>
        <head>
            <style>
                body {
                    font-family: sans-serif;
                    padding: 2rem;
                }

                @media (prefers-color-scheme: dark) {
                    body {
                        background-color: #121212;
                        color: #f1f1f1;
                    }
                }

                @media (prefers-color-scheme: light) {
                    body {
                        background-color: #ffffff;
                        color: #000000;
                    }
                }
            </style>
        </head>
        <body>
            <div>
                <h1>Dark Mode Test</h1>
                <p>This is a test for dark mode.</p>
            </div>
        </body>
        </html>
    ');

    /** @var Webpage $page */
    $page = visit('/')->inDarkMode();

    $page->assertScreenshotMatches();
})->with(ColorScheme::cases());
