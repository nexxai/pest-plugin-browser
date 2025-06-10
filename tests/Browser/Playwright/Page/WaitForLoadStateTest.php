<?php

declare(strict_types=1);

it('waits for load state', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForLoadState();

    expect(true)->toBeTrue();
});

it('waits for specific load state', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForLoadState('domcontentloaded');

    expect(true)->toBeTrue();
});

it('waits for networkidle state', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForLoadState('networkidle');

    expect(true)->toBeTrue();
});
