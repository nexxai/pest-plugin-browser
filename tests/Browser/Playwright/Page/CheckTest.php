<?php

declare(strict_types=1);

it('checks unchecked checkboxes', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isChecked('#unchecked-checkbox'))->toBeFalse();

    $page->check('#unchecked-checkbox');

    expect($page->isChecked('#unchecked-checkbox'))->toBeTrue();
});

it('changes state after checking', function (): void {
    $page = $this->page('/test/frame-tests');
    expect($page->isChecked('#unchecked-checkbox'))->toBeFalse();

    $page->check('#unchecked-checkbox');
    expect($page->isChecked('#unchecked-checkbox'))->toBeTrue();
});
