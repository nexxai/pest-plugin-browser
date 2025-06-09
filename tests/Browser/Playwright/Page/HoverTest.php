<?php

declare(strict_types=1);

describe('hover', function (): void {
    beforeEach(function (): void {
        $this->page = $this->page('/test/frame-tests');
    });

    it('hovers over elements and triggers hover state changes', function (): void {
        $this->page->waitForSelector('#hover-target');
        expect($this->page->textContent('#hover-display'))->toBe('No element hovered yet');

        $this->page->hover('#hover-target');
        expect($this->page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
        expect($this->page->isVisible('#hover-target'))->toBeTrue();
    });

    it('hovers over disabled elements with force parameter', function (): void {
        $this->page->waitForSelector('#disabled-button');
        $this->page->hover('#disabled-button', force: true);
        expect($this->page->isEnabled('#disabled-button'))->toBeFalse();
    });

    it('hovers with position parameter', function (): void {
        $this->page->waitForSelector('#hover-target');
        $this->page->hover('#hover-target', position: ['x' => 10, 'y' => 10]);
        expect($this->page->textContent('#hover-display'))->toBe('Last hovered: hover-target');
    });
});
