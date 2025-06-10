<?php

declare(strict_types=1);

it('can set simple HTML content', function (): void {
    $page = $this->page('/test/frame-tests');
    $html = '<h1>Test Title</h1><p>Test paragraph</p>';

    $page->setContent($html);

    expect($page->innerText('h1'))->toBe('Test Title');
    expect($page->innerText('p'))->toBe('Test paragraph');
});

it('can set content with forms', function (): void {
    $page = $this->page('/test/frame-tests');
    $html = '
    <form>
        <input type="text" id="test-input" value="test-value">
        <button type="submit" id="test-button">Submit</button>
    </form>';

    $page->setContent($html);

    expect($page->inputValue('#test-input'))->toBe('test-value');
    expect($page->isVisible('#test-button'))->toBeTrue();
});

it('can set content with scripts', function (): void {
    $page = $this->page('/test/frame-tests');
    $html = '
    <div id="target">Initial</div>
    <script>
        document.getElementById("target").textContent = "Updated by script";
    </script>';

    $page->setContent($html);

    expect($page->innerText('#target'))->toBe('Updated by script');
});

it('can set complete HTML document', function (): void {
    $page = $this->page('/test/frame-tests');
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Test Page</title>
    </head>
    <body>
        <h1>Complete Document</h1>
        <div id="content">This is a complete HTML document</div>
    </body>
    </html>';

    $page->setContent($html);

    expect($page->title())->toBe('Test Page');
    expect($page->innerText('h1'))->toBe('Complete Document');
    expect($page->innerText('#content'))->toBe('This is a complete HTML document');
});

it('can clear content by setting empty HTML', function (): void {
    $page = $this->page('/test/frame-tests');
    $page->setContent('<div id="test">Original content</div>');
    expect($page->isVisible('#test'))->toBeTrue();

    $page->setContent('<html><body></body></html>');
    expect($page->isVisible('#test'))->toBeFalse();
});
