<?php

declare(strict_types=1);

use Pest\Browser\Playwright\JSHandle;
use Pest\Browser\Support\JavaScriptSerializer;

it('can evaluate basic expressions on a JSHandle', function (): void {
    $page = page('/test/frame-tests');

    // Create a JSHandle for a DOM element
    $handle = $page->evaluateHandle('document.querySelector("#test-content")');
    expect($handle)->toBeInstanceOf(JSHandle::class);

    // Evaluate a simple property access on the handle
    $textContent = $handle->evaluate('node => node.textContent');
    expect($textContent)->toContain('This is the main content for testing');
});

it('can evaluate expressions that modify a JSHandle element', function (): void {
    $page = page('/test/frame-tests');

    // Create a JSHandle for an input element
    $handle = $page->evaluateHandle('document.querySelector("#test-input")');
    expect($handle)->toBeInstanceOf(JSHandle::class);

    // Set the value of the input
    $handle->evaluate('input => { input.value = "test value"; return true; }');

    // Verify the value was changed
    $value = $page->inputValue('#test-input');
    expect($value)->toBe('test value');
});

it('can pass arguments when evaluating expressions on a JSHandle', function (): void {
    $page = page('/test/frame-tests');

    // Create a JSHandle
    $handle = $page->evaluateHandle('document.querySelector("#test-content")');
    expect($handle)->toBeInstanceOf(JSHandle::class);

    // Pass a simple string argument
    $result = $handle->evaluate('(node, text) => { node.textContent = text; return node.textContent; }', 'Updated content');
    expect($result)->toBe('Updated content');

    // Verify the content was actually changed in the page
    $content = $page->textContent('#test-content');
    expect($content)->toBe('Updated content');
});

it('can evaluate expressions on JSHandles that return primitives', function (): void {
    $page = page('/test/frame-tests');

    $handle = $page->evaluateHandle('document.querySelector("h1")');
    expect($handle)->toBeInstanceOf(JSHandle::class);

    // Return a string
    $text = $handle->evaluate('h1 => h1.textContent');
    expect($text)->toBeString();
    expect($text)->toContain('PESTPHP');

    // Return a boolean
    $hasChildren = $handle->evaluate('h1 => h1.hasChildNodes()');
    expect($hasChildren)->toBeTrue();

    // Return a number
    $childCount = $handle->evaluate('h1 => h1.childNodes.length');
    expect($childCount)->toBeGreaterThan(0);
});
