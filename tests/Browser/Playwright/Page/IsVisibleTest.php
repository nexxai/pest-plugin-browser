<?php

declare(strict_types=1);

it('returns true for visible elements', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isVisible('#visible-element'))->toBeTrue();
    expect($page->isVisible('#test-form'))->toBeTrue();
});

it('returns false for hidden elements', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isVisible('#hidden-element'))->toBeFalse();
});
