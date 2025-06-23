<?php

declare(strict_types=1);

it('gets attribute value from element', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#test-input');

    $placeholder = $page->getAttribute('#test-input', 'placeholder');
    expect($placeholder)->toBe('Enter text here');

    $id = $page->getAttribute('#test-input', 'id');
    expect($id)->toBe('test-input');
});

it('returns null for non-existent attribute', function (): void {
    $page = page('/test/frame-tests');
    $page->waitForSelector('#test-input');

    $nonExistent = $page->getAttribute('#test-input', 'non-existent-attr');
    expect($nonExistent)->toBeNull();
});
