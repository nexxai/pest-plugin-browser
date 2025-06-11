<?php

declare(strict_types=1);

it('gets the inner text of an element', function (): void {
    $page = page('/test/frame-tests');
    $text = $page->innerText('#test-content p');

    expect($text)->toBe('This is the main content for testing.');
});

it('gets inner text from nested elements', function (): void {
    $page = page('/test/frame-tests');
    $text = $page->innerText('#deep-text');

    expect($text)->toBe('Deep nested text');
});

it('gets inner text without HTML tags', function (): void {
    $page = page('/test/frame-tests');
    $text = $page->innerText('#html-content');

    expect($text)->toBe('Bold text and italic text');
});
