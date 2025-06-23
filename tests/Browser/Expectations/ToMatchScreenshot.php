<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\ExpectationFailedException;

it('does match a screenshot', function (): void {
    $page = page()->goto('/');

    expect($page)->toMatchScreenshot();
});

it('does not match a screenshot', function (): void {
    Route::get('screenshot-mismatch', function () {
        return 'pest';
    });

    $page = page()->goto('screenshot-mismatch');

    expect($page)->toMatchScreenshot(showDiff: true);
})->throws(ExpectationFailedException::class);
