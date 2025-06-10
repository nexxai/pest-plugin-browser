<?php

declare(strict_types=1);

it('returns true for enabled elements', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isEnabled('#test-input'))->toBeTrue();
    expect($page->isEnabled('#enabled-button'))->toBeTrue();
});

it('returns false for disabled elements', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isEnabled('#disabled-input'))->toBeFalse();
    expect($page->isEnabled('#disabled-button'))->toBeFalse();
    expect($page->isEnabled('#disabled-checkbox'))->toBeFalse();
});
