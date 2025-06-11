<?php

declare(strict_types=1);

it('unchecks checked checkboxes', function (): void {
    $page = page('/test/frame-tests');
    expect($page->isChecked('#checked-checkbox'))->toBeTrue();

    $page->uncheck('#checked-checkbox');

    expect($page->isChecked('#checked-checkbox'))->toBeFalse();
});

it('changes state after unchecking', function (): void {
    $page = page('/test/frame-tests');
    $page->check('#unchecked-checkbox');
    expect($page->isChecked('#unchecked-checkbox'))->toBeTrue();

    $page->uncheck('#unchecked-checkbox');
    expect($page->isChecked('#unchecked-checkbox'))->toBeFalse();
});
