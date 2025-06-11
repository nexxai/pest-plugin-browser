<?php

declare(strict_types=1);

it('waits for element to be available', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#hover-target');

    expect($page->isVisible('#hover-target'))->toBeTrue();
});

it('waits for multiple elements', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#test-input');
    $page->waitForSelector('#test-form');

    expect($page->isVisible('#test-input'))->toBeTrue();
    expect($page->isVisible('#test-form'))->toBeTrue();
});
