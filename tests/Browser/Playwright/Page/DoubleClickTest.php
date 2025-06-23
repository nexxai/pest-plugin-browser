<?php

declare(strict_types=1);

it('double clicks elements', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#double-click-target');

    expect(mb_trim((string) $page->textContent('#double-click-target')))->toBe('Double Click Me');

    $page->doubleClick('#double-click-target');

    expect($page->textContent('#double-click-target'))->toBe('Double Clicked!');
});
