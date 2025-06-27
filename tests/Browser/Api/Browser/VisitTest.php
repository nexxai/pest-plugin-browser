<?php

declare(strict_types=1);

use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Api\Webpage;

// grab all methods from PendingAwaitablePage
$reflection = new ReflectionClass(PendingAwaitablePage::class);

$methods = array_map(
    fn (ReflectionMethod $method): string => $method->getName(),
    array_filter(
        $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
        fn (ReflectionMethod $method): bool => str_starts_with($method->getName(), 'on'),
    ),
);

it('may visit a page', function (string $method): void {
    Route::get('/', fn (): string => file_get_contents(
        fixture('responsive.html'),
    ));

    /** @var Webpage $page */
    $page = visit('/')->{$method}();

    $page->assertSee('Experience elegance across every device.')
        ->assertScreenshotMatches();
})->with($methods);
