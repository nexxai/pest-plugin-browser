<?php

declare(strict_types=1);

describe('click', function (): void {
    beforeEach(function (): void {
        $this->page = $this->page('/test/frame-tests');
    });

    it('clicks on elements and verifies click effects', function (): void {
        $this->page->waitForSelector('#click-target');
        expect($this->page->textContent('#click-target'))->toContain('Click Me');

        $this->page->click('#click-target');
        expect($this->page->textContent('#click-target'))->toBe('Clicked!');
    });
});
