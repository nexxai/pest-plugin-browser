<?php

declare(strict_types=1);

it('returns true for disabled elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isDisabled('#disabled-button'))->toBeTrue();
    expect($page->isDisabled('#disabled-input'))->toBeTrue();
});

it('returns false for enabled elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isDisabled('#enabled-button'))->toBeFalse();
    expect($page->isDisabled('input[type="text"]'))->toBeFalse();
});

it('returns false for elements that cannot be disabled', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isDisabled('div'))->toBeFalse();
    expect($page->isDisabled('span'))->toBeFalse();
});
