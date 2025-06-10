<?php

declare(strict_types=1);

it('returns true for checked checkboxes', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isChecked('#checked-checkbox'))->toBeTrue();
    expect($page->isChecked('#radio-option2'))->toBeTrue();
});

it('returns false for unchecked checkboxes', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isChecked('#unchecked-checkbox'))->toBeFalse();
    expect($page->isChecked('#radio-option1'))->toBeFalse();
    expect($page->isChecked('#radio-option3'))->toBeFalse();
});
