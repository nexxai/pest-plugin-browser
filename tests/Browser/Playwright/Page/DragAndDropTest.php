<?php

declare(strict_types=1);

describe('dragAndDrop', function (): void {
    beforeEach(function (): void {
        $this->page = $this->page('/test/frame-tests');
    });

    it('performs drag and drop operations and verifies state changes', function (): void {
        $this->page->waitForSelector('#draggable');
        $this->page->waitForSelector('#droppable');
        expect($this->page->textContent('#droppable'))->toContain('Drop Zone');

        $this->page->dragAndDrop('#draggable', '#droppable');
        expect($this->page->textContent('#droppable'))->toBe('Element dropped!');
    });
});
