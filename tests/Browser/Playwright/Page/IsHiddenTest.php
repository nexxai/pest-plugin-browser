<?php

declare(strict_types=1);

it('returns false for visible elements when checking isHidden', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isHidden('#visible-element'))->toBeFalse();
    expect($page->isHidden('#test-form'))->toBeFalse();
});

it('returns true for hidden elements when checking isHidden', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isHidden('#hidden-element'))->toBeTrue();
});
