<?php

declare(strict_types=1);

it('clicks on elements and verifies click effects', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->waitForSelector('#click-target');
    expect($page->textContent('#click-target'))->toContain('Click Me');

    $page->click('#click-target');
    expect($page->textContent('#click-target'))->toBe('Clicked!');
});
