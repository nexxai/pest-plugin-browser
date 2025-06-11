<?php

declare(strict_types=1);

it('gets the text content of an element', function (): void {
    $page = $this->page('/test/frame-tests');
    $text = $page->textContent('#test-content span');

    expect($text)->toBe('Inner text content');
});

it('gets text content from mixed content', function (): void {
    $page = $this->page('/test/frame-tests');
    $text = $page->textContent('#mixed-content');

    expect($text)->toContain('Paragraph with bold and italic text');
    expect($text)->toContain('List item 1');
    expect($text)->toContain('List item 2');
});

it('gets text content as empty string when no content', function (): void {
    $page = $this->page('/test/frame-tests');

    $text = $page->textContent('#empty-id');

    expect($text)->toBe('');
});
