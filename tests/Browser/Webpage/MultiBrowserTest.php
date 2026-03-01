<?php

declare(strict_types=1);

use Pest\Browser\Api\MultiBrowserPendingPage;
use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Enums\BrowserType;
use Pest\Browser\Enums\Device;

it('creates multi-browser pending pages', function (): void {
    $page = new PendingAwaitablePage(
        BrowserType::CHROME,
        Device::DESKTOP,
        '/test',
        [],
    );

    $pages = $page->browser([BrowserType::CHROME, BrowserType::FIREFOX]);

    expect($pages)->toBeInstanceOf(MultiBrowserPendingPage::class);
    expect($pages)->toHaveCount(2);
});

it('iterates over multiple browsers', function (): void {
    $page = new PendingAwaitablePage(
        BrowserType::CHROME,
        Device::DESKTOP,
        '/test',
        [],
    );

    $pages = $page->browser([BrowserType::CHROME, BrowserType::FIREFOX]);

    $count = 0;
    foreach ($pages as $p) {
        expect($p)->toBeInstanceOf(PendingAwaitablePage::class);
        $count++;
    }

    expect($count)->toBe(2);
});

it('executes callback for each browser', function (): void {
    $page = new PendingAwaitablePage(
        BrowserType::CHROME,
        Device::DESKTOP,
        '/test',
        [],
    );

    $pages = $page->browser([BrowserType::CHROME, BrowserType::FIREFOX]);

    $browsers = [];
    $pages->each(function (PendingAwaitablePage $p) use (&$browsers): void {
        $browsers[] = $p->getBrowserType();
    });

    expect($browsers)->toBe([BrowserType::CHROME, BrowserType::FIREFOX]);
});
