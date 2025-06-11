<?php

declare(strict_types=1);

it('returns true for editable elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isEditable('input[type="text"]'))->toBeTrue();
    expect($page->isEditable('textarea'))->toBeTrue();
});

it('returns false for non-editable elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isEditable('button'))->toBeFalse();
    expect($page->isEditable('div'))->toBeFalse();
    expect($page->isEditable('span'))->toBeFalse();
});

it('returns false for disabled input elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isEditable('#disabled-input'))->toBeFalse();
});

it('returns false for readonly input elements', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isEditable('#readonly-input'))->toBeFalse();
});
