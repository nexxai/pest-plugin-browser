<?php

declare(strict_types=1);

it('performs drag and drop operations and verifies state changes', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#draggable');
    $page->waitForSelector('#droppable');
    expect($page->textContent('#droppable'))->toContain('Drop Zone');

    $page->dragAndDrop('#draggable', '#droppable');
    expect($page->textContent('#droppable'))->toBe('Element dropped!');
});
