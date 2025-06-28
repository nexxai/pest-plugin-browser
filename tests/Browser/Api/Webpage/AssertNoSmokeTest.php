<?php

declare(strict_types=1);

use PHPUnit\Framework\ExpectationFailedException;

it('may not have smoke', function (): void {
    Route::get('/', fn (): string => '<div>
        <h1>Smoke Test</h1>
    </div>');

    $response = visit('/');

    $response->assertNoSmoke();
});

it('may have smoke because of console logs', function (): void {
    Route::get('/', fn (): string => '<div>
        <h1>Smoke Test</h1>
        <script>
            console.log("This is a console log.");
        </script>
    </div>');

    $response = visit('/');

    $response->assertNoConsoleLogs();
})->throws(ExpectationFailedException::class);

it('may have smoke because of JavaScript errors', function (): void {
    Route::get('/', fn (): string => '<div>
        <h1>Smoke Test</h1>
        <script>
            throw new Error("This is a JavaScript error.");
        </script>
    </div>');

    $response = visit('/');

    $response->assertNoJavaScriptErrors();
})->throws(ExpectationFailedException::class);
